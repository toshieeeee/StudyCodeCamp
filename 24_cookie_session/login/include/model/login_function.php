<?php

/*************************************************************

▼関数を定義

**************************************************************/


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
* 投入金と、DBのプライスを比較する関数

* @param DBハンドラ,ユーザーから受け取るID,ユーザーから受け取る整数 
* @return 引き算の結果 / FALSE
************************************/

function get_user_id($link,$mail,$passwd){ //$link = PDOオブジェクト

  global $error;

  $sql = 'SELECT user_id FROM login_table WHERE user_address = "' .$mail. '" AND user_pass = "'.$passwd .'"';

  $data = $link->query($sql);

  $data = $data->fetch(PDO::FETCH_ASSOC); 

  if(!$data){ // ユーザーIDが返ってきたら処理を実行

    $error[] = 'メールアドレス、またはパスワードが一致しません';

  } else {

    $user_id = $data['user_id'];

    return $user_id;

  }  

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

  return $data; // 配列を逆にして返す

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
