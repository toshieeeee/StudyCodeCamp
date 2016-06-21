<?php



for ($i = 1; $i <= 9; $i++) {

  echo '<table border=1>';
  echo '<tr>';

//for文のネスト

  for ($j = 1; $j <= 9; $j++) {

      $result = $i * $j ;

      echo '<td>' .$i. ' * ' .$j. ' = ' .$result. '</td>';
    
  }

  //echo '<br>';
  echo '</tr>';
  echo '</table>';

}




?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>

  <style type="text/css">

    body{
      width :1200px;
    }

    table {
      margin: 0 auto;
     margin-top :4px;
    }
      
      td {
        width: 88px;
        text-align: center;
      }

      td:nth-child(odd) {
        background: #ccc;
      }

  </style>
</head>
<body>
  
</body>
</html>


