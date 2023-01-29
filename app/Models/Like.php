<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * いいね情報クラス
 */
class Like extends Model
{
    /** @var string テーブル名 */
    protected $table = 'likes';

    /** @var bool   タイムスタンプ有効フラグ */
    public $timestamps = false;
    
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
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
