<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<?php
// 0〜2のランダムな数値を2つ取得し、それぞれ変数$rand1と$rand2へ代入
$rand1 = mt_rand(0, 2);
$rand2 = mt_rand(0, 2);

// ランダムな数値$rand1と$rand2をそれぞれ表示
print 'rand1: ' . $rand1 . "\n";
print 'rand2: ' . $rand2 . "\n";

if ($rand1 > $rand2){
?>
<p>rand1のが大きい</p>
<?php } else if ($rand2 > $rand1){?>
<p>rand2のが大きい</p>
<?php } else {?>
<p>同じ値</p>
<?php }?>
</body>
</html>