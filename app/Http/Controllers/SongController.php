<?php

namespace App\Http\Controllers;

use App\Libraries\SongPuller\Puller;
use App\Models\Song;
use App\Models\Status;
use DB;

/**
 * 曲関連画面制御クラス
 */
class SongController extends Controller
{
    /**
     * 曲詳細画面表示処理
     *
     * @param string $id    曲ID
     * @return void
     */
    public function index($id)
    {
        // DBから曲情報を取得
        $song = Song::select('songs.id', 'title', 'artist_id', 'artist', 'image_url', 'audio_url', DB::raw('IFNULL(s1.state, 0) as my_state'))
            ->leftjoin('statuses as s1', function($join) {
                $join->where('s1.user_id', auth()->id())
                ->on('songs.id', '=', 's1.song_id');
            })
            ->where('songs.id', $id)
            ->first();

        // DBからの取得に失敗した場合は、外部APIから曲情報を取得
        if(is_null($song)) {
            $puller_song = Puller::lookSong($id);
            if(!is_null($puller_song)) {
                $state = Status::select('state')
                    ->where('user_id', auth()->id())
                    ->where('song_id', $id)
                    ->first();
                $song = new Song();
                $song->id = $puller_song["id"];
                $song->title = $puller_song["title"];
                $song->artist_id = $puller_song["artist_id"];
                $song->artist = $puller_song["artist"];
                $song->image_url = $puller_song["image_url"];
                $song->audio_url = $puller_song["audio_url"];
                $song->my_state = $state != null ? $state['state'] : 0;
            }
        }
        
        // 曲が見つからない場合は404エラー画面を表示
        if(is_null($song)) {
            return view('errors.404');
        }

        // 曲詳細画面を表示
        return view('pages.song', ['song' => $song, 'my_state' => $song->my_state]);
    }
}
