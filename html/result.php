<?php
header('X-Frame-Options:DENY'); // クリックジャッキング対策

// 定数ファイル読み込み
require_once '../conf/const.php';
// DB接続用関数ファイル読み込み
require_once MODEL_PATH . 'db.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// result関数ファイル読み込み
require_once MODEL_PATH . 'result.php';

// session開始
session_start();

// DB接続
$db = get_db_connect();

// ユーザーの結果が算出済みであればnumに保存
if ($_SESSION['user_num'] !== NULL) {
    $user_num = $_SESSION['user_num'];

    // デバッグ用
    // print('セッションにナンバーが保存されています' . $_SESSION['user_num']);

    // ユーザーの結果が未算出であれば算出
} else {

    // POSTされたフォームの入力値を取得
    $birth_year = get_post('year');
    $birth_month = get_post('month');
    $birth_day = get_post('day');

    // 有効な日付かどうかのチェック
    if (is_available_day($db, $birth_month, $birth_day) == TRUE) {
        header('Location: http://npburanai.com/top.php?error=true');
    }

    // ユーザーのどうぶつ占い結果を取得
    $user_num = get_animal_uranai_result($db, $birth_year, $birth_month, $birth_day);

    // sessionにユーザーの結果ナンバーを保存
    $_SESSION['user_num'] = $user_num;

    // デバッグ用
    // print('セッションに新たにナンバーが保存されました' . $_SESSION['user_num']);
}
$user_result = get_uranai_result($db, $user_num);

// ベストパートナーの選手の結果を取得
$player_result = get_player_result($db, $user_num);

// ロゴ画像用に名前を取得
$logoname = get_logoname($db, $player_result['team']);

// topページのクライアントソースファイル読み込み
include_once VIEW_PATH . 'result_view.php';
