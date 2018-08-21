<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Menu;
use App\Permission;
use DB;

class MenuCtrl extends Controller
{

    public function index()
    {
        return view('menu.tree');
    }

    public function tree()
    {
        $menu = Menu::where('parent_id', 0)
            ->orderBy('order_no')
            ->get();
        return response()->json($this->build_tree($menu));
    }

    private function build_tree($data)
    {
        $op = [];
        foreach ($data as $value) {
            // array build of current item
            $item = [
                'title'=>$value->name,
                'key'=>$value->id
            ];
            // build children of current item
            $childrenData = $value->children()->get();
            if(!$childrenData->isEmpty()) {
                $children = $this->build_tree($childrenData);
                $item['folder'] = true;
                $item['expanded'] = true;
                $item['children'] = $children;
            }
            // build item
            $op[] = $item;
        }
        return $op;
    }

    public function create($type, $id)
    {
        $params = [];
        if($type==='create') {
            $parent = $id == 0 ? 0 : Menu::find($id);
            $params['parent_id'] = empty($parent) ? 0 : $parent->id;
            $params['order_no'] = empty($parent) ? Menu::where('parent_id', 0)->count()+1 : $parent->children()->count()+1;
        } else {
            $menu = Menu::find($id);
            $params['data'] = $menu;
            $params['perms'] = $menu->permissions;
        }
        return view('menu.create', $params);
    }

    public function store(Request $req)
    {
        return DB::transaction(function() use($req) {
            try {
                // store menu
                $menu = empty($req->id) ? new Menu : Menu::find($req->id);
                $menu->parent_id = empty($req->parent_id) ? 0 : $req->parent_id;
                $menu->name = $req->name;
                $menu->slug = $req->slug;
                $menu->icon = $req->icon;
                $menu->is_active = empty($req->is_active) ? 0 : 1;
                $menu->order_no = $req->order_no;
                $menu->save();
                // sync permissions
                $perms = $req->permissions;
                foreach ($perms as $perm) {
                    $data = Permission::firstOrCreate([ 'name' => $perm ]);
                }
                $menu->syncPermissions($req->permissions);
                return redirect('menus')->with('success', 'Menu data saved!');
            } catch(Exception $e) {
                DB::rollback();
                return back()->with('error', 'Error while saving data! '. $e->getMessage())->withInput();
            }
        });
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        $this->do_destroy($menu);
        return redirect('menus')->with('success', 'Menu deleted!');
    }

    private function do_destroy($data)
    {
        $children = $data->children()->get();
        if($children->isNotEmpty())
            foreach ($children as $val) {
                $this->do_destroy($val);
            }
        $data->delete();
    }

}
