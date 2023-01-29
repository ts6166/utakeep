<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\Deactivate;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateDeactiveRequest;
use Illuminate\Http\Request;

/**
 * 設定関連画面制御クラス
 */
class SettingController extends Controller
{
    /**
     * プロフィール編集画面表示処理
     *
     * @return void
     */
    public function showProfileSettingForm()
    {
        // プロフィール編集画面を表示
        return view('pages.settings.profile');
    }

    /**
     * アカウント設定画面表示処理
     *
     * @return void
     */
    public function showAccountSettingForm()
    {
        $response['isApplied'] = Deactivate::where('user_id', auth()->user()->id)->exists();

        // アカウント設定画面を表示
        return view('pages.settings.account', $response);
    }

    /**
     * プロフィール更新処理
     *
     * @param UpdateProfileRequest $request
     * @return void
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        // ユーザー情報レコードを更新
        $user = auth()->user();
        $user->name = $request->name;
        $user->description = $request->description;
        if(isset($request->avatar)) {
            $avatar = Avatar::find($request->avatar);
            if(isset($avatar)) {
                $user->profile_image = "{$avatar->category}/{$avatar->id}";
            }
        }
        $result = $user->save();

        // プロフィール編集画面を表示
        return redirect()->route('settings.profile')
            ->with($result ? 'status' : 'error', 
                __($result ? "プロフィールの変更を保存しました" : 'プロフィールの変更に失敗しました'));
    }

    /**
     * メールアドレス更新処理
     *
     * @param UpdateEmailRequest $request
     * @return void
     */
    public function updateEmail(UpdateEmailRequest $request)
    {
        // ユーザー情報レコードのメールアドレスを更新
        $user = auth()->user();
        $user->email = $request->email;
        $result = $user->save();

        // アカウント設定画面を表示
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "メールアドレスの変更を保存しました" : 'メールアドレスの変更に失敗しました'));
    }

    /**
     * パスワード更新処理
     *
     * @param UpdatePasswordRequest $request
     * @return void
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        // ユーザー情報レコードのパスワードを更新
        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $result = $user->save();

        // アカウント設定画面を表示
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "パスワードの変更を保存しました" : 'パスワードの変更に失敗しました'));
    }

    /**
     * アカウント削除申請処理
     *
     * @param UpdateDeactiveRequest $request
     * @return void
     */
    public function updateDeactivate(UpdateDeactiveRequest $request)
    {
        // アカウント削除申請レコードを作成する
        $result = Deactivate::insert(['user_id' => auth()->user()->id]);

        // アカウント設定画面を表示
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "アカウントの削除申請を受け付けました" : 'アカウントの削除申請に失敗しました'));
    }

    /**
     * アカウント削除申請取り消し処理
     *
     * @param UpdateDeactiveRequest $request
     * @return void
     */
    public function updateUndeactivate(UpdateDeactiveRequest $request)
    {
        // アカウント削除申請レコードを削除する
        $result = Deactivate::where('user_id', auth()->user()->id)->delete();

        // アカウント設定画面を表示
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "アカウントの削除申請を解除しました" : 'アカウントの削除申請の解除に失敗しました'));
    }
    
}
