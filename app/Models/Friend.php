<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * フレンド情報クラス
 */
class Friend extends Model
{
    /** @var string テーブル名 */
    protected $table = 'friends';
    
    /** @var bool　 タイムスタンプ有効フラグ */
    public $timestamps = false;
    
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
    public function following()
    {
        return $this->belongsTo('App\Models\User');
    }
}
