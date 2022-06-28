<?php
header('X-Frame-Options:DENY'); // クリックジャッキング対策

// 定数ファイル読み込み
require_once '../conf/const.php';
// DB接続用関数ファイル読み込み
require_once MODEL_PATH . 'db.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// TOPページ用関数ファイル読み込み
require_once MODEL_PATH . 'top.php';

$delete_plan_id = 0; // plan削除実行用の変数を用意

// session開始
session_start();

// CSRF対策
$token = get_csrf_token();

// PDO取得
$db = get_db_connect();

// トラベルid取得
$travel_id = 1; // 一旦固定で。

// トラベル情報を取得
$travel_info = get_travel_info($db, $travel_id);
// 日程数を取得
$days = $travel_info[0]['days'];

// REQUEST_METHODで削除オーダーを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sql_order']) === TRUE) {
        $sql_order = $_POST['sql_order'];
        
    }

    // planを削除する場合
    if ($sql_order === 'delete_plan') {
        $delete_plan_id = $_POST['delete_id'];
        delete_plan($db, $delete_plan_id);
        $dialog = 'プランを削除しました';
        
    } else if($sql_order === 'delete_member'){
        // memberを削除する場合
        $delete_member_id = $_POST['delete_id'];
        delete_member($db, $delete_member_id);
    }
    
}

// 参加メンバー情報を取得
$members_info = get_members_info($db, $travel_id);
// var_dump($members_info);

// メンバーリスト表示のレイアウトcol数を算出
$members_num = count($members_info);
$memberslist_col_num = calc_memberslist_col_num($members_num);

// 旅程情報を取得
$plans_info = get_plans_info($db, $travel_id);

// topページのクライアントソースファイル読み込み
include_once VIEW_PATH . 'top_view.php';
