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

require_once '../include/model/function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();

/*************************************************************

▼関数を実行

**************************************************************/


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

  // バリデーション

  $name = str_validation('name'); 
  $mail = mail_validation('email'); 
  $passwd = str_validation('passwd'); 
  $passwd = md5($passwd); // 暗号化

  if(count($error) === 0){

    $link = get_db_connect();

    // 重複の確認

    confirm_name_exist($link,$name); // ユーザー名が重複してるかどうか確認
    confirm_address_exist($link,$mail); // アドレスが重複してるかどうか確認

    if(count($error) === 0){ 

      $_SESSION['login'] = TRUE;
      $_SESSION['user_name'] = $name; // セッションにユーザー名を保存
      $_SESSION['user_address'] = $mail;

      insert_table($link,$name,$mail,$passwd); // クエリ実行

      // ログイン済みページへリダイレクト

      header('Location: http://'. $_SERVER['HTTP_HOST'] .'/24_cookie_session/login/htdocs/home.php'); 

    } 

  }

}

/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/top_view.php';
