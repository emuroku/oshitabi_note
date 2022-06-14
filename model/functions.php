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

// 占い結果(リザルトページに表示する[ユーザーの動物タイプ、動物の画像、相性の良い選手名、チーム名、プロフィールリンク]を取得

// ユーザーのどうぶつ占いの結果を計算して結果ナンバーを返す
function get_animal_uranai_result($db, $year, $month, $day){
    // 結果ナンバーを設定
    $result_num = 0;

    // 早見表から計算用tmp_numを取得
    $tmp_num = get_tmp_num($db, $year, $month);

    // tmp_numにdayを加算
    $tmp_num += $day;

    // tmp_numが60以下であれば結果ナンバーへ代入
    if($tmp_num <= 60){
        $result_num = $tmp_num;
    }else{
    // tmp_numが60より大きければ60を引いて結果ナンバーへ代入
        $result_num = $tmp_num - 60;
    }
    return $result_num;
}

// どうぶつ占いの結果ナンバーの各種情報（テキスト、詳細リンク、どうぶつ名）を取得して配列で返す
function get_uranai_result($db, $num){
    // SQL文作成
    $sql = "
        SELECT *
        FROM animal_result_list
        WHERE num = {$num}
    ";

    // SQLを実行し、配列として取得
    $result = fetch_query($db, $sql);

    return $result;
}

// ユーザーの動物占いの結果からベストパートナーの選手情報を取得して配列で返す
function get_player_result($db, $num){
    // compatibility listからベストパートナーのナンバーを取得
    $partner_list = get_partner_num($db, $num);
    // ベストパートナーの選手の番号を取得
    $best_partner_num = $partner_list['best_partner_num'];
    // SQL文作成
    $sql = "
        SELECT 
            players_list.name,
            players_list.team,
            animal_result_list.text
        FROM
            players_list
        JOIN
            animal_result_list
        ON
            players_list.num = animal_result_list.num
        WHERE 
            players_list.num = {$best_partner_num}
    ";

    // SQLを実行し、配列として取得
    $result = fetch_query($db, $sql);
    return $result;
}

 // compatibility listからベスト・バッドパートナーのナンバーを取得して返す
 function get_partner_num($db, $user_num){

    // SQL文作成
    $sql = "
        SELECT * FROM compatibility_list
        WHERE num = {$user_num}
    ";

    // SQLを実行し、配列として取得
    $result = fetch_query($db, $sql);
    return $result;
 }
    

// 早見表テーブルから計算用のtmp_numを取得して返す
function get_tmp_num($db, $year, $month){
    // カラム名を取得
    $col_name = 'month_' . $month;

    // SQL文作成
    $sql = "
    SELECT {$col_name} 
    FROM simplified_chart
    WHERE year = {$year}
    ";
    // SQLを実行し、配列として取得する
    $result = fetch_query($db, $sql);
    
    // 取得した配列の$col_nameの値を返す
    return $result[$col_name];
}

// 日本語表示チーム名とロゴ表示用英字表示名を取得
function get_logoname($db, $name){

    // SQL文作成
    $sql = "
    SELECT name_eng 
    FROM logoname_list
    WHERE name_jp = '{$name}'
    ";
    // SQLを実行し、配列として取得する
    $result = fetch_query($db, $sql);
    
    // 取得した配列の$col_nameの値を返す
    return $result;
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