<?php

/*************************************************************

▼関数を定義

**************************************************************/

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

