<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 削除申請情報クラス
 */
class Deactivate extends Model
{
    /** @var string テーブル名 */
    protected $table = 'deactivates';

    /** @var bool   タイムスタンプ有効フラグ */
    public $timestamps = false;
    
}
