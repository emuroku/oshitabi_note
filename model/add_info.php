<?php

// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';

// topページ用関数ファイル読み込み
require_once MODEL_PATH . 'top.php';

// 旅程 新規登録：POSTされたデータをbindValueしてplansテーブルへINSERTする
function insert_travel_info($dbh, $title, $start_date, $end_date, $days_num, $thumbnail)
{

    $result_url_checked = FALSE;
    $new_param = '';

    while ($result_url_checked === FALSE) {
        // 専用URL用のランダム文字列を生成
        $new_param = generate_new_url_str();
        // print ($new_param);

        // 既存のtravelレコードに一致する文字列をもつparamがないかチェックする
        $result_url_checked = is_param_available($dbh, $new_param);

        // ※有効な文字列が生成されるまで繰り返す
    }

    // SQL文の作成
    $sql = 'INSERT INTO 03_travels (travel_name, param, thumbnail, start_date, end_date, days) VALUES(?, ?, ?, ?, ?, ?);';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $title, PDO::PARAM_STR);
    $stmt->bindValue(2, $new_param, PDO::PARAM_STR);
    $stmt->bindValue(3, $thumbnail, PDO::PARAM_INT);
    $stmt->bindValue(4, $start_date, PDO::PARAM_STR);
    $stmt->bindValue(5, $end_date, PDO::PARAM_STR);
    $stmt->bindValue(6, $days_num, PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
}

function is_param_available($dbh, $str)
{

    $result = FALSE;

    // SQL文の作成
    $sql = 'SELECT * FROM `03_travels` WHERE param = ?;';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $str, PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    $tmp_data = $stmt->fetchAll();

    // 結果をカウント
    if (count($tmp_data) === 0 && $str != '') {
        $result = true;
    }

    return $result;
}

// メンバー新規登録：POSTされたデータをbindValueしてmembersテーブルへINSERTする
function insert_member($dbh, $travel_id, $member_id)
{
    // SQL文の作成
    $sql = 'INSERT INTO 03_members (travel_id, member_id) VALUES(?, ?);';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $travel_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $member_id, PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
}


