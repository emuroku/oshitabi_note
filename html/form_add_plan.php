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
// 情報登録用関数ファイル読み込み
require_once MODEL_PATH . 'add_info.php';

// 変数初期化
$travel_id = 1;

// 送信されたパラメータを入れる変数の宣言
$new_plan_title = ''; 
$new_plan_cateory = ''; 
$new_plan_start_time = ''; 
$new_plan_end_time = ''; 
$new_plan_day_num = ''; 

// DBへ接続
try {
    $dbh = get_db_connect();

    // トラベル情報を取得
    $travel_info = get_travel_info($dbh, $travel_id);

    // 日程数を取得
    $days = $travel_info[0]['days'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // --------------ここから入力情報のチェック----------------
        
        // POSTされた入力値が正規のものかをチェックする
        
        // plansテーブルへユーザ情報をINSERTする
        // ----------ここからトランザクション処理----------
        $dbh -> beginTransAction();
        try {
            // 入力値を変数に代入
            $new_plan_title = $_POST['title'];
            $new_plan_cateory = $_POST['category'];
            $new_plan_day_num = $_POST['day_num'];
            $new_plan_start_time = $_POST['start_time'];
            $new_plan_end_time = $_POST['end_time'];
            $new_plan_url = $_POST['url'];

            // member_profileテーブルへ書き込み処理
            insert_plan($dbh, $travel_id, $new_plan_day_num, $new_plan_title, $new_plan_cateory, $new_plan_start_time, $new_plan_end_time, $new_plan_url);

            // コミット処理
            $dbh -> commit();
            $insert_result = true; // 登録完了フラグをTRUEにする
        } catch (PDOException $e) {
                
                // ロールバック処理
            echo 'トランザクション中のエラーが発生しました。理由: ' . $e -> getMessage();
            $dbh -> rollback();
            // 例外をスロー
            throw $e;
        }
        // ----------ここまでトランザクション処理----------
    }
} catch (PDOException $e) {
    // DB接続に失敗した場合エラーを返す
}

// topページのクライアントソースファイル読み込み
include_once VIEW_PATH . 'form_add_plan_view.php';
