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

$item_id = '';
$change = '';
$items  = array();
$errors  = array();
$success = array();
$update_stock = '';

//postじゃなくget
    
    $item_id = get_get('item_id');
    
    if ($item_id === '') {
        $errors[] = '商品を選択してください';
    } else if (check_number($item_id) !== TRUE ) {
        $errors[] = 'エラー: 不正な入力値です';
    }

    if (count($errors) === 0){
        $dbh = get_db_connect();
        $items = get_item_by_id($dbh,$item_id);
        // var_dump($items);
        
        if ($items['item_status'] === 0){
            $errors[] = 'この商品は現在取り扱っておりません。';
        }
    }
    try{
        if (count($errors) === 0 && is_post() === TRUE){
            
            //カートへの追加の時だけ判定するようにする
            if ($items['item_stock'] === 0){
                $errors[] = '品切れです';
            }
            $carts = get_cart_by_user_and_item_id($dbh,$user_id,$item_id);
            
            if (count($errors) === 0){
                //カートへの追加
                if($carts === FALSE){
                    $carts_amount = 1;
                    add_carts($dbh,$item_id,$user_id,$carts_amount);
                }else{
                    $carts_amount = $carts['carts_amount'] + 1;
                    update_carts($dbh,$item_id,$user_id,$carts_amount);
                }
                $success[] = 'カートに追加されました';
            }
        }
    }catch(PDOException $e){
        $errors[] = '処理を完了できませんでした。理由：'.$e->getMessage();
    }
    

// テンプレートファイル読み込み
include_once '../include/view/display_item_detail_view.php';