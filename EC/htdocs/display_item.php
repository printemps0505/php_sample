<?php
// 設定ファイル読み込み
require_once '../include/conf/const.php';
// 関数ファイル読み込み
require_once '../include/model/function.php';
session_start();
$data    = array();
$errors = array();
$user_id = get_login_user_id();

if($user_id === FALSE){
  header('Location: login.php');
  exit;
}

//カテゴリ一覧から飛んできた際に必要な処理
$item_types = get_get('item_type');

try {

  $dbh = get_db_connect();

  $data = get_item_list_status_one($dbh);

} catch (PDOException $e) {
  $errors[] = 'データの一覧の取得に失敗しました。理由：'.$e->getMessage();
}

include_once '../include/view/display_item_view.php';