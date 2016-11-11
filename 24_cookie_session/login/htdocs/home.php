<?php

session_start(); 

// DBからつぶやきを取得して、表示
// DBにつぶやきを登録


/*************************************************************

▼設定ファイル読み込み

**************************************************************/

require_once '../include/conf/const.php';

/*************************************************************

▼Model読み込み

**************************************************************/

require_once '../include/model/home_function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();

/*************************************************************

▼関数を実行

**************************************************************/


if(isset($_SESSION['login'])){ // ログインしていたら、セッションの値を変数に格納

  $name = $_SESSION['user_name'];
 // $user_id = $_SESSION['user_id'];
  $user_address = $_SESSION['user_address'];

} else{

  $error[] .= '<p>ログインされていません</p>';
  $error[] .= '<p><a href="./">ログイン画面へ</a></p>';

}

$link = get_db_connect();

$data = get_goods_table_list($link);


if(isset($_POST['user_comment']) === TRUE){

  $user_comment = $_POST['user_comment'];

  insert_table($link,$user_comment);

  header('Location: http://'. $_SERVER['HTTP_HOST'] .'/24_cookie_session/login/htdocs/home.php'); 

}


/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/home_view.php';