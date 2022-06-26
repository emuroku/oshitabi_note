<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add member</title>

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
    <p>メンバーを追加する</p>
    <!-- 入力フォーム -->
    <div class="">
                    <form method="post" action="../html/form_add_member.php">
                        <!-- CSRF対策 -->
                        <div class="form-group col-12">
                            <div class="name">名前
                                <input type="text" class="form-control form-control-lg" name="name">
                            <div class="add_member_thumbnail">サムネイル
                              <input type="file" name="img">
                            </div>
                            <div class="name">推し
                                <input type="text" class="form-control form-control-lg" name="favorite">
                            <div>血液型:
                            <select name="blood_type">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="O">O</option>
                                <option value="AB">AB</option>
                                <option value="不明">不明</option>            
                            </select>
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