<?php

$table = '';

$table .= '<table border=1>';

for ($i = 1; $i <= 9; $i++) {

  $table .= '<tr>';

  for ($j = 1; $j <= 9; $j++) {

    $result = $i * $j ;

    $table .= '<td>' .$j. ' * ' .$i. ' = ' .$result. '</td>';
    
  }

  $table .= '</tr>';

}

$table .= '</table>';

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

  <?php echo $table ?>
  
</body>
</html>


