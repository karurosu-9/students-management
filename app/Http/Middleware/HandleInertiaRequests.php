<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
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

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],

            // フロント側にprops.can[]として受け取らせる用
            // if (page.props.can['user.create']) {　ボタン表示 } がフロント側でできるように設定
            'can' => $user ? collect($permissions)->unique()->map(function ($permission) {
                return [$permission => true]; // map()で、['student_create' => true]のように配列を作り直す
            })->collapse()->toArray() : [], // collapse()は複数の配列を 1つの配列にまとめる関数

            // フラッシュメッセージの設定
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'status' => fn () => $request->session()->get('status'),
            ],
        ];
    }
}
