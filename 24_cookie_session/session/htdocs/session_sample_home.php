<?php
/*
*  ログイン済みユーザのホームページ
*
*  セッションの仕組み理解を優先しているため、一部処理はModelへ分離していません
*  また処理はセッション関連の最低限のみ行っており、本来必要な処理も省略しています
*/

require_once '../include/conf/const.php';
require_once '../include/model/function.php';

// セッション開始

session_start();

// セッション変数からuser_id取得 
// →このIDが、情報フラグとなる。


if (isset($_SESSION['user_id']) === TRUE) {

   $user_id = $_SESSION['user_id'];

} else {

   // 非ログイン（=セッション変数が空だったら）の場合、ログインページへリダイレクト

   header('Location: http://codecamp.lesson.codecamp.jp/session_sample_top.php');
   exit;

}

// データベース接続
$link = get_db_connect();

// user_idからユーザ名を取得するSQL
// →ここで、セッション変数の値を使用する。

$sql = 'SELECT user_name FROM user_table WHERE user_id = ' . $user_id; // IDを条件に、ユーザー名を取得するSQL

// SQL実行し登録データを配列で取得

$data = get_as_array($link, $sql);

// データベース切断

close_db_connect($link);

// ユーザ名を取得できたか確認

if (isset($data[0]['user_name'])) {
   $user_name = $data[0]['user_name'];
} else {
   // ユーザ名が取得できない場合、ログアウト処理へリダイレクト
   // →本来なら、セッション変数が存在しない場合のバリデーションで、弾かれる。

   header('Location: http://codecamp.lesson.codecamp.jp/session_sample_logout.php');
   exit;
}
 
// ログイン済みユーザのホームページ表示
include_once '../include/view/session_sample_home.php';

/*


▼ 役割 : コントローラー
▼ 目的 : ログイン済みユーザー専用のページを表示する
 
▼ 処理の流れ : 


1. バリデーション（セッション変数が、存在するかどうか？）
↓
2. DB接続（user_idを条件にユーザ名を取得するSQL）
↓
3.バリデーション（DBから、情報が取得できたかどうか？）
↓ 
4. ログイン済みユーザのページを表示する

****MEMO****

・ログイン済みのユーザーに対して、表示するページ

・セッション変数には、ユーザーIDを保存している。

*/