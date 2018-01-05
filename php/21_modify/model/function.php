<?php
//フォームからデータを受け取ったかどうかの確認(まだ中身はわからない)
function recieve_post_data($key){
    $str = '';
    if(isset($_POST[$key])){
        $str = $_POST[$key];
    }
    return $str;
}
//入力された値の前後の空白を消す（スペースのみも該当）
function trim_space($str){
    //\Aは^、\zは$とほぼ同じ。\sは空白文字（半角スペース　タブ　改行　改ページ）。uはutf-8(全角文字使用時はuを使う)
    return preg_replace('/\A[　\s]*|[　\s]*\z/u','',$str);
}

//フォームから受け取った画像ファイルの保管及び拡張子の編集
function upload_img_file($key){
    if(is_uploaded_file($_FILES[$key]['tmp_name']) === TRUE){
        $extension = pathinfo($_FILES[$key]['name'],PATHINFO_EXTENSION);
        if(preg_match("/^(jpg|jpeg|png)$/i",$extension) === 1){
            $product_img_name = sha1(uniqid(mt_rand(),true)).'.'.$extension;
            if(is_file(IMG_DIR.$product_img_name) !== TRUE){
                if(move_uploaded_file($_FILES[$key]['tmp_name'],IMG_DIR.$product_img_name) === TRUE){
                    return $product_img_name;
                }else{
                    throw new Exception('ファイルのアップロードに失敗しました。');
                }
            }else{
                throw new Exception('ファイル名が重複しています。もう一度やり直してください。');
            }
        }else{
            throw new Exception('ファイルの拡張子は、jpg,jpeg,pngのみ可能です');
        }
    }else{
        throw new Exception('不正なファイルです');
    }
    return FALSE;
}

//db接続
function db_connect(){
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARACTER_SET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $dbh;
}

//主DBへの登録
function register_master_db($dbh,$product_name,$product_price,$product_img_name,$product_status){
    $sql = 'INSERT INTO 21_drink_master
            (master_drink_name,master_drink_price,master_drink_img,master_drink_status)
            VALUES
            (:master_drink_name,:master_drink_price,:master_drink_img,:master_drink_status)';
    $params = array(
        ':master_drink_name' => $product_name,
        ':master_drink_price' => $product_price,
        ':master_drink_img' => $product_img_name,
        ':master_drink_status' => $product_status
    );
    return sql_execution($dbh,$sql,$params);
}

//在庫DBへの登録
function register_stock_db($dbh,$product_stock){
    $sql = 'INSERT INTO 21_drink_stock
            (stock_drink_stock)
            VALUES
            (:stock_drink_stock)';
    $params = array(
        ':stock_drink_stock' => $product_stock
    );
    return sql_execution($dbh,$sql,$params);
}

//在庫DB更新
function update_stock_db($dbh,$product_id,$product_stock){
    $sql = 'UPDATE 21_drink_stock
            SET
            stock_drink_stock = :stock_drink_stock
            WHERE
            stock_drink_id = :stock_drink_id';
    $params = array(
        'stock_drink_stock' => $product_stock,
        'stock_drink_id' => $product_id
    );
    return sql_execution($dbh,$sql,$params);
}

//ステータス更新
function change_master_db_drink_status($dbh,$product_id,$product_status){
    $sql = 'UPDATE 21_drink_master
            SET
            master_drink_status = :master_drink_status
            WHERE
            master_drink_id = :master_drink_id';
    $params = array(
        'master_drink_status' => $product_status,
        'master_drink_id' => $product_id
    );
    return sql_execution($dbh,$sql,$params);
}

//DBへの登録sql実行
function sql_execution($dbh,$sql,$params){
    $stmt = $dbh->prepare($sql);
    return $stmt->execute($params);
}

//DB情報取得
function get_product_list($dbh){
    $sql = 'SELECT
                21_drink_master.master_drink_id,
                21_drink_master.master_drink_img,
                21_drink_master.master_drink_name,
                21_drink_master.master_drink_price,
                21_drink_stock.stock_drink_stock,
                21_drink_master.master_drink_status,
                21_drink_master.master_drink_id
            FROM
                21_drink_master
            INNER JOIN 21_drink_stock
            ON 21_drink_master.master_drink_id = 21_drink_stock.stock_drink_id';
    return sql_select_execution($dbh,$sql,$params = array());
}

//DB情報取得sql実行
function sql_select_execution($dbh,$sql,$params = array()){
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
    return $rows;
}


//htmlエンティティ変換関数
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,HTML_CHARACTER_SET);
}