<?php 


if(isset($_SESSION['login']) === FALSE){

  echo "<p>ログインされていません</p>";
  echo '<p><a href="./">ログイン画面へ</a></p>';
  exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  
  <p>ようこそ<?php echo $name ?>さん</p>

</body>
</html>