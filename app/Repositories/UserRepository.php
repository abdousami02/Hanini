<?php

namespace App\Repositories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;

class UserRepository
{

    public function get($id)
    {
        return User::findOrFail($id);
    }

    public function getAll()
    {
        return User::where('id', '!=', '1')->get();
    }

    public function store($request)
    {
        $user_type = 'staff';
        if ($request->role == 'super_admin') {
            $user_type = 'super_admin';
        }

        $user = User::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
            'phone'  => $request->phone,
            'user_type' => $user_type,
            'password' => Hash::make($request->password),
        ]);
        if ($user_type != 'super_admin') {
            $user->syncRoles([$request->role]);
        }
        return $user;
    }

    public function update($request, $id)
    {
        $user = $this->get($id);
        $user_type = 'staff';
        if ($request->role == 'super_admin') {
            $user_type = 'super_admin';
        }
        
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'user_type' => $user_type,
            'status'    => $request->status,
        ]);

        if($request->role != 'super_admin') {
            $user->syncRoles([$request->role]);
        }else{
            $user->syncRoles([]);
        }
        return $user;
    }

    public function updatePwd($request, $id)
    {
        $user = $this->get($id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->id == userId()){
            throw new \Exception(__("can't delete this user"));
        }
        $user->delete();
        return $user->delete();
    }

    public function storeToken($request)
    {
        // $user = User::findOrFail($request->id);
        $user_id = userId();
        $device = Device::where([['user_id', $user_id],['token', $request->current_token]])->first();
        if($device){
            return true;
        }
        $device = Device::create([
            'user_id' => $user_id,
            'token'   => $request->current_token,
            'device_name' => $request->userAgent(),
        ]);

        return true;
    }
}
