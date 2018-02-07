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

$item_types = array();

//postじゃなくget

try {

  $dbh = get_db_connect();
  
  $item_types = get_item_type($dbh);

} catch (PDOException $e) {
  $errors[] = 'データの一覧の取得に失敗しました。理由：'.$e->getMessage();
}

// テンプレートファイル読み込み
include_once '../include/view/category_list_view.php';