<?php

setlocale(LC_ALL, 'ja_JP.UTF-8');

$csv = array();
$file = 'iwate.csv';
/*
$data = file_get_contents($file); // ファイルの内容をすべて文字列として読み込む
$data = mb_convert_encoding($data, 'UTF-8');
*/
$fp = fopen($file,'r');


while(($data = fgetcsv($fp, 0, ",")) !== FALSE){

  $csv[] = $data;

}

fclose($fp);

$csv = mb_convert_variables("UTF-8","SJIS",$data);

var_dump($csv[0][3]);






//fgetcsvでCSVファイルの出力はできた。

//CSVが文字化けして見れない。

// mb_convert_encoding - 配列ではなく、文字列が対象。
// fgetscsv()では、配列が返ってくるので、ダメだ~!!!!

//そこで、mb_convert_variables ()
//配列を含めて、変数のエンコーディングを行う



?>