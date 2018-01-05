<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DB操作</title>
  </head>
  <body>
    <?php
    $host     = 'localhost';    //現在使用しているシステムのこと。今回は自分が使用しているコンピュータ。
    $username = 'codecamp19367';   // MySQLのユーザ名（ユーザ名を入力してください）
    $password = '';       // MySQLのパスワード（空でOKです）
    $dbname   = 'codecamp19367';   // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
    $charset  = 'utf8';   // データベースの文字コード
 
    // MySQL用のDSN文字列(これから接続しようとしているDBの情報を文字列として定義している。ホストは対象のシステムをあらわす)
    //dbname:接続先サーバー名　host:接続先コンピュータ名(DB名)
    $dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 
    try {
      // データベースに接続***************************************************************************************
      //PDOメソッドに、接続先DBの情報、接続しようとしているユーザー情報を渡す。
      $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
      //接続失敗した際のエラー処理
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //プリペアドステートメントのエミュレーションを無効
      //→プリペアドステートメント：SQL実行前に(html側で?)いろいろ準備を行うこと。無効にしておくことで、その準備をMySQL側で行う。セキュリティ上、無効にしておく。
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      echo 'データベースに接続しました';
      
    } 
    
    //接続エラー時の実際の処理。例外メッセージは$e->getMessage()で覚える
    catch (PDOException $e) {
      echo '接続できませんでした。理由：'.$e->getMessage();
    }
 
    ?>
  </body>
</html>