<?php

namespace App\Http\Controllers\Api;

use App\Consts\AppConst;
use App\Http\Requests\ApiRequestRules;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;

/**
 * 通知関連API制御クラス
 */
class NotificationController extends ApiController
{   
    /**
     * 通知取得処理
     * 
     * @param Request $request
     * @return array $response
     */
    public function index(Request $request)
    {
        // 通知レコードを取得
        $response = Notification::select('notifications.id', 'notifications.sender_id', 'notifications.kind', 'notifications.created_at', DB::raw('posts.id as post_id'), 'posts.song_id')
            ->leftjoin('posts', function($join) {
                $join->where('notifications.kind', '=', 'like')
                    ->on('posts.id', '=', 'notifications.context_id');
            })
            ->where('receiver_id', auth()->id())
            ->with(['sender', 'post', 'song'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 「未読」のレコードを全てを「既読」に更新
        Notification::where('receiver_id', auth()->id())
            ->where('confirm', '=', AppConst::STS_UNREAD)
            ->update(['confirm' => AppConst::STS_READ]);

        // 200（正常）を返却
        return response()->json($response)->setStatusCode(200);
    }

}
