<?php

$filename = './codeCamp.txt';

$error = array();
$data = array();
$comment = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $user_name = null;

  /*
  isset()
  変数がセットされていること、そして NULL でないことを検査する。
  →Null以外だったらtrueを返す
  */

  //それぞれエラー用のコメントを連想配列に格納しておく 

  //名前のエラー文章

  if(isset($_POST['user_name']) !== TRUE || mb_strlen($_POST['user_name']) === 0){

    $error['user_name'] = '名前を入力してください';

  } else if(mb_strlen(($_POST['user_name']) > 20)){

    $error['user_name'] = '名前は20文字以内で入力してください';

  } else if(preg_match ('/^\s$|^　$/',$_POST['user_name'])){

    $error['user_name'] = '名前は半角、または全角スペースだけでは登録できません';

  } else {

    $user_name = $_POST['user_name'];    

  }

  //ひとことのエラー文章

  $user_comment = null;

  if(isset($_POST['user_comment']) !== TRUE || mb_strlen($_POST['user_comment']) === 0){

    $error['user_comment'] = 'コメントを入力してください';

  } else if(mb_strlen(($_POST['user_comment']) > 100)){

    $error['user_comment'] = 'コメントは100文字以内で入力してください';

  } else if(preg_match('/^\s$|^　$/',$_POST['user_comment'])){

    $error['user_comment'] = 'コメントは半角、または全角スペースだけでは登録できません';

  } else {

    $user_comment = $_POST['user_comment'];

  }

  //エラーがなければ保存
  // = $error[]の配列に何も入ってなければ、処理を実行

  if(count($error) === 0){

    $comment = $user_name . ',' . $user_comment . ',' . date('Y-m-d H:i:s') ."\n";

    // fgetsCSVで取り出すために、','で区切ってるのか！

    if(!$fp = fopen($filename, 'a')){ // ファイルポインタリソースを取得

      echo 'Cannot Open File' . $filename;
      exit;

    }

    if(fwrite($fp, $comment) === FALSE) {

      echo 'Cannot Write to file' . $filename;
      exit;

    }

    fclose($fp);

    header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); // ブラウザをリダイレクトします

    /*
      ページ遷移による対策は、POSTでデータを登録後、
      header関数を用いて違うページに飛ばす（GETを実行する）ことで対策します。
    */

  }
}


//ここまで、テキストにデータを書き込む処理

if(is_readable($filename) === TRUE) {

  if(($fp = fopen($filename, 'r')) !== FALSE) {

    while (($row = fgetcsv($fp, 1000, ',')) !== FALSE) {

      //配列に格納

      $data[] = $row;

    }

    fclose($fp);
    $data = array_reverse($data); // 逆順に並べ替える。この実装はやったほうがいいね。
  }

}

//ここまで、ブラウザ出力用に、データを適切な形で配列に入れる処理

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>掲示板 - 課題</title>
</head>
<body>
  
  <h1>課題</h1>
   
  <form action="codeCampCopy.php" method="post">

    <?php if(count($error) > 0){ ?>

      <ul>

        <?php foreach ($error as $error_text) { ?>

        <li><?php echo $error_text ?></li>

        <?php } ?>

      </ul>

    <?php } ?>
        
    <p>名前 : <input type="text" name="user_name"></p>

    コメント : <input type="text" name="user_comment" size="60">

    <p><input type="submit" name="submit" value="送信"></p>
      
    </form>


    <p>発言一覧</p>

    <ul>

      <?php foreach ($data as $read) { ?>

        <li>
          <?php echo htmlspecialchars($read[0], ENT_QUOTES, 'UTF-8');?>
          <?php echo htmlspecialchars($read[1], ENT_QUOTES, 'UTF-8');?>
          <?php echo htmlspecialchars($read[2], ENT_QUOTES, 'UTF-8');?>
        </li>
        
      <?php } ?>

    </ul>

    


</body>
</html>