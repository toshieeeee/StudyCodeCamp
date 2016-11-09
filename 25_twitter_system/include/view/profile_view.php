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

  <a href="./"><h1 class="h_text">Twitter</h1></a>


  </div>

  <div class="header_profile_image"></div>

  <ul class="header_profile_list_wrapper">

    <div class="header_profile_list_box">

      <li class="header_profile_list">ツイート <p class="header_profile_list_num">12</p></li>
      <li class="header_profile_list">フォロー <p class="header_profile_list_num">100</p></li>
      <li class="header_profile_list">フォロワー <p class="header_profile_list_num">249</p></li>

    </div>

    <a href="profile_edit.php"><li class="header_profile_edit_btn">プロフィールを編集</li></a>

  </ul>

  </header>

  <section>

  <div class="section_whole_contents_wrapper_profile_page">

    <div class="section_profile_wrapper_profile_page">

      <a href="./profile.php"><div class="section_profile_image_profile_page">
        <img class="section_profile_image_tag" src=./image/<?php echo sanitize($user_image) ?>>
      </div></a>

      <p class="user_name_profile_page"><?php echo $user_name ?></p>

      <p class="user_account_name_profile_page">@toshieee</p>

      <p class="user_profile_text_profile_page"><?php echo sanitize($user_profile_text) ?></p>

      <p class="user_place_profile_page"><?php echo sanitize($user_place) ?></p>

      <!--
      <form action="logout.php" method="post" name="edit_profile">

          <input type="submit" value="ログアウト" class="logout_btn">

      </form>
      -->


    </div>

    <div class="section_tweet_wrapper">

      <?php foreach ($data as $data_text) { ?>

        <div class="tweet_str_wrapper">
   
          <img class="tweet_user_image" src=./image/<?php echo sanitize($user_image) ?>>
      
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