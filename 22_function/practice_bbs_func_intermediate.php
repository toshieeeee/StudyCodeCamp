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


$link = get_db_connect(); // DBに接続する関数 [返り値] : PDOオブジェクト

$data = get_goods_table_list($link); // SQLを実行して、連想配列として格納


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
  
  // SQL生成
  $sql = 'SELECT pro_id,pro_name FROM pro_info_table';

  return get_as_array($link, $sql);

}


/***********************************
▼例外サブクラスの定義
************************************/

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
</head>
<body>
  
  <h1>課題</h1>
   
  <form action="bbs.php" method="post">

        
    <p>名前 : <input type="text" name="user_name"></p>

    コメント : <input type="text" name="user_comment" size="60">

    <p><input type="submit" name="submit" value="送信"></p>
      
    </form>

    <p>発言一覧</p>

    <ul>

      <?php foreach ($data as $data_text) { ?>

      <li><?php echo $data_text["pro_name"] ?></li>
      <li><?php echo $data_text["pro_id"] ?></li>

      <?php } ?>

    </ul>

</body>
</html>