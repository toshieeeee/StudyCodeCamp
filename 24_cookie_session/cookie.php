<?php
if (isset($_COOKIE['visited']) === TRUE) {
   $count = $_COOKIE['visited'] + 1;
} else {
   $count = 1;
}
setcookie('visited', $count, time() + 60 * 60 * 24 * 365);

//setcookie(クッキーの名前 , cookieの値 , クッキーの有効期限);

//返り値 TRUE/FALSE 

print $count . '回目の訪問です';
