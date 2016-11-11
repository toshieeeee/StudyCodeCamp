<?php

/***********************************
* DBハンドル取得を取得
*
* @return obj $link DBハンドル
************************************/

function get_db_connect(){

  try{
      
    $dbh = new PDO(DSN,DB_USER,DB_PASSWD);

      if(!$dbh->query('SET NAMES utf8')){

        throw new DBException;        

      }

      return $dbh;

    }catch(DBException $e){

      echo 'Fatal Error : '.$e->getMessage().'<br>';
      echo $e->getFile().'<br>';
      echo $e->getLine().'<br>';
      
      exit();

  }
}

/***********************************
▼DBを切断
************************************/

function close_db_connect($link) {

    $link = null; // 接続を閉じる

}


/***********************************
* 商品の一覧を取得
*
* @param obj $link DBハンドル
* @param obj $sql 実行するクエリ
* @return array $data 商品一覧、連想配列データ
************************************/

function get_as_array($link,$sql){
  
  $data = array(); // 返却用配列

  $stmt = $link->prepare($sql); //プリペアードステートメント

  try {

    if($stmt->execute()){ // 実行（判定） + 結果セットを格納 

      while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $rec;

      }

    } else {

      throw new QueryException(); // クエリの記述が間違っていて、実行されなければ、スルーされる

    }

  } catch (QueryException $e){

      echo 'Fatal Error : '.$e->getMessage().'<br>';
      echo $e->getFile().'<br>';
      echo $e->getLine().'<br>';

  }

  $data = array_reverse($data);

  return $data; // 配列を逆にして返す

}


/***********************************
* 自分のツイートを取得
************************************/


function get_my_tweet_list($link,$user_id) {
  
  $sql = 'SELECT tweet_table.user_id,user_table.user_name,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id  WHERE tweet_table.user_id = '.$user_id; 


  return get_as_array($link, $sql); //SQL実行 

}


/***********************************
* フォローIDを取得
***********************************/

function get_follow_id($link,$user_id){

  $sql = 'SELECT follow_id FROM follow_table WHERE user_id ='.$user_id;
  
  $list = ''; // 保存用

  $follow_id = get_as_array($link, $sql); 

  if($follow_id){ 

    foreach($follow_id as $follow_id_list) {
          
      $list .= $follow_id_list['follow_id'].',';

    }

    $list = rtrim($list,',');

    return $list;

  } else {

    return FALSE;

  }

}

/***********************************
* フォローするユーザーを取得
***********************************/

function get_follow_user($link, $follow_id_list){

  $sql = 'SELECT user_id,user_name,user_profile_text,user_image FROM user_table WHERE user_id IN ('.$follow_id_list.')';

  $follow_user = get_as_array($link, $sql); //SQL実行 

  return $follow_user;

}

/***********************************
* フォロワーIDを取得
***********************************/

function get_follower_id($link,$user_id){

  $sql = 'SELECT user_id FROM follow_table WHERE follow_id ='.$user_id;
  
  $list = ''; // 保存用

  $follower_id = get_as_array($link, $sql);

  if($follower_id){ // フォロワー数が0でなければ

    foreach($follower_id as $follower_id_list) {
          
      $list .= $follower_id_list['user_id'].',';

    }

    $list = rtrim($list,',');

    return $list;

  } else{

    return FALSE;

  }

}

/***********************************
* フォロワーを取得
***********************************/

function get_follower_user($link, $follower_id_list){

  $sql = 'SELECT user_id,user_name,user_profile_text,user_image FROM user_table WHERE user_id IN ('.$follower_id_list.')';

  $follower_user = get_as_array($link, $sql); //SQL実行 

  return $follower_user;


}

/***********************************
* フォローを解除
***********************************/

function delete_follow_user($link,$user_id,$follow_id){

  $sql = 'DELETE FROM follow_table WHERE user_id = '.$user_id.' AND follow_id = '.$follow_id;

  $link->query($sql);

}

/***********************************
* 自分以外のユーザー情報を取得
***********************************/


function get_other_user_info($link,$other_user_id) {

  // SQL生成
  
  $sql = 'SELECT user_name,user_image,user_profile_text,user_place FROM user_table WHERE user_id = '.$other_user_id;

  return get_as_array($link, $sql); //SQL実行 

}

/***********************************
* サニタイズの実行
*
* @param str エスケープする文字列
* @return エスケープした文字列
************************************/

function sanitize($str) {

  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);

}

/*************************************************************

▼例外サブクラスの定義

**************************************************************/

//オブジェクトにしておいたほうが、後の更に強い。
//複雑なエラーを追加したいような場合にも対応できるから。

class DBException extends Exception{

  public function __construct(){ //メンバ変数の初期化

    $this->message = 'DBの接続に失敗しました';

  }

}

class QueryException extends Exception{

  public function __construct(){ //メンバ変数の初期化

    $this->message = 'クエリの実行に失敗しました';

  }

}
