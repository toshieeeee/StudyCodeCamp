<?php

//文字列が空でない
//文字列がスペースだけでない = 最初から最後までスペースでない

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














/********06/07*********/


$class = array('ガリ勉' => '鈴木', '委員長' => '佐藤', 'セレブ' => '斎藤', 'メガネ' => '伊藤', '女神' => '杉内');


foreach ($class as $key => $name) {
  echo $key;
?>



























?>