<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

/**
 * ユーザー情報クラス
 */
class User extends Authenticatable
{
    use Notifiable;

    /** @var string テーブル名 */
    protected $table = 'users';

    /** @var array  取得対象フィールド */
    protected $fillable = [
        'screen_name', 'name', 'description', 'record_count', 'stacked_count', 'training_count', 'mastered_count', 'following_count', 'follower_count', 'profile_image', 'password',
    ];

    /** @var array  取得対象外フィールド */
    protected $hidden = [
        'email', 'password', 'remember_token', 'updated_at'
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * パスワードリセットメール送信処理
     *
     * @param   string $token トークン
     * @return  void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * 登録済み曲数取得処理
     *
     * @return int 登録済み曲数
     */
    public function stateCount() 
    {
        return $this->stacked_count + $this->training_count + $this->mastered_count;
    }

    /**
     * 他ユーザー情報設定処理
     *
     * @param   User $user ユーザ情報
     * @return  void
     */
    public static function setData(&$user) 
    {
        if(auth()->check() && auth()->id() != $user->id) {
            // フレンド状態を取得
            $user->is_following = DB::table('friends')
                ->where('user_id', $user->id)
                ->where('following_id', auth()->id())
                ->exists();
            $user->is_following_you = DB::table('friends')
                ->where('user_id', auth()->id())
                ->where('following_id', $user->id)
                ->exists();

            // 共通曲のカウント
            $user->common_count = DB::table('statuses')
            ->select('statuses.song_id')
            ->join('statuses as s1', function($join) {
                $join->where('s1.user_id', auth()->id())
                ->where('s1.state', 3)
                ->on('statuses.song_id', '=', 's1.song_id');
            })
            ->where('statuses.user_id', $user->id)
            ->where('statuses.state', 3)
            ->count();
        }
    }
}
