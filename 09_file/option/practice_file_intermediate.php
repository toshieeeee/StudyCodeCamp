<?php

setlocale(LC_ALL, 'ja_JP.UTF-8');

$csv = array();
$file = 'iwate.csv';

//エンコーディング処理

$data = file_get_contents($file); // string型に変更
$data = mb_convert_encoding($data, 'UTF-8', 'sjis-win'); //この関数を通すことで文字化けが解消される

//一時ファイル作成

$temp = tmpfile(); 

fwrite($temp, $data); //$tempファイルに、$dataの内容を書き込む。
rewind($temp); //ファイルポインタを先頭の位置に戻す

while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {

$data = implode(",", $data); //一行づつ、配列を","で連結して、文字列として返す
$csv[] = htmlentities($data);

}

$result = array(); //多次元配列を実現して、必要なデータだけを取り出せる形にする
$table = '';

for ($i = 0; $i < 200; $i++){ //表示件数を指定

  $result[$i] = explode(",", $csv[$i]); //多次元配列に変換

  $table .= '<tr>';

  $table .= '<td>' .$result[$i][2]. '</td>'; //郵便番号を格納

  for ($k = 6; $k <= 8; $k++){

    $table .= '<td>' .$result[$i][$k]. '</td>'; //住所情報を格納

  }

  $table .= '</tr>' ;

}
 
fclose($temp);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>

<style type="text/css">
  
  .table {
    border-collapse: collapse;
  }
  .table th {
    background-color: #cccccc;
  }

  .table td {
    padding: 4px;
  }

  .t-head td {
    font-weight: bold;
  }

</style>
</head>
<body>

  <p>以下にファイルから読み込んだ住所データを表示</p>

  <p>住所データ（岩手県）</p>

  <table class="table" border=1>
    
    <tr class="t-head">
      <td>郵便番号</td>
      <td>都道府県</td>
      <td>市町村</td>
      <td>町域</td>
    </tr>

    <?php echo $table ?>

  </table>


</body>
</html>