// メンバー新規登録：POSTされたデータをbindValueしてmembersテーブルへINSERTする
function insert_member_profile($dbh, $name, $thumbnail, $blood_type, $favorite)
{
    // SQL文の作成
    $sql = 'INSERT INTO 03_member_profiles (member_name, member_thumbnail, blood_type, favorite) VALUES(?, ?, ?, ?);';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    $stmt->bindValue(2, $thumbnail, PDO::PARAM_STR);
    $stmt->bindValue(3, $blood_type, PDO::PARAM_STR);
    $stmt->bindValue(4, $favorite, PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
}

// ランダムURL用の文字列を生成する
function generate_new_url_str()
{
    $new_str = uniqid(mt_rand(), true);
    return $new_str;
}

// 直前にmember_profileテーブルへ登録したメンバーid（AUTO_INCREMENT）の取得
function get_added_member_id($dbh)
{
    // SQL文の作成
    $sql = 'SELECT LAST_INSERT_ID()';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    $added_member_id = $stmt->fetchAll();
    //  var_dump($added_member_id);
    return $added_member_id;
}

// 直前にtravelsテーブルへ登録したtravel_idのレコードのURL用paramの取得
function get_added_travel_param($dbh)
{
    // SQL文の作成
    $sql = 'SELECT param FROM 03_travels WHERE travel_id = LAST_INSERT_ID()';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    $added_param = $stmt->fetchAll();
    return $added_param[0]['param'];
}

// 旅程 新規登録：POSTされたデータをbindValueしてplansテーブルへINSERTする
function insert_plan($dbh, $travel_id, $day_num, $title, $category, $start_time, $end_time, $url)
{

    // トランザクションエラー避け：datetimeに仮値を指定しておく
    // $start_time = '';

    // SQL文の作成
    $sql = 'INSERT INTO 03_plans (travel_id, plan_name, plan_category, start_time, end_time, day_num, plan_url) VALUES(?, ?, ?, ?, ?, ?, ?);';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $travel_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $title, PDO::PARAM_STR);
    $stmt->bindValue(3, $category, PDO::PARAM_INT);
    $stmt->bindValue(4, $start_time, PDO::PARAM_STR);
    $stmt->bindValue(5, $end_time, PDO::PARAM_STR);
    $stmt->bindValue(6, $day_num, PDO::PARAM_INT);
    $stmt->bindValue(7, $url, PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
}

// ----------------- ここから画像登録まわり ----------------- 

//画像ファイルの拡張子を取得する
function get_extenstion($file)
{
    // 拡張子を取得
    $extension = pathinfo($file['img']['name'], PATHINFO_EXTENSION);
    return $extension;
}


// 画像ファイルの拡張子をチェックする。指定の拡張子出ない場合はFALSEを返す
function extension_check($file)
{
    $result = TRUE;
    // 拡張子を取得
    $extension = get_extenstion($file);
    // 指定の拡張子であるかチェック
    if ($extension !== 'jpeg' && $extension !== 'png' && $extension !== 'jpg') {
        $result = FALSE;
    }
    return $result;
}

// 画像ファイルをアップロードしてファイル名を返す
function create_filename($file)
{
    // ファイル名の初期化
    // 拡張子の取得
    $extension = get_extenstion($file);
    // 保存する新しいファイル名の生成
    $new_img_filename = sha1(uniqid(mt_rand(), true)) . '.' . $extension;

    return $new_img_filename;
}

// 画像ファイル名を受け取ってファイルを保存する
function file_upload($file, $err_msg, $filename, $img_dir)
{
    // 同名ファイルが存在するかチェックし、アップロード出来ない場合はエラーメッセージ配列にメッセージを入れて返す
    if (is_file($img_dir . $filename) !== TRUE) {
        // 同名ファイルが無ければ、ファイルを指定ディレクトリへ保存
        if (move_uploaded_file($file['img']['tmp_name'], $img_dir . $filename) !== TRUE) {
            $err_msg[] = 'ファイルアップロードに失敗しました';
            // print($err_msg);
        }
    } else {
        $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
        // print($err_msg);
    }
    return $err_msg;
}

// 画像データをチェックし、不正の場合は空の文字列を返す。不正でない場合は画像名を生成して返す
function get_upload_filename($file)
{
    // 画像ファイルをチェックする
    if (is_valid_upload_image($file) === false) {
        // チェック結果がfalseの場合、空の文字列を返す
        return '';
    }
    // チェック結果がtrueの場合、ファイルの先頭バイトを読み込み定数を$mimetypeに代入
    $mimetype = exif_imagetype($file['tmp_name']);
    // PERMITTED_IMAGE_TYPESに保存されている$mimetypeの拡張子を取得し、$extに代入
    $ext = PERMITTED_IMAGE_TYPES[$mimetype];

    // 画像名にランダムの文字列を取得し、拡張子を付けて返す
    return get_random_string() . '.' . $ext;
}

// 入力した画像ファイルの内容をチェックし、不正な場合はエラーメッセージを設定しfalseを返す。適正な場合はtrueを返す
function is_valid_upload_image($image)
{
    // $imageがHTTP POSTでアップロードされたファイルでない場合
    if (is_uploaded_file($image['tmp_name']) === false) {
        // SESSIONにエラーメッセージを設定する
        set_error('ファイル形式が不正です。');
        // falseを返す
        return false;
    }
    // 画像の先頭バイトを読み、$mimetypeに結果を代入する
    $mimetype = exif_imagetype($image['tmp_name']);
    // 画像のデータ形式がPERMITTED_IMAGE_TYPESの要素に含まれない（不正な）場合
    if (isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false) {
        // ファイル形式に関するエラーメッセージを、許容されるファイル形式を連結してセットする
        set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
        // falseを返す
        return false;
    }
    // 画像データ形式が適正な場合、trueを返す
    return true;
}

// -------画像のアップロード---------
function upload_img($array, $filepath)
{
    $image = uniqid(mt_rand(), true); //ファイル名をユニーク化
    $new_img = $image . '.' . substr(strrchr($_FILES['img']['name'], '.'), 1); //アップロードされたファイルの拡張子を取得
    $file = $filepath . $new_img;
    if (!empty($_FILES['img']['name'])) { //ファイルが選択されていれば$imageにファイル名を代入
        move_uploaded_file($_FILES['img']['tmp_name'], $filepath . $new_img); //imagesディレクトリにファイル保存
        if (exif_imagetype($file)) { //画像ファイルかのチェック
            $message = '画像をアップロードしました';
        } else {
            $message = '画像ファイルではありません';
        }
    }
    return $new_img;
}

// 登録済みProfileのUPDATE
function update_profile($db, $member_id, $name, $thumbnail, $blood_type, $favorite){
    // SQL文の作成
    // $sql = 'INSERT INTO 03_member_profiles (member_name, member_thumbnail, blood_type, favorite) VALUES(?, ?, ?, ?);';
    $sql = 'UPDATE `03_member_profiles` SET `member_name`= ?, `member_thumbnail`= ?
                    ,`blood_type`= ?, `favorite`= ? WHERE `member_id`= ?';
    // SQL文を実行する準備
    $stmt = $db->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    $stmt->bindValue(2, $thumbnail, PDO::PARAM_STR);
    $stmt->bindValue(3, $blood_type, PDO::PARAM_STR);
    $stmt->bindValue(4, $favorite, PDO::PARAM_STR);
    $stmt->bindValue(5, $member_id, PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
}

// 登録済みplanのUPDATE
function update_plan($db, $plan_id, $name, $category, $start_time, $end_time, $day_num, $url){
    // SQL文の作成
    $sql = 'UPDATE `03_plans` SET `plan_name`= ?, `plan_category`= ?
                    ,`start_time`= ?, `end_time`= ?, `day_num`= ?, `plan_url`= ? WHERE `plan_id`= ?';
    // SQL文を実行する準備
    $stmt = $db->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    $stmt->bindValue(2, $category, PDO::PARAM_INT);
    $stmt->bindValue(3, $start_time, PDO::PARAM_STR);
    $stmt->bindValue(4, $end_time, PDO::PARAM_STR);
    $stmt->bindValue(5, $day_num, PDO::PARAM_INT);
    $stmt->bindValue(6, $url, PDO::PARAM_STR);
    $stmt->bindValue(7, $plan_id, PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
}