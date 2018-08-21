<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Menu;
use Yajra\Datatables\Datatables;
use DB;

class RoleCtrl extends Controller
{
    
    public function index()
    {
        return view('role.dt');
    }

    public function dt()
    {
        $data = Role::all();
        return Datatables::of($data)
            ->addColumn('action', function($item) {
                $user = auth()->user();
                $html = $user->can('update role') ? '<a href="'. url('roles/create/'. $item->id) .'" class="text-primary row-update" data-toggle="tooltip" title="Update Role"><span class="glyphicon glyphicon-wrench"></span></a>&nbsp;&nbsp;' : '';
                $html .= $user->can('delete role') ? '<a href="javascript:" data-id="'. $item->id .'" class="text-danger row-delete" data-toggle="tooltip" title="Delete Role"><span class="glyphicon glyphicon-trash"></span></a>' : '';
                return $html;
            })
            ->make(true);
    }

    public function create($id = false)
    {
        $params = [];
        if(!empty($id)) {
            $role = Role::find($id);
            $params['data'] = $role;
            $params['menus'] = Menu::role($role)->get();
            $params['perms'] = $role->permissions;
        }
        return view('role.create', $params);
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
                'title' => $value->name,
                'key' => $value->id,
                'perms' => $value->permissions
            ];
            // build available permissions
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

    public function store(Request $req)
    {
        return DB::transaction(function() use($req) {
            try {
                // store role
                $role = empty($req->id) ? new Role : Role::find($req->id);
                $role->name = $req->name;
                $role->guard_name = 'web';
                $role->save();
                // sync menus
                Menu::role($role)->get()->each(function($val,$key) use($role) {
                    $val->removeRole($role);
                });
                $menus = $req->menus;
                foreach ($menus as $menu) {
                    $menu = Menu::find($menu);
                    $menu->assignRole($role);
                }
                $role->syncPermissions($req->perms);
                return redirect('roles')->with('success', 'Role data saved!');
            } catch(Exception $e) {
                DB::rollback();
                return back()->with('error', 'Error while saving data! '. $e->getMessage())->withInput();
            }
        });
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect('roles')->with('success', 'Role deleted!');
    }

}
