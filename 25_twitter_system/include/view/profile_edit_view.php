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

      <a href="./profile.php"><div class="section_profile_image_profile_page"></div></a>

      <p class="user_name_profile_page"><?php echo $user_name ?></p>

      <p class="user_account_name_profile_page">@toshieee</p>

      <p class="user_profile_text_profile_page">渋谷で働くWEBクリエイター。デザインとプログラミングを勉強してます。読書と音楽が好き。英語:金融の勉強も好き。</p>

      <p class="user_place_profile_page">Tokyo</p>

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

        <form class="use_profile_edit_form">

        <div class="profile_edit_list_wrapper">

          <p class="user_name_edit_text edit_text">ユーザー名</p>

          <input class="user_name_edit" maxlength="15" name="user_name" type="text" value="toshieeeeeee">
          
        </div>

        <div class="profile_edit_list_wrapper">

          <p class="edit_text">メールアドレス</p>

          <input class="user_address_edit" maxlength="15" name="user_address" type="text" value="mac@gmail.com">
          
        </div>

        <div class="profile_edit_list_wrapper">

          <p class="edit_text">プロフィール画像</p>
          
        </div>

        <div class="profile_edit_list_wrapper">

          <p class="edit_text">場所</p>
          
        </div>

        <input type="submit" value="保存する" class="profile_edit_complete_btn">


        </form>
        
    </div>

  </div>
  </section>

<?php } ?>
</body>
</html>