<?php
//定数として定義(変えないから)
// データベースの接続情報
define('DB_USER',   'codecamp19367');    // MySQLのユーザ名
define('DB_PASSWD', 'KXLSPRWO');    // MySQLのパスワード
define('DB_NAME', 'codecamp19367');  // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
define('DB_CHARACTER_SET', 'SET NAMES utf8mb4');  // MySQLのcharset
define('DSN', 'mysql:dbname='.DB_NAME.';host=localhost;charset=utf8');  // データベースのDSN情報

define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング
define('IMG_DIR','./img/');