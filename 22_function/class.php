<?php

class Test {

    // No.1　静的プロパティ
    public static $a = 8;

    // No.2　静的メソッド
    public static function sum($b,$c) {
        echo $b + $c;
    }

    // No.3　インスタンスプロパティ
    public static $d = 9;

    // No.4　インスタンスメソッド
    public function count() {
        static $e = 0;
        echo $e;
        $e++;
    }

    // No.5　インスタンスメソッド
    public function division($f,$g) {
        echo $f / $g;
    }

}

// No.1 静的プロパティへアクセス
//echo Test::$a;

// No.2 静的メソッド

//echo Test::sum(1,2);

//echo Test->$d;

//$test = new Test;
//echo Test::$d;
//echo Test::$a; 
//echo Test::sum(1,3); 

// No1.車クラスを作成
class Car {

    private $km = 0; 

    public function drive($distance) {
        $this->km += $distance;
    }

    public function getKm() {
        return $this->km;
    }
}

// No2.インスタンス化して変数priusに代入
$prius = new Car();

// No3.インスタンスのdriveメソッドへアクセスして引数に80を指定
$prius->drive(80);

// No4.同じくインスタンスのdriveメソッドへアクセスして引数に20を指定
$prius->drive(20);

// No5.インスタンスのgetKmメソッドへアクセスして走行距離を出力
print $prius->getKm();

// No6.インスタンス化して変数corollaに代入
$corolla = new Car();

// No7.インスタンスのdriveメソッドへアクセスして引数に50を指定
$corolla->drive(50);

// No8.インスタンスのgetKmメソッドへアクセスして走行距離を出力
print $corolla->getKm();

?>