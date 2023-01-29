<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * ログイン画面制御クラス
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /** @var string リダイレクトURL */
    protected $redirectTo = '/';

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 認証時ユーザー名フィールド定義処理
     *
     * @return void
     */
    public function username()
    {
        return 'screen_name';
    }

    /**
     * 認証後処理
     *
     * @param Request $request
     * @param [type] $user
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect('/')->with('status', __('messages.nav_logined', ['screen_name' => $user->screen_name]));
    }
}
