<?php
/*
*  ログイン処理
*/
// 設定ファイル読み込み
require_once './const.php';
// 関数ファイル読み込み
require_once './function.php';

// リクエストメソッド確認
if (is_post() === FALSE) {
  // POSTでなければログインページへリダイレクト
  header('Location: session_sample_top.php');
  exit;
}
$user = array();

// セッション開始
session_start();
// POST値取得
$email  = get_post('email');  // メールアドレス
$password = get_post('passwd'); // パスワード

setcookie('email', $email, time() + 60 * 60 * 24 * 365);

$dbh = get_db_connect();
$user = get_user_data_by_email_password($dbh,$email,$password);

// 登録データを取得できたか確認
if (isset($user['user_id'])) {
  // セッション変数にuser_idを保存
  $_SESSION['user_id'] = $user['user_id'];
  // ログイン済みユーザのホームページへリダイレクト
  header('Location: session_sample_home.php');
  exit;
} else {
  // ログインページへリダイレクト
  header('Location: session_sample_top.php');
  exit;
}