<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * パスワードリセット画面制御クラス
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /** @var string リダイレクトURL */
    protected $redirectTo = '/';

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
