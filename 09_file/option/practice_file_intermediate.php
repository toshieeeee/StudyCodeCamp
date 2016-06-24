<?php

setlocale(LC_ALL, 'ja_JP.UTF-8');

$csv = array();
$file = 'iwate.csv';

//エンコーディング処理

$data = file_get_contents($file); // string型に変更
$data = mb_convert_encoding($data, 'UTF-8', 'sjis-win'); //この関数を通すことで文字化けが解消される

//初期化・一時ファイル作成

$temp = tmpfile(); 
$csv  = array();

fwrite($temp, $data); //$tempファイルに、$dataの内容を書き込む。
rewind($temp); //ファイルポインタを先頭の位置に戻す


while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {

$data = implode(",", $data); //一行づつ、配列を","で連結して、文字列として返す
$csv[] = htmlentities($data);

}


$result = array(); //多次元配列を実現して、必要なデータだけを取り出せる形にする

for ($i=0; $i <10 ; $i++) { 

  $result[$i] = explode(",", $csv[$i]); 

}
 
var_dump($result);

//多次元配列からデータを取り出す（ここができない）
//$result[$i] [2 ~ 4] -こんなイメージ


fclose($temp);





?>