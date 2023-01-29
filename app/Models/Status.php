<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 状態情報クラス
 */
class Status extends Model
{
    /** @var string テーブル名 */
    protected $table = 'statuses';

    /** @var bool   タイムスタンプ有効フラグ */
    public $timestamps = false;

    /** @var array  取得対象フィールド */
    protected $fillable = [
        'state', 'used_at'
    ];

    /** @var array  取得対象外フィールド */
    protected $hidden = [
        'user_id', 'song_id'
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function song()
    {
        return $this->belongsTo('App\Models\Song');
    }
    
    /**
     * 共通曲数取得処理
     *
     * @param   integer     $user_id ユーザーID
     * @return  integer     共通の登録済み曲数
     */
    public static function commonCount($user_id)
    {
        // 非認証または認証ユーザーと対象ユーザーが等しい場合は0を返却
        if(!auth()->check() || auth()->id() == $user_id) {
            return 0;
        }

        // 共通の登録済み曲数を取得
        $count = Status::select('statuses.song_id')
        ->join('statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->where('s1.state', 3)
            ->on('statuses.song_id', '=', 's1.song_id');
        })
        ->where('statuses.user_id', $user_id)
        ->where('statuses.state', 3)
        ->count();

        return $count;
    }
    
}