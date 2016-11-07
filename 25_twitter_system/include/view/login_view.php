<!DOCTYPE html>
<html lang="ja">
<head>

   <meta charset="UTF-8">
   <title>ログイン</title>

   <style>

       input {
           display: block;
           margin-bottom: 10px;
       }

   </style>

</head>

<body>

  <?php if(count($error) > 0){ ?>

    <ul>

      <?php foreach ($error as $error_text) { ?>

      <li><?php echo $error_text ?></li>

      <?php } ?>

    </ul>

  <?php } ?>

  <h1>ログインページ</h1>

  <form action="login.php" method="post">

    <label for="email">メールアドレス</label>
    <input type="email" id="user_address" name="user_address" value= <?php print $user_address;?>>

    <label for="passwd">パスワード</label>
    <input type="password" id="user_passwd" name="user_passwd" value="">

    <input type="checkbox" name="cookie_check" value="checked" <?php print $cookie_check;?>>
    
    <p>次回からアドレスの入力を省略</p>
    
    <div></div>

    <input type="submit" value="登録">

  </form>

</body>
</html>