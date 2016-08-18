<?php


$good_data = array();
$order = 'ASC';


if(isset($_GET['order']) === TRUE){

	$order = $_GET['order'];

}


//DBの接続情報

$host = 'localhost'; // データベースのホスト名又はIPアドレス
$username = 'username';  // MySQLのユーザ名
$passwd   = 'passwd';    // MySQLのパスワード
$dbname   = 'dbname';    // データベース名

$link = mysqli_connect($host, $username, $passwd, $dbname);



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
	<h1>商品一覧</h1>

    <form>

       <input type="radio" name="order" value="ASC" <?php if ($order === 'ASC') {print 'checked';} ?>>昇順
       <input type="radio" name="order" value="DESC" <?php if ($order === 'DESC') {print 'checked';} ?>>降順
       <input type="submit" value="表示">

    </form>

    <table>

       <tr>
           <th>商品名</th>
           <th>値段</th>
       </tr>

     </table>

</body>
</html>