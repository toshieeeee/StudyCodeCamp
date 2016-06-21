<?php

$filename = './challenge_log.txt';

//ファイルの書き込み処理

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  if(empty($_POST['name']) && empty($_POST['comment'])) { 

    echo "<p>名前とコメントが未入力です</p>";

  } else if (mb_strlen($_POST['name']) >= 20 && mb_strlen($_POST['comment']) >= 100){

    echo "<p>名前は20文字以内で入力してください</p>";
    echo "<p>コメントは100文字以内で入力してください</p>"; 

  } else if (empty($_POST['comment']) && mb_strlen($_POST['name']) >= 20){

    echo "<p>名前は20文字以内で入力してください</p>";
    echo "<p>コメントが未入力です</p>"; 

  } else if (empty($_POST['name']) && mb_strlen($_POST['comment']) >= 100){

    echo "<p>名前が未入力です</p>"; 
    echo "<p>コメントは100文字以内で入力してください</p>";

  } else if(empty($_POST['name'])){

    echo "<p>名前が未入力です";    

  } else if(empty($_POST['comment'])){

    echo "<p>コメントが未入力です</p>";    

  } else if(mb_strlen($_POST['name']) >= 20){

    echo "<p>名前は20文字以内で入力してください</p>";

  } else if(mb_strlen($_POST['comment']) >= 100){

    echo "<p>ひとことは100文字以内で入力してください</p>";

  } else {

    $userLog = $_POST['name'] ." :\t".               
               $_POST['comment'] . " --\t".
               date('m月d日 H:i:s') ."\n";

    if(($fp = fopen($filename, 'a')) !== FALSE) {

      if(fwrite($fp, $userLog) === FALSE) {

        print 'ファイル書き込み失敗:' . $filename;

      }

    fclose($fp);

    } 

  }

}

//ファイルの読み込み処理


$data = array();

//$dataの中に、データを配列の形で読み込み、
//HTML側のforeachで出力できる状態にしておく

if(is_readable($filename) === TRUE) {

  if(($fp = fopen($filename, 'r')) !== FALSE) {

    while(($tmp = fgets($fp)) !== FALSE) {

      $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');

    }

    fclose($fp);

  } else {

    $data[] = 'ファイルがありません';

  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>掲示板 - 課題</title>
</head>
<body>
  
<h1>課題</h1>
 
<form method="post">
  
  <p>名前 : <input type="text" name="name"></p>

  コメント : <input type="text" name="comment" size="60">

  <p><input type="submit" name="submit" value="送信"></p>
    
</form>

<p>発言一覧</p>

<ul>

<?php foreach ($data as $read) { ?>

  <li><?php print $read; ?></li>
  
<?php } ?>

</ul>

</body>
</html>