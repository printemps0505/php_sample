<?php
$host = 'localhost';
$username = 'codecamp19367';
$password = 'KXLSPRWO';
$dbname = 'codecamp19367';
$charset = 'utf8';

$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

$process_kind = '';
$product_name = '';
$product_price = '';
$product_stock = '';
$product_img_filename = '';
$img_dir = './img/';
$errors = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if ( isset($_POST['process_kind']) === TRUE) {
        $process_kind = $_POST['process_kind'];
    }
    
    if ($process_kind === 'insert_item') {//新規商品追加判定
        if (isset($_POST['product_name']) === TRUE) {
            $product_name = $_POST['product_name'];
        }
        if ($product_name === ''){
            $errors[] = '商品名を入力してください';
        }
        if (isset($_POST['product_price']) === TRUE) {
            $product_price = $_POST['product_price'];
        }
        if ($product_price === ''){
            $errors[] = '値段を入力してください';
        }else if (preg_match("/^[0-9]+$/",$product_price) !== 1){
            $errors[] = '値段は半角数字を入れてください';
        }
        if (isset($_POST['product_stock']) === TRUE) {
            $product_stock = $_POST['product_stock'];
        }
        if ($product_stock === ''){
            $errors[] = '在庫数を入力してください';
        }else if (preg_match("/^[0-9]+$/",$product_stock) !== 1){
            $errors[] = '在庫数は半角数字を入れてください';
        }
        
        if(is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE){//画像の判定及びディレクトリへの新しい名前で保存
            $extension = pathinfo($_FILES['new_img']['name'],PATHINFO_EXTENSION);
            if ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'png'){
                $product_img_filename = sha1(uniqid(mt_rand(),true)). '.'.$extension;
                if (is_file($img_dir . $product_img_filename) !== TRUE){
                    if(move_uploaded_file($_FILES['new_img']['tmp_name'],$img_dir . $product_img_filename) !== TRUE){
                        $errors[] = 'ファイルのアップロードの失敗しました。';
                    }
                }else{
                    $errors[] =  'ファイルのアップロードに失敗しました。再度お試しください。';
                }
            }else{
                $errors[] = 'ファイル形式が異なります。画像ファイルはJPEGとJPGとPNGのみ利用可能です。';
            }
        }else{
            $errors[] = 'ファイルを選択してください。';
        }
    }
    
    if ($process_kind === 'update_stock') {//在庫数変更判定
        if (isset($_POST['update_stock']) === TRUE) {
            $product_stock = $_POST['update_stock'];
        }
        if (isset($_POST['drink_id']) === TRUE) {
            $drink_id = $_POST['drink_id'];
        }
        if ($drink_id === ''){
            $errors[] = 'ドリンクを選択してください';
        }
        if ($product_stock === ''){
            $errors[] = '新しい在庫数を入力してください';
        }else if (preg_match("/^[0-9]+$/",$product_stock) !== 1){
            $errors[] = '在庫数は半角数字を入れてください';
        }
    }
}

//DBへの登録及び一覧表示設定*******************************************************************
try{//DB接続 不必要な処理はtryの外側で行う推奨
    $dbh = new PDO($dsn,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    //DBへの書き込み
    try{
        if (count($errors) === 0){
            if ($process_kind === 'insert_item') {
                $dbh->beginTransaction();
                try{
                    $sql_insert = 'INSERT INTO test_drink_master
                                    (drink_name,price,img)
                                    VALUES
                                    (:drink_name,:price,:img)';
                    $stmt_insert = $dbh->prepare($sql_insert);
                    $stmt_insert->bindValue(':drink_name',$product_name,     PDO::PARAM_STR);
                    $stmt_insert->bindValue(':price',$product_price,    PDO::PARAM_INT);
                    $stmt_insert->bindValue(':img',$product_img_filename,      PDO::PARAM_STR);
                    $stmt_insert->execute();
                    
                    $sql_insert = 'INSERT INTO test_drink_stock
                                    (stock)
                                    VALUES
                                    (:stock)';
                    $stmt_insert = $dbh->prepare($sql_insert);
                    $stmt_insert->bindValue(':stock',$product_stock,     PDO::PARAM_INT);
                    $stmt_insert->execute();
                    
                    $dbh->commit();
                    $success[] = 'データが登録できました';
                    
                }catch(PDOException $e){
                    //ロールバック処理
                    $dbh->rollback();
                    //例外をスロー
                    throw $e;
                }
            }else if($process_kind === 'update_stock'){
                try{
                    $sql_update = 'UPDATE test_drink_stock
                                    SET
                                    stock = :stock
                                    WHERE
                                    drink_id = :drink_id;
                                    ';
                    $stmt_update = $dbh->prepare($sql_update);
                    $stmt_update->bindValue(':drink_id',$drink_id,     PDO::PARAM_INT);
                    $stmt_update->bindValue(':stock',$product_stock,     PDO::PARAM_INT);
                    $stmt_update->execute();
                    $success[] = 'データが更新されました';
                    
                }catch(PDOException $e){
                    //例外をスロー
                    throw $e;
                }
            }
        }
    }catch(PDOException $e){
        $errors[] = 'データが登録できませんでした。理由：'.$e->getMessage();
    }
    
    //DBからのデータ取得
    $sql_select = 'SELECT
                    test_drink_master.drink_id,test_drink_master.drink_name,test_drink_master.price,test_drink_master.img,test_drink_stock.stock
                    FROM
                    test_drink_master
                    INNER JOIN test_drink_stock
                    ON test_drink_master.drink_id = test_drink_stock.drink_id';
    $stmt_select = $dbh->prepare($sql_select);
    $stmt_select->execute();
    $rows = $stmt_select->fetchAll();
}catch(PDOException $e){
    $errors[] = '接続できませんでした。理由：'.$e->getMessage();
}
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
var_dump($errors);
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
                <p>名前：<input type="text" name="product_name" value=""></p>
                <p>値段：<input type="text" name="product_price" value=""></p>
                <p>個数：<input type="text" name="product_stock" value=""></p>
                <p><input type="file" name="new_img"></p>
                <input type="hidden" name="process_kind" value="insert_item">
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
                    <th>在庫数</th>
                </tr>
                <?php foreach ($rows as $read)  { ?>
                    <tr>
                    <form method="post">
                        <td><img src="<?php print h($img_dir . $read['img']); ?>" class="img_size"></td>
                        <td><?php print h($read['drink_name']); ?></td>
                        <td><?php print h($read['price']); ?>円</td>
                        <td><input type="text" class="form_size" name="update_stock" value=<?php print h($read['stock']); ?>>個&nbsp;&nbsp;<input type="submit" value="変更"></td>
                        <input type="hidden" name="process_kind" value="update_stock">
                        <input type="hidden" name="drink_id" value="<?php print h($read['drink_id']); ?>">
                    </form>
                    </tr>
                <?php } ?>
            </table>
        </section>
    </body>
</html>