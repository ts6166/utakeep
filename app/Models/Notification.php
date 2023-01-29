<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 通知情報クラス
 */
class Notification extends Model
{
    /** @var string テーブル名 */
    protected $table = 'notifications';

    /** @var string タイムスタンプ有効フラグ */
    public $timestamps = false;

    /** @var array  取得対象外フィールド */
    protected $hidden = [
        'receiver_id', 'sender_id', 'post_id', 'song_id'
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
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
     * 通知レコード作成処理
     *
     * @param integer       $receiver_id  受信ユーザーID
     * @param integer|null  $context_id   記録ID
     * @param integer       $kind         通知種別
     * @return void
     */
    public static function create($receiver_id, $context_id, $kind)
    {
        // 通知レコード作成
        Notification::insert([
            'receiver_id' => $receiver_id,
            'sender_id' => auth()->id(),
            'context_id' => $context_id,
            'kind' => $kind
        ]);
    }

    /**
     * 通知レコード削除処理
     *
     * @param integer       $receiver_id  受信ユーザーID
     * @param integer|null  $context_id   記録ID
     * @return void
     */
    public static function remove($receiver_id, $context_id = null)
    {
        // 通知レコード削除
        Notification::where('receiver_id', $receiver_id)
            ->where('sender_id', auth()->id())
            ->where('context_id', $context_id)
            ->delete();
    }
    
}
