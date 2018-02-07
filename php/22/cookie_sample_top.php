<?php
// $user_name ='';
// $cookie_check = '';

//クッキーのデータとして扱う前処理
$user_name = get_cookie_data('user_name');
$cookie_check = get_cookie_data('cookie_check');

function get_cookie_data($str){
    if(isset($_COOKIE[$str]) === TRUE){
        return $_COOKIE[$str];
    }
    return '';
}

function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ユーザー名自動入力</title>
    </head>
    <body>
        <form action="./cookie_sample_login.php" method="post">
            <label for="user_name">ユーザー名</label>
            <div><input type="text" id="user_name" name="user_name" value="<?php print h($user_name); ?>"></div>
            
            <label for="password">パスワード</label>
            <div><input type="text" id="password" name="password" value=""></div>
            
            <div>
            <input type="checkbox" name="cookie_check" value="checked" <?php print h($cookie_check); ?>>次回からユーザ名の入力を省略
            </div>
            <input type="submit" value="ログイン">
        </form>
    </body>
</html>