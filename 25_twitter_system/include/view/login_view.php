<!DOCTYPE html>
<html lang="ja">
<head>

   <meta charset="UTF-8">
   <title>ログイン</title>
   <link rel="stylesheet" type="text/css" href="./css/reset.css">
   <link rel="stylesheet" type="text/css" href="./css/home.css">
   

</head>

<body>

    <h1 class="login_header_text">ログインページ</h1>

    <div class ='login_form_wrapper'>

      <form action="login.php" method="post" class="login_form">

        
      <div class="login_text">
        メールアドレス 
        <input type="email" id="user_address" name="user_address" class="user_address">

      </div>

      <div class="login_text">
        パスワード
        <input class="passwd" type="password" id="user_passwd" name="user_passwd" value="">

      </div>

      <?php if(count($error) > 0){ ?>

        <ul>

          <?php foreach ($error as $error_text) { ?>

          <li class="error_text"><?php echo $error_text ?></li>

          <?php } ?>

        </ul>

      <?php } ?>

      <div class="user_text">新しく登録する方は<a href="index.php">こちら</a></div>
         
      <div class="login_btn_wrap"><input type="submit" value="ログイン" class="login_btn"></div>

      </form>

    </div>

</body>
</html>