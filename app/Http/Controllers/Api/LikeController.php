<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use DB;

/**
 * いいね関連API制御クラス
 */
class LikeController extends ApiController
{   
    /**
     * いいね登録処理
     * 
     * @param Request $request
     * @return bool
     */
    public function create(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => 'required|string|between:10,14',
        ]);

        // 対象いいねが存在しない場合は、404（検出不可）を返却
        $post = Post::find($request->id);
        if(is_null($post)) {
            return response()->json()->setStatusCode(404);
        }

        // トランザクションを開始
        DB::beginTransaction();
        try {
            // いいねレコードを作成
            Like::insert([
                'post_id' => $post->id,
                'user_id' => auth()->id()
            ]);

            // いいね数を更新
            $post->like_count++;
            $post->save();

            // 通知を発行
            Notification::create($post->user->id ,$post->id, 'like');

            // コミットをして、200（正常）を返却
            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (\Exception $e) {
            // ロールバックをして、404（異常）を返却
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }

    /**
     * いいね解除処理
     * 
     * @param Request $request
     * @return bool
     */
    public function destroy(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => 'required|string|between:10,14',
        ]);
        
        // 対象いいねが存在しない場合は、404（検出不可）を返却
        $post = Post::find($request->id);
        if(is_null($post)) return response()->json()->setStatusCode(404);
        
        // トランザクションを開始
        DB::beginTransaction();
        try {
            // いいねレコードを削除
            $deleteCount = Like::where('post_id', $post->id)
                ->where('user_id', auth()->id())
                ->delete();
            if($deleteCount != 1) {
                throw new \Exception();
            }

            // いいね数を更新
            $post->like_count--;
            $post->save();

            // 通知を取り消し
            Notification::remove($post->user->id ,$post->id);

            // コミットをして、200（正常）を返却
            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (\Exception $e) {
            // ロールバックをして、404（異常）を返却
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }

}
