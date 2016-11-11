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

      <!--*****おすすめ繰り返し（3回回ったら、forループを抜けたい）*****-->

      <!--foreach - 連想配列を、全部取りだす-->

      <?php foreach ($other_user as $other_user_info) { ?>

      <div class ="user_recommend_wrapper">

        <div class="section_profile_recommend_image"></div>

        <p class="user_recommend_name"><?php echo sanitize(($other_user_info["user_name"])) ?></p>

        <form action="home.php" method="post">

          <!--VALUEに$user_id-->

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

          <input type="text" name="user_tweet_str" class="tweer_form_wrapper">

          <input type="submit" value="つぶやく" class="tweet_btn" name="tweet">

        </form>

      </div>

      <!--*****ツイート繰り返し*****-->

      <!--*****GETでユーザーIDを渡す*****-->

      <?php foreach ($data as $data_text) { ?>

        <div class="tweet_str_wrapper">

          <form action="profile_other.php" method="post" name="edit_profile">
            
            <a href="profile_other.php?user_id=<?php echo sanitize(($data_text["user_id"])) ?>">

              <img class="tweet_user_image" src=./image/<?php echo sanitize(($data_text["user_image"])) ?>>

            </a>

            <div class="tweet_str_inner_wrapper">         

            <p class="tweet_user"><?php echo sanitize(($data_text["user_name"])) ?></p>
            <p class="tweet_str"><?php echo sanitize(($data_text["user_tweet_str"])) ?></p>

          </div>

        </div>
    
      <?php } ?>



    </div>

  </div>
  </section>

<?php } ?>
</body>
</html>