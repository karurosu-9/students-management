<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
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
        return Inertia::render('Roles/Create');
    }

    public function Store(StoreRoleRequest $request)
    {
        Role::create([
            'title' => $request->title
        ]);

        return redirect(route('roles.index'))->with([
            'status' => 'success',
            'message' => '権限の登録が完了いたしました。'
        ]);
    }

    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit', [
            'role' => RoleResource::make($role) // 単数のデータをJSON化する場合は、make()を使用する
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->title = $request->title;
        $role->save();

        return redirect(route('roles.index'))->with([
            'status' => 'success',
            'message' => '権限の更新をしました。'
        ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return Inertia::render('Roles/Index')->with([
            'status' => 'delete',
            'message' => '権限を削除しました。'
        ]);
    }
}
