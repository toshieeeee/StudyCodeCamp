<?php

// 変数初期化

$name;
$gender;
$mail;

if(!empty($_POST['my_name'])){

  //ここでは、POST[]がString(0)を返しているので、iseetで判定した場合、Trueになる
  //なぜなら、issetはNull型以外がtrueで返すから

  //なので、issetで判定しない
  //emptyで判定した場合、falseに等しい場合Falseを返す。String(0)もFalseと判定する

  $name = htmlspecialchars($_POST['my_name'], ENT_QUOTES, 'UTF-8');
  echo 'お名前:' .$name. '<br>';

}

/****************
isset()の仕様
*****************

issetはNULL以外の値はTRUEとして返す！！
変数の初期化を文字列型にしてしまうと、ISSETで判定した場合、TRUEが返ってきてしまう

*/


if(isset($_POST['gender'])){

  $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
  echo '性別:' .$gender. '<br>';

}

if(isset($_POST['mail'])){

  $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
  echo 'お知らせメールを受け取る : ' .$mail;

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Practice-php</title>
</head>
<body>

<h1>課題</h1>

<form method="post">

  <p>お名前 : <input id="my_name" type="text" name="my_name" value=""></p>
  <p>性別 : <input type="radio" name="gender" value="man">男<input type="radio" name="gender" value="woman">女</p>
  <p><input type="checkbox" name="mail" value="OK">お知らせメールを受け取る</p>
  <input type="submit" value="送信"  name="regist">

</form>

</body>
</html>