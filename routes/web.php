<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# ホーム画面
Route::get('/', 'HomeController@index')->name('home');
# 通知画面
Route::get('notifications', 'NotificationController@index')->name('notifications');
# ヘルプ画面
Route::get('help', function () {return view('pages.help');})->name('help')->middleware('auth');

# ユーザ関連
Route::prefix('@{id}')->group(function() {
  # ユーザ個別画面
  Route::get('/', 'UserController@index')->name('user');
  # 記録一覧画面
  Route::get('records', 'UserController@records')->name('user.records');
  # フレンド一覧画面
  Route::get('friends', 'UserController@friends')->name('user.friends');
  # 登録曲一覧画面
  Route::get('status/{state}', 'UserController@status')->name('user.status')
    ->where('state', 'all|mastered|training|stacked');
  # 共通曲一覧画面
  Route::get('common', 'UserController@common')->name('user.common')->middleware('auth');
  # ランダム選択
  Route::get('random', 'UserController@random')->name('user.random');
});

# 曲詳細画面
Route::get('songs/{id}', 'SongController@index')->name('song')
  ->where('id', '\d{5,18}');
# アーティスト詳細画面
Route::get('artists/{id}', 'ArtistController@index')->name('artist')
  ->where('id', '\d{5,18}');

Route::get('statuses/{id}', 'PostController@index')->name('post')
  ->where('id', '\d{14}');

# 検索関連
Route::group(['prefix' => 'search', 'middleware' => 'auth'], function() {
  # ユーザ検索画面
  Route::get('user', 'SearchController@searchUser')->name('search.user');
  # 曲検索画面
  Route::get('song', 'SearchController@searchSong')->name('search.song');
});

# 設定関連
Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function() {
  # プロフィール設定関連
  Route::prefix('profile')->group(function() {
    Route::get('/', 'SettingController@showProfileSettingForm')->name('settings.profile');
    Route::post('update', 'SettingController@updateProfile')->name('settings.profile.update');
  });
  # アカウント設定関連
  Route::prefix('account')->group(function() {
    Route::get('/', 'SettingController@showAccountSettingForm')->name('settings.account');
    Route::post('email', 'SettingController@updateEmail')->name('settings.account.email');
    Route::post('password', 'SettingController@updatePassword')->name('settings.account.password');
    Route::post('deactivate', 'SettingController@updateDeactivate')->name('settings.account.deactivate');
    Route::post('undeactivate', 'SettingController@updateUndeactivate')->name('settings.account.undeactivate');
  });
});

# ツール
Route::group(['prefix' => 'tools', 'middleware' => 'auth'], function() {
  # エクスポート画面
  Route::get('export', 'ToolController@showExport')->name('tools.export');
});

# ログイン画面
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
# ログアウト
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

# ユーザ登録
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

# パスワードリセット関連
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
