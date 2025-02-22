<?php

namespace App\Repositories;

use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository
{
    public function getAll()
    {
        return Role::get();
    }
    public function store($request)
    {
        $role = Role::create(['guard_name' => 'web', 'name' => $request->name]);
        if(!$role){
            throw new Exception('error in create role');
        }
        $role->syncPermissions($request->permissions);
    }

    public function getRole($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function getPermissions()
    {
        return Permission::all();
    }
    public function getPermissionsByGroup()
    {
        $permissions = $this->getPermissions();
        return $permissions->groupBy('attribute');
    }

    public function update($request, $id)
    {
        $role = Role::findOrFail($id);

        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (!$role->delete()) {
            throw new Exception(__('error delete Role'));
        }
        return true;
    }
}
