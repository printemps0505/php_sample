<?php
// 設定ファイル読み込み
require_once '../include/conf/const.php';
// 関数ファイル読み込み
require_once '../include/model/function.php';

$process_kind = '';
$item_id = '';
$item_type = '';
$item_name = '';
$item_price = '';
$item_stock = '';
$item_comment = '';
$item_status = '';
$item_img_filename = '';
$errors = array();
$success =array();
$data = array();
$rows = array();
$item_types = array('食品','飲み物','貴金属','甘い物');

if (is_post()){
    //新商品追加・在庫数変更・公開非公開切り替え用識別子作成
    $process_kind = get_post('process_kind');
    
    //新商品追加判定
    if ($process_kind === 'insert_item') {
        //各フォームからデータを受け取っているかどうか判定
        $item_type = get_post('item_type');
        $item_name = get_post('item_name');
        $item_price = get_post('item_price');
        $item_stock = get_post('item_stock');
        $item_comment = get_post('item_comment');
        $item_status = get_post('item_status');
        
        //フォームからのデータが空白でないかどうかの判定(数値に関しての書式判定)
        if ($item_type === ''){
            $errors[] = 'カテゴリを選択してください';
        }
        if ($item_name === ''){
            $errors[] = '商品名を入力してください';
        }
        if ($item_price === ''){
            $errors[] = '値段を入力してください';
        }else if (preg_match("/^[1-9][0-9]*$|^0$/",$item_price) !== 1){//"/^([1-9][0-9]*|0)$/"もおけ
            $errors[] = '値段は0以上の整数を入れてください';
        }
        if ($item_stock === ''){
            $errors[] = '在庫数を入力してください';
        }else if (preg_match("/^[1-9][0-9]*$|^0$/",$item_stock) !== 1){
            $errors[] = '在庫数は0以上の整数を入れてください';
        }
        if ($item_comment === ''){
            $errors[] = '商品詳細を入力してください';
        }
        //セレクトボックス・ラジオボックス等も必ずチェックする
        if ($item_status === ''){
            $errors[] = '公開ステータスを入力してください。';
        }else if($item_status !== '0' && $item_status !== '1'){
            $errors[] = '不正なステータスです。';
        }
        //フォームから送られてきた画像の判定及びディレクトリへの新しい名前で保存
        try{
            $item_img_filename = upload_img('item_img');
        }catch(Exception $e){
            $errors[] = $e->getMessage();
        }
    }
    //在庫数変更判定
    
    if ($process_kind === 'update_stock') {
        //各フォームからデータを受け取っているかどうか判定
        $item_stock = get_post('item_stock');
        $item_id = get_post('item_id');
        
        //フォームからのデータが空白でないかどうかの判定(数値に関しての書式判定)
        if ($item_stock === ''){
            $errors[] = '新しい在庫数を入力してください';
        }else if (preg_match("/^([1-9][0-9]*|0)$/",$item_stock) !== 1){
            $errors[] = '在庫数は0以上の整数を入れてください';
        }
        if ($item_id === ''){
            $errors[] = '商品を選択してください';
        }
    }
    if ($process_kind === 'update_comment') {
        //各フォームからデータを受け取っているかどうか判定
        $item_comment = get_post('item_comment');
        $item_id = get_post('item_id');
        
        //説明変更判定
        if ($item_comment === ''){
            $errors[] = '説明を入力してください';
        }
        if ($item_id === ''){
            $errors[] = '商品を選択してください';
        }
    }
   
    
    //ステータス更新判定
    if ($process_kind === 'change_status') {
        //各フォームからデータを受け取っているかどうか判定
        $item_status = get_post('item_status');
        $item_id = get_post('item_id');
        
        if ($item_id === ''){
            $errors[] = '商品を選択してください';
        }
    }
    //カテゴリ更新判定
    if ($process_kind === 'change_type') {
        //各フォームからデータを受け取っているかどうか判定
        $item_type = get_post('item_type');
        $item_id = get_post('item_id');
        
        if ($item_id === ''){
            $errors[] = '商品を選択してください';
        }
        
        if ($item_type === ''){
            $errors[] = 'カテゴリを選択してください';
        }
    }
    //削除判定
    if ($process_kind === 'delete') {
        //各フォームからデータを受け取っているかどうか判定
        $item_id = get_post('item_id');
        
        if ($item_id === ''){
            $errors[] = '商品を選択してください';
        }
    }
}

//DBへの登録及び一覧表示設定*******************************************************************
try{
    // データベースに接続
    $dbh = get_db_connect();
    
    //DBへの書き込み
    try{
        if (count($errors) === 0 && is_post()){
            //新規商品データDB登録
            if ($process_kind === 'insert_item') {
                //主DB登録
                insert_items($dbh,$item_type,$item_name,$item_price,$item_stock,$item_img_filename,$item_comment,$item_status);
                $success[] = 'データが登録できました';
            }else if($process_kind === 'update_stock'){
                try{
                    //在庫数更新
                    update_stock($dbh,$item_stock,$item_id);
                    $success[] = '在庫が更新されました';
                }catch(PDOException $e){
                    $errors[] = '在庫が更新されませんでした';
                }
            }else if($process_kind === 'update_comment'){
                try{
                    //在庫数更新
                    update_comment($dbh,$item_comment,$item_id);
                    $success[] = '説明が更新されました';
                }catch(PDOException $e){
                    $errors[] = '説明が更新されませんでした';
                }
            }else if ($process_kind === 'change_status') {
                try {
                    //ステータス更新
                    update_status($dbh,$item_id, $item_status);
                    $success[] = 'ステータスが更新されました';
                
                } catch (PDOException $e) {
                    $errors[] = 'ステータスが更新されませんでした';
                }
            }else if ($process_kind === 'change_type') {
                try {
                    //カテゴリ更新
                    update_type($dbh,$item_id, $item_type);
                    $success[] = 'カテゴリが更新されました';
                
                } catch (PDOException $e) {
                    $errors[] = 'カテゴリが更新されませんでした';
                }
            }else if ($process_kind === 'delete') {
                try {
                    //レコード削除
                    delete_item_by_item_id($dbh,$item_id);
                    $success[] = 'レコードが削除されました';
                
                } catch (PDOException $e) {
                    $errors[] = '削除に失敗しました';
                }
            }
        }
    }catch(PDOException $e){
        $errors[] = 'データが登録できませんでした。理由：'.$e->getMessage();
    }
    
    //DBからのデータ取得
    $rows = get_item_list($dbh);

}catch(PDOException $e){
    $errors[] = '接続できませんでした。理由：'.$e->getMessage();
}
// コメント一覧ファイル読み込み
include_once '../include/view/register_item_view.php';
