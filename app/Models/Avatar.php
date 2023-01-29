<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * プロフィール画像情報クラス
 */
class Avatar extends Model
{
    /** @var string テーブル名 */
    protected $table = 'avatars';

    /** @var string 主キー型 */
    protected $keyType = 'string';

    /** @var bool   自動インクリメント有効フラグ */
    public $incrementing = false;

    /** @var bool   タイムスタンプ有効フラグ */
    public $timestamps = false;
    
}
