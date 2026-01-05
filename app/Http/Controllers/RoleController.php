<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        // 複数のデータをJSON化する場合は、collection()を使用
        $roles = RoleResource::collection(Role::all());

        return Inertia::render('Roles/Index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = PermissionResource::collection(Permission::all());

        return Inertia::render('Roles/Create', [
            'permissions' => $permissions
        ]);
    }

    public function Store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'title' => $request->title
        ]);

        $role->permissions()->sync($request->selectedPermissions);

        return redirect(route('roles.index'))->with([
            'status' => 'success',
            'message' => '権限の登録が完了いたしました。'
        ]);
    }

    public function edit(Role $role)
    {
        // 該当の$roleに紐づくpermissionの取得
        $role = $role->load('permissions');

        return Inertia::render('Roles/Edit', [
            'role' => RoleResource::make($role), // 単数のデータをJSON化する場合は、make()を使用する
            'permissions' => PermissionResource::collection(Permission::all()) // 編集画面での選択用
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->title = $request->title;
        $role->save();

        $role->permissions()->sync($request->selectedPermissions);

        return redirect(route('roles.index'))->with([
            'status' => 'success',
            'message' => '権限の更新をしました。'
        ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect(route('roles.index'))->with([
            'status' => 'delete',
            'message' => '権限を削除しました。'
        ]);
    }
}
