<?

session_start(); 

/*************************************************************

▼全体の処理のロジック[ログイン]

*************************************************************

アドレス + パスワード入力 
↓
入力バリデーション
↓
メールアドレスをCOOKIEに保存
↓
DBへ接続（アドレスとパスを条件に、ユーザーIDを取得する）
↓
セッションにユーザーIDを保存
↓
home.phpへリダイレクト

**************************************************************/

/*************************************************************

▼設定ファイル読み込み

**************************************************************/

require_once '../include/conf/const.php';

/*************************************************************

▼Model読み込み

**************************************************************/

require_once '../include/model/login_function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();
$now = time();
$cookie_check = '';

/*************************************************************

▼関数を実行

**************************************************************/

// ログイン済みの場合、ホームページへリダイレクト

if (isset($_SESSION['user_id']) === TRUE) {

   header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

   exit;

}

if (isset($_COOKIE['user_address']) === TRUE) {

   $user_address = $_COOKIE['user_address'];

} else {

   $user_address = '';

}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  // バリデーション

  $user_address = mail_validation('user_address'); 
  $user_passwd = str_validation('user_passwd'); 
  $user_passwd = md5($user_passwd); // 暗号化

  if(count($error) === 0){

    $link = get_db_connect();

    // DBへ接続（アドレスとパスを条件に、ユーザーIDを取得する）

    $user_id = get_user_id($link,$user_address,$user_passwd);
    $user_name = get_user_name($link,$user_address,$user_passwd);

    if(count($error) === 0){

      $_SESSION['login'] = TRUE;
      
      $_SESSION['user_id'] = $user_id; 
      $_SESSION['user_name'] = $user_name; // / セッションにユーザー名を保存

      if (isset($_POST['cookie_check']) === TRUE) {

         $cookie_check = $_POST['cookie_check'];
         setcookie('user_address', $user_address , time() + 60 * 60 * 24 * 365);

      } else {

         $cookie_check = '';

      }
   

      //$_SESSION['user_address'] = $user_address; 

      // ログイン済みページへリダイレクト

      header('Location: http://'. $_SERVER['HTTP_HOST'] .'/25_twitter_system/htdocs/home.php'); 

    } 

  }

}



/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/login_view.php';
