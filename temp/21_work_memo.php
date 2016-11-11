<?php

// 処理の流れ

/*
1.画像かCHECK(is_uploaded_file())

2.拡張子をCHECK(pathinfo())

3.ファイル名変更(md5().拡張子)

4.画像を、移動（任意のディレクトリ → PJのディレクトリへ）

▼バリデーションの優先順位

 ファイルがUPされているか？ > ファイル形式は適切か? > ファイル名（ID）に重複はないか？[user_error]
 ファイルが適切にUPされたか？ [system_error]

*/

//  HTTP POST でファイルがアップロードされたか確認 - 成功したら、TRUEを返す 

$img_dir = './img/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {

    

    $new_img = $_FILES['new_img']['name'];  

    $extension = pathinfo($new_img, PATHINFO_EXTENSION); // 拡張子チェック

    if ($extension === 'jpg' || $extension == 'jpeg' || $extension == 'png') {  

      // ユニークID生成し保存ファイルの名前を変更            
      $new_img = md5(uniqid(mt_rand(), true)) . '.' . $extension; 

     // var_dump($new_img);     
    
        // 同名ファイルが存在するか確認             
        if (is_file($img_dir . $new_img) !== TRUE) { 

          // ファイルを移動し保存                 
          if (move_uploaded_file($_FILES['new_img']['tmp_name'], $img_dir . $new_img) !== TRUE) {

              $err_msg[] = 'ファイルアップロードに失敗しました';

          } 
          
        } else { // 生成したIDがかぶることは通常ないため、IDの再生成ではなく再アップロードを促すようにした 

          $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
        }

      } else { 

        $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。';

      }     

  } else {

    $err_msg[] = 'ファイルを選択してください';

  }

if(isset($err_msg)){

  var_dump($err_msg);

}

}

/***********************************
新しい関数・変数
************************************/
/*

▼is_uploaded_file($filename)

$filename という名前のファイルが HTTP POST によりアップロードされたものである場合に TRUE を返します。 

返り値 : TRUE or  FALSE

例 : 

is_uploaded_files($_FILES['filename']['tmp_file']);


▼pathinfo()


引数 :
PATHINFO_EXTENSION を指定すると、拡張子だけを返す

返り値 : 引数を渡さなければ、dirname / filename を返す

*/


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>

  <form method="post" action="21_work_memo.php" enctype="multipart/form-data">

  <p>画像を選択してください</p>
    <input type="file" name="new_img">

  <div>

    <br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">

  </div>

  </form>
  
</body>
</html>

