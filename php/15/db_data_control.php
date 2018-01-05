<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DB操作</title>
    </head>
    <body>
        <?php
        $host = 'localhost';
        $username = 'codecamp19367';
        $password = 'KXLSPRWO';
        $dbname = 'codecamp19367';
        $charset = 'utf8';
        
        //MySQL用のDSN文字列
        $dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.'$charset';
        
        try{
            //データベース接続
            $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            //検索条件
            $user_name = '中井';
            $user_comment = 'こんばんは！';
            //SQL分作成
            $sql = 'select * from test_post where user_name = ? AND user_comment = ?';
            //SQL分を実行する準備
            $stmt = $dbh->prepare($sql);
            //SQL文のプレースホルダ(値を入れるところ)に値をバインド(割り当て)
            //28行目のuser_name = ?の？に$user_nameの値を入れる。PDO::PARAM_STRはデータ型の指定。intならPDO::PARAM_NULLを指定(PARAM_INTじゃなくて？)
            $stmt->bindValue(1,$user_name, PDO::PARAM_STR);
            $stmt->bindValue(2,$user_comment, PDO::PARAM_STR);
            //SQLを実行
            $stmt->execute();
            //レコードの取得
            $rows = $stmt->fetchAll();
            var_dump($rows);
        }
        catch(PDOException $e){
            echo '接続できませんでした。理由：'.$e->getMessage();
        }
        ?>
    </body>
</html>