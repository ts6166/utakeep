<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DB;

/**
 * 記録関連画面制御クラス
 */
class PostController extends Controller
{
    /**
     * 記録詳細画面表示処理
     *
     * @param integer $id    記録ID
     * @return void
     */
    public function index($id)
    {
        // IDから記録レコードを取得
        $post = Post::select('posts.id', 'posts.user_id', 'posts.song_id', 'posts.old_state', 'posts.state', DB::raw('IFNULL(statuses.state, 0) as my_state'),  DB::raw('IFNULL(posts.like_count, 0) as like_count'), DB::raw('IF(likes.id IS NOT NULL, 1, 0) as is_liked'), 'posts.created_at')
        ->leftjoin('statuses', function($join) {
            $join->where('statuses.user_id', auth()->id())
            ->on('posts.song_id', '=', 'statuses.song_id');
        })
        ->leftjoin('likes', function($join2) {
            $join2->where('likes.user_id', auth()->id())
            ->on('posts.id', '=', 'likes.post_id');
        })
        ->where('posts.id', '=', $id)
        ->with(['user', 'song'])
        ->first();
        
        // 記録が見つからない場合は404エラー画面を表示
        if(is_null($post)) {
            return view('errors.404');
        }

        // 記録詳細画面を表示
        return view('pages.post', ['status' => $post]);
    }
}
