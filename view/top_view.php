<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>出張オリ姫会 in SAPPORO</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    
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
            <h3>出張オリ姫会 in SAPPORO★2022</h3>

            <div class="travel_title_schedule">
              <h5> 2022/7/1 ~ 7/3 </h5>
            </div>
          </div>
        </div>
    
    <!-- サムネイル     -->
     <!-- <img src="<?php print(IMG_PATH . 'thumbnail/' . $user_result['animal'] . '.png'); ?>" class="animal_img"> -->
     <img src="<?php print(IMG_PATH . '/thumbnail/' . "buffapon.jpg"); ?>" class="travel_thumbnail">

     <!-- メンバー -->
     <div class="members">
      <div class="col-12">
        <h4>MEMBERS</h4>
            <div class="row">
                <div class="col-4">
                    <p>ベルちゃん</p>
                    <img src="<?php print(IMG_PATH . 'members/' . "belltaso.jpg"); ?>" class="trim-image-to-circle">
                </div>
                <div class="col-4">
                    <p>KH</p>
                    <img src="<?php print(IMG_PATH . 'members/' . "kihyun_2.png"); ?>" class="trim-image-to-circle">
                </div>
                <div class="col-4">
                    <p>バファ子</p>
                    <img src="<?php print(IMG_PATH . 'members/' . "flower.jpg"); ?>" class="trim-image-to-circle">
                </div>
            </div>
        </div>
     </div>

    <!-- navigation -->
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="#" class="nav-link">旅程</a></li>
                <li class="nav-item"><a href="#" class="nav-link">もちもの</a></li>
                <li class="nav-item"><a href="#" class="nav-link">写真</a></li>
            </ul>
        </div>
    </nav>
    

  
    <!-- 旅程 -->
      <div class="card">
        <div class="card-body">
          <div class="caption">
            <div class="card_plans">
            <h4 class="card-title">11:00 AM 羽田空港発</h4>
            <p class="card-link"></p>
            <div class="modal fade" id="_">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">11:00 AM 羽田空港発</h4>
                    <button class="close" data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    
                  </div>
                  <div class="modal-footer">
                    <p class="mb-0 mr-3"></p>
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">閉じる</button>
                  </div>
                </div>
              </div>
            </div> <!-- モーダル -->
          </div>
        </div>
        </div>
      </div>
      
      <div class="card">
        <div class="card-body">
          <div class="caption">
            <div class="card_plans">
            <h4 class="card-title">13:00 PM ホテルチェックイン</h4>
            <p class="card-link"></p>
            <div class="modal fade" id="_">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">11:00 AM 羽田空港発</h4>
                    <button class="close" data-dismiss="modal">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    
                  </div>
                  <div class="modal-footer">
                    <p class="mb-0 mr-3"></p>
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">閉じる</button>
                  </div>
                </div>
              </div>
            </div> <!-- モーダル -->
          </div>
        </div>
        </div>
      </div>

    
    



        
    </div>
</body>
<footer>
    <div class="copyright">
        <small>@ m610310</small>
    </div>
</footer>
</html>