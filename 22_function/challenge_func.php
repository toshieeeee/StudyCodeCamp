<?php
  
/*************************
▼課題

・「身長と体重の入力値チェック」 - バリデーションの関数 - check_float関数

・「BMIの計算」 - 計算の関数 - calc_bmi関数作成

＜処理の流れ＞

(1) check_float()で、受け取った値をバリデーション

(2) calc_bmi関数に(1)の値を渡して、出力する。


**************************/

// エラーメッセージ用配列

$err_msg = array();

// 初期化
$height = '';
$weight = '';
$bmi    = '';

//var_dump(check_float());

  
// リクエストメソッド取得
$request_method = get_request_method();
  
// POSTの場合
if ($request_method === 'POST') {
  
    // POSTデータ取得
    $height = get_post_data('height');
    $weight = get_post_data('weight');
  
    // 身長の値が小数かチェック
    if (check_float($height) !== TRUE) {
        $err_msg[] = '身長は数値を入力してください';
    }
  
    // 体重の値が小数かチェック
    if (check_float($weight) !== TRUE) {
        $err_msg[] = '体重は数値を入力してください';
    }
  
    // エラーがない場合
    if (count($err_msg) === 0) {
        // BMI算出
        $bmi = calc_bmi($height, $weight);
    }

}
  
  
/**
* BMIを計算
* @param mixed $height 身長
* @param mixed $weight 体重
* @return float BMI
*/
//////////////////////////////////////////
// ▼calc_bmi関数作成
//////////////////////////////////////////


function calc_bmi($height,$weight){

    $result = ($weight / ($height * $height)) * 10000; // BMI計算
    $result = round($result,2); // 小数点第2以下を切り上げ

    return $result;

}
  
/**
* 値が正の整数又は小数か確認 = 1より小さい値かどうか ? 
* @param mixed $float 確認する値
* @return bool TUREorFALSE
*/



///////////////////////////////////////////
// ▼check_float関数作成
//////////////////////////////////////////

//少数かどうかチェック

function check_float($float = ''){ // 初期値を空に設定

    if(preg_match('/^[0|\.]/',$float)){

        //  1より小さい (= 0 or . ~ から始まっている場合)は、少数判定

        //  それ以外の数値だったら、trueを返す

        return FALSE;

    }

    return TRUE;

}
  
/**
* リクエストメソッドを取得
* @return str GET/POST/PUTなど
*/
function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}
  
/**
* POSTデータを取得
* @param str $key 配列キー
* @return str POST値
*/
function get_post_data($key) {
  
    $str = '';
  
    if (isset($_POST[$key]) === TRUE) {
        $str = $_POST[$key];
    }
  
    return $str;
  
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>BMI計算</title>
</head>
<body>
    <h1>BMI計算</h1>
    <form method="post">
        身長: <input type="text" name="height" value="<?php print $height ?>">
        体重: <input type="text" name="weight" value="<?php print $weight ?>">
        <input type="submit" value="BMI計算">
    </form>
<?php if (count($err_msg) > 0) { ?>
<?php     foreach ($err_msg as $value) { ?>
    <p><?php print $value; ?></p>
<?php     } ?>
<?php } ?>
<?php if ($request_method === 'POST' && count($err_msg) ===0) { ?>
    <p>あなたのBMIは<?php print $bmi; ?>です</p>
<?php } ?>
</body>
</html>


