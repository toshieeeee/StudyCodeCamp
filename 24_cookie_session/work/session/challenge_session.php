<?php 

/*

ーーーーーーーーーーーーーーーーーー
＊ 大まかな流れ
ーーーーーーーーーーーーーーーーーー

▼ GETの場合

１、セッションに、「訪問回数」と「現在時刻」の２つをセットする
２、変数に、セッションの値を保存する
３、HTMLで出力する

▼ POSTの場合

クッキーの値を削除　→ リダイレクト →　GETの処理が走る


*/


session_start(); // セッション開始

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

  /********************************
  ▼ 訪問回数をセッションに保存する
  *********************************/

  if (isset($_SESSION['count']) === TRUE) {

     $_SESSION['count']++;

  } else {

     $_SESSION['count'] = 1;
  }

  $count = $_SESSION['count'].'回目の訪問です';

  /********************************
  ▼ 時刻をセッションに保存する
  *********************************/

  date_default_timezone_set('Asia/Tokyo');

  $now = date('Y/m/d H:i:s');

  if (isset($_SESSION['visited_time']) === TRUE) {

    // ２回目以降の処理

    $y = '前回アクセス : '.$_SESSION['visited_time']; // Xの値をコピーする

    $_SESSION['visited_time'] = $now; // セッションに、現在時刻を保存

    $x = '現在時刻 : '.$now;
     
  } else {

    // 初回の処理

    $_SESSION['visited_time'] = $now; // セッションに、現在時刻を保存

    $x = '現在時刻 : '.$now; 

    $y = '';

  }

}

/********************************

▼ セッション削除

*********************************/

if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  $session_name = session_name(); // セッション名取得 

  $_SESSION = array(); // 「セッション変数」を削除

  if (isset($_COOKIE[$session_name])) { // ユーザの「Cookie」に保存されているセッションIDを削除

    setcookie($session_name, '', time() - 42000);

  }

  session_destroy(); // セッションIDを無効化

  header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); // ブラウザをリダイレクト

}

// 重要な情報 = session
// session - DBに保存してある。サーバーのメモリが占有。
//IDトPASSは、サーバー上に、すでに保存してる。確かに。

// 例 :ECサイト 

// 購入商品 / 発送先 / 値段 / 決済方法 / 
// 共通点 = 複数ページに、またがる必要性がある情報（データの受け渡しは、POSTではなく、セッションで管理する）
// なぜ、クッキーではいけないのか？
// ユーザーの環境に依存するから。

// よって、特に理由がなければ、セッションの方が良い？ 

// セッションの負荷が高い？ → クッキー（クライアント）に、負荷を分散させる 

// 通信を避ける - クッキーに、保存する。ローカルで、いろいろやる？ Ajax ? 



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>

  <?php echo $count ?>

  <div></div>

  <p><?php echo $x ?></p>
  <p><?php echo $y ?></p>


  <form action="challenge_session.php" method="post">

    <input type="submit" value="履歴削除">

  </form>

</body>
</html>