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
* すべてのユーザー名/ユーザーIDを取得する

* @param DBハンドラ,ユーザーから受け取るID,ユーザーから受け取る整数 
* @return ユーザーID / エラー文章
************************************/

function get_user_id_name_list($link,$user_id) {

  $sql = 'SELECT user_id,user_name,user_image FROM user_table WHERE user_id != '.$user_id.' ORDER BY RAND() LIMIT 3';
  
  return get_as_array($link, $sql); //SQL実行 

}

/***********************************
* ユーザー名を取得する関数

* @param DBハンドラ,ユーザーから受け取るID,ユーザーから受け取る整数 
* @return ユーザー名 / エラー文章
************************************/

function get_user_name($link,$mail,$passwd){ //$link = PDOオブジェクト

  global $error;

  $sql = 'SELECT user_name FROM login_table WHERE user_address = "' .$mail. '" AND user_pass = "'.$passwd .'"';

  $data = $link->query($sql);

  $data = $data->fetch(PDO::FETCH_ASSOC); 

  if(!$data){ // ユーザーIDが返ってきたら処理を実行

    $error[] = 'メールアドレス、またはパスワードが一致しません';

  } else {

    $user_name = $data['user_name'];


    return $user_name;

  }  

}

/***********************************
* SQLの定義 / get_as_arrayを実行
*
* @param obj $link DBハンドル
* @return つぶやき一覧、連想配列データ
************************************/

function get_user_tweet_list($link) {
  
  $sql = 'SELECT tweet_table.user_id,user_table.user_name,user_table.user_image,tweet_table.tweet_id,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id'; // SQL生成

  return get_as_array($link, $sql); //SQL実行 

}

/***********************************
* INSERTの実行 / つぶやき機能
*
* @param0 - DBハンドラ
* @param1 - ユーザーID
* @param2 - ツイート内容
*
* @return TRUE / FALSE
***********************************/

// tweet_idはA_I

function insert_table($link,$param1,$param2){

  try{

    $sql_info = 'INSERT INTO tweet_table(user_id,user_tweet_str,user_tweet_time) VALUES (?,?,?)';
    $stmt = $link->prepare($sql_info); 

    $data[] = $param1;
    $data[] = $param2;
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
* INSERTの実行 / フォロー機能
*
* @param0 - DBハンドラ
* @param1 - ユーザーID
* @param2 - フォローID
*
* @return TRUE / FALSE
***********************************/

function insert_follow_table($link,$param1,$param2){

  try{

    $sql_info = 'INSERT INTO follow_table(user_id,follow_id,follow_time) VALUES (?,?,?)';
    $stmt = $link->prepare($sql_info); 

    $data[] = $param1;
    $data[] = $param2;
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

