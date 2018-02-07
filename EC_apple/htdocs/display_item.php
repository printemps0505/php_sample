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
$food_data = array();
$luxury_data = array();
$drink_data = array();
$food_type = '食品';
$luxury_type = '貴金属';
$drink_type = '飲み物';
$dessert_type = '甘い物';
$dessert_data = array();
$errors = array();

try {

  $dbh = get_db_connect();
  $food_data = get_item_list_by_category($dbh,$food_type);
  $luxury_data = get_item_list_by_category($dbh,$luxury_type);
  $drink_data = get_item_list_by_category($dbh,$drink_type);
  $dessert_data = get_item_list_by_category($dbh,$dessert_type);

  $data = get_item_list_status_one($dbh);

} catch (PDOException $e) {
  $errors[] = 'データの一覧の取得に失敗しました。理由：'.$e->getMessage();
}

include_once '../include/view/display_item_view.php';