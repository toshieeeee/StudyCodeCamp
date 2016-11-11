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

/*************************************************************

▼関数を実行

**************************************************************/

if (isset($_SESSION['user_id']) === TRUE) {

   // ログイン済みの場合、ホームページへリダイレクト

   header('Location: http://'. $_SERVER['HTTP_HOST'] .'/24_cookie_session/login/htdocs/home.php'); 

   exit;

}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  // バリデーション

  $mail = mail_validation('email'); 
  $passwd = str_validation('passwd'); 
  $passwd = md5($passwd); // 暗号化

  if(count($error) === 0){

    $link = get_db_connect();

    // DBへ接続（アドレスとパスを条件に、ユーザーIDを取得する）

    $user_id = get_user_id($link,$mail,$passwd);
    $user_name = get_user_name($link,$mail,$passwd);

    if(count($error) === 0){

      $_SESSION['login'] = TRUE;
      $_SESSION['user_name'] = $user_id; 
      $_SESSION['user_id'] = $user_id; // セッションにユーザー名を保存
      $_SESSION['user_address'] = $mail; 

      // ログイン済みページへリダイレクト

      header('Location: http://'. $_SERVER['HTTP_HOST'] .'/24_cookie_session/login/htdocs/home.php'); 

    } 

  }

}



/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/login_view.php';
