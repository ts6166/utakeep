<?php

namespace App\Http\Controllers\Api;

use App\Consts\AppConst;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

/**
 * フレンド関連API制御クラス
 */
class FriendController extends ApiController
{   
    /**
     * フォロー一覧取得処理
     * 
     * @param Request $request
     * @return array $response
     */
    public function following(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
            'page' => 'nullable|numeric|between:1,9999',
        ]);

        $response = [];
        $page = $request->query('page', AppConst::DEF_STT_PAGE);
        $count = AppConst::DEF_PER_MIN_PAGE;

        // フレンドレコードを取得
        $results = Friend::select('user_id')
            ->where('following_id', $request->id)
            ->skip(($page - 1) * $count)
            ->take($count)
            ->with('user')
            ->get();

        foreach($results as $result) {
            $response[] = $result->user;
        }

        // 200（正常）を返却
        return response()->json($response)->setStatusCode(200);
    }

    /**
     * フォロワー一覧取得処理
     * 
     * @param Request $request
     * @return array $response
     */
    public function followers(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
            'page' => 'nullable|numeric|between:1,9999',
        ]);

        $response = [];
        $page = $request->query('page', AppConst::DEF_STT_PAGE);
        $count = AppConst::DEF_PER_MIN_PAGE;
        
        // フレンドレコードを取得
        $results = Friend::select('following_id')
            ->where('user_id', $request->id)
            ->skip(($page - 1) * $count)
            ->take($count)
            ->with('following')
            ->get();

        foreach($results as $result) {
            $response[] = $result->following;
        }

        // 200（正常）を返却
        return response()->json($response)->setStatusCode(200);
    }

    /**
     * フレンド登録処理
     * 
     * @param Request $request
     * @return bool
     */
    public function create(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
        ]);

        // 認証ユーザーと対象ユーザーが等しい場合は、422（処理不可）を返却
        $following_user = auth()->user();
        if($following_user->id == $request->id) {
            return response()->json()->setStatusCode(422);
        }

        // 対象ユーザーが存在しない場合は、404（検出不可）を返却
        $user = User::find($request->id);
        if(is_null($user)) {
            return response()->json()->setStatusCode(404);
        }

        // トランザクションを開始
        DB::beginTransaction();
        try {
            // フレンドレコードを作成して、フォロー数を更新
            Friend::insert([
                'user_id' => $user->id,
                'following_id' => auth()->id()
            ]);
            $following_user->following_count++;
            $user->follower_count++;
            $following_user->save();
            $user->save();

            // 通知を発行
            Notification::create($user->id, null, 'follow');

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
     * フレンド解除処理
     * 
     * @param Request $request
     * @return bool
     */
    public function destroy(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
        ]);
        
        // 認証ユーザーと対象ユーザーが等しい場合は、422（処理不可）を返却
        $following_user = auth()->user();
        if($following_user->id == $request->id) {
            return response()->json()->setStatusCode(422);
        }
        
        // 対象ユーザーが存在しない場合は、404（検出不可）を返却
        $user = User::find($request->id);
        if(is_null($user)) {
            return response()->json()->setStatusCode(404);
        }
        
        // トランザクションを開始
        DB::beginTransaction();
        try {
            // フレンドレコードを削除して、フォロー数を更新
            $deleteCount = Friend::where('user_id', $user->id)
                ->where('following_id', auth()->id())
                ->delete();
            if($deleteCount != 1) {
                throw new \Exception();
            } 
            $following_user->following_count--;
            $user->follower_count--;
            $following_user->save();
            $user->save();

            // 通知を取り消し
            Notification::remove($user->id);

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
