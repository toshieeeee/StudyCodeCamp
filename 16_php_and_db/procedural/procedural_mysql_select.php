<?php

//同じDBに接続して、データを選択して表示する BY 手続き型

if($_SERVER['REQUEST_METHOD'] === 'GET'){ 

  //変数初期化

  $job = '';
  $list = '';

  //DB情報定義

  $host = 'localhost';
  $username = 'root';  // MySQLのユーザ名
  $passwd   = 'root';    // MySQLのパスワード
  $dbname   = 'codeCamp';    // データベース名

  $link = mysqli_connect($host,$username,$passwd,$dbname); // DB接続

  if(isset($_GET['job'])){

    $job = $_GET['job']; 

  }

  if($link){

    mysqli_set_charset($link, 'utf8');

    if($job === 'manager') {

      $query = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE job LIKE \'manager\';'; 

    } else if($job === 'analyst') {

      $query = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE job LIKE \'analyst\';'; 

    } else if($job === 'clerk'){

      $query = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE job LIKE \'clerk\';'; 

    } else {

      $query = 'SELECT emp_id,emp_name,job,age FROM emp_table WHERE 1'; 

    }

    $result = mysqli_query($link, $query);

      while ($row = mysqli_fetch_array($result)){

        $list .= '<tr>';
        $list .= '<td>' .$row['emp_id'].'</td>';
        $list .= '<td>' .$row['emp_name'].'</td>';
        $list .= '<td>' .$row['job'].'</td>';
        $list .= '<td>' .$row['age'].'</td>';
        $list .= '</tr>';

      }

      //メモリ解放 + DB切断

      mysqli_free_result($result);
      mysqli_close($link);

    }

}else{
  echo "db接続失敗";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
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

  <form action="procedural_mysql_select.php" method="get">

    <select name="job">

        <option value="all">全員</option>
        <option value="manager" >マネージャー</option>
        <option value="analyst" >アナリスト</option>
        <option value="clerk" >一般職</option>

    </select>

    <input type="submit" value="表示">

  </form>

  <table>

    <?php echo $list ?>

  </table>
  
</body>
</html>