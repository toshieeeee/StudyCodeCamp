<?php

//定数定義 → 変数定義 → 関数実行 → 関数定義 



/***********************************

▼DB Access INFO - 定数

************************************/

date_default_timezone_set('Asia/Tokyo');

define('DSN','mysql:dbname=vending_machine;host=localhost');
define('DB_USER','root');
define('DB_PASSWD','root');
define('HTML_CHARACTER_SET','UTF-8');  // HTML文字エンコーディング
define('DB_CHARACTER_SET','SET NAMES utf8'); 

$error = array();

/*************************************************************

▼関数を実行

**************************************************************/

$link = get_db_connect(); // DBに接続する関数 [返り値] : PDOオブジェクト

$data = get_goods_table_list($link); // SQLを実行して、結果セットを取得。連想配列として格納

close_db_connect($link); // DBを切断


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

  $name = str_validation('pro_name'); // Name属性を引数に渡す
  echo $name;
  $price = num_validation('pro_price');
  echo $price;
 
}


/*************************************************************

▼関数を定義

**************************************************************/


/***********************************
▼PDOインスタンス作成 + DBハンドル取得 
@return obj $link DBハンドル取得
************************************/

function get_db_connect(){

  try{
      
    $dbh = new PDO(DSN,DB_USER,DB_PASSWD);

      if(!$dbh->query('SET NAMES utf8')){

        throw new DBException;        

      };

      //PDO::query() は、PDOStatement オブジェクトを返します。
      //失敗した場合は FALSE を返します。

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
* 商品の一覧を取得する
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

  return $data;

}


/***********************************
* SQLを定義して、get_as_arrayを実行する
*
* @param obj $link DBハンドル
* @return 商品一覧、連想配列データ
************************************/

function get_goods_table_list($link) {
  
  $sql = 'SELECT pro_id,pro_name,pro_price,pro_status FROM pro_info_table'; // SQL生成

  return get_as_array($link, $sql); //SQL実行 

}


/***********************************

▼文字列をバリデーション

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

▼整数をバリデーションする関数

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
* サニタイズ
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
    /*margin : auto;*/
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

        
    <p>名前 : <input type="text" name="pro_name"></p>

    コメント : <input type="text" name="pro_price" size="60">

    <p><input type="submit" name="submit" value="送信"></p>
      
  </form>

  <p>発言一覧</p>

  <table>

    <p>▼商品一覧</p>

    <tbody>

      <tr>
          <th>商品名</th>
          <th>価格</th>
          <th>ステータス</th>
      </tr>

      <!--ここにPHPのコードを書きます-->

      

      <?php foreach ($data as $data_text) { ?>

        <tr>
          <td><?php echo sanitize(($data_text["pro_name"])) ?></td>
          <td><?php echo sanitize(($data_text["pro_price"])) ?></td>
          <td><?php echo sanitize(($data_text["pro_status"])) ?></td>
        </tr>

      <?php } ?>


    </tbody>

  </table>

</body>
</html>