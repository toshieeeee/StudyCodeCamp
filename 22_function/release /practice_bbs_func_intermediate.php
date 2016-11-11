<?php

/***********

*処理の流れ 

1.定数定義
↓
2.変数定義
↓
3.関数実行
↓
4.関数定義 

***********/

/***********************************

▼DB Access INFO - 定数

************************************/

define('DSN','mysql:dbname=codecamp10334;host=localhost');
define('DB_USER','codecamp10334');
define('DB_PASSWD','SXHGVPSG');
define('HTML_CHARACTER_SET','UTF-8');  // HTML文字エンコーディング
define('DB_CHARACTER_SET','SET NAMES utf8'); 

date_default_timezone_set('Asia/Tokyo');
$error = array();

/*************************************************************

▼関数を実行

**************************************************************/

$link = get_db_connect(); // DBに接続する関数 [返り値] : PDOオブジェクト

$data = get_goods_table_list($link); // SQLを実行して、結果セットを取得。連想配列として格納

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

  $name = str_validation('user_name'); // Name属性を引数に渡す
  $comment = str_long_validation('user_comment');

  if(count($error) === 0){

    insert_table($link,$name,$comment);

  }
 
}


close_db_connect($link); // DBを切断


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

  return array_reverse($data); // 配列を逆にして返す

}


/***********************************
* SQLの定義 / get_as_arrayを実行
*
* @param obj $link DBハンドル
* @return 商品一覧、連想配列データ
************************************/

function get_goods_table_list($link) {
  
  $sql = 'SELECT user_name,user_comment,user_date FROM board_table'; // SQL生成

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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>掲示板 - 課題</title>

  <style type="text/css">
    
  table,td,th {
    border: solid black 1px;
  }

  td,th {
    min-width: 120px;

    text-align: left;
    padding-left: 8px;

  }

  table {
      width: 350px;
      margin-top: 10px;
  }

  img {
    width: 480px;
  }

  .open {
    background: #fff;
  }

  .close {
    background: #ccc;
  }

  </style>

</head>
<body>


    <ul>

      <?php foreach ($error as $error_text) { ?>

      <li><?php echo $error_text ?></li>

      <?php } ?>

    </ul>


  
  <h1>課題</h1>
   
  <form action="practice_bbs_func_intermediate.php" method="post">

        
    <p>名前 : <input type="text" name="user_name"></p>

    コメント : <input type="text" name="user_comment" size="100">

    <p><input type="submit" name="submit" value="送信"></p>
      
  </form>

  <p>発言一覧</p>

  <table>

    <tbody>

      <tr>
          <th>名前</th>
          <th>コメント</th>
          <th>投稿日時</th>
      </tr>

      <!--ここにPHPのコードを書きます-->

      <?php foreach ($data as $data_text) { ?>

        <tr>
          <td><?php echo sanitize(($data_text["user_name"])) ?></td>
          <td><?php echo sanitize(($data_text["user_comment"])) ?></td>
          <td><?php echo sanitize(($data_text["user_date"])) ?></td>
        </tr>

      <?php } ?>


    </tbody>

  </table>

</body>
</html>