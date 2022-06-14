<?php

  // 入力された日付（month / dayの組み合わせ）が有効かをチェックする
  function is_available_day($db, $birth_month, $birth_day){
    // 存在しない組み合わせデータの取得
    $unavailable_day_list = get_table_list($db, 'unavailable_day_list');
    // フラグの設定
    $err = '';
    foreach($unavailable_day_list as $line){
      if($line['month'] == $birth_month && $line['day'] == $birth_day){
        $err = 'true';
      }
    }
    return $err;
  }