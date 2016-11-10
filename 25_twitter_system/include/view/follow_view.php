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

  <a href="home.php"><h1 class="h_text">Twitter</h1></a>

  <a href="profile.php">

    <img class="h_profile_btn" src=./image/<?php echo sanitize($user_image) ?>
    
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
          <p class="sum_common_num_text"><?php echo $my_tweet_num ?></p>
        </a>
      </div>

      <div class="profile_sum_wrapper">

        <a href="follow.php">
          <p class="sum_common_text follow_sum">フォロー</p>
          <p class="sum_common_num_text"><?php echo $follow_user_num?></p>
        </a>
        
      </div>

      <div class="profile_sum_wrapper">

        <a href="follower.php">
          <p class="sum_common_text follower_sum">フォロワー</p>
          <p class="sum_common_num_text"><?php echo $follower_user_num?></p>
        </a>

      </div>

    </div>

    <div class="section_user_recommend_wrapper">

      <p class="user_recommend_text">おすすめユーザー</p>

      <?php foreach ($other_user as $other_user_info) { ?>

      <form action="follow.php" method="post">

        <div class ="user_recommend_wrapper">

          <div class="section_profile_recommend_image"></div>

          <p class="user_recommend_name"><?php echo sanitize(($other_user_info["user_name"])) ?></p>

            <input type="hidden" name="follow_id" value="<?php echo sanitize(($other_user_info["user_id"])) ?>">
            <input type="submit" value="フォローする" class="follow_btn" name="follow_btn">

        </div>

      </form>

      <?php } ?>

      <!--*****おすすめ繰り返し*****-->

    </div>

  

    <ul class="section_follow_parents_wrapper">

    <?php foreach($follow_user as $follow_user_list) { ?>
      
      <form action="follow.php" method="post" class="form_follow">

        <li class="section_follow_wrapper">
        
          <div class="section_follow_header_image"></div>

          <div class="section_profile_image"></div>

          <p class="section_profile_user_name"><?php echo $follow_user_list['user_name'] ?></p>

          <p class="section_profile_user_account_name">@komuro</p>

          <p class="section_profile_text">I am japanese in asia who is musician, producer,composer,keyboard player(piano organ synthesizer) PLS find out by WIKI or QWIKI! sizer)</p>
          
          <input type="hidden" name="follow_id" value= <?php echo sanitize(($follow_user_list["user_id"])) ?>>
          <input type="submit" value="フォロー中" class="section_follow_follow_btn" name="follow_remove_btn">

        </li>

      </form>

    <?php } ?>

    </ul>

  </div>
  </section>

<?php } ?>
</body>
</html>