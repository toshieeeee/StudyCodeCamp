<?php

$timestamp = time() ;

$second = date( "s" , $timestamp );

if($second == 00){

  echo 'ジャストタイム<br>アクセスした瞬間の秒は' .$second. '秒でした';

}else if($second === '11' || $second === '22' || $second === '33' || $second === '44' || $second === '55'){

//preg_match("/^([1-9])\1{1}$/", $second
//正規表現で書き直す

  echo 'ゾロ目です<br>アクセスした瞬間の秒は' .$second. '秒でした';

}else{
  echo '外れ <br>アクセスした瞬間の秒は' .$second. '秒でした';

}

/*******************
MEMO
*******************

「{n}」で直前のパターンをn回繰り返し、「{n,}」だとn回以上
　後方参照 
 \1 = 1つ目のカッコの中身と同じ内容
 () = グループ化

*******************/
 
?>