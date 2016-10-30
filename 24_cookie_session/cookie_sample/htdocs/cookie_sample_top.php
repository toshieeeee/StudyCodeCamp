<?php

//コントローラー


//実際にCookieの値を利用しているのはcookie_sample_top.php

//クッキーの名前を定義
//変数に、クッキーの値を格納

//→クッキーの値は、HTMLのVALUE属性で、出力

//Cookieの仕組み理解を優先しているため、Modelへ処理を分離していません
//require_once '../include/conf/const.php';
//require_once '../include/model/function.php';

if (isset($_COOKIE['cookie_check']) === TRUE) {

  //ブラウザに、cookie_checkという文字列（連想配列のキー）を保存する。

   $cookie_check = 'checked';

} else {

   $cookie_check = '';

}

if (isset($_COOKIE['user_name']) === TRUE) {

   $user_name = $_COOKIE['user_name'];

} else {

   $user_name = '';

}

//パスワードもクッキーに保存してみる

if (isset($_COOKIE['user_passwd']) === TRUE) {

   $user_passwd = $_COOKIE['user_passwd'];

} else {

   $user_passwd = '';

}

/*****************************
出力用
*****************************/

$cookie_check = htmlspecialchars($cookie_check, ENT_QUOTES, 'UTF-8'); 
$user_name = htmlspecialchars($user_name  , ENT_QUOTES, 'UTF-8');
$user_passwd = htmlspecialchars($user_passwd  , ENT_QUOTES, 'UTF-8');

include_once '../include/view/cookie_sample_top.php';