<?php


//コイントスをセレクトボックスで指定した回数(10 or 100 or 100)行い、表と裏が出た回数を表示するプログラム

$omote = '';
$ura = '';

if(!empty($_POST['number'])){

$set = htmlspecialchars($_POST['number'], ENT_QUOTES, 'UTF-8'); //文字列の10が入っている

//配列に0,1をランダムで生成

$arrayInit = array_fill (  1 ,  $set ,  0 );

for ($i = 1; $i <= $set; $i++) {
      
    $random = rand(0,1);
    $arrayInit[$i] =  $random;

}

  //var_dump($arrayInit);

  //配列のキーが1のときのインデックスを取得

  //不明点は、このインデックスがなんこあるか数える事。

  for ($i = 1; $i <= $set; $i++) {

      if($arrayInit[$i] == 1){

          $omote += $arrayInit[$i];

      }

  }

  $ura = $set - $omote;

}else{
  echo "回数を選択してください";
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  
    <article id="wrap">
        <section>
            <p>表: <?php echo $omote ?>回</p>
            <p>裏: <?php echo $ura ?>回</p>
        </section>
        <form method="post">
            <select name="number">
                <option value="">回数選択</option>
                <option value="10">10</option>
                <option value="100">100</option>
                <option value="1000">1000</option>
            </select>回
            <button type="submit">コイントス</button>
        </form>
    </article>

</body>
</html>

