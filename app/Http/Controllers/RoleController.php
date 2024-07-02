<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\users;
use Illuminate\Http\Request;
use App\Models\UserRoles;
use App\Models\Roles;


class RoleController extends Controller
{
    use SoftDeletes;

    public function addRole($id){
        $user = user::select('users.*', 'users.name', 'users.email')
                                    ->join('users', 'users.id', '=', 'users.user_id')
                                    ->where('users.id', $id)
                                    ->first();
   
 
        $roles = Roles::whereNotIn('roles.id', function($query) use ($user){
                                $query->select('role_id')
                                ->from('user_roles')
                                ->where('user_id',  $user->user_id);
                            })
                            ->get();
        
        return view('users.addRoles', ['user' => $user, 'roles'=>$roles]);
    }

    public function storeRole($id, Request $request){
        $user = user::findOrFail($id);
        
        if($user != null){
            $role = new UserRoles();
            $role->role_id = $request->input('inputRoleId');
            $role->user_id = $user->user_id;
            $role->save();
        }
        
        return redirect()->route('users.view', ['id' => $user->id]);
    }

    public function removeRole($id){

        $role = UserRoles::findOrFail($id);
        
        $user = user::select('users.*', 'users.name', 'users.email')
                                    ->join('users', 'users.id', '=', 'users.user_id')
                                    ->where('users.user_id', $role->user_id)
                                    ->first();
        $role->delete();

        return redirect()->route('users.view', ['id' => $user->id]);

    }
}
