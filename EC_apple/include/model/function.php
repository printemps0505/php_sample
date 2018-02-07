<?php
function is_post(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function get_post($key){
    if(isset($_POST[$key]) === TRUE){
        return $_POST[$key];
    }
    return '';
}
function get_get($key){
    if(isset($_GET[$key]) === TRUE){
        return $_GET[$key];
    }
    return '';
}

function get_db_connect(){
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARACTER_SET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $dbh;
}
function insert_user_data($dbh,$name,$password,$email_address,$name_kana,$telephone,$address,$address_detail,$zip_code){
    $sql = 'INSERT INTO `users`
                (`name`, 
                `password`, 
                `email_address`, 
                `name_kana`, 
                `telephone`,
                `address`,
                `address_detail`,
                `zip_code`) 
            VALUES 
                (:name, 
                :password, 
                :email_address, 
                :name_kana, 
                :telephone,
                :address,
                :address_detail,
                :zip_code
            )';
    $params = array(
        ':name' => $name, 
        ':password' => $password, 
        ':email_address' => $email_address, 
        ':name_kana' => $name_kana, 
        ':telephone' => $telephone,
        ':address' => $address,
        ':address_detail' => $address_detail,
        ':zip_code' => $zip_code);
    return sql_execution($dbh,$sql,$params);
}

function update_stock($dbh,$item_stock,$item_id){
    $sql = 'UPDATE items
            SET
            item_stock = :item_stock
            WHERE
            item_id = :item_id;
            ';
    $params = array(
    ':item_stock' => $item_stock,
    ':item_id' => $item_id
    );
    sql_execution($dbh,$sql,$params);
}

function update_comment($dbh,$item_comment,$item_id){
    $sql = 'UPDATE items
            SET
            item_comment = :item_comment
            WHERE
            item_id = :item_id;
            ';
    $params = array(
    ':item_comment' => $item_comment,
    ':item_id' => $item_id
    );
    sql_execution($dbh,$sql,$params);
}

function update_status($dbh,$item_id, $item_status){
    $sql = 'UPDATE items
            SET
            item_status = :item_status
            WHERE
            item_id = :item_id;
            ';
    $params = array(
        ':item_status' => $item_status,
        ':item_id' => $item_id
    );
    sql_execution($dbh,$sql,$params);
}

function update_type($dbh,$item_id, $item_type){
    $sql = 'UPDATE items
            SET
            item_type = :item_type
            WHERE
            item_id = :item_id;
            ';
    $params = array(
        ':item_type' => $item_type,
        ':item_id' => $item_id
    );
    sql_execution($dbh,$sql,$params);
}


function get_login_user_data($dbh,$email_address,$password){
    $sql = 'SELECT user_id FROM users
            WHERE
               email_address = :email_address
            AND
               password = :password';
    $params = array(
                ':email_address' => $email_address,
                ':password' => $password);
    return sql_select_execution_one($dbh,$sql,$params);
}
function get_login_user_id(){
    // セッション変数からuser_id取得
    if (isset($_SESSION['user_id'])) {
      return $_SESSION['user_id'];
    } else {
      return FALSE;
    }
}

//主DB登録
function insert_items($dbh,$item_type,$item_name,$item_price,$item_stock,$item_img_filename,$item_comment,$item_status){
    $sql = 'INSERT INTO items
            ( 
            `item_type`, 
            `item_img`, 
            `item_name`, 
            `item_price`, 
            `item_stock`, 
            `item_comment`, 
            `item_status`
            )
            VALUES
        (:item_type,:item_img,:item_name,:item_price,:item_stock,:item_comment,:item_status)';
    $params = array(
        ':item_type' => $item_type,
        ':item_img' => $item_img_filename,
        ':item_name' => $item_name,
        ':item_price' => $item_price,
        ':item_stock' => $item_stock,
        ':item_comment' => $item_comment,
        ':item_status' => $item_status
    );
   sql_execution($dbh,$sql,$params);
}

function insert_purchase_history($dbh,$user_id,$item_id,$purchase_amount){
    $sql = 'INSERT INTO purchase_history
            ( 
            `item_id`,
            `user_id`,
            `purchase_amount`
            )
            VALUES
            (:item_id,:user_id,:purchase_amount)';
    $params = array(
        ':item_id' => $item_id,
        ':user_id' => $user_id,
        ':purchase_amount' => $purchase_amount
    );
   sql_execution($dbh,$sql,$params);
}

function upload_img($key){
//物があるかどうか・フォームから送られてきたかどうかの判定（&&(短絡評価)を使用する際は順番が大切）
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
//カートへの追加
function add_carts($dbh,$item_id,$user_id,$carts_amount){
    $sql = 'INSERT INTO carts
            (item_id,user_id,carts_amount)
            VALUES
            (:item_id,:user_id,:carts_amount)';
    $params = array(
        ':item_id' => $item_id,
        ':user_id' => $user_id,
        ':carts_amount' => $carts_amount
    );
    sql_execution($dbh,$sql,$params);
}

function update_carts($dbh,$item_id,$user_id,$carts_amount){
    $sql = 'UPDATE `carts` 
            SET `carts_amount`= :carts_amount
            WHERE 
                item_id = :item_id
            AND
                user_id = :user_id
            ';
    $params = array(
        ':carts_amount' => $carts_amount,
        ':item_id' => $item_id,
        ':user_id' => $user_id
    );
    sql_execution($dbh,$sql,$params);
}

function get_item_list($dbh){
    $sql = 'SELECT
                `item_id`, 
                `item_type`, 
                `item_img`,
                `item_name`, 
                `item_price`, 
                `item_stock`, 
                `item_comment`, 
                `item_status`
            FROM 
                items';
    return sql_select_execution($dbh,$sql);
}

function get_item_list_by_category($dbh,$item_type){
    $sql = 'SELECT items.item_id, items.item_img, items.item_name, items.item_price, items.item_stock,SUM(purchase_history.purchase_amount)
            FROM `items`
            JOIN `purchase_history`
            ON items.item_id = purchase_history.item_id
            WHERE 
            item_type = :item_type
            GROUP BY
            items.item_id
            ORDER BY
            SUM(purchase_history.purchase_amount) DESC';
    $params = array(':item_type' => $item_type);
    return sql_select_execution($dbh,$sql,$params);
}


function get_item_type($dbh){
    $sql = 'SELECT DISTINCT
                `item_type`
            FROM
                `items` 
            WHERE 1';
    return sql_select_execution($dbh,$sql);
}

function get_item_by_item_id($dbh,$item_id){
    $sql = 'SELECT
                `item_id`, 
                `item_type`, 
                `item_img`,
                `item_name`, 
                `item_price`, 
                `item_stock`, 
                `item_comment`, 
                `item_status`
            FROM 
                items
            WHERE
                item_id = :item_id';
    $params = array(
        ':item_id' => $item_id
    );
    return sql_select_execution_one($dbh,$sql,$params);
}
function get_cart_list($dbh){
    $sql = 'SELECT
                `carts_id`,
                `user_id`, 
                `item_id`, 
                `carts_amount` 
            FROM
                carts';
    return sql_select_execution($dbh,$sql);
}
function get_cart_by_user_and_item_id($dbh,$user_id,$item_id){
    $sql = 'SELECT
                `carts_id`,
                `user_id`, 
                `item_id`, 
                `carts_amount` 
            FROM
                carts
            WHERE
                item_id = :item_id
            AND
                user_id = :user_id
            ';
    $params = array(
        ':item_id' => $item_id,
        ':user_id' => $user_id
    );
    return sql_select_execution_one($dbh,$sql,$params);
}

//公開ステータスの商品のみ抽出
function get_item_list_status_one($dbh){
    $sql = 'SELECT
                item_id,
                item_name,
                item_price,
                item_img,
                item_stock
            FROM
                items
            WHERE
                item_status = 1';
    return sql_select_execution($dbh,$sql);
}

function get_item_by_id($dbh,$item_id){
    //statusも取得しておかないと、買おうとしたときに売り切れている際の判定ができなくなる。
    //ex.ユーザーがindex画面を見ている最中に、管理者が管理画面がから在庫を０にする。しかし、ユーザーは在庫がある際のページを開いたままなので
    //このままだと買うことができてしまう。それを防ぐために、ステータスも同時に取得することによって、後でエラー判定をして、在庫切れと処理することができる
    $sql ='SELECT
                item_id,
                item_name,
                item_price,
                item_img,
                item_status,
                item_comment,
                items.item_stock
            FROM
                items
            WHERE
                item_id = :item_id
            ';
            $params = array(':item_id' => $item_id);
            return sql_select_execution_one($dbh,$sql,$params);
}


//今カートに入っている商品の抽出
function get_carts_list_by_user_id($dbh,$user_id){
    $sql = 'SELECT
                items.item_id,
                items.item_name,
                items.item_price,
                items.item_img,
                items.item_status,
                items.item_stock,
                carts.carts_amount
            FROM
                items
            INNER JOIN carts
            ON items.item_id = carts.item_id
            WHERE
                carts.user_id = :user_id';
    $params = array(
        ':user_id' => $user_id
    );
    return sql_select_execution($dbh,$sql,$params);
}

function delete_carts_by_item_user_id($dbh,$item_id,$user_id){
    $sql = 'DELETE
            FROM 
                `carts` 
            WHERE
                item_id = :item_id
            AND
                user_id = :user_id';
    $params = array(
        ':item_id' => $item_id,
        ':user_id' => $user_id
    );
    return sql_execution($dbh,$sql,$params);
}
function delete_carts_by_user_id($dbh,$user_id){
    $sql = 'DELETE
            FROM 
                `carts` 
            WHERE
                user_id = :user_id';
    $params = array(
        ':user_id' => $user_id
    );
    return sql_execution($dbh,$sql,$params);
}

function delete_item_by_item_id($dbh,$item_id){
    $sql = 'DELETE
            FROM 
                `items` 
            WHERE
                item_id = :item_id';
    $params = array(
        ':item_id' => $item_id
    );
    return sql_execution($dbh,$sql,$params);
}

function sql_execution($dbh,$sql,$params){
    $stmt = $dbh->prepare($sql);
    return $stmt->execute($params);
}

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

function check_number($str){
    return preg_match('/^[1-9][0-9]*$/',$str) === 1;
}

function h($str){
    return htmlspecialchars($str,ENT_QUOTES,HTML_CHARACTER_SET);
}
