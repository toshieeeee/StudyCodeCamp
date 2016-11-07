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

  <h1>ユーザー登録</h1>

  <form action="index.php" method="post">
    
    <label for="user_name">ユーザー名</label>
    <input type="text" id="user_name" name="user_name" value="">

    <label for="user_address">メールアドレス</label>
    <input type="email" id="user_address" name="user_address" value="">

    <label for="user_passwd">パスワード</label>
    <input type="password" id="user_passwd" name="user_passwd" value="">
    <input type="submit" value="登録">

  </form>

</body>
</html>