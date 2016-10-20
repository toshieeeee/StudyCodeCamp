<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>掲示板 - 課題</title>

  <style type="text/css">
    
  table,td,th {
    border: solid black 1px;
    /*margin : auto;*/
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


    <ul>

      <?php foreach ($error as $error_text) { ?>

      <li><?php echo $error_text ?></li>

      <?php } ?>

    </ul>


  
  <h1>課題</h1>
   
  <form action="controller.php" method="post">

        
    <p>名前 : <input type="text" name="user_name"></p>

    コメント : <input type="text" name="user_comment" size="60">

    <p><input type="submit" name="submit" value="送信"></p>
      
  </form>

  <p>発言一覧</p>

  <table>

    <p>▼商品一覧</p>

    <tbody>

      <tr>
          <th>商品名</th>
          <th>価格</th>
          <th>ステータス</th>
      </tr>

      <!--ここにPHPのコードを書きます-->

      

      <?php foreach ($data as $data_text) { ?>

        <tr>
          <td><?php echo sanitize(($data_text["user_name"])) ?></td>
          <td><?php echo sanitize(($data_text["user_comment"])) ?></td>
          <td><?php echo sanitize(($data_text["user_date"])) ?></td>
        </tr>

      <?php } ?>


    </tbody>

  </table>

</body>
</html>