<?php

//文字列が空でない
//文字列がスペースだけでない = 最初から最後までスペースでない

if(!empty($_POST['my_name']) && !preg_match('/^\s+$/',($_POST['my_name']))){

  $name = htmlspecialchars($_POST['my_name'], ENT_QUOTES, 'UTF-8');

  echo 'ようこそ' .$name. 'さん';

}else{

  echo '名前を入力してください';

}

//Question

//全角スペースの場合はどうするか？

/***********************************************
MEMO - 正規表現
************************************************

// ^ = 行頭
// + = 直前のパターンの一回以上の繰り返し
// $ = 行末
// \s = 半角スペース


/^\s+$/
半角スペースが、行頭から行末まで一回1回以上繰り返す場合Matchする。


var_dump($_POST['my_name']);

if(preg_match('/^\s+$/',($_POST['my_name']))){
  echo 'match!';
}else{
  echo 'Not Match!';
}

*/



?>