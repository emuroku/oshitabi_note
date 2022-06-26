<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Plan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    
    <!-- オフライン時作業用 -->
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . '/bootstrap4/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'top.css'); ?>">
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'common.css'); ?>">
    
    <!-- icon CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- font読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1&display=swap" rel="stylesheet">
  </head>

<body>
    <!-- navigation -->
    <nav class="navbar navbar-expand-sm justify-content-center navbar-light bg-light">
        <!-- <a class="navbar-brand" href="top.php"> -->
        <div class="title">
            <h4> 推し旅note </h4>
        </div>
        <!-- </a> -->
    </nav>

    <!-- container -->
    <div class="container">
        <div class="jumbotron">
          <div class="travel_title">
            <h3><?php print($travel_info[0]['travel_name']); ?></h3>

            <div class="travel_title_schedule">
              <h5><?php print($travel_info[0]['start_date'] . ' ~ ' . $travel_info[0]['end_date']); ?></h5>
            </div>
          </div>
        </div>
    <p>旅程を追加する</p>
    <!-- 入力フォーム -->
    <div class="">
                    <form method="post" action="../html/form_add_plan.php">
                        <!-- CSRF対策 -->
                        <div class="form-group col-12">
                            <div>  
                            <select name="day_num">
                            <?php for($i=1; $i<=$days; $i++){
                            ?>
                                <option value="<?php print($i);?>"><?php print($i) . '日目';?></option>
                            <?php
                            } ?>
                                </select>
                            </div>
                            <div class="name">タイトル
                                <input type="text" class="form-control form-control-lg" name="title">
                            </div>
                            <div>カテゴリ
                            <select name="category">
                                <option value="1"></option>
                                <option value="2"></option>
                                <option value="3"></option>
                                <option value="4"></option>
                                <option value="5"></option>            
                                <option value="6"></option>            
                                <option value="7"></option>            
                            </select>
                            </div>
                            <div class="name">開始時間
                                <input type="datetime-local" class="form-control form-control-lg" name="start_time">
                            </div>
                            <div class="name">終了時間
                                <input type="datetime-local" class="form-control form-control-lg" name="end_time">
                            </div>
                            <div class="name">サイトリンク
                                <input type="text" class="form-control form-control-lg" name="url">
                            </div>
                        </div>
                            <div class="submit"><button class="btn btn-primary" id="btn_submit">登録する</button></div>
                        </div>
                    </form>
                </div>
  </div>
</body>
<footer>
    <div class="copyright">
        <small>@ m610310</small>
    </div>
</footer>
</html>