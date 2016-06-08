<?php

$filename = './file_write.txt';

//ファイルの書き込み処理
//出力はまた別で行う

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  //POSTメソッドでデータを受け取ったら処理を開始する

  $comment = $_POST['comment']; // 実際のカキコが格納される。

  if(($fp = fopen($filename, 'a')) !== FALSE) {

    //$fpの中身は、'./file_write.txt'のファイルポインタ
    //aモードで、ポインタを末尾に移動してから、書き込みを行う


    if(fwrite($fp, $comment) === FALSE) {

        print 'ファイル書き込み失敗:' . $filename;

    }

    fclose($fp);

  }
}



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



//ファイルの書き込み（保存）と、読み込みはPHPだけで行い
//ファイルの出力は、HTMLにPHPを埋め込むことで出力する。

var_dump($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>


<h1>ファイル操作</h1>

<form method="post">

  <textarea name="comment" rows="4" cols="40"></textarea>

  <input type="submit" name="submit" value="送信">
    
</form>

<p>以下に、<?php print $filename; ?>の中身を表示</p>

<?php foreach ($data as $read) { ?>
    
    <p><?php print $read; ?></p>

<?php } ?>

</body>
</html>



