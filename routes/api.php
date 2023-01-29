<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API関連
Route::middleware('api')->group(function() {
    // 統計情報取得API
    Route::prefix('application')->group(function() {
        Route::get('analysis', 'Api\ApplicationController@analysis');
        Route::get('resource', 'Api\ApplicationController@resource');
    });

    // フレンドAPI関連
    Route::prefix('friends')->group(function() {
        // フォロー一覧取得API
        Route::get('following', 'Api\FriendController@following');
        // フォロワー一覧取得API
        Route::get('followers', 'Api\FriendController@followers');
    });

    // 曲API関連
    Route::prefix('songs')->group(function() {
        // 曲検索API
        Route::get('/', 'Api\SongController@index');
        // 登録曲取得API
        Route::get('@{id}', 'Api\SongController@user');
        // 共通曲取得API
        Route::get('@{id}/common', 'Api\SongController@common');
        // リリース曲取得API
        Route::get('recent', 'Api\SongController@recent');
        // ランキング曲取得API
        Route::get('ranking', 'Api\SongController@ranking');
        // 歌詞取得API
        Route::get('lyric', 'Api\SongController@getLyric');
    });

    // 状態API関連
    Route::prefix('statuses')->group(function() {
        Route::get('lookup', 'Api\StatusController@lookup');
        Route::get('registerdUser', 'Api\StatusController@registerdUser');
    });

    // タイムライン取得API
    Route::get('timeline', 'Api\PostController@index');

    // ユーザ一覧取得API
    Route::get('users', 'Api\UserController@index');

    Route::middleware('auth.api')->group(function() {
        // プロフィール画像取得API
        Route::get('avatars', 'Api\AvatarController@index');
    
        // フレンドAPI関連
        Route::prefix('friends')->group(function() {
            // フォロー適用API
            Route::post('create', 'Api\FriendController@create');
            // フォロー解除API
            Route::post('destroy', 'Api\FriendController@destroy');
        });
        
        // いいねAPI関連
        Route::prefix('likes')->group(function() {
            // いいね適用API
            Route::post('create', 'Api\LikeController@create');
            // いいね解除API
            Route::post('destroy', 'Api\LikeController@destroy');
        });

        // 通知取得API
        Route::get('notifications', 'Api\NotificationController@index');

        // 記録削除API
        Route::prefix('posts')->group(function() {
            Route::post('destroy', 'Api\PostController@destroy');
        });
        
        // 状態API関連
        Route::prefix('statuses')->group(function() {
            // 状態変更API
            Route::post('update', 'Api\StatusController@update');
        });
    });
});
