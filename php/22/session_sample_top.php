<?php
//ログイン済みかどうか確認→してたらホームへしてなかったらログインページへ
//※メアド自動表示処理も一応やっている

/*
*  ログインページ
*/
// セッション開始
session_start();
// セッション変数からログイン済みか確認
if (isset($_SESSION['user_id'])) {
  // ログイン済みの場合、ホームページへリダイレクト
  header('Location: session_sample_home.php');
  exit;
}
// Cookie情報からメールアドレスを取得→次回以降自動で表示されるようにするための処理
if (isset($_COOKIE['email'])) {
  $email = $_COOKIE['email'];
} else {
  $email = '';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <style>
    input {
      display: block;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <form action="./session_sample_login.php" method="post">
    <label for="email">メールアドレス</label>
    <input type="text" id="email" name="email" value="<?php print $email; ?>">
    <label for="passwd">パスワード</label>
    <input type="password" id="passwd" name="passwd" value="">
    <input type="submit" value="ログイン">
  </form>
</body>
</html>