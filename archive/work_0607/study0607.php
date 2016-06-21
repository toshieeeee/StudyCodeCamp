<?php
 
$filename = './file_write.txt'; // ファイル名　- 初期設定 - PATHを変数に格納

//ファイル書き込む処理 ~ 16


if ($_SERVER['REQUEST_METHOD'] === 'POST'){  //POSTメソッドでデータを受け取ったら、処理を実行する。 
 
    $comment = $_POST['comment'];
 
    if (($fp = fopen($filename, 'a')) !== FALSE) {


        // fopen — ファイルまたは URL をオープンする

        //fopen() 返り値 : IDが取得できるイメージ
        //返り値 - 成功した場合にファイルポインタリソース、エラー時に FALSE を返します。
        
        //引数 (w,a) 
        // w,aの違い ファイルポインタの位置
        //ファイルの中で今どこが対象になっているかという「ファイル内の位置」を示すもの
        //wordのカーソルみたいなイメージ
        
        // fopen("パスを含めたファイル名", "モード")

        // a はadditional = add
        // 存在しない場合は、新規作成。
        // 追記専用（ファイルがなければ自動生成)

        if (fwrite($fp, $comment) === FALSE) {
            print 'ファイル書き込み失敗:  ' . $filename;
        }
        fclose($fp);

        /*fgets(ファイルハンドル);

        ファイルハンドルとはファイルを特定するためのIDのようなものです。開いたファイルを操作する場合は、ファイル名ではなく、このファイルハンドルを使います。

機能
  ファイルから1行を読み込む
  1行 = 改行文字で判定
  */
    }
}
 
$data = array();

//ファイルの読み込み 

//is_readable( ファイル名 )
//指定したファイル名が、読み込み可能か確認し、読み込み可能ならTRUE、読み込み不可能ならFALSEを返す。

if (is_readable($filename) === TRUE) {
    if (($fp = fopen($filename, 'r')) !== FALSE) {
        while (($tmp = fgets($fp)) !== FALSE) {
            $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
        }
        fclose($fp);
    }
} else {
    $data[] = 'ファイルがありません';
}
 
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ファイル操作</title>
</head>
<body>
    <h1>ファイル操作</h1>
 
    <form method="post">
        <input type="text" name="comment">
        <input type="submit" name="submit" value="送信">
    </form>
 
<!--結果表示-->

    <p>以下に<?php print $filename; ?>の中身を表示</p>
<?php foreach ($data as $read) { ?>
    <p><?php print $read; ?></p>
<?php } ?>
</body>
</html>