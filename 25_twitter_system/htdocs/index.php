<?

session_start(); 

/*************************************************************

▼全体の処理のロジック[ユーザー登録]

*************************************************************

POSTの値を取得する（ユーザー名 & アドレス & パスワード）
↓
バリデーション
↓
SQL実行（SELECTクエリ - 任意のユーザー名 & アドレスを取得する）
↓
バリデーション（ユーザー名 & アドレスが重複しているかどうか）
↓
ユーザー情報（ログインフラグ / ユーザー名）をセッションに保存
↓
SQL実行（INSERTクエリ - ユーザー情報をDBに保存）
↓
ログイン済みページにリダイレクト

**************************************************************/

/*************************************************************

▼設定ファイル読み込み

**************************************************************/

require_once '../include/conf/const.php';

/*************************************************************

▼Model読み込み

**************************************************************/

require_once '../include/model/common_function.php'; 
require_once '../include/model/top_function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();

/*************************************************************

▼関数を実行

**************************************************************/

// ログイン済みの場合、ホームページへリダイレクト

if (isset($_SESSION['user_id']) === TRUE) {

   header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

   exit;

}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

  // バリデーション

  $user_name = str_validation('user_name'); 
  $user_address = mail_validation('user_address'); 
  $user_passwd = str_validation('user_passwd'); 
  $user_passwd = md5($user_passwd); // 暗号化

  if(count($error) === 0){

    $link = get_db_connect();

    // 重複の確認

    confirm_name_exist($link,$user_name);
    confirm_address_exist($link,$user_address); // アドレスが重複してるかどうか確認

    if(count($error) === 0){ 

      $_SESSION['login'] = TRUE; // セッションにフラグを立てる。
      $_SESSION['user_name'] = $user_name; // [修正] - クッキーに保存するようにする。
      $_SESSION['user_address'] = $user_address; // [修正] - クッキーに保存するようにする。

      insert_table($link,$user_name,$user_address,$user_passwd); // クエリ実行

      $user_id = get_user_id($link,$user_address);

      $_SESSION['user_id'] = $user_id;



      // ログイン済みページへリダイレクト

      header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

    } 

  }

}

/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/top_view.php';
