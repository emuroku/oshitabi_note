<?php

// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';


// 旅IDに紐づいたメンバーリストの情報をすべて取得する
function get_members_info($db, $travei_id){

    get_table_list($db, $travei_id);
    
}