<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ホーム関連画面制御クラス
 */
class HomeController extends Controller
{
    /**
     * ホーム画面表示処理
     *
     * @return void
     */
    public function index()
    {
        // 認証確認
        if (Auth::check()) {
            $response = [];

            // 登録曲がない場合はメッセージを表示
            if(Auth::user()->stateCount() == 0) {
                $response['alert'] = ['type' => 'default', 'text' => __('messages.nav_unused')];
            }

            // 通知確認
            $response['exist_unconfirm_notification'] = 
                Notification::where('receiver_id', auth()->id())
                    ->where('confirm', '=', 0)
                    ->exists();

            // ホーム画面を表示
            return view('pages.home', $response);
        } else {
            // 認証していない場合はトップ画面を表示
            return view('pages.welcome');
        }
    }
}
