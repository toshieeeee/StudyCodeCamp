<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Result</title>
  <style type="text/css">
    
    img {
    width: 480px;
  }

  </style>
</head>
<body>

  <?php if(count($error) > 0){ ?>

    <ul>

      <?php foreach ($error as $error_text) { ?>

      <li><?php echo $error_text ?></li>

      <?php } ?>

    </ul>

  <?php } ?>

  <div>

    <?php if(count($error) == 0){ ?>

      <p>【<?php echo $pro_name ?>】を購入しました</p>
      <img src = ./image/<?php echo $pro_image ?>></p>
      <p>お釣りは<?php echo $pro_price_result ?>円です！</p>

      <?php } ?>
      

  </div>

  <footer><a href="index.php">戻る</a></footer>
  
</body>
</html>