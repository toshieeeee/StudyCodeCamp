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

function compare_db_price($link,$pro_id,$pro_price_submit){ //$link = PDOオブジェクト

  global $error;

  $sql = 'SELECT pro_price FROM pro_info_table WHERE pro_id = '.$pro_id;  // 条件付SQL

  $data = $link->query($sql);

  $data = $data->fetch(PDO::FETCH_ASSOC); //購入品の金額を取得

  $pro_price = $data['pro_price'];
  
  if($pro_price > $pro_price_submit){ 

    $error['pro_price'] = '投入金額が足りません';

  } else {

    $pro_price_result = $pro_price_submit - $pro_price;

    return $pro_price_result;

  }

}

/***********************************
* 商品の在庫を確認する関数

* @param DBハンドラ,ユーザーから受け取るID
* @return TRUE / FALSE
************************************/

function compare_db_stock($link,$pro_id){ //$link = PDOオブジェクト

  global $error;

  $sql = 'SELECT pro_num FROM pro_num_table WHERE pro_id = '.$pro_id;  // 条件付SQL

  $data = $link->query($sql);

  $data = $data->fetch(PDO::FETCH_ASSOC); //購入品の金額を取得

  $pro_num = $data['pro_num'];
  
  if($pro_num  === '0'){ 

    $error['pro_num'] = '在庫切れです';

  } else {

    return $pro_num;

  }

}

/***********************************
* 商品のステータスを比較する関数

* @param DBハンドラ,ユーザーから受け取るID
* @return TRUE / FALSE
************************************/

function compare_db_status($link,$pro_id){ //$link = PDOオブジェクト

  global $error;

  $sql = 'SELECT pro_status FROM pro_info_table WHERE pro_id = '.$pro_id;  // 条件付SQL

  $data = $link->query($sql);

  $data = $data->fetch(PDO::FETCH_ASSOC); //購入品の金額を取得

  $pro_status = $data['pro_status'];
  
  if($pro_status  === '0'){ 

    $error['pro_status'] = '非公開商品です';

  } else {

    return TRUE;

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
* ユーザー名が存在するかどうか確認する
*
* @param obj $link DBハンドル
* @return str 入力に一致したユーザー名
************************************/

function confirm_name_exist($link,$name) {

  global $error;
  
  $sql = 'SELECT user_name FROM login_table WHERE user_name = "'.$name.'"';

  $user_name = get_as_array($link, $sql); //SQL実行 

  if(!$user_name){

    return $user_name;

  } else {

    $error['user_name'] = $name.'は既に登録されているユーザー名です';

  }

}


/***********************************
* アドレスが存在するかどうか確認する
*
* @param obj $link DBハンドル
* @return str 入力に一致したアドレス
************************************/

function confirm_address_exist($link,$address) {

  global $error;
  
  $sql = 'SELECT user_address FROM login_table WHERE user_address = "'.$address.'"';

  $user_address = get_as_array($link, $sql); //SQL実行 

  if(!$user_address){

    return $user_address;

  } else {

    $error['user_address'] = $address.'は既に登録されているアドレスです';

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

    $sql_info = 'INSERT INTO login_table(user_name,user_address,user_pass,user_date) VALUES (?,?,?,?)';
    $stmt = $link->prepare($sql_info); 

    $data[] = $param1;
    $data[] = $param2;
    $data[] = $param3;
    $data[] = date('Y-m-d H:i:s');
  
    if(!$stmt->execute($data)){ // SQLの判定 / 実行

      throw new QueryException();

    }

    header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); // ブラウザをリダイレクト

  } catch (QueryException $e){

    echo 'Fatal Error : '.$e->getMessage().'<br>';
    echo $e->getFile().'<br>';
    echo $e->getLine().'<br>';

  }
  
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
