<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 曲情報クラス
 */
class Song extends Model
{
    /** @var string テーブル名 */
    protected $table = 'songs';

    /** @var string 主キー型 */
    protected $keyType = 'string';

    /** @var bool   自動インクリメント有効フラグ */
    public $incrementing = false;

    /** @var bool   タイムスタンプ有効フラグ */
    public $timestamps = false;
    
    /** @var array  取得対象フィールド */
    protected $fillable = [];
    
    /** @var array  取得対象外フィールド */
    protected $hidden = [
        'created_at'
    ];
    
}
