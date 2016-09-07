<?php

$error = array();
$data = array();
$comment = '';

date_default_timezone_set('Asia/Tokyo');


try{

  //DB Access INFO

  $dsn = 'mysql:dbname=codeCamp;host=localhost';
  $user = 'root';
  $password = 'root';

  //Connection Established

  $dbh = new PDO($dsn,$user,$password); //PDO Instance
  $dbh->query('SET NAMES utf8'); // Query run & Access DB
    
  //Assign SQL Statement

  $selectSql = 'SELECT user_name,user_comment,user_date FROM board_table WHERE 1';
  $selectStmt = $dbh->prepare($selectSql);
  $selectStmt->execute();
    
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['user_name']) !== TRUE || mb_strlen($_POST['user_name']) === 0){

      $error['user_name'] = '名前を入力してください';

    } else if(mb_strlen($_POST['user_name']) > 20){

      $error['user_name'] = '名前は20文字以内で入力してください';

    } else if(preg_match ('/^\s*$|^　*$/',$_POST['user_name'])){

      $error['user_name'] = '名前は半角、または全角スペースだけでは登録できません';

    } else {

      $user_name = $_POST['user_name'];    

    }

    //ひとことのエラー文章

    $user_comment = null;

    if(isset($_POST['user_comment']) !== TRUE || mb_strlen($_POST['user_comment']) === 0){

      $error['user_comment'] = 'コメントを入力してください';

    } else if(mb_strlen($_POST['user_comment']) > 100){

      $error['user_comment'] = 'コメントは100文字以内で入力してください';

    } else if(preg_match('/^\s*$|^　*$/',$_POST['user_comment'])){

      $error['user_comment'] = 'コメントは半角、または全角スペースだけでは登録できません';

    } else {

      $user_comment = $_POST['user_comment'];

    }

    if(count($error) === 0){

      $sql = 'INSERT INTO board_table(user_name,user_comment,user_date,user_info) VALUES (?,?,?,?)';
      $stmt = $dbh->prepare($sql); 
      $data[] = $_POST['user_name'];;
      $data[] = $_POST['user_comment'];
      $data[] = date('Y-m-d H:i:s');
      $data[] = $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].gethostbyaddr($_SERVER['REMOTE_ADDR']);
     // $data[] = $_SERVER['REMOTE_ADDR'];
      //$data[] = $_SERVER['REMOTE_HOST'];
      $stmt->execute($data); 

      header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); // ブラウザをリダイレクトします

    }

  }


  //Disconnect DB

  $dbh = null;

  $rec = '';

  while($rec !== FALSE){

    $rec = $selectStmt->fetch(PDO::FETCH_ASSOC); // Get Result As Associative Array  
    
    $data[] = $rec; // 多次元配列に変換

  }

  //var_dump($data[5]["user_comment"]);

  array_pop($data); // 配列の最後がFALSEなので、最後のFALSEをPOPで削除・・なんでだ。。

  $data = array_reverse($data);
  
}catch(Exception $e){

  echo 'ただいま障害により大変ご迷惑をおかけしております';
  exit();

}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>掲示板 - 課題</title>

  <style type="text/css">

    table {
      display: table;
      min-width: 780px;
    }

    th {
      background: #DFDFDF;  
      padding-left: 12px;
    }

    tr {
      background: #F5F5F5;
      display: table-row;
      text-align: left;
    }

    tr:nth-child(even) {
      background: #DFDFDF;  
    }

    td {
      padding-left: 12px;
    }

  </style>
</head>
<body>
  
  <h1>課題</h1>
   
  <form action="practice_bbs_db_intermediate.php" method="post">

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

    <table>

    <tr>
      <th>名前</th>
      <th>コメント</th>
      <th>投稿日時</th>
    <tr>


      <?php foreach ($data as $read) { ?>

        <tr>

          <td><?php echo htmlspecialchars($read['user_name'], ENT_QUOTES, 'UTF-8');?></td>
          <td><?php echo htmlspecialchars($read['user_comment'], ENT_QUOTES, 'UTF-8');?></td> 
          <td><?php echo htmlspecialchars($read['user_date'], ENT_QUOTES, 'UTF-8');?></td>
          
        </tr>
        
      <?php } ?>

    </table>
    
</body>
</html>