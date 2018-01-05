<?php
$your_name = '';
$your_comment = '';
$errors = array();

$host     = 'localhost';    
$username = 'codecamp19367';
$password = 'KXLSPRWO';
$dbname   = 'codecamp19367';
$charset  = 'utf8';

// MySQL用のDSN文字列
//dbname:接続先サーバー名　host:接続先コンピュータ名(DB名)
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

// フォームからのデータ受け取り判定及び、氏名・コメント・作成日時のDBへの書き込み
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['your_name']) === TRUE) {
        $your_name = $_POST['your_name'];
    }
    if ($your_name === ''){
        $errors[] = '名前を入力してください';
    }
    if(mb_strlen($your_name) > 20){
        $errors[] = '名前は20文字以内で入力してください。'; 
    }
    if (isset($_POST['your_comment']) === TRUE) {
        $your_comment = $_POST['your_comment'];
    }
    if ($your_comment === ''){
        $errors[] = 'コメントを入力してください';
    }
    if(mb_strlen($your_comment) > 100){
        $errors[] = 'コメントは100文字以内で入力してください。'; 
    }
    
    try {
    // データベースに接続***************************************************************************************
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //   echo 'データベースに接続しました';
    if (count($errors) === 0){
    //DBへのデータ書き込み
        $sql_insert = 'INSERT INTO post
            (user_name,user_comment)
            VALUES
            (:user_name, :user_comment)';
        $stmt_insert = $dbh->prepare($sql_insert);
        $stmt_insert->bindValue(':user_name', $your_name,    PDO::PARAM_STR);
        $stmt_insert->bindValue(':user_comment', $your_comment,    PDO::PARAM_STR);
        $stmt_insert->execute();
    }
    
    //DBからデータの取得
    $sql_select = 'SELECT user_name,user_comment,create_datetime
                    FROM post
                    ORDER BY create_datetime DESC';
    $stmt_select = $dbh->prepare($sql_select);
    $stmt_select->execute();
    $rows = $stmt_select->fetchAll();
    
    }catch (PDOException $e) {//接続エラー時の実際の処理。例外メッセージは$e->getMessage()で覚える
        $errors[] = '接続できませんでした。理由：'.$e->getMessage();
    }
}

try {
    // データベースに接続***************************************************************************************
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //   echo 'データベースに接続しました';
    
    //DBからデータの取得
    $sql_select = 'SELECT user_name,user_comment,create_datetime
                    FROM post
                    ORDER BY create_datetime DESC';
    $stmt_select = $dbh->prepare($sql_select);
    $stmt_select->execute();
    $rows = $stmt_select->fetchAll();
    
    }catch (PDOException $e) {//接続エラー時の実際の処理。例外メッセージは$e->getMessage()で覚える
        $errors[] = '接続できませんでした。理由：'.$e->getMessage();
    }
    
function h($str){//h()はよく使用されるのでおススメ
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');//return ~で、～の値を返すという意味
    }
?>

<!--表示処理-------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>DB操作</title>
</head>
<body>
　<h1>一言掲示板(DB使用)</h1>
  <form method="post">
    <p>名前：<input type="text" name="your_name">ひとこと：<input type="text" name="your_comment"> <input type="submit" name="submit" value="送信"></p>
  </form>
  
    <!--エラー表示処理-->
    <?php foreach ($errors as $value) { ?>
        <p><?php print h($value) ?></p>
    <?php } ?>
    
    <!--結果表示処理-->
    <?php foreach ($rows as $read) { ?>
      <p><?php print h($read['user_name'])?>
      ：<?php print h($read['user_comment']) ?>
      ：<?php print h($read['create_datetime'])?></p>
    <?php } ?>
</body>
</html>