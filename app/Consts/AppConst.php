<?php

namespace App\Consts;

/**
 * 定数定義クラス
 */
class AppConst
{
    const DEF_STT_PAGE = 1;     // 開始ページ番号（デフォルト）
    const DEF_PER_PAGE = 50;    // 1ページの項目数（デフォルト）
    const DEF_PER_MIN_PAGE = 20;// 1ページの項目数（少量）（デフォルト）
    
    // 登録曲状態
    const STS_NONE = 0;         // 未登録
    const STS_STACKED = 1;      // 気になる
    const STS_TRINING = 2;      // 練習中
    const STS_MASTERED = 3;     // 習得済み

    // 通知状態
    const STS_UNREAD = 0;       // 未読
    const STS_READ = 1;         // 既読

    const SRC_LOCAL = -1;
    const SRC_ITUNES = 0;
    const SRC_DAM = 1;
}