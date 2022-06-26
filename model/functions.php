<?php

// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';

// SESSIONの__errorsキーに$errorを設定する
function set_error($error){
    $_SESSION['__errors'][] = $error;
}

// ランダムの文字列を生成して返す
// 文字列の長さのデフォルトは20
function get_random_string($length=20){
    // ハッシュ関数でランダムの文字列を作成し、指定された文字数で文字列を切り取って返す
    return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

// トークンを生成し、セッションにセットして生成したトークンを返す
function get_csrf_token(){
    // ランダムの値を取得
    $token = get_random_string(30);
    // sessionにトークンをセット
    set_session('csrf_token', $token);
    return $token;
}

// SESSIONの$nameキーの値に$valueを設定する
function set_session($name, $value){
    $_SESSION[$name] = $value;
}

// $name のPOSTパラメータを取得する。値が入っていない場合は空の文字列を返す
function get_post($name){
    // $nameのPOSTパラメータが設定されている場合
    if(isset($_POST[$name]) === TRUE){
        return $_POST[$name];
    };
    // POSTパラメータが設定されていない場合は、空の文字列を返す
    return '';
}

// $name のGETパラメータを取得する。値が入っていない場合は空の文字列を返す
function get_get($name){
    // $nameのPOSTパラメータが設定されている場合
    if(isset($_GET[$name]) == TRUE){
        return $_GET[$name];
    };
    // GETパラメータが設定されていない場合は、空の文字列を返す
    return '';
}

// 指定のSQL文を実行し、実行結果を取得して返す
function fetch_query($db, $sql, $params = array()){
    try {
        // statementに指定のSQL文をセット
        $statement = $db->prepare($sql);
        // SQL実行
        $statement->execute($params);
        // 実行結果を取得して返す
        return $statement->fetch();
    } catch (PDOException $e){
        // try処理中にエラーが発生した場合は、エラーメッセージを設定
        set_error('データ取得に失敗しました');
    }
    // エラーが発生した場合はfalseを返す
    return false;
}

// 指定のテーブルからすべての登録済みの情報を配列で取得する
function get_table_list($dbh, $table_name)
{
    // SQL文生成
    $sql = 'SELECT * FROM '. $table_name . ';';
    // SQL文を実行する準備
    try {
        $stmt = $dbh->prepare($sql);
        // SQL文を実行
        $stmt->execute();
        // レコードの取得
        $data = $stmt->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
    return $data;
}

// 指定のテーブルから特定のカラムに指定のパラメータをもつ行の情報を配列で取得する
function get_info_specific_id($dbh, $table_name, $col_name, $id){
    
    // SQL文作成
    $sql = 'SELECT * FROM ' . $table_name 
                            . ' WHERE ' . $col_name . "=" . $id . ';'; 
    // var_dump($sql);
    // SQL文を実行する準備
    try {
        $stmt = $dbh->prepare($sql);
        // SQL文を実行
        $stmt -> execute();
        // レコードの取得
        $data = $stmt->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
    return $data;
}

// POSTメソッドによりアップロードされたファイルの内容を返す。値が入っていない場合は空の配列を返す
function get_file($name){
    // _FILESに値がアップロードされている場合
    if(isset($_FILES[$name]) === true){
      // アップロードされた値を返す
      return $_FILES[$name];
    };
    // _FILESに値がない場合は、空の配列を返す
    return array();
  }
  