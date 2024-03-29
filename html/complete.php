<?php
// 新しい旅を登録した直後にURLを発行するcompleteページ

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


// session開始
session_start();

// CSRF対策
$token = get_csrf_token();

// PDO取得
$db = get_db_connect();

// REQUEST_METHODで削除オーダーを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // travelsテーブルへユーザ情報をINSERTする
        if (is_post_available($_POST) === true) {
            // ----------ここからトランザクション処理----------
            try {
                $db -> beginTransAction();

                // 入力値を変数に代入
                $new_travel_title = $_POST['title'];
                $new_travel_start_date = $_POST['start_date'];
                $new_travel_end_date = $_POST['end_date'];
                $new_travel_days_num = $_POST['days'];
                $new_travel_thumbnail = '';

                // travelsテーブルへ書き込み処理
                insert_travel_info($db, $new_travel_title, $new_travel_start_date, 
                    $new_travel_end_date, $new_travel_days_num, $new_travel_thumbnail);
                        
                $db -> commit();
                $insert_result = true; // 登録完了フラグをTRUEにする
                
            } catch (PDOException $e) {
                // ロールバック処理
                echo 'トランザクション中のエラーが発生しました。理由: ' . $e -> getMessage();
                $db -> rollback();
                // 例外をスロー
                throw $e;
            }

            // INSERT成功したレコードのparamを取得する
            $added_url_param = get_added_travel_param($db);
        }
        // ----------ここまでトランザクション処理----------
    }

// topページのクライアントソースファイル読み込み
$_GET['h'] = $added_url_param;
include_once 'registered.php';