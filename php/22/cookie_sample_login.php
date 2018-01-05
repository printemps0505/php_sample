<?php
$errors = array();
$success = '';
$cookie_check = '';
$user_name = '';
$password = '';

    $now = time();
    if(isset($_POST['cookie_check'])){
        $cookie_check = $_POST['cookie_check'];
    }
    
    if(isset($_POST['user_name'])){
        $user_name = $_POST['user_name'];
    }
    if($user_name === ''){
        $errors[] = 'ユーザー名を入力してください';
    }
    if(isset($_POST['password'])){
        $password = $_POST['password'];
    }
    if($password === ''){
        $errors[] = 'パスワードを入力してください';
    }
    
    if(count($errors) === 0){
        //ユーザ名の入力を省略のチェックがONの場合、Cookieを利用する。OFFの場合、Cookieを削除する。
        if($cookie_check === 'checked'){
            //cookieへ保存する
            setcookie('cookie_check',$cookie_check,$now + 60 * 60 * 24 * 365);
            setcookie('user_name',$user_name,$now + 60 * 60 * 24 * 365);
        }else{
            //cookieを削除する
            setcookie('cookie_check','',$now - 3600);
            setcookie('user_name','',$now - 3600);
        }
        $success = 'ようこそ';
    }
    
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ログイン後</title>
    </head>
    <body>
        <?php if(count($errors) === 0){ ?>
            <h1><?php print h($success); ?></h1>
        <?php }else{ ?>
            <?php foreach($errors as $reads) {?>
            <p><?php print h($reads); ?></p>
            <?php } ?>
        <?php } ?>
    </body>
</html>
