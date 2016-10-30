<?php

// Cookieの仕組み理解を優先しているため、Modelへ処理を分離していません
//require_once '../include/conf/const.php';
//require_once '../include/model/function.php';

//クッキーに値を設定しているのは、ここ。

//Name属性の値を受け取る → set_cookieに値をセットする

$now = time();

if (isset($_POST['cookie_check']) === TRUE) {

   $cookie_check = $_POST['cookie_check'];

} else {

   $cookie_check = '';

}


if (isset($_POST['user_name']) === TRUE) {

   $cookie_value = $_POST['user_name'];

} else {

   $cookie_value = '';

}

if (isset($_POST['user_passwd']) === TRUE) {

   $cookie_pass = $_POST['user_passwd'];


} else {

   $cookie_pass = '';

}

////setcookie(クッキーの名前 , cookieの値 , クッキーの有効期限);


// Cookieを利用するか確認

if ($cookie_check === 'checked') {

   // Cookieへ保存

   setcookie('cookie_check' , $cookie_check, $now + 60 * 60 * 24 * 365);
   setcookie('user_name' , $cookie_value, $now + 60 * 60 * 24 * 365);
   setcookie('user_passwd' , $cookie_pass, $now + 60 * 60 * 24 * 365);

} else {

   // Cookieを削除
   setcookie('cookie_check', '', $now - 3600);
   setcookie('user_name'   , '', $now - 3600);
   setcookie('user_passwd'   , '', $now - 3600);
}

if (isset($_COOKIE['visited']) === TRUE) {

   $count = $_COOKIE['visited'] + 1;

} else {
   $count = 1;
}

/*追加*/

setcookie('visited', $count, time() + 60 * 60 * 24 * 365);

//setcookie(クッキーの名前 , cookieの値 , クッキーの有効期限);

//返り値 TRUE/FALSE 

print $count . '回目の訪問です<br>';


print 'ようこそ';