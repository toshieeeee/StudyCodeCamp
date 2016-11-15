<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>

  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="./css/home.css">
  
</head>

<body>

<?php if(count($error) > 0){ ?>

  <?php foreach ($error as $error_text) { ?>

    <?php echo $error_text ?>

  <?php } ?>

<?php } else { ?>

  <header>
  <div class="header">

  <h1 class="h_text">Twitter</h1>
  
  <a href="profile.php">

    <img class="h_profile_btn" src="./image/<?php echo sanitize($user_image) ?>">
    
  </a>

  <form action="logout.php" method="post" name="edit_profile">

      <input type="submit" value="ログアウト" class="h-logout_btn">

  </form>

  </div>
  </header>

  <section>

  <div class="section_whole_contents_wrapper">

    <div class="section_profile_wrapper">
      
      <div class="section_profile_header_image"></div>

      <a href="./profile.php"><div class="section_profile_image">
        <img class="tweet_user_image tweet_user_image_home_follow_follower" src=./image/<?php echo sanitize($user_image) ?>>
      </div></a>
      <p class="user_name"><?php echo $user_name ?></p>

      <div class="profile_sum_wrapper profile_sum_wrapper_first">
        <a href="profile.php">
          <p class="sum_common_text tweet_sum">ツイート</p>
          <p class="sum_common_num_text"><?php echo sanitize($my_tweet_num) ?></p>
        </a>
      </div>

      <div class="profile_sum_wrapper">
        <a href="follow.php">
          <p class="sum_common_text follow_sum">フォロー</p>
          <p class="sum_common_num_text"><?php echo sanitize($follow_user_num) ?></p>
        </a>
      </div>      

      <div class="profile_sum_wrapper">
        <a href="follower.php">
          <p class="sum_common_text follower_sum">フォロワー</p>
          <p class="sum_common_num_text"><?php echo sanitize($follower_user_num) ?></p>
        </a>

      </div>

    </div>

    <div class="section_user_recommend_wrapper">

      <p class="user_recommend_text">おすすめユーザー</p>

      <?php foreach ($other_user as $other_user_info) { ?>

      <div class ="user_recommend_wrapper">

      <a href="profile_other.php?user_id=<?php echo sanitize($other_user_info["user_id"]) ?>">

        <img class="section_profile_recommend_image" src=./image/<?php echo sanitize($other_user_info["user_image"]) ?>>
      </a>

        <p class="user_recommend_name"><?php echo sanitize(($other_user_info["user_name"])) ?></p>

        <form action="home.php" method="post">

          <input type="hidden" name="follow_id" value="<?php echo sanitize(($other_user_info["user_id"])) ?>">
          <input type="submit" value="フォローする" class="follow_btn" name="follow_btn">


        </form>

      </div>

      <?php } ?>

      <!--*****おすすめ繰り返し*****-->

    </div>

    <div class="section_tweet_wrapper">

      <div class="tweet_box_wrapper">

        <form action="home.php" method="post">

          <input type="text" name="user_tweet_str" class="tweer_form_wrapper"  placeholder="いまなにしてる？">

          <input type="submit" value="つぶやく" class="tweet_btn" name="tweet">

        </form>

      </div>

      <!--*****ツイート繰り返し*****-->

      <!--*****GETでユーザーIDを渡す*****-->


      <?php foreach ($data as $data_text) { ?>

        <div class="tweet_str_parents_wrapper">

    
          <div class="tweet_str_wrapper">
        
            <a href="profile_other.php?user_id=<?php echo sanitize(($data_text["user_id"])) ?>">

              <img class="tweet_user_image" src=./image/<?php echo sanitize(($data_text["user_image"])) ?>>

            </a>

            <div class="tweet_str_inner_wrapper">         

              <p class="tweet_user"><?php echo sanitize(($data_text["user_name"])) ?></p>
              <p class="tweet_str"><?php echo sanitize(($data_text["user_tweet_str"])) ?></p>

            </div>

          </div>

          <div class="tweet_str_action_wrapper tweet_action_id_<?php echo sanitize(($data_text["tweet_id"])) ?>"> 

            <img class="tweet_replay tweet_user_reply_image tweet_replay_id_<?php echo sanitize(($data_text["tweet_id"])) ?>" src="./image/reply.png">

            <img class="retweet tweet_user_reply_image retweet_id_<?php echo sanitize(($data_text["tweet_id"])) ?>" src="./image/retweet_btn.png">

          </div>

          <div class="replay_tweet_str_wapper replay_tweet_str_wapper_<?php echo sanitize(($data_text["tweet_id"])) ?>">

            <form action="home.php" method="post" name="tweet_reply">

            <input type ="hidden" name= "user_tweet_reply_id" value="<?php echo sanitize(($data_text["tweet_id"])) ?>">

            <textarea name="user_tweet_str" class="tweer_form_wrapper" rows="4" cols="40">@<?php echo sanitize(($data_text["user_name"])) ?> </textarea>

              <input type="submit" value="返信する" class="tweet_btn" name="tweet_reply">

            </form>

          </div>

          <div class="retweet_str_wapper retweet_str_wapper_<?php echo sanitize(($data_text["tweet_id"])) ?>">

            <form action="home.php" method="post" name="retweet">

            <input type ="hidden" name= "retweet_id" value="<?php echo sanitize(($data_text["tweet_id"])) ?>">

              <input type="submit" value="リツイート" class="tweet_btn" name="retweet">

            </form>

          </div>
        
        </div>




      <?php } ?>


    </div>

  </div>
  </section>

<?php } ?>

<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">

/***********************************
* 返信フォームを表示
************************************/
  

$('.tweet_replay').click(function(){

  // クリックしたボタンのユニークなIDを取得

  $('.retweet_str_wapper').css('display','none');

  $tweet_replay_id = ($(this).attr('class')); 
  $replay_tweet_str_wapper = $('.replay_tweet_str_wapper').attr('class');

  // クラス名をスライス

  $tweet_replay_id = $tweet_replay_id.slice(36); 
  $replay_tweet_str_wapper = $replay_tweet_str_wapper.slice(24);
  
  // 隠れているフォームの要素を取得

  $replay_tweet_str_wapper = $('.'+ $tweet_replay_id).parent().next().attr('class');

  // クラス名をスライス

  $replay_tweet_str_wapper = $replay_tweet_str_wapper.slice(24);

  $('.' + $replay_tweet_str_wapper).css('display','block'); // 返信ブロックを表示



  });

/***********************************
* リツイートフォームを表示
************************************/
  

$('.retweet').click(function(){

  $('.replay_tweet_str_wapper').css('display','none'); // 返信ブロックを非表示

  // クリックしたボタンのユニークなIDを取得

  $retweet_id = ($(this).attr('class'));

  // クラス名をスライス
  
  $retweet_id = $retweet_id.slice(31);

  // 隠れているフォームの要素を取得

  $retweet_str_wapper = $('.'+ $retweet_id).parent().next().next().attr('class'); //兄弟要素の兄弟要素を取得

  
  // クラス名をスライス

  $retweet_str_wapper = $retweet_str_wapper.slice(19);

  $('.' + $retweet_str_wapper).css('display','block'); // リツイートブロックを表示

  

  });



</script>

</body>
</html>