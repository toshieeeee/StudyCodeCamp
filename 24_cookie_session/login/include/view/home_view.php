<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>

<body>

<?php if(count($error) > 0){ ?>

  <?php foreach ($error as $error_text) { ?>

    <?php echo $error_text ?>

  <?php } ?>

<?php } else { ?>

  <h1>Twitter風 - 掲示板</h1>
  
  <p>ようこそ<?php echo $name ?>さん</p>

  <form action="home.php" method="post" name="user_comment">

    <input type="text" name="user_comment">

    <input type="submit" value="つぶやく">

  </form>

  <?php foreach ($data as $data_text) { ?>

    <p><?php echo sanitize(($data_text["user_comment"])) ?></p>

  <?php } ?>

  <form action="logout.php" method="post" name="logout">

      <input type="submit" value="ログアウト">

  </form>

<?php } ?>
</body>
</html>