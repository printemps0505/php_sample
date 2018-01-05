<?php
// 設定ファイル読み込み
require_once './conf/setting.php';
// 関数ファイル読み込み
require_once './model/model.php';
$your_name = '';
$your_comment = '';
$errors = array();
$db_data = array();

// フォームからのデータ受け取り判定及び、氏名・コメント・作成日時のDBへの書き込み
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    //フォームからのデータ受け取り判定
    $your_name = get_post_data('your_name');
    $your_comment = get_post_data('your_comment');
    
    //受け取りデータエラー判定
    if ($your_name === ''){
        $errors[] = '名前を入力してください';
    }
    if(mb_strlen($your_name) > 20){
        $errors[] = '名前は20文字以内で入力してください。'; 
    }
   
    if ($your_comment === ''){
        $errors[] = 'コメントを入力してください';
    }
    if(mb_strlen($your_comment) > 100){
        $errors[] = 'コメントは100文字以内で入力してください。'; 
    }
}
    
try {
    // データベースに接続
    $dbh = get_db_connect();
    if (count($errors) === 0 && $_SERVER['REQUEST_METHOD'] === 'POST'){
        //DBへのデータ書き込み
        sql_insert($dbh,$your_name,$your_comment);
    }
    //DBからデータの取得
    $db_data =  sql_select($dbh);
}catch (PDOException $e) {//接続エラー時の実際の処理。例外メッセージは$e->getMessage()で覚える
    $errors[] = 'DBエラー。理由：'.$e->getMessage();
}
// //html文字列変換処理
// $db_data = entity_array($db_data);
    
// コメント一覧ファイル読み込み
include_once './view/view.php';