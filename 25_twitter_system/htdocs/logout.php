<?php

session_start();

$session_name = session_name(); // セッション名取得

$_SESSION = array(); // セッション変数を全て削除

// ユーザのCookieに保存されているセッションIDを削除

if (isset($_COOKIE[$session_name])) {

  setcookie($session_name, '', time() - 42000);

}

session_destroy(); // セッションIDを無効化

header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/login.php'); 

exit;