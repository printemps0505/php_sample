<?php
// 設定ファイル読み込み
require_once '../include/conf/const.php';
// 関数ファイル読み込み
require_once '../include/model/function.php';

session_start();
$user_id = get_login_user_id();

if($user_id === FALSE){
  header('Location: login.php');
  exit;
}

$process_kind = '';
$item_id = '';
$carts_amount = '';
$item_stock = '';
$item_status = '';
$errors = array();
$items = array();
$carts = array();
$data = array();
$success = array();

if (is_post() === TRUE){
    $process_kind = get_post('process_kind');
}
try{
    // データベースに接続
    $dbh = get_db_connect();
    try{
        if (count($errors) === 0 && is_post() === TRUE){
            
            if ($process_kind === 'add_to_carts') {
                $items = get_item_by_item_id($dbh,$item_id);
                $carts = get_cart_by_user_and_item_id($dbh,$user_id,$item_id);
                
                if($items['item_stock'] <= 0){
                    $errors[] = '在庫切れです';
                }
                if($items['item_status'] === 0){
                    $errors[] = '現在取り扱っていません';
                }
                
                if (count($errors) === 0){
                    $dbh->beginTransaction();
                    try{
                        //カートへの追加
                        if($carts === FALSE){
                            $carts_amount = 1;
                            add_carts($dbh,$item_id,$user_id,$carts_amount);
                        }else{
                            $carts_amount = $carts['carts_amount'] + 1;
                            update_carts($dbh,$item_id,$user_id,$carts_amount);
                        }
                        
                        $dbh->commit();
                        $success[] = 'データが登録できました';
                    }catch(PDOException $e){
                        //ロールバック処理
                        $dbh->rollback();
                        //例外をスロー
                        throw $e;
                    }
                }
            }
            
            if ($process_kind === 'update_carts_amount') {
                
                //各フォームからデータを受け取っているかどうか判定
                $carts_amount = get_post('carts_amount');
                $item_id = get_post('item_id');
                
                //フォームからのデータが空白でないかどうかの判定(数値に関しての書式判定)
                if ($carts_amount === ''){
                    $errors[] = '新しい個数を入力してください';
                }else if (preg_match("/^([1-9][0-9]*)$/",$carts_amount) !== 1){
                    $errors[] = '個数は1以上の整数を入れてください';
                }
                if ($item_id === ''){
                    $errors[] = '商品を選択してください';
                }
                if(count($errors) === 0){
                    try {
                        //個数の更新
                        update_carts($dbh,$item_id,$user_id,$carts_amount);
                        $success[] = '個数が更新されました';
                        
                    } catch (PDOException $e) {
                        $errors[] = '個数が更新されませんでした';
                    }
                }
            }
            if ($process_kind === 'delete_carts') {
                
                //各フォームからデータを受け取っているかどうか判定
                $item_id = get_post('item_id');
                
                if ($item_id === ''){
                    $errors[] = '商品を選択してください';
                }
                if(count($errors) === 0){
                    try {
                        //個数の更新
                        delete_carts_by_item_user_id($dbh,$item_id,$user_id);
                        $success[] = '商品が削除されました';
                        
                    } catch (PDOException $e) {
                        $errors[] = '商品の削除に失敗しました';
                    }
                }
            }
        }
    }catch(PDOException $e){
        $errors[] = '処理を完了できませんでした。理由：'.$e->getMessage();
    }
    
    //DBからのデータ取得
    $data = get_carts_list_by_user_id($dbh,$user_id);
}catch(PDOException $e){
    $errors[] = '接続できませんでした。理由：'.$e->getMessage();
}
include_once '../include/view/cart_list_view.php';