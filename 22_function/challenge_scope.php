<pre>

<?php
$a = 10;
$b = 10;
$c = 10;
$d = 10;
define('DEF', 10);

print 'fuga_before: a = ' . $a . "\n";
print 'fuga_before: b = ' . $b . "\n";
print 'fuga_before: c = ' . $c . "\n";
print 'fuga_before: d = ' . $d . "\n";
print 'fuga_before: DEF = ' . DEF  . "\n";

function fuga($c) {
  
    global $d;
  
    $a++; 
    print 'fuga: a = ' . $a . "\n";

    // a = 1
  
    $b = 100;
    $b++;
    print 'fuga: b = ' . $b . "\n";

    // b = 101 
  
    $c++;
    print 'fuga: c = ' . $c . "\n";

    // c = 1 → 11 引数に、グローバル変数の$Cが渡されているので。
    // 10 + 1 = 11 
  
    $d++;
    print 'fuga: d = ' . $d . "\n";

    // d = 11
  
    define('DEF', 100);
    print 'fuga: DEF = ' . DEF . "\n";

    // すでに定数が定義されているので、エラーが出てくる。
}

fuga($c);
  
print 'fuga_after: a = ' . $a . "\n";
print 'fuga_after: b = ' . $b . "\n";
print 'fuga_after: c = ' . $c . "\n";
print 'fuga_after: d = ' . $d . "\n"; // $dだけグローバル変数として、定義されているので、関数で処理したあとの結果が返ってくる。

print 'fuga_after: DEF = ' . DEF  . "\n";
  
?>

</pre>