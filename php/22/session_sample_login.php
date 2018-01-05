<?php
/*
*  ログイン処理
*/
// リクエストメソッド確認
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  // POSTでなければログインページへリダイレクト
  header('Location: session_sample_top.php');
  exit;
}
// セッション開始
session_start();
// POST値取得
$email  = get_post_data('email');  // メールアドレス
$password = get_post_data('passwd'); // パスワード
// var_dump($_POST);
// メールアドレスをCookieへ保存→次回以降自動表示
setcookie('email', $email, time() + 60 * 60 * 24 * 365);

$host = 'localhost';
$username = 'codecamp19367';
$passwd = 'KXLSPRWO';
$dbname = 'codecamp19367';
$charset = 'utf8';

$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

try{//DB接続 不必要な処理はtryの外側で行う推奨
    $dbh = new PDO($dsn,$username,$passwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    $sql = 'SELECT user_id FROM test_user_table
                WHERE e_mail = :e_mail
                AND   password = :password';
    $params = array(':e_mail' => $email,':password' => $password);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $user = $stmt->fetch();
    // var_dump($user);
    // $stmt->debugDumpParams();
    // // var_dump($email);
    // // var_dump($password);
    // // exit;
    
}catch(PDOException $e){
    print $e->getMessage(); 
    exit;
}

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
//POSTデータから任意データの取得
function get_post_data($key) {
  $str = '';
  if (isset($_POST[$key])) {
    $str = $_POST[$key];
  }
  return $str;
}
?>