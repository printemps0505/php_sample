<?php
 
// データベースの接続情報
//define('定数名','定数の中身')
define('DB_USER',   'codecamp19367');    // MySQLのユーザ名
define('DB_PASSWD', 'KXLSPRWO');    // MySQLのパスワード
define('DB_NAME', 'codecamp19367');  // MySQLのDB名(今回、MySQLのユーザ名を入力してください)
define('DB_CHARSET', 'SET NAMES utf8mb4');  // MySQLのcharset
define('DSN', 'mysql:dbname='.DB_NAME.';host=localhost;charset=utf8');  // データベースのDSN情報
 
define('TAX', 1.08);  // 消費税
 
define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング
?>