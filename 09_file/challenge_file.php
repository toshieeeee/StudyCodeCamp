<?php

$filename = './challenge_log.txt';

//ファイルの書き込み処理
//出力はまた別で行う


if($_SERVER['REQUEST_METHOD'] === 'POST'){

  //POSTメソッドでデータを受け取ったら処理を開始する

  $userLog =  date('m月d日 H:i:s') ."\t".
              $_POST['comment'] . "\n"; 

  if(($fp = fopen($filename, 'a')) !== FALSE) {

    //$fpの中身は、'./file_write.txt'のファイルポインタ
    //aモードで、ポインタを末尾に移動してから、書き込みを行う


    if(fwrite($fp,  $userLog ) === FALSE) {

        print 'ファイル書き込み失敗:' . $filename;

    }

    fclose($fp);

  }
}

/****************
ここまでの処理で、アクセスログを取ることが可能
*********************/

$data = array();


//ファイルの読み込み処理

if(is_readable($filename) === TRUE) { // 読み込み処理

  if(($fp = fopen($filename, 'r')) !== FALSE) {
    
    while (($tmp = fgets($fp)) !== FALSE) { 
    //$tmpの実態は、ファイルからとりだした、一文字。
    //fgetsは、$fpのデータがなくなると、falseを返す

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
  <title>Document</title>
</head>
<body>

<h1>課題</h1>
 
<form method="post">

  <input type="text" name="comment">

  <input type="submit" name="submit" value="送信">
    
</form>

<p>発言一覧</p>

<?php foreach ($data as $read) { ?>

  <p><?php print $read; ?></p>
  
<?php } ?>
  

</body>
</html>