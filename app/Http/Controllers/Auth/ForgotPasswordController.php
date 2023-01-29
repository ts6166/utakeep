<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * パスワード変更要求画面制御クラス
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

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
