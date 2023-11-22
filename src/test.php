<?php
// xdebug確認用
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 変数を初期化
$number1 = 5;
$number2 = "10";

// 加算関数
function addNumbers($a, $b)
{
    if (!is_numeric($a) || !is_numeric($b)) {
        throw new Exception("両方の引数は数値でなければなりません。");
    }
    return $a + $b;
}

// 結果を試みる
try {
    $result = addNumbers($number1, $number2);
    echo "結果: " . $result;
} catch (Exception $e) {
    echo "エラー発生: " . $e->getMessage();
}
