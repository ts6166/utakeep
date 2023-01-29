<?php

namespace App\Models;

/**
 * アーティスト情報クラス
 */
class Artist
{
    /** @var integer    アーティストID */
    public $id;

    /** @var string     アーティスト名 */
    public $name;
    
    /**
     * コンストラクタ
     *
     * @param integer $id   アーティストID
     * @param string $name  アーティスト名
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    
}
