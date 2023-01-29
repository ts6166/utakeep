<?php

namespace App\Http\Controllers\Api;

use App\Consts\AppConst;
use App\Http\Requests\ApiRequestRules;
use App\Models\Post;
use Illuminate\Http\Request;
use DB;

/**
 * 記録関連API制御クラス
 */
class PostController extends ApiController
{
    /**
     * 記録取得処理
     * 
     * @param Request $request
     * @return array $response
     */
    public function index(request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => 'nullable|numeric',
            'count' => 'nullable|numeric|between:1,50',
        ]);

        $user_id = $request->query('id', null);
        $next_id = $request->query('next', null);
        $count = $request->query('count', AppConst::DEF_PER_PAGE);

        // 記録レコードを取得
        $query = Post::select('posts.id', 'posts.user_id', 'posts.song_id', 'posts.old_state', 'posts.state', DB::raw('IFNULL(statuses.state, 0) as my_state'),  DB::raw('IFNULL(posts.like_count, 0) as like_count'), DB::raw('IF(likes.id IS NOT NULL, 1, 0) as is_liked'), 'posts.created_at')
        ->leftjoin('statuses', function($join) {
            $join->where('statuses.user_id', auth()->id())
            ->on('posts.song_id', '=', 'statuses.song_id');
        })
        ->leftjoin('likes', function($join2) {
            $join2->where('likes.user_id', auth()->id())
            ->on('posts.id', '=', 'likes.post_id');
        });

        // 対象のユーザーのみを取得
        if(!is_null($user_id)) {
            $query = $query->where('posts.user_id', $user_id);
        }

        // next以降のアクティビティを取得
        if(!is_null($next_id)) {
            $query = $query->where('posts.id', '<', $next_id);
        }

        $response = $query
            ->take($count)
            ->with(['user', 'song'])
            ->orderBy('id', 'desc')
            ->get();

        // 200（正常）を返却
        return response()->json($response)->setStatusCode(200);
    }
    
    /**
     * 記録削除処理
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getPostIdRule(),
        ]);

        $user = auth()->user();

        // 対象記録が存在しない場合は、404（検出不可）を返却
        $post = Post::find($request->id);
        if(is_null($post)) {
            return response()->json()->setStatusCode(404);
        }

        // 取得した記録のユーザーIDが認証ユーザーIDと異なる場合は422（処理不可）を返却
        if($post->user->id != $user->id) {
            return response()->json()->setStatusCode(422);
        }

        // トランザクションを開始
        DB::beginTransaction();
        try {
            // 記録レコードを削除して、記録数を更新
            $deleteCount = $post->delete();
            if($deleteCount != 1) {
                throw new \Exception();
            }
            $user->record_count--;
            $user->save();

            // コミットして、200（正常）を返却
            DB::commit();
            return response()->json(['user' => $user])->setStatusCode(200);
        } catch (\Exception $e) {
            // ロールバックをして、404（異常）を返却
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }
}
