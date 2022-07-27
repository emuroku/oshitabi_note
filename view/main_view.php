<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>推し旅note</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>

    
    <!-- オフライン時作業用 -->
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . '/bootstrap4/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . '/top.css'); ?>">
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . '/main.css'); ?>">
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'common.css'); ?>">
    
    <!-- Modal -->
    
    <!-- icon CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- font読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1&display=swap" rel="stylesheet">

    <!-- カレンダー機能 -->
    <!-- bootstrap-datepickerを読み込む -->
    <link rel="stylesheet" type="text/css" href="../bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="../bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../bootstrap-datepicker-1.6.4-dist/locales/bootstrap-datepicker.ja.min.js"></script>
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
            <h3>推し旅のしおりを作成して仲間とシェアできます</h3>
          </div>
        </div>  
        <!-- 旅の追加ボタン -->
        <div class="addtravel"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_addtravel">作ってみる！</button></div>
        <!-- 追加Modalフォーム -->
        <div class="modal fade" id="modal_addtravel" tabindex="-1" role="dialog" aria-labelledby="AddTravelModal" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="AddTravelModal">新しい旅を登録します</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" action="added_travel.php" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group col-12">
                            <div class="name">旅のタイトル
                                <input type="text" class="form-control form-control-lg" name="title" required = "required">
                            </div>
                            <div class="name">開始日
                                <input type="date" class="form-control form-control-lg" name="start_date"  required = "required">
                            </div>
                            <div class="name">終了日
                                <input type="date" class="form-control form-control-lg" name="end_date" required = "required">
                            </div>
                            <div>日数
                                <div class="days">
                                    <input type="number" class="form-control col-3" name="days" required min="1" max="99" id="days" placeholder value="1"  required = "required">
                                    <label for="days">日間</label>
                                </div>
                            </div>
                            <div class="add_member_thumbnail">サムネイル<br/>
                                <!-- <small>設定しない場合、デフォルトのサムネイルフォトが表示されます</small> -->
                              <input type="file" name="img">
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">やめる</button>
                    <div class="submit"><button class="btn btn-primary" id="btn_submit">登録する</button>
                    <input type = "hidden" name = "sql_order" value = "add_plan">
                    </div>
                  </form>
                </div>
              </div>
  </div>
    </div>
</body>
<!-- <footer>
    <div class="copyright">
        <small>@ m610310</small>
    </div>
</footer> -->
</html>