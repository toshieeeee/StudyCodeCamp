<?php

/*

▼specifications 

File Name : challenge_mysql_select.php
choose All → Show All records "emp_table"
choose manager → show Only record "manager"

*/

try{

  if($_SERVER['REQUEST_METHOD'] === 'GET'){ 

    //Define val 

    $list = '';
    $id = '';
    $age = '';
    $job = '';

    if(isset($_GET['job'])){

      $job = $_GET['job']; 

    }

    //DB Access INFO

    $dsn = 'mysql:dbname=codeCamp;host=localhost';
    $user = 'root';
    $password = 'root';

    $dbh = new PDO($dsn,$user,$password); //PDO Instance

    $dbh->query('SET NAMES utf8'); // Query run & Access DB

    //Assign SQL Statement

    if($job === 'manager') {

      $sql = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE job LIKE \'manager\';'; 

    } else if($job === 'analyst') {

      $sql = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE job LIKE \'analyst\';'; 

    } else if($job === 'clerk'){

      $sql = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE job LIKE \'clerk\';'; 

    } else {

      $sql = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE 1'; 

    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute(); 

    //Disconnect DB

    $dbh = null;

  }
  
}catch(Exception $e){

  echo 'ただいま障害により大変ご迷惑をおかけしております';
  exit();
}

while(true){

  $rec = $stmt->fetch(PDO::FETCH_ASSOC); // Get Result As Associative Array

  if($rec==false){
    break;
  }

  $list .= '<tr>';
  $list .= '<td>' .$rec['emp_id'].'</td>';
  $list .= '<td>' .$rec['emp_name'].'</td>';
  $list .= '<td>' .$rec['job'].'</td>';
  $list .= '<td>' .$rec['age'].'</td>';
  $list .= '</tr>';


}

/******************************************************
PHP Code END 
*******************************************************/

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodeCamp</title>
  
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

  </style>

</head>

<body>

    <p>表示する職種を選択してください。</p>

    <form action="challenge_mysql_select.php" method="get">

      <select name="job">

          <option value="all">全員</option>
          <option value="manager" >マネージャー</option>
          <option value="analyst" >アナリスト</option>
          <option value="clerk" >一般職</option>

      </select>

      <input type="submit" value="表示">

    </form>

    <table>

    <p>社員一覧</p>

    <tbody>

      <tr>
          <th>社員番号</th>
          <th>名前</th>
          <th>職種</th>
          <th>年齢</th>
      </tr>

      <tr>

          <?php echo $list ?>

      </tr>

    </tbody>

    </table>

</html>