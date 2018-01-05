<?php
$host = 'localhost';
$username = 'codecamp19367';
$password = 'KXLSPRWO';
$dbname = 'codecamp19367';
$charset = 'utf8';

$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

$product_name = '';
$product_price = '';
$product_img_filename = '';
$img_dir = './img/';
$errors = array();
$data = array();

//DBへの登録及び一覧表示設定*******************************************************************
try{//DB接続
    $dbh = new PDO($dsn,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset($_POST['product_name']) === TRUE) {//商品名、価格の判定
            $product_name = $_POST['product_name'];
        }
        if ($product_name === ''){
            $errors[] = '商品名を入力してください';
        }
        if (isset($_POST['product_price']) === TRUE) {
            $product_price = $_POST['product_price'];
        }
        if ($product_price === ''){
            $errors[] = '価格を入力してください';
        }
        
        if(is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE){//画像の判定及びディレクトリへの新しい名前で保存
            $extension = pathinfo($_FILES['new_img']['name'],PATHINFO_EXTENSION);
            if ($extension === 'jpg' || $extension === 'jpeg'){
                $product_img_filename = sha1(uniqid(mt_rand(),true)). '.'.$extension;
                if (is_file($img_dir . $product_img_filename) !== TRUE){
                    if(move_uploaded_file($_FILES['new_img']['tmp_name'],$img_dir . $product_img_filename) !== TRUE){
                        $errors[] = 'ファイルのアップロードの失敗しました。';
                    }
                }else{
                    $errors[] =  'ファイルのアップロードに失敗しました。再度お試しください。';
                }
            }else{
                $errors[] = 'ファイル形式が異なります。画像ファイルはJPEGのみ利用可能です。';
            }
        }else{
            $errors[] = 'ファイルを選択してください。';
        }
        //DBへの書き込み
        if (count($errors) === 0){
                $sql_insert = 'INSERT INTO test_drink_master
                (drink_name,price,img)
                VALUES
                (:drink_name,:price,:img)';
                $stmt_insert = $dbh->prepare($sql_insert);
                $stmt_insert->bindValue(1,$product_name,     PDO::PARAM_STR);
                $stmt_insert->bindValue(2,$product_price,    PDO::PARAM_INT);
                $stmt_insert->bindValue(3,$product_img_filename,      PDO::PARAM_STR);
                $stmt_insert->execute();
        }
    }
    //DBからのデータ取得
    $sql_select = 'SELECT drink_name,price,img
                    FROM test_drink_master';
    $stmt_select = $dbh->prepare($sql_select);
    $stmt_select->execute();
    $rows = $stmt_select->fetchAll();
}catch(PDOException $e){
    $errors[] = '接続できませんでした。理由：'.$e->getMessage();
}
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
?>
<!--表示処理--------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta varchar="utf-8">
        <title>自動販売機</title>
        <link rel="stylesheet" href="manage.css">
        <link rel="stylesheet" href="reset.css">
        <style>
            table {
              /*width: 900px;*/
              border-collapse: collapse;
            }
            table, tr, th, td {
              border: solid 1px;
              padding: 10px;
              text-align: center;
            }
        </style>
    </head>
    <body>
        <section class="black_under_line">
            <h1>自動販売機管理ツール</h1>
             <!--エラー表示処理-->
            <?php foreach ($errors as $value) { ?>
                <p><?php print h($value) ?></p>
            <?php } ?>
        </section>
        <section class="black_under_line">
            <h3>新規商品追加</h3>
            <form method="post" enctype="multipart/form-data">
                <p>名前：<input type="text" name="product_name"></p>
                <p>値段：<input type="text" name="product_price"></p>
                <p><input type="file" name="new_img"></p>
                <p><input type="submit" name="submit" value="商品を追加" class="style"></p>
            </form>
        </section>
        <section>
            <h3>商品情報変更</h3>
            <p>商品一覧</p>
            <table>
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                </tr>
                <?php foreach ($rows as $read)  { ?>
                    <tr>
                        <td><img src="<?php print $img_dir . $read['img']; ?>" class = img_size></td>
                        <td><?php print h($read['drink_name']); ?></td>
                        <td><?php print h($read['price']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </section>
    </body>
</html>