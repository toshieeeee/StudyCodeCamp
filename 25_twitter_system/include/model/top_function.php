<?php

/*************************************************************

▼関数を定義

**************************************************************/

/***********************************
* 文字列のバリデーション（パスワード含む）
*
* @param str name属性
* @return 成功 : 入力データ 失敗 : $errorに、入力した文字列を格納したデータ
************************************/

function str_validation($str){

  global $error;

  $temp = $str; // 属性名を受け取る
  $str = $_POST[$str]; //属性の値を受け取る
  $attr = $temp;

  if(isset($str) !== TRUE || mb_strlen($str) === 0){

    $error[$attr] = $attr.'を入力してください';

  } else if(mb_strlen($str) > 20){

    $error[$attr] = $attr.'は20文字以内で入力してください';

  } else if(preg_match ('/^\s*$|^　*$/',$str)){

    $error[$attr] = $attr.'は半角、または全角スペースだけでは登録できません';

  } else {

    return $str;

  }

}

/***********************************
* メールアドレスのバリデーション
*
* @param str email属性
* @return 成功 : 入力したアドレスを返す 失敗 : $errorに、入力した文字列を格納したデータ
************************************/

function mail_validation($str){

  global $error;

  $temp = $str; // 属性名を受け取る
  $str = $_POST[$str]; //属性の値を受け取る
  $attr = $temp;

  if(isset($str) !== TRUE || mb_strlen($str) === 0){

    $error[$attr] = $attr.'を入力してください';

  } else if(mb_strlen($str) > 100){

    $error[$attr] = $attr.'は100文字以内で入力してください';

  } else if(preg_match ('/^\s*$|^　*$/',$str)){

    $error[$attr] = $attr.'は半角、または全角スペースだけでは登録できません';

  } else if(!preg_match ('/^\w[\w.+]+@[\w.+]+$/',$str)){ 

    $error[$attr] = $attr.'はアドレス形式ではありません';

  } else {

    return $str;

  }

}

/***********************************
* ユーザー名が存在するかどうか確認する
*
* @param obj $link DBハンドル
* @return str 入力に一致したユーザー名
************************************/

function confirm_name_exist($link,$user_name) {

  global $error;

  $name_exist = $user_name;
  
  $sql = 'SELECT user_name FROM user_table WHERE user_name = "'.$user_name.'"';

  $user_name = get_as_array($link, $sql); //SQL実行 

  if(!$user_name){

    return $user_name;

  } else {

    $error['user_name'] = $name_exist.'は既に登録されているユーザー名です';

  }

}


/***********************************
* アドレスが存在するかどうか確認する
*
* @param obj $link DBハンドル
* @return str 入力に一致したアドレス
************************************/

function confirm_address_exist($link,$user_address) {

  global $error;

  $address_exist = $user_address;
  
  $sql = 'SELECT user_address FROM user_table WHERE user_address = "'.$user_address.'"';

  $user_address = get_as_array($link, $sql); //SQL実行 

  if(!$user_address){

    return $user_address;

  } else {

    $error['user_address'] = $address_exist.'は既に登録されているアドレスです';

  }

}

/***********************************
* INSERTの実行
*
* @param1 - DBハンドラ
* @param2 - プレースホルダーに入れる値
*
* @return TRUE / FALSE
***********************************/

function insert_table($link,$param1,$param2,$param3){

  try{

    $sql_info = 'INSERT INTO user_table(user_name,user_address,user_passwd,user_create_date) VALUES (?,?,?,?)';
    $stmt = $link->prepare($sql_info); 

    $data[] = $param1;
    $data[] = $param2;
    $data[] = $param3;
    $data[] = date('Y-m-d H:i:s');
  
    if(!$stmt->execute($data)){ // SQLの判定 / 実行

      throw new QueryException();

    }

  } catch (QueryException $e){

    echo 'Fatal Error : '.$e->getMessage().'<br>';
    echo $e->getFile().'<br>';
    echo $e->getLine().'<br>';

  }
  
}

/***********************************

* ユーザーIDを取得する関数（アドレスと、パスワードを条件）

************************************/

function get_user_id($link,$user_address,$user_passwd){ //$link = PDOオブジェクト

  global $error;

  $sql = 'SELECT user_id FROM user_table WHERE user_address = "' .$user_address. '" AND user_passwd = "'.$user_passwd .'"';

  $data = $link->query($sql);

  $data = $data->fetch(PDO::FETCH_ASSOC); 

  if(!$data){ // ユーザーIDが返ってきたら処理を実行

    $error[] = 'メールアドレス、またはパスワードが一致しません';

  } else {

    $user_id = $data['user_id'];

    return $user_id;

  }  

}
