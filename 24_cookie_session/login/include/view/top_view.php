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

  <form action="index.php" method="post">

     <label for="email">メールアドレス</label>
     <input type="email" id="email" name="email" value="">
     <label for="passwd">パスワード</label>
     <input type="password" id="passwd" name="passwd" value="">
     <input type="submit" value="登録">

  </form>

</body>
</html>