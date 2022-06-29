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
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'top.css'); ?>">
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'common.css'); ?>">
    
    <!-- Modal -->
    
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
                      <?php print('<button class="btn btn-light" data-toggle="modal" data-target="#modal' . $line[0]['member_id'].'"'); ?>>PROFILE</button>
                    </div>
                    <?php print('<div class="modal fade" id="modal' . $line[0]['member_id'].'"'); ?>>
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <!-- Profile Modal ヘッダ -->
                                <div class="modal-header">
                                    <h3 class="modal-title">PROFILE</h3>
                                    <button class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Profile Modal ヘッダここまで -->

                                <!-- Profile Modal Body -->
                                <div class="modal-body">
                                  <div class="modal_profile col-6">
                                    <h4><?php print($line[0]['member_name']); ?></h4>
                                    <p><?php print('Blood Type: ' . $line[0]['blood_type']); ?></p>
                                    <p><?php print('推し: ' . $line[0]['favorite']); ?></p>
                                  </div>
                                  <div class="modal_profile_thumbnail">
                                  <img src="<?php print(IMG_PATH . 'members/' . $line[0]['member_thumbnail']); ?>" class="trim-image-to-circle">
                                  </div>
                                </div>
                                <!-- Profile Modal Body ここまで-->

                                <!-- Profile Modal フッタ -->
                                <div class="modal-footer">
                                  <!-- メンバー削除ボタン -->
                                  <?php print('<button type="button" class="btn btn-danger rounded-circle p-0" 
                                    style="width:2rem;height:2rem;" data-toggle="modal" 
                                    data-target="#modal-member-del' . $line[0]['member_id'] . '">-</button>'); ?>
                                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                                 <!-- Profile Modal フッタ ここまで -->
                                 
                                 <!-- ここからメンバー削除確認ダイアログ -->
                                  <?php print('<div class="modal fade" id="modal-member-del' . $line[0]['member_id'] . '">'); ?>
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">メンバーを削除</h3>
                                                <button class="close" data-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                このメンバーを削除していいですか？
                                            </div>
                                            <div class="modal-footer">
                                              <form method = "post">
                                                <input type="submit" value="OK" button class="btn btn-primary">
                                                <input type = "hidden" name = "sql_order" value = "delete_member">
                                                <input type = "hidden" name = "delete_id" value = "<?php print($line[0]['member_id']); ?>">
                                              </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ここまでMember削除確認Modal -->
                            </div>
                            <!-- ここまでModal Content -->
                        </div>
                        <!-- ここまでModal Dialog -->
                  </div>
                  <!-- ここまでModal Fade -->
                  </div>
                  </div>
                  <?php } ?>                  
                </div>
            
            <!-- メンバー追加ボタン -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_addmember">Add Member</button>
            <!-- メンバー追加Modalフォーム -->
            <div class="modal fade" id="modal_addmember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">メンバーを追加する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group col-12">
                              <div class="name">名前
                                <input type="text" class="form-control form-control-lg" name="name">
                              </div>     
                              <div class="add_member_thumbnail">サムネイル
                              <input type="file" name="img">
                              </div>
                              <div class="name">推し
                                  <input type="text" class="form-control form-control-lg" name="favorite">
                              </div>
                              <div>血液型:
                                <select name="blood_type">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="O">O</option>
                                <option value="AB">AB</option>
                                <option value="不明">不明</option>            
                                </select>
                            </div>
                      </div>
              </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">やめる</button>
                    <div class="submit"><button class="btn btn-primary" id="btn_submit">追加する</button>
                  </div>
                  </form>
                  </div>
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
              <h4>
                <!-- categoryに応じたアイコン表示  -->
              <?php if($plan['plan_category'] == 1){ 
                print('<i class="fas fa-plane"></i>');
              }else if($plan['plan_category'] == 2){ 
                print('<i class="fas fa-monument"></i>');
              }else if($plan['plan_category'] == 3){ 
                print('<i class="fas fa-utensils"></i>');
              }else if($plan['plan_category'] == 4){ 
                print('<i class="fas fa-bed"></i>');
              }else if($plan['plan_category'] == 5){ 
                print('<i class="fas fa-shopping-bag"></i>');
              }else if($plan['plan_category'] == 6){ 
                print('<i class="fas fa-baseball-ball"></i>');
              }else if($plan['plan_category'] == 7){ 
                print('<i class="fas fa-music"></i>');
              }else if($plan['plan_category'] == 8){ 
                print('<i class="fas fa-kiss-wink-heart"></i>');
              }else if($plan['plan_category'] == 9){ 
                print('<i class="fas fa-synagogue"></i>');
              } ?>

              <?php print($plan['plan_name']); ?></h4>

              <div>
              <!-- リンクボタン -->
              <a href="<?php print($plan['plan_url']); ?>">
                <button type="button" class="btn btn-info"
                            <?php if ($plan['plan_url'] =='') {
                print('disabled');
                }; ?>>Link
                </button>
              </a>
              <?php print('<button type="button" class="btn btn-danger rounded-circle p-0" 
              style="width:2rem;height:2rem;" data-toggle="modal" 
              data-target="#modal' . $plan['plan_id'] . '">-</button>'); ?>
 
              <?php print('<div class="modal fade" id="modal' . $plan['plan_id'] . '">'); ?>
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h3 class="modal-title">プランを削除</h3>
                              <button class="close" data-dismiss="modal">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              このプランを削除していいですか？
                          </div>
                          <div class="modal-footer">
                             <form method = "post">
                               <input type="submit" value="OK" button class="btn btn-primary">
                               <input type = "hidden" name = "sql_order" value = "delete_plan">
                               <input type = "hidden" name = "delete_id" value = "<?php print($plan['plan_id']); ?>">
                             </form>
                          </div>
                      </div>
                  </div>
              </div>
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
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_addplan">Add Plan</button>
  <!-- メンバー追加Modalフォーム -->
  <div class="modal fade" id="modal_addplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">プランを追加する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="post" enctype="multipart/form-data">
                  <div class="modal-body">
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
                                <option value="1">移動</option>
                                <option value="2">観光</option>
                                <option value="3">食事</option>
                                <option value="4">宿泊</option>
                                <option value="5">ショッピング</option>
                                <option value="6">試合</option>            
                                <option value="7">ライブ</option>            
                                <option value="8">ファンミ</option>            
                                <option value="9">聖地巡礼</option>            
                                <option value="10">そのほか</option>            
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
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">やめる</button>
                    <div class="submit"><button class="btn btn-primary" id="btn_submit">追加する</button>
                    <input type = "hidden" name = "sql_order" value = "add_plan">
                    </div>
                  </form>
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