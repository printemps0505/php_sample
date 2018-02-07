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

$sum_price = '';
$errors = array();
$data = array();

if (is_post() === TRUE){
    try{
        // データベースに接続
        $dbh = get_db_connect();
        
        try{
            $data = get_carts_list_by_user_id($dbh,$user_id);
            foreach($data as $read){
                $sum_price = $sum_price + $read['item_price'] * $read['carts_amount'];
            }
        }catch(PDOException $e){
            $errors[] = '処理が完了しませんでした。理由：'.$e->getMessage();
        }
    }catch(PDOException $e){
        $errors[] = '接続できませんでした。理由：'.$e->getMessage();
    }
}
include_once '../include/view/purchase_confirm_view.php';