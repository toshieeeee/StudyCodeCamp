<pre>
<?php
session_start(); // セッション名（固定値） + セッションID（変動値）を発行（保存領域はCookie）

//スーパーグローバル変数から、セッション名、IDを、参照する事が出来る

print 'セッション名: ' . session_name() . "\n"; //出力してるだけ。すでに値は、セットされている。
print 'セッションID: ' . session_id() . "\n";


//post - a → b → c （このようにデータを渡す際は、HTMLのinput="hidden"などで）
//session - 一時的な保存
//cookie - 長期的な保存


if (isset($_SESSION['count']) === TRUE) { //count - サーバー上で連想配列の型で保存してある
   $_SESSION['count']++;
} else {
   $_SESSION['count'] = 1;
}
print $_SESSION['count'] . '回目の訪問です' . "\n";
?>
</pre>