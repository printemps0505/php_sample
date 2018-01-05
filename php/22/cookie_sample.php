<?php
$comment = array();
$cookie_count = $_COOKIE['visit_count'];
if(!isset($cookie_count)){
    setcookie('visit_count',1);
    $comment[] = '訪問回数は1回です';
}else{
    $count = ($cookie_count + 1);
    $count_str =  (string)$count;
    setcookie('visit_count',$count,time() + 3600);
    $comment[] = '訪問回数は'.$count_str.'回です';
}
        
function h($str){
    //htmlspecialcharsは文字列型のみ引数に取れるので、間にint型が入っているとエラーになる。そのために9の処理が必要
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>cookie</title>
    </head>
    <body>
        <?php foreach($comment as $read){ ?>
            <p><?php print h($read); ?></p>
        <?php } ?>
    </body>
</html>