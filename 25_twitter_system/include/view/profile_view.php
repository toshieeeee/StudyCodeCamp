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
  </header>

  <section>

  <div class="section_whole_contents_wrapper">

    <div class="section_profile_wrapper">

      <div class="section_profile_header_image"></div>

      <a href="./profile.php"><div class="section_profile_image"></div></a>
      <p class="user_name"><?php echo $user_name ?></p>

      <div class="profile_sum_wrapper profile_sum_wrapper_first">
        <p class="sum_common_text tweet_sum">ツイート</p>
      </div>

      <div class="profile_sum_wrapper">
        <p class="sum_common_text follow_sum">フォロー</p>
      </div>

      <div class="profile_sum_wrapper">
        <p class="sum_common_text follower_sum">フォロワー</p>

      </div>

      <form action="logout.php" method="post" name="edit_profile">

          <input type="submit" value="ログアウト" class="logout_btn">

      </form>


    </div>

    <div class="section_tweet_wrapper">

      <?php foreach ($data as $data_text) { ?>

        <div class="tweet_str_wrapper">

            <div class="tweet_user_image"></div> 

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