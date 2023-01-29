<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 記録情報クラス
 */
class Post extends Model
{
    /** @var string テーブル名 */
    protected $table = 'posts';

    /** @var string 主キー型 */
    protected $keyType = 'string';

    /** @var bool   自動インクリメント有効フラグ */
    public $incrementing = false;

    /** @var bool   タイムスタンプ有効フラグ */
    public $timestamps = false;
    
    /** @var array  取得対象フィールド */
    protected $fillable = [
        'id', 'kind', 'created_at'
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
     * Undocumented function
     *
     * @return void
     */
    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }
    
}
