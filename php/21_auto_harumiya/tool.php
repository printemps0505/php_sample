<?php
// 設定ファイル読み込み
require_once './conf/const.php';
// 関数ファイル読み込み
require_once './model/function.php';

$process_kind = '';
$drink_id = '';
$product_name = '';
$product_price = '';
$product_stock = '';
$product_status = '';
$product_img_filename = '';
$errors = array();
$success =array();
$data = array();
$rows = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    //新商品追加・在庫数変更・公開非公開切り替え用識別子作成
    $process_kind = get_post_data('process_kind');
    
    //新商品追加判定
    if ($process_kind === 'insert_item') {
        //各フォームからデータを受け取っているかどうか判定
        $product_name = get_post_data('product_name');
        // $product_name = trim_space($product_name);
        //or trim_space(get_post_data('product_name'))でもいい
        
        $product_price = get_post_data('product_price');
        $product_stock = get_post_data('product_stock');
        $product_status = get_post_data('new_status');
        
        //フォームからのデータが空白でないかどうかの判定(数値に関しての書式判定)
        if ($product_name === ''){
            $errors[] = '商品名を入力してください';
        }
        if ($product_price === ''){
            $errors[] = '値段を入力してください';
        }else if (preg_match("/^[1-9][0-9]*$|^0$/",$product_price) !== 1){//"/^([1-9][0-9]*|0)$/"もおけ
            $errors[] = '値段は0以上の整数を入れてください';
        }
        
        if ($product_stock === ''){
            $errors[] = '在庫数を入力してください';
        }else if (preg_match("/^[1-9][0-9]*$|^0$/",$product_stock) !== 1){
            $errors[] = '在庫数は0以上の整数を入れてください';
        }
        //セレクトボックス・ラジオボックス等も必ずチェックする
        if ($product_status === ''){
            $errors[] = '公開ステータスを入力してください。';
        }else if($product_status !== '0' && $product_status !== '1'){
            $errors[] = '不正なステータスです。';
        }
        
        //フォームから送られてきた画像の判定及びディレクトリへの新しい名前で保存
        try{
            $product_img_filename = upload_img('new_img');
        }catch(Exception $e){
            $errors[] = $e->getMessage();
        }
    }
    //在庫数変更判定
    
    if ($process_kind === 'update_stock') {
        //各フォームからデータを受け取っているかどうか判定
        $product_stock = get_post_data('update_stock');
        $drink_id = get_post_data('drink_id');
        
        //フォームからのデータが空白でないかどうかの判定(数値に関しての書式判定)
        if ($product_stock === ''){
            $errors[] = '新しい在庫数を入力してください';
        }else if (preg_match("/^([1-9][0-9]*|0)$/",$product_stock) !== 1){
            $errors[] = '在庫数は0以上の整数を入れてください';
        }
        if ($drink_id === ''){
            $errors[] = 'ドリンクを選択してください';
        }
    }
    
    //ステータス更新判定
    if ($process_kind === 'change_status') {
        //各フォームからデータを受け取っているかどうか判定
        $product_status = get_post_data('change_status');
        $drink_id = get_post_data('drink_id');
        
        if ($drink_id === ''){
            $errors[] = 'ドリンクを選択してください';
        }
    }
    
    
}

//DBへの登録及び一覧表示設定*******************************************************************
try{
    // データベースに接続
    $dbh = get_db_connect();
    
    //DBへの書き込み
    try{
        if (count($errors) === 0 && $_SERVER['REQUEST_METHOD'] === 'POST'){
            //新規商品データDB登録
            if ($process_kind === 'insert_item') {
                $dbh->beginTransaction();
                try{
                    //主DB登録
                    insert_main_db($dbh,$product_name,$product_price,$product_img_filename,$product_status);
                    $drink_id = $dbh->lastInsertId();
                    //在庫DB登録
                    insert_stock_db($dbh,$drink_id,$product_stock);
                    
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
                    //在庫数更新
                    update_stock_db($dbh,$product_stock,$drink_id);
                    $success[] = 'データが更新されました';
                }catch(PDOException $e){
                    $errors[] = 'データが更新されませんでした';
                }
            }else if ($process_kind === 'change_status') {
                try {
                    //ステータス更新
                    update_drink_master_status($dbh,$drink_id, $product_status);
                    $success[] = 'ステータスが更新されました';
                
                } catch (PDOException $e) {
                    $errors[] = 'ステータスが更新されませんでした';
                }
            }
        }
    }catch(PDOException $e){
        $errors[] = 'データが登録できませんでした。理由：'.$e->getMessage();
    }
    
    //DBからのデータ取得
    $rows = get_drink_list($dbh);

}catch(PDOException $e){
    $errors[] = '接続できませんでした。理由：'.$e->getMessage();
}
// コメント一覧ファイル読み込み
include_once './view/tool.php';
