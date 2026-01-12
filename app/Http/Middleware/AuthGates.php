<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $request?->user()でログインユーザーなのか確認し、ログインユーザーであればloadMissing()で、まだ読み込まれていなければ読み込む処理を実行する
        $user = $request?->user()?->loadMissing('roles.permissions');

        $permissions = [];

        // ログインしていれば、そのユーザーの権限に登録されている許可されたアクションを取得する
        if($user) {
            foreach ($user->roles as $role) {
                foreach ($role->permissions as $singlePermission) {
                    $permissions[] = $singlePermission->title;
                }
            }
        }

        // ログインユーザーの許可されたアクションをGateに登録
        collect($permissions)->unique()->each(function ($permission) {
            Gate::define($permission, function ($user) {
                return true;
            });
        });

        return $next($request);
    }
}
