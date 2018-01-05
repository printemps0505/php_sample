<?php

// 設定ファイル読み込み
require_once './conf/const.php';
// 関数ファイル読み込み
require_once './model/function.php';

$drink_id = '';
$money    = '';
$change = '';
$drink     = array();
$errors  = array();
$update_stock = '';
// var_dump($_POST);
// var_dump(1===0);

// var_dump($_SERVER['REQUEST_METHOD']);
if (is_post()) {
    $money = get_post_data('money');
    $money = trim_space($money);
    
    $drink_id = get_post_data('drink_id');
    
    if ($money === '') {
        $errors[] = 'お金を投入してください。';
    } else if (check_number($money) !== TRUE ) {
        $errors[] = 'お金は正の整数を入力してください';
    } else if ($money > 10000) {
        $errors[] = '投入金額は1万円以下にしてください';
    } 
    if ($drink_id === '') {
        $errors[] = '商品を選択してください';
    } else if (check_number($drink_id) !== TRUE ) {
        $errors[] = 'エラー: 不正な入力値です';
    }

    if (count($errors) === 0){
        $dbh = get_db_connect();
        $drink = get_drink_by_id($dbh,$drink_id);
        // var_dump($drink);
        
        //お金が足りてるかどうか判定
        if ($money >= $drink['price']){
            $change = $money - $drink['price'];
        }else{
            $errors[] = 'お金が足りません';
        }
        
        if ($drink['stock'] === '0'){
            $errors[] = '品切れです';
        }
        
        if ($drink['status'] === '0'){
            $errors[] = 'この商品は現在取り扱っておりません。';
        }
        if (count($errors) === 0){
            $update_stock = $drink['stock'] - 1;
            update_stock($dbh,$drink_id,$update_stock);
        }
    }
}else{
    $errors[] = '不正なアクセスです';
}
//在庫数変更後の値をDBに反映

// テンプレートファイル読み込み
include_once './view/result.php';