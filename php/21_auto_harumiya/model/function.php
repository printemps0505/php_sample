<?php
function is_post(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

//各フォームからデータ（中身の確認はまだ。とりあえず箱があるかどうか）を受け取っているかどうか判定
function get_post_data($key) {
    $str = '';
    if (isset($_POST[$key]) === TRUE) {
        $str = $_POST[$key];
    }
    return $str;
}

/**
* 前後の空白を削除
* @param str $str 文字列
* @return str 前後の空白を削除した文字列
*/
function trim_space($str) {
  return preg_replace('/\A[　\s]*|[　\s]*\z/u', '', $str);
}

function upload_img($key){
//中身があるかどうか・フォームから送られてきたかどうかの判定（&&(短絡評価)を使用する際は順番が大切）
// var_dump($_FILES);
    if(isset($_FILES[$key]) === TRUE && is_uploaded_file($_FILES[$key]['tmp_name']) === TRUE){
        //拡張子抽出
        $extension = pathinfo($_FILES[$key]['name'],PATHINFO_EXTENSION);
        //画像の名前生成及び拡張子との結合
        if (preg_match("/^(jpg|jpeg|png|JPG|JPEG|PNG)$/",$extension) === 1){//"/^(jpg|jpeg|png)$/i"も同じ。※どれかが大路でもどれかが大路でも含まれてしまうがおけ（iはignore caseの略）
            $product_img_filename = sha1(uniqid(mt_rand(),true)). '.'.$extension;
            //名前が重複していなければ
            if (is_file(IMG_DIR . $product_img_filename) !== TRUE){
                //画像格納用ディレクトリへの画像の保存が成功すれば
                if(move_uploaded_file($_FILES[$key]['tmp_name'],IMG_DIR . $product_img_filename) === TRUE){
                    return $product_img_filename;
                }else{
                    throw new Exception('ファイルのアップロードに失敗しました。');
                    // $errors[] = 'ファイルのアップロードに失敗しました。';
                }
            }else{
                throw new Exception('ファイルが存在しません。');
                // $errors[] =  'ファイルが存在しません';
            }
        }else{
            throw new Exception('ファイル形式が異なります。画像ファイルはJPEGとJPGとPNGのみ利用可能です。。');
            // $errors[] = 'ファイル形式が異なります。画像ファイルはJPEGとJPGとPNGのみ利用可能です。';
        }
    }else{
        throw new Exception('ファイルが選択されていません。');
        // $errors[] = 'ファイルが選択されていません。';
    }
    return FALSE;
}

//データベース接続関数
function get_db_connect(){
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARACTER_SET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $dbh;
}

//主DB登録
function insert_main_db($dbh,$product_name,$product_price,$product_img_filename,$product_status){
    $sql = 'INSERT INTO test_drink_master
        (drink_name,price,img,status)
        VALUES
        (:drink_name,:price,:img,:status)';
    $params = array(
        ':drink_name' => $product_name,
        ':price' => $product_price,
        ':img' => $product_img_filename,
        ':status' => $product_status
    );
   sql_execution($dbh,$sql,$params);
}

//在庫DB登録
function insert_stock_db($dbh,$drink_id,$product_stock){
    $sql = 'INSERT INTO test_drink_stock
            (stock,drink_id)
            VALUES
            (:stock,:drink_id)';
    $params = array(
        ':stock' => $product_stock,
        ':drink_id' => $drink_id
    );
    sql_execution($dbh,$sql,$params);
}

//在庫DB更新
function update_stock_db($dbh,$product_stock,$drink_id){
    $sql = 'UPDATE test_drink_stock
            SET
            stock = :stock
            WHERE
            drink_id = :drink_id;
            ';
    $params = array(
    ':stock' => $product_stock,
    ':drink_id' => $drink_id
    );
    sql_execution($dbh,$sql,$params);
}

//在庫数更新
function update_stock($dbh,$drink_id,$update_stock){
    $sql = 'UPDATE test_drink_stock
            SET
            stock = :stock
            WHERE
            drink_id = :drink_id;
            ';
    $params = array(
        ':stock' => $update_stock,
        ':drink_id' => $drink_id
        );
    sql_execution($dbh,$sql,$params);
}

//ステータス更新
function update_drink_master_status($dbh,$drink_id, $product_status){
    $sql = 'UPDATE test_drink_master
            SET
            status = :status
            WHERE
            drink_id = :drink_id;
            ';
    $params = array(
        ':status' => $product_status,
        ':drink_id' => $drink_id
    );
    sql_execution($dbh,$sql,$params);
}


//DB更新関数
function sql_execution($dbh,$sql,$params){
    $stmt = $dbh->prepare($sql);
    return $stmt->execute($params);
}

//DB情報取得
function get_drink_list($dbh){
    $sql = 'SELECT
                test_drink_master.drink_id,
                test_drink_master.drink_name,
                test_drink_master.price,
                test_drink_master.img,
                test_drink_master.status,
                test_drink_stock.stock
            FROM
                test_drink_master
            INNER JOIN test_drink_stock
            ON test_drink_master.drink_id = test_drink_stock.drink_id';
    return sql_select_execution($dbh,$sql);
}

function get_drink_by_id($dbh,$drink_id){
    //statusも取得しておかないと、買おうとしたときに売り切れている際の判定ができなくなる。
    //ex.ユーザーがindex画面を見ている最中に、管理者が管理画面がから在庫を０にする。しかし、ユーザーは在庫がある際のページを開いたままなので
    //このままだと買うことができてしまう。それを防ぐために、ステータスも同時に取得することによって、後でエラー判定をして、在庫切れと処理することができる
    $sql ='SELECT
                test_drink_master.drink_id,
                test_drink_master.drink_name,
                test_drink_master.price,
                test_drink_master.img,
                test_drink_master.status,
                test_drink_stock.stock
            FROM
                test_drink_master
            INNER JOIN test_drink_stock
            ON test_drink_master.drink_id = test_drink_stock.drink_id
            WHERE
                test_drink_master.drink_id = :drink_id
            ';
            $params = array(':drink_id' => $drink_id);
            return sql_select_execution_one($dbh,$sql,$params);
}


//DB情報取得
function get_drink_list_new($dbh){
    $sql = 'SELECT
                test_drink_master.drink_id,
                test_drink_master.drink_name,
                test_drink_master.price,
                test_drink_master.img,
                test_drink_stock.stock
            FROM
                test_drink_master
            INNER JOIN test_drink_stock
            ON test_drink_master.drink_id = test_drink_stock.drink_id
            WHERE test_drink_master.status = 1';
    return sql_select_execution($dbh,$sql);
}

//DB情報取得関数
function sql_select_execution($dbh,$sql,$params = array()){
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
    return $rows;
}

function sql_select_execution_one($dbh,$sql,$params = array()){
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row;
}

//htmlエンティティ変換関数
function h($str){
    return htmlspecialchars($str,ENT_QUOTES,HTML_CHARACTER_SET);
}

function check_number($str){
    // if(preg_match('/^[1-9][0-9]*$/',$str) === 1){
    //     return TRUE;
    // }
    // return FALSE;
    return preg_match('/^[1-9][0-9]*$/',$str) === 1;
}