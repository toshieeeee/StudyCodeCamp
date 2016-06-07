<?php

// $valueの値を定義
$value = 55.5555;

/*************************
<MEMO>
**************************

小数点以下の桁数を指定するには？

→round()の場合は単純に、第2引数に、小数点以下の桁数を指定

*/

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>課題</title>
</head>
<body>
    <p>元の値: <?php echo $value ?></p>
    <p>小数切り捨て: <?php echo floor($value) ?></p>
    <p>小数切り上げ: <?php echo ceil($value) ?></p>
    <p>小数四捨五入: <?php echo round($value) ?></p>
    <p>小数第二位で四捨五入: <?php echo round($value,2) ?></p>
</body>
</html>