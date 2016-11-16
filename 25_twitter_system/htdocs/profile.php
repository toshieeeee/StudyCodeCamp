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
require_once '../include/model/profile_function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();

// セッション初期値の設定

$user_image = 'dummy.png'; // 初期値の画像を設定
$user_profile_text = 'プロフィールを入力してください';
$user_place = '場所を設定してください';


/*************************************************************

▼関数を実行

**************************************************************/

date_default_timezone_set('Asia/Tokyo');

/*************************************************************
▼ ログイン判定
**************************************************************/

if(isset($_SESSION['login'])){ 

  /*************************************************************
  ▼ ログインしていたら、セッションの値を変数に格納
  **************************************************************/

  $user_id = $_SESSION['user_id']; // セッションにユーザーIDを保存
  $user_name = $_SESSION['user_name']; // セッションにユーザー名を保存
  
  if(isset($_SESSION['user_profile_text']) === TRUE AND mb_strlen($_SESSION['user_profile_text']) !== 0){

    $user_profile_text = $_SESSION['user_profile_text']; // セッションにプロフィールの文章を保存

  }

  if(isset($_SESSION['user_image']) === TRUE AND mb_strlen($_SESSION['user_image']) !== 0){

    $user_image = $_SESSION['user_image']; // セッションに画像を保存

  } 

  if(isset($_SESSION['user_place']) === TRUE AND mb_strlen($_SESSION['user_place']) !== 0){

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

  /***********************************
  ▼ つぶやき数取得
  ************************************/ 

  //$data = get_my_tweet_list($link,$user_id);

  $data = get_my_tweet_retweet_list($link,$user_id);

  $my_tweet_num = count($data);


  /***********************************
  ▼ フォロワー取得
  ************************************/ 

  $follower_id_list = get_follower_id($link,$user_id); //　自分がフォローしている人のユーザーIDを"文字列"で取得

  if($follower_id_list){

    $follower_user = get_follower_user($link, $follower_id_list);
    $follower_user_num = count($follower_user); // フォロワー数取得

  } else {

    $follower_user = array();
    $follower_user_num = '0';

  }


  /***********************************
  ▼ フォロー数取得
  ************************************/ 

  $follow_id_list = get_follow_id($link,$user_id);

  if($follow_id_list){

    $follow_user = get_follow_user($link, $follow_id_list);

    $follow_user_num = count($follow_user);

  } else {
    
    $follow_user = array();

    $follow_user_num = '0';

  }

}

/*************************************************************
▼ POSTリクエスト時の処理
**************************************************************/


if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  //if(isset($_POST['tweet']) === TRUE){

  $link = get_db_connect();
  
  $user_tweet_str = $_POST['user_tweet_str'];

  insert_table($link,$user_id,$user_tweet_str); // DBハンドラ,ユーザーID,つぶやき

  header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

  //}

}

/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/profile_view.php';