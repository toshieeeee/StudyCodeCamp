<?php

/**********************
正規表現関数
***********************/

function ptMatch($regexp,$str){

  $arr = array();
  $list = '';

  for ($i=0; $i < count($str); $i++){ 

    if(preg_match($regexp, $str[$i])){

      $arr[] = $str[$i]; //正規表現にマッチした文字列を、配列に格納

    }

  }

  if(count($arr) === count($str)){ // 「正規表現のバリデーションに通った要素数」 と、「初期値の要素数」が一致したら

    $result = '完全一致';

    for ($i=0; $i < count($arr); $i++){

      $list .= $arr[$i]." , ";

    }

  } else if(count($arr) !== 0){ //正規表現のバリデーションに通った要素数」がゼロでなければ

    $result = '部分一致';

    for ($i=0; $i < count($arr); $i++){

      $list .= $arr[$i]." , ";

    }

     
  } else if(count($arr === 0)){

    $result = '一致なし';

  }

   return $result.'<br>一致した文字列 : '.htmlspecialchars($list);

}


/**********************
//課題
***********************/


//最初から最後まで、半角英数字かどうか判定

//   /^[a-zA-Z0-9]/

// 西暦

$regexp_year = '/\d{4}/'; // 数字 {量指定子}
$check_year[0] = '1953';
$check_year[1] = '2013';

// 電話番号
$regexp_phone_number = '/^\d{2,4}-\d{3,4}-\d{3,4}$/'; // 電話番号の正規表現を入力 - 数字 {量指定子}
$check_phone_number[0] = '03-1111-1111';
$check_phone_number[1] = '040-222-2222';
$check_phone_number[2] = '0120-000-000';

// formタグ
//$regexp_form = '/^<\w{4}\s\w*>$/'; // formの正規表現 - 最初が < で始まって、間に何でもいい文字列が、1文字以上続いて、最後は > で終わる

$regexp_form = '/^<.+>$/';

$check_form[0] = '<form>';
$check_form[1] = '<form method="post">';

// メールアドレス
$regexp_mail = '/^\w[\w.+]+@[\w.+]+$/'; 

/* メールアドレスの正規表現を入力 - 

1文字目:ローマ字のみ許可 - 2文字目以降~ : ローマ字+ハイフンを許可  
3 : @ 4:@以降〜 :ローマ字+ハイフンを許可

*/

$check_mail[0] = 'test@test.com';
$check_mail[1] = 'test_2@test.co.jp';
$check_mail[2] = 'test.3@example.ne.jp';

// URL

$regexp_url = '/https?:\/\/.+?/'; // URLの正規表現  =  ?  - sがあってもなくてもマッチする  == htt(p|ps)
$check_url[0] = 'http://codecamp.jp';
$check_url[1] = 'https://test.com';
$check_url[2] = 'http://codecamp.jp/index.html?q=test';


?>

<!DOCTYPE html>
<html lang="ja">
<head>

   <meta charset="UTF-8">
   <title>正規表現課題</title>

   <style type="text/css">
     
     .title {
      font-weight: bold;
      color :blue;
     }


   </style>

<body>

<p class="title">西暦 : </p>
<p><?php echo ptMatch($regexp_year,$check_year); ?></p>


<p class="title">電話番号 : </p>
<p><?php echo ptMatch($regexp_phone_number,$check_phone_number); ?></p>


<p class="title">フォーム : </p>
<p><?php echo ptMatch($regexp_form,$check_form); ?></p>


<p class="title">メールアドレス: </p>
<p><?php echo ptMatch($regexp_mail,$check_mail); ?></p>


<p class="title">URL : </p>
<p><?php echo ptMatch($regexp_url,$check_url); ?></p>


</body>
</html>


