<?php

if(!empty($_POST['choice'])){ // POSTmethodでデータを受け取ったら処理を実行

  //var_dump($_POST['choice']);

  //自分の手

  echo '自分 : '.$_POST['choice'].'<br>';

  //相手の手

  $janken = array('グー','チョキ','パー');
  $random = rand(0,2);
  $bot_hand = $janken[$random];

  echo '相手 : '.$bot_hand.'<br>';


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  
<form method="post">

  <input type='radio' name='choice' value="グー">グー
  <input type='radio' name='choice' value="チョキ">チョキ
  <input type='radio' name='choice' value="パー">パー

  <input type="submit" value="送信">

</form>

</body>
</html>
