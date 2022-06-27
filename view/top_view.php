<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>推し旅note</title>

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
    
    <!-- サムネイル     -->
     <!-- <img src="<?php print(IMG_PATH . 'thumbnail/' . $user_result['animal'] . '.png'); ?>" class="animal_img"> -->
     <img src="<?php print(IMG_PATH . '/thumbnail/' . "buffapon.jpg"); ?>" class="travel_thumbnail">

     <!-- メンバー -->
     <div class="members">
      <div class="col-12">
        <h4>MEMBERS</h4>
            <div class="row">
              <?php foreach($members_info as $line){
              ?>
                <div class="col-<?php print($memberslist_col_num); ?>">
                  <div class="member_top_info">
                    <p><?php print($line[0]['member_name']); ?></p>
                    <img src="<?php print(IMG_PATH . 'members/' . $line[0]['member_thumbnail']); ?>" class="trim-image-to-circle">
                    <div class="button_profile">
                      <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModal">PROFILE
                    
                      <!-- メンバープロフィール モーダル
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              ...
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div> -->
                    </div>
                </div>
              </div>
              <?php } ?>
           </div>
            <!-- メンバー追加ボタン -->
            <a href="form_add_member.php"><button type="button" class="btn btn-primary" >Add Member</button></a>
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
    <?php for($day_num = 1; $day_num <= $days; $day_num++){ ?>
      <div class="card">
        <div class="card-header bg-secondary">
          <div class="plan_day_header">
            <?php print('Day-' . $day_num); ?>
          </div>
        </div>
    </div>
    <?php foreach ($plans_info as $plan) {
        // 該当の日程のプランであれば出力
        if ($plan['day_num'] == $day_num) {
            ?>
        <div class="card-body">
          <div class="caption">
            <div class="card_plans">
              <h4><?php print($plan['start_time']); ?></h4>
              <h4><?php print($plan['plan_name']); ?></h4>

              <div>
              <!-- リンクボタン -->
              <a href="<?php print($plan['plan_url']); ?>">
                <button type="button" class="btn btn-info"
                            <?php if ($plan['plan_url'] =='') {
                print('disabled');
                }; ?>>Link
                </button>
              </a>
              <!-- plan削除ボタン -->
                <button type="button" class="btn btn-outline-danger rounded-circle p-0" style="width:2rem;height:2rem;">-
                <form method = "post">
                    <input type = "hidden" name = "sql_order" value = "delete">
                    <input type = "hidden" name = "delete_id" value = "<?php print $plan['plan_id']; ?>"> <!-- 削除するidを送信する -->
                </form>
                </button>
            </div>
            </div>
        </div>
        </div>
    <?php
        }
    }
  }
    ?>
  <!-- 旅程追加ボタン -->
  <a href="form_add_plan.php"><button type="button" class="btn btn-primary" >Add Plan</button></a>

</body>
<footer>
    <div class="copyright">
        <small>@ m610310</small>
    </div>
</footer>
</html>