<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodeCamp</title>
  
  <style type="text/css">
    
  table,td,th {
    border: solid black 1px;
    margin : auto;
  }

  td,th {
    min-width: 120px;

    text-align: left;
    padding-left: 8px;

  }

  table {
      width: 350px;
      margin-top: 10px;
  }

  img {
    width: 480px;
  }

  .open {
    background: #fff;
  }

  .close {
    background: #ccc;
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

  <? if(isset($msg)){ ?>

    <?php echo  $msg ?>

  <?php } ?>


  <form method="post" action="tool.php" enctype="multipart/form-data">

    <p>▼商品名を入力してください</p>

    <input type="text" name="pro_name">

    <p>▼価格を入力してください</p>

    <input type="text" name="pro_price"> 円

    <p>▼個数を入力してください</p>

    <input type="text" name="pro_num"> 個

    <p>▼画像を選択してください</p>

    <input type="file" name="pro_image">

    <p>▼表示ステータスを選択してください</p>

    <input type="radio" name="pro_status" value="1"> 表示
    <input type="radio" name="pro_status" value="0"> 非表示

    <div>

      <br><input type="submit" name="pro_add" value="OK">

    </div>

  </form>

  <br><hr><br>

  <table>

    <p>▼商品一覧</p>

    <tbody>

      <tr>
          <th>商品名</th>
          <th>価格</th>
          <th>商品画像</th>
          <th>在庫数</th>
          <th>ステータス</th>
      </tr>

      <!--ここにPHPのコードを書きます-->

      <?php foreach ($record as $record_output) { ?>

        
        <?php if($record_output['pro_status'] === '1'){ ?>

          <tr class="open"> 

        <?php } else { ?>

          <tr class="close">

        <?php } ?> 

          <td><?php echo sanitize(($record_output["pro_name"])) ?></td>
          <td><?php echo sanitize(($record_output["pro_price"])) ?></td>
          <td><img src=./image/<?php echo sanitize(($record_output["pro_image"])) ?>></td>

          <!--在庫数をを出力-->

          <form method="post" action="tool.php">

            <input type=hidden name="pro_id" value=<?php echo sanitize(($record_output["pro_id"])) ?>>

            <td class="pro_num">
              <input type="text" name="pro_num"  value=<?php echo sanitize(($record_output["pro_num"])) ?>>
              <input type="submit" name="pro_update" value="update">
            </td>

          </form>

          <!--表示ステータスを出力-->

          <form method="post" action="tool.php">

            <input type=hidden name="pro_id" value=<?php echo sanitize(($record_output["pro_id"])) ?>>

            <?php if($record_output['pro_status'] === '1'){ ?>

            <td>
              <input type="submit" name ="pro_status" value="close">
            </td>

            <?php } else { ?>

            <td>
              <input type="submit" name ="pro_status" value="show">
            </td>

            <?php } ?>

          </form>

        </tr>

      <?php } ?>

    </tbody>

  </table>

</body>

</html>