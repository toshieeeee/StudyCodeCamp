<?php

session_start(); 


/*************************************************************
▼処理の流れ
**************************************************************/
/*

POSTでデータを受け取る
↓
バリデーション
↓
INSERT or UPDATEを実行（データがなければINSERT / データがあったらUPDATE ）
↓
リダイレクト

*/
/*************************************************************

▼設定ファイル読み込み

**************************************************************/

require_once '../include/conf/const.php';

/*************************************************************

▼Model読み込み

**************************************************************/

require_once '../include/model/common_function.php'; 
require_once '../include/model/profile_edit_function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();
$error_text = array();

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

} else{

  $error[] .= '<p>ログインされていません</p>';
  $error[] .= '<p><a href="./">ログイン画面へ</a></p>';

}


/*************************************************************
▼ GETリクエスト時の処理
**************************************************************/

if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 

  $link = get_db_connect();

  //$data = get_my_tweet_list($link,$user_id);

}

/*************************************************************
▼ POSTリクエスト時の処理
**************************************************************/


if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  //if(isset($_POST['tweet']) === TRUE){

  $link = get_db_connect();

  // バリデーション

  $user_name_edit = str_validation('user_name_edit'); 
  $user_profile_text_edit = str_long_validation('user_profile_text_edit'); // プロフィールの文章

  $user_image_edit = upload_image('user_image_edit'); // 画像
  $user_place_edit = str_validation('user_place_edit'); // 場所

  if(count($error_text) === 0){
  
  update_profile_table($link,$user_id,$user_name_edit,$user_profile_text_edit,$user_image_edit,$user_place_edit);

  //update_profile_table($link,$user_id,$user_name_edit,$user_profile_text_edit,$user_place_edit);

  header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/profile_edit.php'); 

  }

  //}

}


/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/profile_edit_view.php';