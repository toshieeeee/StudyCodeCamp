<!DOCTYPE html>
<html lang="ja">
<head>

   <meta charset="UTF-8">
   <title>ログイン</title>

   <link rel="stylesheet" type="text/css" href="./css/reset.css">
   <link rel="stylesheet" type="text/css" href="./css/home.css">

</head>

<body>

  <h1 class="login_header_text">ユーザー登録</h1>

  <div class ='user_form_wrapper'>

  <form action="index.php" method="post">
    
    <div class="user_text">ユーザー名

      <input type="text" id="user_name" name="user_name" value="" class="top_user_name">

    </div>

    <div class="user_text">メールアドレス

      <input type="email" id="user_address" name="user_address" value="" class="user_address">

    </div>

    <div class="user_text">パスワード

      <input type="password" id="user_passwd" name="user_passwd" value="" class="passwd">

    </div>

    <?php if(count($error) > 0){ ?>

      <ul>

        <?php foreach ($error as $error_text) { ?>

        <li class="error_text"><?php echo $error_text ?></li>

        <?php } ?>

      </ul>

    <?php } ?>

    <input type="submit" value="登録" class="login_btn">

    <div class="user_text">登録済みの方は<a href="login.php">こちら</a></div>

  </form>

</body>
</html>