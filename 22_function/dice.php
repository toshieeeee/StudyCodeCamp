<pre>
<?php

print 'サイコロを1個振る:' . throw_dice(1) . "\n";
print 'サイコロを1個振る:' . throw_dice(1) . "\n";
print 'サイコロを2個振る:' . throw_dice(2) . "\n";
print 'サイコロを2個振る:' . throw_dice(2) . "\n";
print 'サイコロを3個振る:' . throw_dice(3) . "\n";
print 'サイコロを3個振る:' . throw_dice(3) . "\n";


//サイコロの目 * サイコロを振った回数 = サイコロの値の合計値


function throw_dice($num = 1) { // 引数のデフォルト値を設定。関数の引数が空の場合、このデフォルト値が実行される。
  
    $sum = 0;
  
    for ($i = 0; $i < $num; $i++) {
        $sum += mt_rand(1,6);
    }
  
    return $sum;
  
}



?>
</pre>