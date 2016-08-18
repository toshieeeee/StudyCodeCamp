<?php


//priceカラムのデータ型はINTのため、価格に数値以外を入力して追加した場合、追加失敗します
//header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); 

try{

  //Define Val

  $list = '';
  $error = array();

  //DB Access INFO

  $dsn = 'mysql:dbname=codeCamp;host=localhost';
  $user = 'root';
  $password = 'root';

  //Connection Established

  $dbh = new PDO($dsn,$user,$password); //PDO Instance
  $dbh->query('SET NAMES utf8'); // Query run & Access DB

  //Assign SQL Statement - SELECT EXECUTE -

  $selectSql = 'SELECT goods_name,goods_value FROM goods_table WHERE 1'; 

  $selectStmt = $dbh->prepare($selectSql);
  $selectStmt->execute();

  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = $_POST['name'];
    $value = $_POST['value'];
    $name = htmlspecialchars($name);
    $value = htmlspecialchars($value);

    //Validation - PRODUCT NAME

    if(isset($name) !== TRUE || mb_strlen($name) === 0){

      $error['pro_name'] = '商品名を入力してください';

    } else if(mb_strlen($name) > 20){

      $error['pro_name'] = '商品名は20文字以内で入力してください';

    } else if(preg_match ('/^\s*$|^　*$/',$name)){

      $error['pro_name'] = '商品名は半角、または全角スペースだけでは登録できません';

    }

    //Validation - PRODUCT VALUE

    if(isset($value) !== TRUE || mb_strlen($value) === 0){

      $error['value'] = '価格を入力してください';

    } else if(mb_strlen($value) > 20){

      $error['value'] = '価格は20文字以内で入力してください';

    } else if(preg_match('/^\s*$|^　*$/',$value)){

      $error['value'] = '価格は半角、または全角スペースだけでは登録できません';

    } else if(!preg_match("/^[0-9]+$/", $value)){

      $error['value'] = '価格は全て、半角数値で入力してください';

    }

    if(count($error) === 0){

    //PREPEARED STATEMENT
    
    $sql = 'INSERT INTO goods_table(goods_name,goods_value) VALUES (?,?)';
    $stmt = $dbh->prepare($sql); 
    $data[] = $name;
    $data[] = $value;
    $stmt->execute($data); 

    header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

    }

  }

  //Disconnect DB

  $dbh = null;

  $rec = '';

  while($rec !== FALSE){

    $rec = $selectStmt->fetch(PDO::FETCH_ASSOC); // Get Result As Associative Array  
    $data[] = $rec;

  }

  array_pop($data); // 配列の最後がFALSEなので、削除・・なんでだ。。

  $data = array_reverse($data);

}catch(Exception $e){

  echo 'ただいま障害により大変ご迷惑をおかけしております';
  exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodeCamp - 2</title>

  <style type="text/css">
    
  table,td,th {
    border: solid black 1px;

  }

  td,th {
    
    text-align: left;
    padding-left: 8px;

  }

  table {
      width: 350px;
      margin-top: 10px;
  }

  .error {
    color : red;
  }

  </style>

</head>
<body>

    <?php if(count($error) > 0){ ?>

      <ul>

        <?php foreach ($error as $error_text) { ?>

        <li class="error"><?php echo $error_text ?></li>

        <?php } ?>

      </ul>

    <?php } ?>

  <form action="challenge_mysql_insert.php" method="post">

    <p>追加したい商品の名前と価格を入力してください</p>

    <p>商品名 : <input type="text" name="name"></p>
    <p>価格 : <input type="text" name="value"></p>

    <input type="submit" value="追加">

  </form>

  <table>

    <p>商品一覧</p>

    <tbody>

      <tr>
          <th>商品</th>
          <th>価格</th>
      </tr>


      <?php foreach ($data as $read) { ?>

        <tr>

          <td><?php echo $read['goods_name'];?></td>

          <td><?php echo $read['goods_value'];?></td>

        </tr>

        <?php } ?>

    </tbody>

    </table>
 
  
</body>
</html>