<?php



/*
▼課題

・0を入力して投稿できるように修正してください。

→原因は、emptyにあって、0を入力するとfalseを返すから登録できない。
→文字列の"0"も空、すなわち、falseと評価される。


・半角空白・全角空白を登録できないように修正

$_post -　連想配列 / 中身は文字列。0もint型ではなく文字列として評価される

*issetは、Nullでないこと、変数が未定義でないことのみを調べる

Null以外 → true
Null → false


・0は正規表現でチェックすべきなのか・・・
・0でも投稿できるようにするのがキー・・・
・emmtyのfalse判定をいかに覆すか・・・


▼修正点

・名前を20文字でも登録可能に
・発言を100文字でも登録可能に


▼聞くべきこと

・0の登録をどうするか
・半角スペースと、全角スペースのバリデーションに関して

→今の実装だと、一つ条件を増やすだけで、さらに分岐をさせなければいけないので、あまり良い実装とは言えないのかもしれない。



------------------------------------------
7/6 
ゼロの追加実装できました。


*/


$filename = './challenge_log.txt';

//ファイルの書き込み処理

//var_dump($_POST);

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 



  //if(empty($_POST['name']) && empty($_POST['comment'])) {  

  if($_POST['name'] === '' && $_POST['comment'] === '') {  

    echo "<p>名前とコメントが未入力です</p>";

  } else if (mb_strlen($_POST['name']) > 20 && mb_strlen($_POST['comment']) > 100){

    echo "<p>名前は20文字以内で入力してください</p>";
    echo "<p>コメントは100文字以内で入力してください</p>"; 

  } else if ($_POST['comment'] === '' && mb_strlen($_POST['name']) > 20){

    echo "<p>名前は20文字以内で入力してください</p>";
    echo "<p>コメントが未入力です</p>"; 

  } else if ($_POST['name'] === '' && mb_strlen($_POST['comment']) > 100){

    echo "<p>名前が未入力です</p>"; 
    echo "<p>コメントは100文字以内で入力してください</p>";

  } else if (preg_match ('/^\s*$|^　$/',$_POST['name']) || preg_match ('/^\s$|[\s　]/',$_POST['comment'])){

    echo "<p>半角・全角スペースのみでの登録はできません</p>"; 

  } else if($_POST['name'] === ''){

    echo "<p>名前が未入力です";    

  } else if($_POST['name'] === ''){

    echo "<p>コメントが未入力です</p>";    

  } else if(mb_strlen($_POST['name']) > 20){

    echo "<p>名前は20文字以内で入力してください</p>";

  } else if(mb_strlen($_POST['comment']) > 100){

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
<html lang="ja">
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