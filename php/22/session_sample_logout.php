<?php
/*
*  ログアウト処理
*
*  セッションの仕組み理解を優先しているため、本来必要な処理も省略しています
*/
// セッション開始
session_start();
// セッション名取得 ※デフォルトはPHPSESSID
$session_name = session_name();
// セッション変数を全て削除(カルテの中身を削除する：シュレッダー)
$_SESSION = array();
 
// ユーザのCookieに保存されているセッションIDを削除
if (isset($_COOKIE[$session_name])) {
  // sessionに関連する設定を取得
  $params = session_get_cookie_params();
 
  // sessionに利用しているクッキーの有効期限を過去に設定することで無効化
  setcookie($session_name, '', time() - 42000,
    $params['path'], $params['domain'],
    $params['secure'], $params['httponly']
  );
}
// セッションIDを無効化（カルテのそのものの廃棄：ゴミ箱へ）
session_destroy();
// ログアウトの処理が完了したらログインページへリダイレクト
header('Location: session_sample_top.php');
exit;
?>