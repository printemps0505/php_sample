<?php 

// 設定ファイル読み込み
require_once './conf/const.php';
// 関数ファイル読み込み
require_once './model/function.php';

$data    = array();
$errors = array();

try {

  $dbh = get_db_connect();

  $data = get_drink_list_new($dbh);

} catch (PDOException $e) {
  $errors[] = 'データの一覧の取得に失敗しました。理由：'.$e->getMessage();
}

// テンプレートファイル読み込み
include_once './view/index.php';