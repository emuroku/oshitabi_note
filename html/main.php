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


// AddTravelで送信されたパラメータを入れる変数の宣言
$new_travel_title = ''; 
$new_travel_start_date = ''; 
$new_travel_end_date = ''; 
$new_travel_days_num = 1; 
$new_travel_thumbnail = '';

// session開始
session_start();

// CSRF対策
$token = get_csrf_token();

// PDO取得
$db = get_db_connect();

// REQUEST_METHODで削除オーダーを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // travelsテーブルへユーザ情報をINSERTする
        // ----------ここからトランザクション処理----------
        try {
            $db -> beginTransAction();

            // 入力値を変数に代入
            $new_travel_title = $_POST['title'];
            $new_travel_start_date = $_POST['start_date'];
            $new_travel_end_date = $_POST['end_date'];
            $new_travel_days_num = $_POST['days'];

            // -------画像のアップロード---------
            $image = uniqid(mt_rand(), true); //ファイル名をユニーク化
            $new_travel_thumbnail = $image . '.' . substr(strrchr($_FILES['img']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
            $file = '../html/assets/img/thumbnail/' . $new_travel_thumbnail;
            if (!empty($_FILES['img']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
                move_uploaded_file($_FILES['img']['tmp_name'], '../html/assets/img/thumbnail/' . $new_travel_thumbnail);//imagesディレクトリにファイル保存
                    if (exif_imagetype($file)) {//画像ファイルかのチェック
                        $message = '画像をアップロードしました';
                    } else {
                        $message = '画像ファイルではありません';
                    }

                // -------ここまで画像アップロード処理--------

                // travelsテーブルへ書き込み処理
                insert_travel_info($db, $new_travel_title, $new_travel_start_date, $new_travel_end_date, $new_travel_days_num, $new_travel_thumbnail);
                
                $db -> commit();
                $insert_result = true; // 登録完了フラグをTRUEにする
            }
        } catch (PDOException $e) {
            // ロールバック処理
            echo 'トランザクション中のエラーが発生しました。理由: ' . $e -> getMessage();
            $db -> rollback();
            // 例外をスロー
            throw $e;
        }
        // ----------ここまでトランザクション処理----------
    }

    // 既存レコードの操作オーダーを受け取った場合の処理
    elseif (isset($_POST['sql_order']) === true) {
        $sql_order = $_POST['sql_order'];

        // Plan追加
        if ($sql_order === 'add_plan') {
            // DBへ接続
            $db -> beginTransAction();
            try {
                // 入力値を変数に代入
                $new_plan_title = $_POST['title'];
                $new_plan_cateory = $_POST['category'];
                $new_plan_day_num = $_POST['day_num'];
                $new_plan_start_time = $_POST['start_time'];
                $new_plan_end_time = $_POST['end_time'];
                $new_plan_url = $_POST['url'];

                if($new_plan_start_time === ''){
                    $new_plan_start_time = NULL;
                }
                if($new_plan_end_time === ''){
                    $new_plan_end_time = NULL;
                }

                // member_profileテーブルへ書き込み処理
                insert_plan($db, $travel_id, $new_plan_day_num, $new_plan_title, $new_plan_cateory, $new_plan_start_time, $new_plan_end_time, $new_plan_url);

                // コミット処理
                $db -> commit();
                $insert_result = true; // 登録完了フラグをTRUEにする
            } catch (PDOException $e) {
                        
                        // ロールバック処理
                echo 'トランザクション中のエラーが発生しました。理由: ' . $e -> getMessage();
                $db -> rollback();
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
include_once VIEW_PATH . 'main_view.php';