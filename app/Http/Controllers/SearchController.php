<?php

namespace App\Http\Controllers;

use App\Libraries\Rivision;
use Illuminate\Http\Request;

/**
 * 検索関連画面制御クラス
 */
class SearchController extends Controller
{
    /**
     * ユーザー検索画面表示処理
     *
     * @param Request $request
     * @return void
     */
    public function searchUser(Request $request)
    {
        $response = [
            'q' => Rivision::q($request->q),
            'page' => Rivision::page($request->page)
        ];

        // ユーザー検索画面を表示
        return view('pages.search.user', $response);
    }

    /**
     * 曲検索画面表示処理
     *
     * @param Request $request
     * @return void
     */
    public function searchSong(Request $request)
    {
        $response = [
            'source' => (isset($request->source) && $request->source >= 0 && $request->source <= 1) ? $request->source : 0,
            'q' => Rivision::q($request->q),
            'page' => Rivision::page($request->page)
        ];

        // 曲検索画面を表示
        return view('pages.search.song', $response);
    }
}
