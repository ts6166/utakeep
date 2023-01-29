<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 通知関連画面制御クラス
 */
class NotificationController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 通知画面表示処理
     *
     * @return void
     */
    public function index() 
    {
        // 通知画面を表示
        return view('pages.notifications');
    }
}
