<?php

  $result = null;
  $error = array();

  if($_SERVER['REQUEST_METHOD'] === 'POST'){


    $mail = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['password']);

    if(isset($mail) !== TRUE || mb_strlen($mail) === 0){

      $error['email']  = 'メールアドレスを入力してください';

    } else if(!preg_match ('/^\w[\w.+]+@[\w.+]+$/',$mail)){

      $error['email']  = 'アドレス形式で入力してください';

    }

    if(isset($pass) !== TRUE || mb_strlen($pass) === 0){

      $error['pass']  = 'パスワードを入力してください';

    } else if(!preg_match ('/^\w{4,18}$/',$pass)){

      $error['pass']  = 'パスワードは半角英数字、4文字以上、18文字以下で入力してください';

    }

    if(count($error) === 0){

      //header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      $result = '登録完了';

    }


///^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/ メール


///^[0-9a-zA-Z!-\/:-@\[-`{-~]{6,18}$/ パスワード


//課題ページ - どうやって、他のページに飛ばすことなく、DOM全体を書き換えているのか？    

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>

  <?php if(count($error) > 0){ ?>

    <ul>

      <?php foreach ($error as $error_text) { ?>

      <li class="error"><?php echo $error_text ?></li>

      <?php } ?>

    </ul>

  <?php } ?>


  <form action="practice_preg_match_intermediate.php" method="post">

    <p>メールアドレス : <input type="text" name="email"></p>
    <p>パスワード :<input type="password" name="password"></p>

    <button  type="submit">送信</button>

  </form>

  <?php if(isset($result)){ ?>

    <p><?php echo $result ?></p>

  <?php } ?>
  
</body>
</html>