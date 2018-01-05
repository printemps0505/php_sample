<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DB操作</title>
  </head>
  <body>
    <?php
    $host     = 'localhost';
    $username = 'codecamp19367';   // MySQLのユーザ名
    $password = 'KXLSPRWO';       // MySQLのパスワード
    $dbname   = 'codecamp19367';   // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
    $charset  = 'utf8';   // データベースの文字コード
 
    // MySQL用のDSN文字列
    $dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 
    try {
      // データベースに接続
      $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 
    //SQL文作成から実行までの一連の流れ***************************************
      // SQL文を作成 test_postが参照するテーブル名
      $sql = 'select * from test_post';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
      // SQLを実行
      $stmt->execute();
      // レコードの取得(一行だけ取得の場合はfetch()メソッドで実行)
      $rows = $stmt->fetchAll();
 
      var_dump($rows);
      //***********************************************************************
 
    } catch (PDOException $e) {
      echo '接続できませんでした。理由：'.$e->getMessage();
    }
    ?>
  </body>
</html>