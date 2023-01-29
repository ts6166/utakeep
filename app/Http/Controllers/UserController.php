<?php

namespace App\Http\Controllers;

use App\Consts\AppConst;
use App\Libraries\Rivision;
use App\Models\Status;
use Illuminate\Http\Request;

/**
 * ユーザー関連画面制御クラス
 */
class UserController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->middleware('user');
    }

    /**
     * ユーザー詳細画面表示処理
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        // ユーザー詳細画面を表示
        return view('pages.users.index', ['user' => $request->user]);
    }

    /**
     * 記録一覧画面表示処理
     *
     * @param Request $request
     * @return void
     */
    public function records(Request $request)
    {
        // 記録一覧画面を表示
        return view('pages.users.records', ['user' => $request->user]);
    }

    /**
     * フレンド一覧画面表示処理
     *
     * @param Request $request
     * @return void
     */
    public function friends(Request $request)
    {
        // フレンド一覧画面を表示
        return view('pages.users.friends', ['user' => $request->user]);
    }

    /**
     * 登録曲一覧画面表示処理
     *
     * @param Request $request
     * @return void
     */
    public function status(Request $request)
    {
        $stateArray = [
            'all' => ['index' => 0, 'jp' => '登録済みの曲', 'en' => 'all', 'icon-class' => 'fa fa-check'], 
            'stacked' => ['index' => 1, 'jp' => '気になる曲', 'en' => 'stacked', 'icon-class' => 'far fa-sticky-note'], 
            'training' => ['index' => 2, 'jp' => '練習中の曲', 'en' => 'training', 'icon-class' => 'fas fa-graduation-cap'], 
            'mastered' => ['index' => 3, 'jp' => '習得済みの曲', 'en' => 'mastered', 'icon-class' => 'fa fa-check'], 
        ];
        $response = [
            'user' => $request->user,
            'state' => $stateArray[$request->state],
            'page' => Rivision::page($request->page),
            'q' => Rivision::q($request->q)
        ];

        // 登録曲一覧画面を表示
        return view('pages.users.status', $response);
    }

    /**
     * 共通登録曲一覧画面表示処理
     *
     * @param Request $request
     * @return void
     */
    public function common(Request $request)
    {
        // ログイン中のユーザーと対象のユーザーIDが等しい場合はユーザー詳細画面を表示
        if(auth()->id() == $request->user->id) {
            return redirect()->route('user', ['id' => auth()->user()->screen_name]);
        }

        $response = [
            'user' => $request->user,
            'page' => Rivision::page($request->page)
        ];

        // 共通登録曲一覧画面を表示
        return view('pages.users.common', $response);
    }

    /**
     * ランダム曲選択処理
     *
     * @param Request $request
     * @return void
     */
    public function random(Request $request)
    {
        // 「習得済み」の曲をランダムに1件のみ取得
        $status = Status::select('song_id')
            ->where('user_id', $request->user->id)
            ->where('state', AppConst::STS_MASTERED)
            ->inRandomOrder()
            ->first();

        // 取得結果によって表示画面を分岐
        if(isset($status)) {
            // 曲詳細画面を表示
            return redirect()->route('song', ['id' => $status['song_id']]);
        } else {
            $alert = ['type' => 'danger', 'text' => '習得済みに登録されている曲が見つかりませんでした'];
            // ユーザー詳細画面を表示
            return view('pages.users.index', ['user' => $request->user, 'alert' => $alert]);
        }
    }
}
