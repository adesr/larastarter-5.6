<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Menu;
use App\Role;
use Yajra\Datatables\Datatables;
use DB;
use Hash;

class UserCtrl extends Controller
{
    
    public function login(Request $req)
    {
        if(auth()->attempt(['username' => $req->username, 'password' => $req->password])) {
            $user = auth()->user();
            $role = $user->roles->first();
            $menus = $this->ancestors(Menu::role($role)->get());
            session([
                'menus' => json_encode($this->buildMenu($menus))
            ]);
            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'error');
        }
    }

    private function ancestors($data)
    {
        $lists = $data->pluck('id')->all();
        foreach ($data as $val) {
            if($val->parent_id > 0 AND !in_array($val->parent_id, $lists)) {
                $lists[] = $val->parent()->first()->id;
            }
        }
        return Menu::whereIn('id', $lists)->get();
    }

    private function buildMenu($data, $parent = 0)
    {
        $op = [];
        foreach ($data as $value) {
            if($value->parent_id===$parent) {
                // array build of current item
                $item = [
                    'name'=>$value->name,
                    'url'=>url($value->slug),
                    'icon'=>$value->icon,
                ];
                // build children of current item
                $children = $this->buildMenu($data, $value->id);
                if($children)
                    $item['children'] = $children;
                // build item
                $op[] = $item;
            }
        }
        return $op;
    }

    public function index()
    {
        return view('user.dt');
    }

    public function dt()
    {
        $data = auth()->user()->id===1 ? User::all() : User::where('id', '<>', 1)->get();
        return Datatables::of($data)
            ->addColumn('role', function($item) {
                return auth()->user()->roles->first()->name;
            })
            ->addColumn('action', function($item) {
                $user = auth()->user();
                $html = $user->can('update user') ? '<a href="'. url('users/create/'. $item->id) .'" class="text-primary row-update" data-toggle="tooltip" title="Update User"><span class="glyphicon glyphicon-wrench"></span></a>&nbsp;&nbsp;' : '';
                $html .= $user->can('delete user') ? '<a href="javascript:" data-id="'. $item->id .'" class="text-danger row-delete" data-toggle="tooltip" title="Delete User"><span class="glyphicon glyphicon-trash"></span></a>' : '';
                return $html;
            })
            ->make(true);
    }

    public function create($id = false)
    {
        $params = [];
        if(!empty($id)) {
            $params['data'] = User::find($id);
        }
        $params['roles'] = Role::all();
        return view('user.create', $params);
    }

    public function store(Request $req)
    {
        return DB::transaction(function() use($req) {
            try {
                // store role
                $user = empty($req->id) ? new User : User::find($req->id);
                $user->name = $req->name;
                $user->username = $req->username;
                $user->email = $req->email;
                if(empty($req->id))
                    $user->password = Hash::make($req->username);
                $user->save();
                // sync role
                $user->syncRoles([ $req->role_id ]);
                return redirect('users')->with('success', 'User data saved!'. (empty($req->id)?' Default password = username.':''));
            } catch(Exception $e) {
                DB::rollback();
                return back()->with('error', 'Error while saving data! '. $e->getMessage())->withInput();
            }
        });
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('users')->with('success', 'User deleted!');
    }

}
