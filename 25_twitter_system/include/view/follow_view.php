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


  </div>
  </header>

  <section>

  <div class="section_whole_contents_wrapper">

    <div class="section_profile_wrapper">
      
      <div class="section_profile_header_image"></div>

      <a href="./profile.php"><div class="section_profile_image"></div></a>
      <p class="user_name"><?php echo $user_name ?></p>

      <div class="profile_sum_wrapper profile_sum_wrapper_first">
        <a href="profile.php">
          <p class="sum_common_text tweet_sum">ツイート</p>
          <p class="sum_common_num_text">100</p>
        </a>
      </div>

      <div class="profile_sum_wrapper">
        <a href="follow.php">
          <p class="sum_common_text follow_sum">フォロー</p>
          <p class="sum_common_num_text">100</p>
        </a>
      </div>

      <div class="profile_sum_wrapper">
        <p class="sum_common_text follower_sum">フォロワー</p>
        <p class="sum_common_num_text">100</p>

      </div>

      <form action="logout.php" method="post" name="edit_profile">

          <input type="submit" value="ログアウト" class="logout_btn">

      </form>

    </div>

    <div class="section_user_recommend_wrapper">

      <p class="user_recommend_text">おすすめユーザー</p>

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

  

    <ul class="section_follow_parents_wrapper">

    <?php foreach($follow_user as $follow_user_list) { ?>
          
      <li class="section_follow_wrapper">
      
        <div class="section_follow_header_image"></div>

        <div class="section_profile_image"></div>

        <p class="section_profile_user_name"><?php echo $follow_user_list['user_name'] ?></p>

        <p class="section_profile_user_account_name">@komuro</p>

        <p class="section_profile_text">I am japanese in asia who is musician, producer,composer,keyboard player(piano organ synthesizer) PLS find out by WIKI or QWIKI! sizer)</p>

      </li>

    <?php } ?>


    </ul>

  </div>
  </section>

<?php } ?>
</body>
</html>