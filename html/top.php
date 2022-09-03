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


$delete_plan_id = 0; // plan削除実行用の変数を用意

// AddPlanで送信されたパラメータを入れる変数の宣言
$new_plan_title = '';
$new_plan_cateory = '';
$new_plan_start_time = '';
$new_plan_end_time = '';
$new_plan_day_num = '';
$new_plan_url = '';

// session開始
session_start();
// $_SESSION['key'] = md5(uniqid() . mt_rand());

// CSRF対策
$token = get_csrf_token();

// PDO取得
$db = get_db_connect();

// GETパラメータからトラベルid取得
$tmp_h_param = get_get('h');

// GETパラメータがparamと合致するレコードをtravelsテーブルから検索
$search_result = get_match_travel_id($db, $tmp_h_param);
// var_dump($search_result);

// FALSEが返ってきたら一致レコード無し。mainへリダイレクト
if ($search_result === FALSE) {
    header('Location: main.php');
    exit;
} else {
    $travel_id = $search_result;
}

// トラベル情報を取得
$travel_info = get_travel_info($db, $travel_id);
// 日程数を取得
$days = $travel_info[0]['days'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 多重submit対策
    // session_start();
    // if (isset($_SESSION['key'], $_POST['key']) && $_SESSION['key'] == $_POST['key']) {
    //     unset($_SESSION['key']);
    // } else {
    //     header("Location: " . $_SERVER['PHP_SELF'] . "?h=" . $travel_info[0]['param']);
    // }

    session_start();
    header("Location: " . $_SERVER['PHP_SELF'] . "?h=" . $travel_info[0]['param']);
    

    if (isset($_POST['sql_order']) !== true) {
        // すべての項目が埋まってるかチェック
        if (is_post_available($_POST) === true) {

            // メンバーテーブルへユーザ情報をINSERTする
            // ----------ここからトランザクション処理----------
            try {
                $db->beginTransAction();

                // 入力値を変数に代入
                $new_member_name = $_POST['name'];
                // $new_member_thumbnail = $_POST['img']; // 画像は別途処理
                $new_member_blood_type = $_POST['blood_type'];
                $new_member_favorite = $_POST['favorite'];

                // -------サムネ画像のアップロード---------
                $new_member_thumbnail = upload_img($_FILES, '../html/assets/img/members/');

                // member_profileテーブルへ書き込み処理
                insert_member_profile($db, $new_member_name, $new_member_thumbnail, $new_member_blood_type, $new_member_favorite);
                // profileテーブルに書き込んだmember_id（AUTO_INCREMENT）の取得
                $added_member_id_array = get_added_member_id($db);
                $added_member_id = $added_member_id_array[0]['LAST_INSERT_ID()'];

                // membersテーブルへtravel_idと紐づけて登録
                insert_member($db, $travel_id, $added_member_id);
                // コミット処理
                $db->commit();
                $insert_result = true; // 登録完了フラグをTRUEにする
            } catch (PDOException $e) {
                // ロールバック処理
                echo 'トランザクション中のエラーが発生しました。理由: ' . $e->getMessage();
                $db->rollback();
                // 例外をスロー
                throw $e;
            }
            // ----------ここまでトランザクション処理----------
        }
    }

    // 既存レコードの操作オーダーを受け取った場合の処理
    elseif (isset($_POST['sql_order']) === true) {
        $sql_order = $_POST['sql_order'];

        // Plan追加
        if ($sql_order === 'add_plan') {

            // if (is_post_available($_POST) === true) {
            // DBへ接続
            $db->beginTransAction();
            try {
                // 入力値を変数に代入
                $new_plan_title = $_POST['title'];
                $new_plan_cateory = $_POST['category'];
                $new_plan_day_num = $_POST['day_num'];
                $new_plan_start_time = $_POST['start_time'];
                $new_plan_end_time = $_POST['end_time'];
                $new_plan_url = $_POST['url'];

                if ($new_plan_start_time === '') {
                    $new_plan_start_time = null;
                }
                if ($new_plan_end_time === '') {
                    $new_plan_end_time = null;
                }

                // member_profileテーブルへ書き込み処理
                insert_plan($db, $travel_id, $new_plan_day_num, $new_plan_title, $new_plan_cateory, $new_plan_start_time, $new_plan_end_time, $new_plan_url);

                // コミット処理
                $db->commit();
                $insert_result = true; // 登録完了フラグをTRUEにする
            } catch (PDOException $e) {

                // ロールバック処理
                echo 'トランザクション中のエラーが発生しました。理由: ' . $e->getMessage();
                $db->rollback();
                // 例外をスロー
                throw $e;
            }
            // ----------ここまでトランザクション処理----------
        }

        // planを削除する場合
        elseif ($sql_order === 'delete_plan') {
            $delete_plan_id = $_POST['delete_id'];
            delete_plan($db, $delete_plan_id);
            $dialog = 'プランを削除しました';
        } elseif ($sql_order === 'delete_member') {
            // memberを削除する場合
            $delete_member_id = $_POST['delete_id'];
            delete_member($db, $delete_member_id);
        } elseif ($sql_order === 'update_profile') {
            // 登録済みprofileをupdateする場合
            $update_member_id = $_POST['update_member_id'];
            $update_member_name = $_POST['name'];
            $update_member_blood_type = $_POST['blood_type'];
            $update_member_thumbnail = upload_img($_FILES, '../html/assets/img/members/');
            $update_member_favorite = $_POST['favorite'];
            update_profile(
                $db,
                $update_member_id,
                $update_member_name,
                $update_member_thumbnail,
                $update_member_blood_type,
                $update_member_favorite
            );
        } elseif ($sql_order === 'update_plan') {
            // 登録済みplanをupdateする場合
            $update_plan_id = $_POST['update_plan_id'];
            $update_plan_name = $_POST['title'];
            $update_plan_category = $_POST['category'];
            $update_plan_start_time = $_POST['start_time'];
            $update_plan_end_time = $_POST['end_time'];
            $update_plan_day_num = $_POST['day_num'];
            $update_plan_url = $_POST['url'];
            update_plan(
                $db,
                $update_plan_id,
                $update_plan_name,
                $update_plan_category,
                $update_plan_start_time,
                $update_plan_end_time,
                $update_plan_day_num,
                $update_plan_url
            );
        }
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
