<!DOCTYPE html>
</html lang="ja">
<head>
    <meta charset="utf-8">
    <title>htmlspecialchars</title>
</head>
<body>
    <?php
    $str = '<h2>phpを勉強中です</h2>';
    print $str;
    print htmlspecialchars($str,ENT_QUOTES);
    ?>
</body>
</html>