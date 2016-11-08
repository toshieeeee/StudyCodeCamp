<?php

/*************************************************************

▼関数を定義

**************************************************************/

/*

function login_validation($login){

  global $error;

  if(!isset($login)){

    $error[] .= '<p>ログインされていません</p>';
    $error[] .= '<p><a href="./">ログイン画面へ</a></p>';

  }

}

*/
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
* すべてのユーザー名/ユーザーIDを取得する

* @param DBハンドラ,ユーザーから受け取るID,ユーザーから受け取る整数 
* @return ユーザーID / エラー文章
************************************/

// 取得レコードのリミットを指定
// 自分以外のIDを取得

function get_user_id_name_list($link,$user_id) {

  //$sql = 'SELECT user_id,user_name FROM user_table WHERE user_id != '.$user_id; // 自分のID以外を取得

  //$sql = 'SELECT user_id,user_name FROM user_table ORDER BY RAND() LIMIT 3'; // 開始位置ランダム ~ 3レコード取得

  $sql = 'SELECT user_id,user_name FROM user_table WHERE user_id != '.$user_id.' ORDER BY RAND() LIMIT 3';
  
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
* サニタイズの実行
*
* @param str エスケープする文字列
* @return エスケープした文字列
************************************/

function sanitize($str) {

    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);

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
* フォローしているユーザーを取得
*
* @param0 - DBハンドラ
* @param1 - ユーザーID
* @param2 - ツイート内容
*
* @return TRUE / FALSE
***********************************/

//<取得するレコード>

//follow_table.follow_id

//$sql = 'SELECT tweet_table.user_id,user_table.user_name,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id'; 

/***********************************
* フォローIDを取得
***********************************/

//フォローIDをget_follow_userに、カンマ区切りで渡す事、


function get_follow_id($link,$user_id) {

  $sql = 'SELECT follow_id FROM follow_table WHERE user_id ='.$user_id;
  
  $list = ''; // 保存用

  $follow_id = get_as_array($link, $sql); 


  foreach($follow_id as $follow_id_list) {
        
    $list .= $follow_id_list['follow_id'].',';

  }

  $list = rtrim($list,',');

  return $list;

}

function get_follow_user($link, $follow_id_list) {

  $sql = 'SELECT user_id,user_name FROM user_table WHERE user_id IN ('.$follow_id_list.')';

  $follow_user = get_as_array($link, $sql); //SQL実行 

  //return array_reverse($follow_user);
  return $follow_user;

}


/***********************************
* フォローを解除
***********************************/

function delete_follow_user($link,$user_id,$follow_id) {

  $sql = 'DELETE FROM follow_table WHERE user_id = '.$user_id.' AND follow_id = '.$follow_id;


  $link->query($sql);

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
