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
$success = array();
$data = array();

if (is_post() === TRUE){
    try{
        // データベースに接続
        $dbh = get_db_connect();
        
        try{
            //ユーザー購入リスト抽出
            $data = get_carts_list_by_user_id($dbh,$user_id);
            foreach($data as $judge){
                if($judge['item_stock'] <= $judge['carts_amount']){
                        $errors[] = $judge['item_name'].'は在庫切れです';
                }
                if($judge['item_status'] === 0){
                    $errors[] = $judge['item_name'].'は現在取り扱っていません';
                }
            }
            if(count($errors) === 0){
                $dbh->beginTransaction();
                try{
                    //purchase_historyテーブル更新
                    //itemsテーブルの在庫更新（foreachでまわす）
                    // //在庫数更新
                        // $item_stock = $judge['item_stock'] - $judge['carts_amount'];
                        // update_stock($dbh,$item_stock,$item_id);
                    //cartsテーブルのレコード削除（user_id一致)
                    $dbh->commit();
                    $success[] = '各種テーブルの更新に成功しました';
                }catch(PDOException $e){
                    $dbh->rollback();
                    throw $e;
                }
            }
        }catch(PDOException $e){
            $errors[] = '処理が完了しませんでした。理由：'.$e->getMessage();
        }
    }catch(PDOException $e){
        $errors[] = '接続できませんでした。理由：'.$e->getMessage();
    }
}
include_once '../include/view/purchase_view.php';