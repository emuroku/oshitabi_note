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
$new_member_sumbnail = ''; 
$new_member_blood_type = ''; 
$new_member_favorite = ''; 

// DBへ接続
try {
    $dbh = get_db_connect();

    // トラベル情報を取得
    $travel_info = get_travel_info($dbh, $travel_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // --------------ここから入力情報のチェック----------------
        
        // POSTされた入力値が正規のものかをチェックする
        // アップロード画像ファイルのチェックと保存
        $member_thumbnail_dir = '../assets/img/members/';
        if (is_uploaded_file($_FILES['img']['tmp_name']) === TRUE) {
            // 画像ファイルのチェック
            $result_post = extension_check($_FILES);
            if($result_post === FALSE){
                 $err_msg[] = "ファイル形式が異なります。画像ファイルはPNGもしくはJPEGのみ利用可能です。";
            }
            // 画像ファイルの書き込み 拡張子が適切であれば、ファイルを移動して保存
            else {
                // ファイル名の生成
                $new_img_filename = create_filename($_FILES);
                // ファイルの書き込み
                $err_msg = file_upload($_FILES, $err_msg, $new_img_filename, $member_thumbnail_dir);
            }
        } else {
            $err_msg[] = 'ファイルを選択してください';
        }
        // NGの場合、エラーメッセージを追加する
        
        // メンバーテーブルへユーザ情報をINSERTする
        // ----------ここからトランザクション処理----------
        $dbh -> beginTransAction();
        try {
            // 入力値を変数に代入
            $new_member_name = $_POST['name'];
            $new_member_thumbnail = $_POST['img'];
            $new_member_blood_type = $_POST['blood_type'];
            $new_member_favorite = $_POST['favorite'];
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
include_once VIEW_PATH . 'form_add_member_view.php';
