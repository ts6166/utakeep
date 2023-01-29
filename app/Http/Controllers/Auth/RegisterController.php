<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

/**
 * アカウント登録画面制御クラス
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /** @var string リダイレクトURL */
    protected $redirectTo = '/';

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            #'agreement' => 'required',
            'screen_name' => 'required|string|max:15|regex:/^[a-zA-Z0-9_]+$/|unique:users',
            'name' => 'required|string|max:20',
            'email' => 'sometimes|nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * アカウント作成処理
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'screen_name' => $data['screen_name'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'profile_image' => 'mark/mark_' . str_pad(rand(1, 24), 2, 0, STR_PAD_LEFT),
        ]);
    }

    /**
     * アカウント登録後処理
     *
     * @param Request $request
     * @param [type] $user
     * @return void
     */
    protected function registered(Request $request, $user)
    {
        return redirect('/')->with('status', __('messages.nav_regstered', ['screen_name' => $user->screen_name]));
    }
}
