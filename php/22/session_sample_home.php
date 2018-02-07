<?php
// 設定ファイル読み込み
require_once './const.php';
// 関数ファイル読み込み
require_once './function.php';

// ログイン済みユーザのホームページ

$user = array();

// セッション開始
session_start();
// セッション変数からuser_id取得
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $dbh = get_db_connect();
  $user = get_user_data($dbh,$user_id);
} else {
  // 非ログインの場合、ログインページへリダイレクト
  header('Location: session_sample_top.php');
  exit;
}

// ユーザ名を取得できたか確認
if (isset($user['user_name'])) {
  $user_name = $user['user_name'];
} else {
  // ユーザ名が取得できない場合、ログアウト処理へリダイレクト
  header('Location: session_sample_logout.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ホーム</title>
</head>
<body>
  <p>ようこそ<?php print $user_name; ?>さん</p>
  <form action="./session_sample_logout.php" method="post">
    <input type="submit" value="ログアウト">
  </form>
</body>
</html>