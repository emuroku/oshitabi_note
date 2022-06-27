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
$new_member_name = ''; 
$new_member_thumbnail = ''; 
$new_member_blood_type = ''; 
$new_member_favorite = ''; 

// DBへ接続
try {
    $dbh = get_db_connect();

    // トラベル情報を取得
    $travel_info = get_travel_info($dbh, $travel_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // --------------ここから入力情報のチェック----------------
        
        // メンバーテーブルへユーザ情報をINSERTする
        // ----------ここからトランザクション処理----------
        $dbh -> beginTransAction();

        // 入力値を変数に代入
        $new_member_name = $_POST['name'];
        // $new_member_thumbnail = $_POST['img']; // 画像は別途処理
        $new_member_blood_type = $_POST['blood_type'];
        $new_member_favorite = $_POST['favorite'];

        // -------画像のアップロード---------
        $image = uniqid(mt_rand(), true); //ファイル名をユニーク化
        $new_member_thumbnail = $image . '.' . substr(strrchr($_FILES['img']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
        print($image);
        $file = '../html/assets/img/members/' . $new_member_thumbnail;
        if (!empty($_FILES['img']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
            print('upload');
            move_uploaded_file($_FILES['img']['tmp_name'], '../html/assets/img/members/' . $new_member_thumbnail);//imagesディレクトリにファイル保存
            if (exif_imagetype($file)) {//画像ファイルかのチェック
                $message = '画像をアップロードしました';
            } else {
                $message = '画像ファイルではありません';
            }

            // -------ここまで画像アップロード処理--------


            // member_profileテーブルへ書き込み処理
            insert_member_profile($dbh, $new_member_name, $new_member_thumbnail, $new_member_blood_type, $new_member_favorite);
            // profileテーブルに書き込んだmember_id（AUTO_INCREMENT）の取得
            $added_member_id_array = get_added_member_id($dbh);
            $added_member_id = $added_member_id_array[0]['LAST_INSERT_ID()'];

            // membersテーブルへtravel_idと紐づけて登録
            insert_member($dbh, $travel_id, $added_member_id);
            // コミット処理
            $dbh -> commit();
            $insert_result = true; // 登録完了フラグをTRUEにする
        }
    }
    } catch (PDOException $e) {
                
                // ロールバック処理
            echo 'トランザクション中のエラーが発生しました。理由: ' . $e -> getMessage();
            $dbh -> rollback();
            // 例外をスロー
            throw $e;
    }
    // ----------ここまでトランザクション処理----------
// topページのクライアントソースファイル読み込み
include_once VIEW_PATH . 'form_add_member_view.php';
