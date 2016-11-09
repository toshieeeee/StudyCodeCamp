<?php

session_start(); 


/*************************************************************

▼設定ファイル読み込み

**************************************************************/

require_once '../include/conf/const.php';

/*************************************************************

▼Model読み込み

**************************************************************/

require_once '../include/model/common_function.php';
require_once '../include/model/home_function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();

/*************************************************************

▼関数を実行

**************************************************************/

date_default_timezone_set('Asia/Tokyo');

/*************************************************************
▼ ログイン判定
**************************************************************/


if(isset($_SESSION['login'])){ // ログインしていたら、セッションの値を変数に格納

  $user_id = $_SESSION['user_id']; // セッションにユーザーIDを保存
  $user_name = $_SESSION['user_name']; // セッションにユーザー名を保存
  
  if(isset($_SESSION['user_profile_text'])){

    $user_profile_text = $_SESSION['user_profile_text']; // セッションにプロフィールの文章を保存

  }

  if(isset($_SESSION['user_image'])){

    $user_image = $_SESSION['user_image']; // セッションに画像を保存

  }

  if(isset($_SESSION['user_place'])){

    $user_place = $_SESSION['user_place']; // セッションに場所を保存

  }


} else{

  $error[] .= '<p>ログインされていません</p>';
  $error[] .= '<p><a href="login.php">ログイン画面へ</a></p>';
  $_SESSION = array(); 

}


/*************************************************************
▼ GETリクエスト時の処理
**************************************************************/

if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 

  $link = get_db_connect();

  $data = get_user_tweet_list($link);

  $other_user = get_user_id_name_list($link,$user_id); // フォローするユーザーIDを取得

}

/*************************************************************
▼ POSTリクエスト時の処理
**************************************************************/


if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  //$user_id = $user_id[0]['user_id'];

  /***********************************
  ▼ つぶやきリクエスト
  ************************************/ 

  if(isset($_POST['tweet']) === TRUE){

  $link = get_db_connect();
  
  $user_tweet_str = $_POST['user_tweet_str'];

  insert_table($link,$user_id,$user_tweet_str); // DBハンドラ,ユーザーID,つぶやき

  header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

  }

  /***********************************
  ▼ フォローリクエスト
  ************************************/ 

  if(isset($_POST['follow_btn']) === TRUE){

    $link = get_db_connect();

    $follow_id = $_POST['follow_id'];

    insert_follow_table($link,$user_id,$follow_id);

    header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 
    
  }
  
}

/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/home_view.php';