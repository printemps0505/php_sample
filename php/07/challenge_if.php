<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>challenge_if</title>
</head>
<body>
<?php
$rand = mt_rand(1,6);
$ans = $rand % 2;
?>
<p><?php print $rand; ?></p>
<?php
if ($ans == 0){
?>
<p>偶数</p>
<?php } else {?>
<p>奇数</p>
<?php } ?>
</body>
</html>