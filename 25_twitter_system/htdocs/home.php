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


if(isset($_SESSION['login'])){ 

  /*************************************************************
  ▼ ログインしていたら、セッションの値を変数に格納
  **************************************************************/

  $user_id = $_SESSION['user_id']; // セッションにユーザーIDを保存
  $user_name = $_SESSION['user_name']; // セッションにユーザー名を保存

  if(!preg_match('/dummy.png/',$_SESSION['user_image'])){

      $user_image = $_SESSION['user_image'];

  } else {

    $user_image = 'dummy.png';

  }

  
  if(isset($_SESSION['user_profile_text']) === TRUE AND mb_strlen($_SESSION['user_profile_text']) !== 0){

    $user_profile_text = $_SESSION['user_profile_text']; // セッションにプロフィールの文章を保存

  } else{

    $user_profile_text = 'プロフィールを入力してください';

  }

  if(isset($_SESSION['user_place']) === TRUE AND mb_strlen($_SESSION['user_place']) !== 0){

    $user_place = $_SESSION['user_place']; // セッションに場所を保存

  } else{

    $user_place = '場所を設定してください';

  }

} else{

  $error[] .= '<p class="login_error">ログインされていません</p>';
  $error[] .= '<a href="login.php" class="login_error_btn_text"><p class="login_error_btn">ログイン画面へ</p></a>';
  $_SESSION = array(); 

}

if(isset($_SESSION['login'])){ 

  /*************************************************************
  ▼ GETリクエスト時の処理
  **************************************************************/

  if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 

    $link = get_db_connect();

    $follow_id_list = get_follow_id($link,$user_id); // フォローID取得

    // フォローしているユーザーがいたら、フォローユーザー + 自分のつぶやきを表示

    if($follow_id_list){ // 条件 : フォローユーザーがいる

      // フォローユーザーのツイートを取得

      $data = get_follow_user_tweet_list($link,$user_id,$follow_id_list);

      // リツイートを含む、ツイートを取得

     //$data = get_my_tweet_retweet_list($link,$user_id);


      // 返信リプライ / リツイートを含む、ツイートを取得 

      $data = reply_into_ass_array($data); 

      $other_user = get_user_id_name_list($link,$follow_id_list); // ランダムに、フォローするユーザーIDを取得

    } else{

      // フォローユーザーがいなければ、自分のつぶやきのみを表示

      $data = get_my_tweet_list($link,$user_id);

      $other_user = get_first_user_id_name_list($link,$user_id);

    }

    /***********************************
    ▼ 自分のつぶやき数取得
    ************************************/ 

    $my_tweet_data = get_my_tweet_list($link,$user_id);

    $my_tweet_num = count($my_tweet_data);

    /***********************************
    ▼ フォロー数取得
    ************************************/ 

    // $follow_id_list = get_follow_id($link,$user_id); // フォローID取得

    if($follow_id_list){

      $follow_id_list = $follow_id_list.','.$user_id; // フォローID + 自分のユーザーID

      $follow_user = get_follow_user($link, $follow_id_list);

      $follow_user_num = count($follow_user);
      
      $follow_user_num = $follow_user_num - 1; 

    } else {

      $follow_user_num = '0';

    }

    /***********************************
    ▼ フォロワー取得
    ************************************/ 

    $follower_id_list = get_follower_id($link,$user_id); //　自分がフォローしている人のユーザーIDを"文字列"で取得

    if($follower_id_list){

      $follower_user = get_follower_user($link, $follower_id_list);
      $follower_user_num = count($follower_user); // フォロワー数取得

    } else {

      $follower_user_num = '0';

    }

  }

  /*************************************************************
  ▼ POSTリクエスト時の処理
  **************************************************************/


  if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 


    /***********************************
    ▼ つぶやきリクエスト
    ************************************/ 

    if(isset($_POST['tweet']) === TRUE){

      $link = get_db_connect();
      
      $user_tweet_str = $_POST['user_tweet_str'];

      $user_tweet_str = str_validation('user_tweet_str'); // バリデーション 

      if(count($error) === 0){

        insert_table($link,$user_id,$user_tweet_str); // DBハンドラ,ユーザーID,つぶやき

        header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

      }

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

    /***********************************
    ▼ 返信機能
    ************************************/ 

    if(isset($_POST['tweet_reply']) === TRUE){

      $link = get_db_connect();

      $user_tweet_reply_id = $_POST['user_tweet_reply_id'];

      $user_tweet_str = $_POST['user_tweet_str'];

      insert_tweet_replay($link,$user_id,$user_tweet_reply_id,$user_tweet_str);

      header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 
      
    }

    /***********************************
    ▼ リツイート機能
    ************************************/ 

    if(isset($_POST['retweet']) === TRUE){

      $link = get_db_connect();

      $retweet_id = $_POST['retweet_id'];

      insert_retweet($link,$user_id,$retweet_id);

      header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

    }
    
  }

}

/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/home_view.php';

