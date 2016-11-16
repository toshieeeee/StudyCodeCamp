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
  
  $sql = 'SELECT tweet_table.user_id,tweet_table.user_tweet_reply_id,user_table.user_name,user_table.user_image,tweet_table.tweet_id,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id'; // SQL生成

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

/***********************************
* INSERTの実行 / 返信機能
*
* @param0 - DBハンドラ
* @param1 - ユーザーID
* @param2 - フォローID
*
* @return TRUE / FALSE
***********************************/

function insert_tweet_replay($link,$param1,$param2,$param3){

  try{

    $sql_info = 'INSERT INTO tweet_table(user_id,user_tweet_reply_id,user_tweet_str,user_tweet_time) VALUES (?,?,?,?)';
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
* 返信ツイート取得
***********************************/


/***********************************
* 返信ツイートのIDを取得
***********************************/

function get_tweet_reply_id($link) {
  
  $sql = 'SELECT user_tweet_reply_id FROM tweet_table WHERE user_tweet_reply_id != 0'; // SQL生成

  $list = '';

  $reply_id = get_as_array($link, $sql); //SQL実行


  if($reply_id){

    foreach($reply_id as $reply_id_list) {
          
      $list .= $reply_id_list['user_tweet_reply_id'].',';

    }

    $list = rtrim($list,',');

    return $list; 

  } else {

    return FALSE;

  }

}

/***********************************
* 返信ツイートの、親を取得
***********************************/

function get_tweet_parents_reply($link, $reply_id_list){

  $sql = 'SELECT tweet_id,user_id,user_tweet_reply_id,user_tweet_str FROM tweet_table WHERE tweet_id IN ('.$reply_id_list.')';

  $tweet_parents_reply = get_as_array($link, $sql); //SQL実行 

  return $tweet_parents_reply;

}

/***********************************
* 返信ツイートの、子を取得
***********************************/


function get_tweet_reply($link, $reply_id_list){

  $sql = 'SELECT tweet_id,user_id,user_tweet_str FROM tweet_table WHERE user_tweet_reply_id IN ('.$reply_id_list.')';

  $tweet_reply = get_as_array($link, $sql); //SQL実行 

  return $tweet_reply;

}

/***********************************
* リツイート機能

retweet_id = リツイートするつぶやきの、ツイートID
***********************************/

function insert_retweet($link,$param1,$param2){

  try{

    $sql_info = 'INSERT INTO tweet_table(user_id,retweet_id,user_tweet_time) VALUES (?,?,?)';
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
* リツイートを取得
***********************************/

//リツイートされた、ツイートを取得

/***********************************
* 返信ツイートのIDを取得
***********************************/

function get_retweet_id($link) {
  
  $sql = 'SELECT retweet_id FROM tweet_table WHERE retweet_id != 0'; // SQL生成

  $list = '';

  $retweet_id = get_as_array($link, $sql); //SQL実行


    if($retweet_id){

    foreach($retweet_id as $retweet_id_list) {
          
      $list .= $retweet_id_list['retweet_id'].',';

    }

    $list = rtrim($list,',');

    return $list; 

  } else {

    return FALSE;

  }

}

/*
'SELECT tweet_table.user_id,user_table.user_name,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id  WHERE tweet_table.user_id = '.$user_id; 
*/

/***********************************
* リツイートを取得
***********************************/


function get_retweet($link, $retweet_id_list){

  $sql = 'SELECT tweet_table.tweet_id,tweet_table.user_id,tweet_table.user_tweet_str,user_table.user_name,user_table.user_image FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id WHERE tweet_id IN ('.$retweet_id_list.')';

  $retweet = get_as_array($link, $sql); //SQL実行 

  return $retweet;

}

// 引数に、全ツイート渡せばいいのではないか。

function get_retweet_test($link,$user_id) {
  
  $sql = 'SELECT tweet_table.user_id,user_table.user_name,user_table.user_image,tweet_table.retweet_id,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id  WHERE tweet_table.user_id = '.$user_id;// ユーザーのツイート情報を取得するSQL生成

   $retweet = get_as_array($link, $sql); // ユーザーの全ツイート情報取得

  foreach($retweet as $retweet_list) {
        
    if($retweet_list['retweet_id'] !== '0'){ // リツイートIDが存在したら != 

      $retweet_id = $retweet_list['retweet_id']; // リツイートIDを変数に格納

      $retweet_info = get_retweet($link,$retweet_id); // リツイート・ユーザー情報を、配列に格納

      // データ入れ替え

      $retweet_list['user_id'] = $retweet_info[0]['user_id']; 
      $retweet_list['user_name'] = $retweet_info[0]['user_name']; 
      $retweet_list['user_image'] = $retweet_info[0]['user_image']; 
      $retweet_list['user_tweet_str'] = $retweet_info[0]['user_tweet_str']; 

    } 

  //var_dump($retweet_list); // ここの時点が、理想の連想配列になっている。.

  $data[] = $retweet_list; // データを配列に格納    

  }

  return $data;
  
}




