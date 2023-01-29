<?php

namespace App\Http\Controllers\Api;

use App\Consts\AppConst;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * ユーザー関連API制御クラス
 */
class UserController extends ApiController
{   
    /**
     * ユーザー取得処理
     * 
     * @param   Request $request
     * @return  array   $response
     */
    public function index(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'keyword' => 'sometimes|string|between:1,20',
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,50',
        ]);

        $keyword = $request->query('keyword', null);
        $page = $request->query('page', AppConst::DEF_STT_PAGE);
        $per_page = $request->query('per_page', AppConst::DEF_PER_PAGE);

        // ユーザーレコードを取得
        $query = User::skip(($page - 1) * $per_page)
            ->take($per_page);

        // キーワードでの検索
        if(!is_null($keyword)) {
            $query = $query->where('screen_name', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%");
        }

        $response = $query->orderBy('mastered_count', 'desc')
            ->get();

        // 200（正常）を返却
        return response()->json($response)->setStatusCode(200);
    }

}
