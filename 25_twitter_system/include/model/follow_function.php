<?php

/*************************************************************

▼関数を定義

**************************************************************/

/***********************************
* すべてのユーザー名/ユーザーIDを取得する
* @param DBハンドラ,ユーザーから受け取るID,ユーザーから受け取る整数 
* @return ユーザーID / エラー文章
************************************/

// 取得レコードのリミットを指定
// 自分以外のIDを取得

function get_user_id_name_list($link,$follow_id_list) {

  $sql = 'SELECT user_id,user_name,user_image FROM user_table WHERE user_id NOT IN ('.$follow_id_list.') ORDER BY RAND() LIMIT 3';
  
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
  
  $sql = 'SELECT tweet_table.user_id,user_table.user_name,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id'; // SQL生成

  return get_as_array($link, $sql); //SQL実行 

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
