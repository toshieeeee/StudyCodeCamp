<?php

//コンストラクタを使用しない場合

$tv = new Television();
$tv->init(8); //メンバ変数の初期化

class Television{

  private $channelNo; //メンバ変数

  function init($channel){

    $this->channelNo = $channel;

    //インスタンスプロパティにアクセスするときは、なぜか、$が不要。

  }

}


//クラス作成時に、メンバ変数を初期化するようにする
//→コンストラクタ関数を使用する。

//インスタンス生成（=コンストラクタ実行 →メンバ変数の初期化） 
/*

$tv = new Television();

class television{

  private $channelNo; //メンバ変数

  function __construct($channel){
    $this->$channelNo = $channel;
  }


}
*/

//コンストラクタ = インスタンス生成時に、必ず実行される関数みたいなイメージでいいような気がする。
//→だから、初期化などの関数を、コンストラクタで実行させるようにすれば、楽ってか、ミスが減るってことか。



class televi{

  public $channelNo; //メンバ変数

  function __construct(){

    $this->channelNo = 8; // televiのインスタンス生成時に、メンバ変数に8を代入（=メンバ変数の初期化）

  }

  function getChannel(){

    return $this->channelNo; // $thisは、インスタンスを指す

  }

}

$test =  new televi(); // このとき、コンストラクタ関数が実行されている。

//echo $test->getChannel();




//「例外クラス」の「サブクラス」

// ▼目的 - エラーの切り分けと、原因追求プロセスの最適化

class webAPIException extends Exception{

  public function __construct(){

    $this->code = 800;
    $this->message = 'WebAPIの接続に失敗しました';

  }

}


try{

  throw new webAPIException();
  
  }catch(webAPIException $e){

  echo $e->getCode().'<br>';
  echo $e->getFile().'<br>';
  echo $e->getLine().'<br>';
  echo $e->getMessage();

}






//PDOに関して

//1.prepare(SQL)
// PDOStatementをインスタンス化して、作成したインスタンスを返す

//2.bindValue(paramID,バインドする値,データ型)
//→値をバインドする

//3.PDO->execute();
//→PDOStatementのインスタンスに、結果セットが格納される




$prepare = $dbh->prepare('SELECT name FROM fruit WHERE price = ?');
$prepare->bindValue(1,(int)$val1,PDO::PARAM_INT);
$prepare->execute();





?>