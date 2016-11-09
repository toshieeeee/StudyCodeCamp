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

// 初期値の設定

$user_image = ''; // 初期値の画像を設定
$user_profile_text = 'プロフィールを入力してください';
$user_place_edit = '場所を設定してください';

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
  $error[] .= '<p><a href="./">ログイン画面へ</a></p>';

}


/*************************************************************
▼ GETリクエスト時の処理
**************************************************************/

if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 

  $link = get_db_connect();

}

/*************************************************************
▼ POSTリクエスト時の処理
**************************************************************/


if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  $link = get_db_connect();

  // バリデーション

  $user_name_edit = str_validation('user_name_edit'); 
  $user_profile_text_edit = str_long_validation('user_profile_text_edit'); // プロフィールの文章

  $user_image_edit = upload_image('user_image_edit'); // 画像
  $user_place_edit = str_validation('user_place_edit'); // 場所

  if(count($error_text) === 0){

    // UPDATE実行
  
    update_profile_table($link,$user_id,$user_name_edit,$user_profile_text_edit,$user_image_edit,$user_place_edit);

    // セッションに、変更情報を保存

    $_SESSION['user_name'] = $user_name_edit;
    $_SESSION['user_profile_text'] = $user_profile_text_edit;
    $_SESSION['user_image'] = $user_image_edit;
    $_SESSION['user_place'] = $user_place_edit;

    // クッキーに、変更情報を保存

    //setcookie('user_address', $user_address , time() + 60 * 60 * 24 * 365);

    header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/profile_edit.php'); 

  }

}

/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/profile_edit_view.php';