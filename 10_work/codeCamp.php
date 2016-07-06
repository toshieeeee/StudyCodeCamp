<?php
// 書き込み情報保存ファイル
$filename = './bbs.txt';

$errors = array();
$data = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  // 名前が正しく入力されているかチェック
  $user_name = null;

  if (isset($_POST['user_name']) !== TRUE || mb_strlen($_POST['user_name']) === 0){
  $errors['user_name'] = '名前を入力してください';

  } elseif (mb_strlen($_POST['user_name']) > 20){
  $errors['user_name'] = '名前は20文字以内で入力してください';
   
  } else {
  $user_name = $_POST['user_name'];

  }

  // ひとことが正しく入力されているかチェック
  $user_comment = null;

  if (isset($_POST['user_comment']) !== TRUE || mb_strlen($_POST['user_comment']) === 0){
  $errors['user_comment'] = 'ひとことを入力してください';

  } elseif (mb_strlen($_POST['user_comment']) > 100){
  $errors['user_comment'] = 'ひとことは100文字以内で入力してください';
   
  } else {
  $user_comment = $_POST['user_comment'];

  }

  // エラーがなければ保存
  if (count($errors) === 0){
  $comment = $user_name . ',' . $user_comment . ',' . date('Y-m-d H:i:s') ."\n";

  // 保存ファイルを開く
  if (!$fp = fopen($filename, 'a')) {
  print 'Cannot open file ' . $filename;
  exit;
  }

  // オープンしたファイルに$commentを書き込む
  if (fwrite($fp, $comment) === FALSE) {
  print 'Cannot write to file ' . $filename;
  exit;
  }

  fclose($fp);

  header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  }
}

// 読み込み可能な場合
if (is_readable($filename) === TRUE) {

  // ファイルオープン
  if (($fp = fopen($filename, 'r')) !== FALSE) {

  // １行ずつデータを取り出す
  while (($row = fgetcsv($fp, 1000, ',')) !== FALSE) {
  // 配列に格納
  $data[] = $row;
  }
  fclose($fp);

  // 逆順に並べ替える
  $data = array_reverse($data);
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ひとこと掲示板</title>
</head>
<body>
  <h1>ひとこと掲示板</h1>

  <form action="bbs.php" method="post">
  <?php if (count($errors) > 0) { ?>
  <ul>
  <?php foreach ($errors as $error) { ?>
  <li>
  <?php print htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
  </li>
  <?php } ?>
  </ul>
  <?php } ?>
  名前：<input type="text" name="user_name">
  ひとこと：<input type="text" name="user_comment" size="60">
  <input type="submit" name="submit" value="送信">
  </form>
<?php
?>
  <ul>
  <?php
  // 配列数分繰り返し処理を行う
  foreach ($data as $value) {
  ?>
  <li>
  <?php print htmlspecialchars($value[0], ENT_QUOTES, 'UTF-8');?>
  <?php print htmlspecialchars($value[1], ENT_QUOTES, 'UTF-8');?>
  <?php print htmlspecialchars($value[2], ENT_QUOTES, 'UTF-8');?>
  </li>
  <?php
  }
  ?>
  </ul>
</body>
</html>
