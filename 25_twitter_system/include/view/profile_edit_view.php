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

  </header>

  <section>

  <div class="section_whole_contents_wrapper_profile_page">

    <div class="section_profile_wrapper_profile_page">

      <a href="./profile.php"><div class="section_profile_image_profile_page">
        <img class="section_profile_image_tag" src=./image/<?php echo sanitize($user_image) ?>>
      </div></a>

      <p class="user_name_profile_page">@<?php echo $user_name ?></p>

      <p class="user_profile_text_profile_page"><?php echo sanitize($user_profile_text) ?></p>

      <p class="user_place_profile_page"><?php echo sanitize($user_place) ?></p>

      <!--
      <form action="logout.php" method="post" name="edit_profile">

          <input type="submit" value="ログアウト" class="logout_btn">

      </form>
      -->


    </div>

    <div class="section_profile_edit_wrapper">

      <div class="section_profile_edit_header_text">

        <p class="profile_edit_header_text">ユーザー情報</p>
        <p class="profile_edit_header_sub_text">アカウント情報と言語設定を変更します</p>

      </div>

      <?php if(count($error_text) > 0){ ?>

        <?php foreach ($error_text as $error_text_output) { ?>

          <p class="profile_error_text">・<?php echo $error_text_output ?></p>

        <?php } ?>

      <?php } ?>

      <form class="use_profile_edit_form" action="profile_edit.php" method="post" enctype="multipart/form-data">

        <div class="profile_edit_list_wrapper">

          <p class="user_name_edit_text edit_text">ユーザー名</p>

          <input class="user_name_edit" maxlength="15" name="user_name_edit" type="text" value="toshiki">
          
        </div>

        <div class="profile_edit_list_wrapper">

          <p class="edit_text">自己紹介</p>

          <textarea class="user_profile_text_edit" name="user_profile_text_edit" rows="4" cols="40">toshsiki  
          </textarea>
          
        </div>

        <div class="profile_edit_list_wrapper">

          <p class="edit_text">プロフィール画像</p>
    
          <input type="file" name="user_image_edit">

        </div>

        <div class="profile_edit_list_wrapper">

          <p class="edit_text">場所</p>

          <input class="user_place_edit" maxlength="15" name="user_place_edit" type="text" value="Tokyo">
          
        </div>

        <input type="submit" value="保存する" class="profile_edit_complete_btn">

      </form>
        
    </div>

  </div>
  </section>

<?php } ?>
</body>
</html>