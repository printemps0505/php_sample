<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>トランザクション</title>
    </head>
    <body>
        <?php
        $host = 'localhost';
        $username = 'codecamp19367';
        $password = 'KXLSPRWO';
        $dbname = 'codecamp19367';
        $charset = 'utf8';
        
        //mySQL用の文字列
        $dsn ='mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
        try{
            $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            //トランザクション処理
            $dbh->beginTransaction();
            try{
                $now_date = date('Y-m-d H:i:s');
                
                //商品情報テーブルにデータ作成
                $sql = 'INSERT INTO test_item_master
                        (id,item_name,price,create_datetime)
                        VALUES
                        (1,"php入門",2000,"' . $now_date . '")';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                
                // 在庫情報テーブルにデータ作成
                $sql = 'INSERT INTO test_item_stock
                        (item_id, stock, create_datetime)
                        VALUES
                        (1, 100, "' . $now_date . '" );';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                
                //コミット処理
                $dbh->commit();
                echo 'データが登録できました';
            }catch(PDOException $e){
                //ロールバック処理
                $dbh->rollback();
                //例外をスロー
                throw $e;
            }
        }catch(PDOException $e){
            echo 'データベース処理でエラーが発生しました。理由；'.$e->getMessage();
        }
        ?>
    </body>
</html>