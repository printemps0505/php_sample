<!DOCTYPE HTML>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>スーパーグローバル変数</title>
</head>
<body>
<?php
if (isset($_GET['my_name']) === TRUE) {
   print 'ようこそ ' . htmlspecialchars($_GET['my_name'], ENT_QUOTES, 'UTF-8').'さん';
} else {
   print '名前を入力してください';
}
?>
</body>
</html>