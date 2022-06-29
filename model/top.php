<?php

// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';

// 旅IDに紐づいたトラベル情報のレコードをtravelsテーブルから取得する
function get_travel_info($db, $travel_id){

    $travel_info = get_info_specific_id($db, '03_travels', 'travel_id', $travel_id);
    return $travel_info;
}

// 旅IDに紐づいたメンバーリストの情報をすべて取得する
function get_members_info($db, $travel_id){

    // 指定の旅IDのメンバーidをmembersテーブルから取得
    $members_list = get_info_specific_id($db, '03_members', 'travel_id', $travel_id);

    // 取得したmember_idのプロフィール情報を取得
    $members_info = get_member_profiles($db, $members_list);

    return $members_info;
    
}

// 指定のメンバーIDのプロフィール情報をmember_profilesテーブルから全て取得する
function get_member_profiles($dbh, $members_list){
    $tmp_member_id = NULL;
    $member_profiles_list = Array();

    foreach ($members_list as $line) {

        $tmp_member_id = $line['member_id'];
        $tmp_data = array();

        // SQL文の作成
        $sql = 'SELECT * FROM 03_member_profiles WHERE member_id = ?';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        // SQL文のプレースホルダに値をバインド
        $stmt->bindValue(1, $tmp_member_id, PDO::PARAM_INT);
        // SQLを実行
        $stmt->execute();
        $tmp_data = $stmt->fetchAll();
        // 結果配列の末尾に読み込んだレコードを追加する
        $member_profiles_list[] = $tmp_data;
    }
    // var_dump($member_profiles_list);
    return $member_profiles_list;
    
}


// メンバー表示レイアウト用：メンバーの数からcol-数を算出
 // 1行4名まで、最大8名まで表示
function calc_memberslist_col_num($members_num){
    $col_num = 1; 
    if($members_num <= 4){
         $col_num = 12 / $members_num;
    }else{
     // メンバーが5名以上」の場合はメンバー表示欄2行目のcol-3で固定
     $col_num = 3;
    }
    return $col_num;
}

// 旅IDに紐づいた旅程リストの情報を、日数および開始時間の昇順でソートして取得する
function get_plans_info($dbh, $travel_id){

    // 指定の旅IDの旅程をplansテーブルから取得
    // SQL文作成
    $sql = 'SELECT * 
            FROM 03_plans WHERE travel_id = ? ORDER BY start_time'; 
    // var_dump($sql);
    // SQL文を実行する準備
    try {
        $stmt = $dbh->prepare($sql);
         // SQL文のプレースホルダに値をバインド
        $stmt->bindValue(1, $travel_id, PDO::PARAM_INT);
        // SQL文を実行
        $stmt -> execute();
        // レコードの取得
        $data = $stmt->fetchAll();

    } catch (PDOException $e){
        throw $e;
    }
    // var_dump($data);

    // 取得したデータをday_num（何日目の旅程か）でソート
        // 並び替えの基準を取得
    // $assorted_data = sort_plans($data);

    return $data;
}

 // 取得したデータをday_num（何日目の旅程か）でソート
 function sort_plans($data){

     // 並び替えの基準を取得
     $day_nums = [];
     foreach ($data as $line) {
         $day_nums[] = $line['day_num'];
     }
     // day_numの昇順に並び替える
     array_multisort($day_nums, SORT_ASC, $data);
     // var_dump($data);
     return $data;
 }

 // 指定したidのplanを03_planテーブルから削除する
function delete_plan($dbh, $plan_id)
{
    // SQL文を作成
    $sql = 'DELETE FROM 03_plans WHERE plan_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQL文のプレースホルダに値をバインド
    $stmt->bindValue(1, $plan_id, PDO::PARAM_INT);
    // SQLを実行
    $stmt->execute();
}

 // 指定したidのmemberを03_membersおよび03_member_profilesテーブルから削除する
 function delete_member($dbh, $member_id)
 {
    // member_profilesテーブルからプロフィールレコードを削除
     // SQL文を作成
     $sql = 'DELETE FROM 03_member_profiles WHERE member_id = ?';
     // SQL文を実行する準備
     $stmt = $dbh->prepare($sql);
     // SQL文のプレースホルダに値をバインド
     $stmt->bindValue(1, $member_id, PDO::PARAM_INT);
     // SQLを実行
     $stmt->execute();

     // membersテーブルからmemberとtravelの紐付けレコードを削除
     // SQL文を作成
     $sql = 'DELETE FROM 03_members WHERE member_id = ?';
     // SQL文を実行する準備
     $stmt = $dbh->prepare($sql);
     // SQL文のプレースホルダに値をバインド
     $stmt->bindValue(1, $member_id, PDO::PARAM_INT);
     // SQLを実行
     $stmt->execute();
 }