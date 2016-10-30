<?php

/*

ーーーーーーーーーーーーーーーーーー
＊ 機能
ーーーーーーーーーーーーーーーーーー

・「アクセスした回数」を表示

・「現在日時」を表示
・「前回アクセスした日時」を表示


▼変数

初回のユーザー　= セッション変数X,Yは、空

２回目のユーザー　= セッション変数Xは現在日時、セッション変数Yは空

３回目のユーザー　= セッション変数Xは、現在日時、セッション変数Yは、過去アクセス日時


▼処理

初回の場合

条件 : セッション変数X,Y = 空
処理 : セッション変数Xに、現在日時をセット


２回目

条件 : セッション変数X = 現在日時 , セッション変数Y = 空
処理 : セッション変数Yに、セッション変数Xの値をセット
       セッション変数Xに、現在日時をセット

３回目

条件 : セッション変数X = 現在日時 , セッション変数Y = セッション変数X'の値
処理 : セッション変数Yに、セッション変数Xの値をセット
       セッション変数Xに、現在日時をセット



共通点

・セッション変数Xには、常に現在日時がセットされる
・セッション変数Yには、常に、セッション変数Xの値がコピーされる
・２回目以降の、処理は同じ処理が走る（2回目のみ条件が異なる）

・アクセス履歴を削除


ーーーーーーーーーーーーーーーーーー
＊ 「アクセスした回数」を表示
ーーーーーーーーーーーーーーーーーー

初めてのユーザー or x回アクセスのユーザー

ーーーーーーーーーーーーーーーーーー
＊ 
ーーーーーーーーーーーーーーーーーー

ーーーーーーーーーーーーーーーーーー
＊ 手順
ーーーーーーーーーーーーーーーーーー

・アクセス回数を表示する機能
・現在日時を表示
・前回のアクセス日時を取得
（クッキーに前回のアクセス日時を保zんしておけばいいんじゃないか？）

・クッキーを削除する


*/


if ($_SERVER['REQUEST_METHOD'] === 'GET'){

  if (isset($_COOKIE['visited']) === TRUE) {
     $count = $_COOKIE['visited'] + 1;
  } else {
     $count = 1;
  }
  setcookie('visited', $count, time() + 60 * 60 * 24 * 365);
  $msg =  $count . '回目の訪問です';



  //時刻設定

  date_default_timezone_set('Asia/Tokyo');
  $now = date('Y/m/d H:i:s');



  if (isset($_COOKIE['visited_time']) === TRUE) {

    //２回目以降の処理

    $y = '前回アクセス : '.$_COOKIE['visited_time']; // Xの値をコピーする

    setcookie('visited_time', $now, time() + 60 * 60 * 24 * 365); // 現在時刻を、クッキーに指定

    $x = '現在時刻 : '.$now;
     
  } else {

    setcookie('visited_time', $now, time() + 60 * 60 * 24 * 365);

    $x = '現在時刻 : '.$now;
    $y = '';

  }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // クッキーを削除する処理

  // クッキ削除 → ブラウザリダイレクト（GETの処理を走らせる）

  $now = date('Y/m/d H:i:s');

  setcookie('visited', '', $now - 3600);
  setcookie('visited_time' , '', $now - 3600);

  header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); // ブラウザをリダイレクト

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>



<?php echo $msg ?>

<div></div>
<div></div>

<p><?php echo $x ?></p>
<p><?php echo $y ?></p>


   <form action="challenge_session.php" method="post">
       <input type="submit" value="履歴削除">
   </form>


  
</body>
</html>

