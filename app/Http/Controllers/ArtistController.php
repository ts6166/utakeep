<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Libraries\SongPuller\Puller;
use Illuminate\Http\Request;

/**
 * アーティスト関連画面制御クラス
 */
class ArtistController extends Controller
{
    /**
     * アーティスト詳細画面表示処理
     *
     * @param integer $id   アーティストID
     * @return void
     */
    public function index($id)
    {
        // アーティスト情報を取得
        $artist = Puller::lookArtist($id);

        // アーティスト情報の取得に失敗した場合は404エラー画面を表示
        if(is_null($artist)) {
            return view('errors.404');
        }

        // アーティスト詳細画面を表示
        return view('pages.artist', ['artist' => new Artist($artist['artist_id'], $artist['artist'])]);
    }
}
