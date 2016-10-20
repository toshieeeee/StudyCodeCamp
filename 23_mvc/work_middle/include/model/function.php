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
* SQLの定義 / get_as_arrayを実行
*
* @param obj $link DBハンドル
* @return 商品一覧、連想配列データ
************************************/

function get_goods_table_list($link) {
  
  $sql = 'SELECT pro_info_table.pro_id,pro_info_table.pro_image,pro_info_table.pro_name,pro_info_table.pro_price,pro_num_table.pro_num,pro_info_table.pro_status FROM pro_num_table JOIN pro_info_table on pro_info_table.pro_id = pro_num_table.pro_id'; // SQL生成

  return get_as_array($link, $sql); //SQL実行 

}


/***********************************
* 文字列のバリデーション
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
* 文字列のバリデーション - Comment
*
* @param str name属性
* @return 成功 : 入力データ 失敗 : $errorに、入力した文字列を格納したデータ
************************************/

function str_long_validation($str){

  global $error;

  $temp = $str; 
  $str = $_POST[$str]; 
  $attr = $temp;

  if(isset($str) !== TRUE || mb_strlen($str) === 0){

    $error[$attr] = $attr.'を入力してください';

  } else if(mb_strlen($str) > 100){

    $error[$attr] = $attr.'は100文字以内で入力してください';

  } else if(preg_match ('/^\s*$|^　*$/',$str)){

    $error[$attr] = $attr.'は半角、または全角スペースだけでは登録できません';

  } else {

    return $str;

  }

}


/***********************************
* 整数のバリデーション
*
* @param str name属性
* @return 成功 : 入力データ 失敗 : $errorに、入力した文字列を格納したデータ
************************************/

function num_validation($num){

  global $error;

  $temp = $num; // 属性名を受け取る
  $num = $_POST[$num]; //属性の値を受け取る
  $attr = $temp;

  if(isset($num) !== TRUE || mb_strlen($num) === 0){

    $error[$attr] = '価格を入力してください';

  } else if(mb_strlen($num) > 5){

    $error[$attr] = '価格は5桁以内で入力してください';

  } else if(preg_match('/^\s*$|^　*$/',$num)){ 

    $error[$attr] = '価格は半角、または全角スペースだけでは登録できません';

  } else if (!preg_match('/^[0-9]+$/',$num)){

    $error[$attr] = '価格は正数値のみ入力可能です';

  } else {

    return $num;

  }

}

/***********************************
* ラジオボタンのバリデーション
*
* @param str name属性
* @return 成功 : 商品のIDを返す 失敗 : $errorに、入力した文字列を格納したデータ
************************************/


function radio_validation($id){

  global $error;

  if(!isset($_POST[$id])){ 

    $error[] = '商品を選択してください';

  } else {

    $temp = $id; // 属性名を受け取る - pro_id  

    $num = $_POST[$id]; //属性の値を受け取る // 112

    $attr = $temp; //pro_id

    return $num;

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
* 「任意の商品名」を取得する

* @param DBハンドラ,ユーザーから受け取るID
* @return IDとヒモ付いた商品名 
************************************/

function get_pro_name($link,$pro_id){ //$link = PDOオブジェクト

  try{

    $sql = 'SELECT pro_name FROM pro_info_table WHERE pro_id = '.$pro_id;  // 条件付SQL

    if(!$data = $link->query($sql)){ // SQLの判定 / 実行

      throw new QueryException();

    }

    $data = $data->fetch(PDO::FETCH_ASSOC); //購入品の金額を取得

    $pro_name = $data['pro_name'];

    return $pro_name;

  } catch (QueryException $e){

    echo 'Fatal Error : '.$e->getMessage().'<br>';
    echo $e->getFile().'<br>';
    echo $e->getLine().'<br>';
 
  }

}

/***********************************
* 「任意の画像名」を取得する

* @param DBハンドラ,ユーザーから受け取るID
* @return IDとヒモ付いた商品名 
************************************/

function get_pro_image($link,$pro_id){ //$link = PDOオブジェクト

  try{

    $sql = 'SELECT pro_image FROM pro_info_table WHERE pro_id = '.$pro_id;  // 条件付SQL

    if(!$data = $link->query($sql)){ // SQLの判定 / 実行

      throw new QueryException();

    }

    $data = $data->fetch(PDO::FETCH_ASSOC); //購入品の金額を取得

    $pro_image = $data['pro_image'];

    return $pro_image;

  } catch (QueryException $e){

    echo 'Fatal Error : '.$e->getMessage().'<br>';
    echo $e->getFile().'<br>';
    echo $e->getLine().'<br>';
 
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

function insert_table($link,$param1,$param2){

  try{

    $sql_info = 'INSERT INTO board_table(user_name,user_comment,user_date,user_info) VALUES (?,?,?,?)';
    $stmt = $link->prepare($sql_info); 

    $data[] = $param1;
    $data[] = $param2;
    $data[] = date('Y-m-d H:i:s');
    $data[] = $_SERVER['HTTP_USER_AGENT'];

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
* UPDATEの実行
*
* @param1 - DBハンドラ
* @param2 - プレースホルダーに入れる値
*
* @return TRUE / FALSE
***********************************/

function update_table($link,$pro_id,$pro_num){

  try{

    $pro_update_date = date('Y-m-d H:i:s');
    $pro_num_update = $pro_num - 1;
    
    $sql = 'UPDATE pro_num_table SET pro_num = '.$pro_num_update.',pro_update_date = "'.$pro_update_date.'" WHERE pro_id = '.$pro_id;
    
    if(!$link->query($sql)){ // SQLの判定 / 実行

      throw new QueryException();

    }

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
