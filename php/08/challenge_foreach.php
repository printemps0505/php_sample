<?php
$class = array('ガリ勉' => '鈴木', '委員長' => '佐藤', 'セレブ' => '斎藤', 'メガネ' => '伊藤', '女神' => '杉内');
$i = 0;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>challenge_foreach</title>
</head>
<body>
    <?php
    //配列のキーを$key,要素を$nameとする。
        foreach($class as $key => $name){
    ?>
            <p><?php print $name;?>さんのアダ名は<?php print $key;?>です。</p>
    <?php
            $i++;
        }
    ?>
</body>
</html>