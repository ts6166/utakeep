<?php

namespace App\Http\Controllers\Api;

use App\Models\Avatar;
use Illuminate\Http\Request;

/**
 * プロフィール画像関連API制御クラス
 */
class AvatarController extends ApiController
{   
    /**
     * プロフィール画像取得処理
     * 
     * @param Request $request
     * @return array $response
     */
    public function index(Request $request)
    {
        // バリデートチェック
        $this->QueryValidate($request, [
            'category' => 'required|string|between:1,20',
        ]);

        // プロフィール画像レコードを取得
        $response = Avatar::where('category', $request->category)->get();

        // 200（正常）を返却
        return response()->json($response)->setStatusCode(200);
    }

}
