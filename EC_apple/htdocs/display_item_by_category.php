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

$data    = array();
$errors = array();

$item_type = get_get('item_type');

if($item_type === FALSE){
  header('Location: display_item.php');
  exit;
}
try {

  $dbh = get_db_connect();

  $data = get_item_list_by_category($dbh,$item_type);

} catch (PDOException $e) {
  $errors[] = 'データの一覧の取得に失敗しました。理由：'.$e->getMessage();
}

include_once '../include/view/display_item_by_category_view.php';