<?php
//メイン処理********************************************************************
/**
* (1).DBハンドルを取得
* @return obj $dbh DBハンドル
*/
function get_db_connect() {
 
  try {
    // データベースに接続
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARSET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $e) {
    throw $e;
  }
 
  return $dbh;
}

/**
* (2).商品の一覧を取得する
*
* @param obj $dbh DBハンドル
* @return array 商品一覧配列データ
*/
function get_goods_table_list($dbh) {
 
  // SQL生成
  $sql = 'SELECT name, price FROM test_products';
  // クエリ実行
  return get_as_array($dbh, $sql);
}
 
/**
* (3).商品の値段を税込みに変換する(配列)
* @param array  $assoc_array 税抜き商品一覧配列データ
* @return array 税込み商品一覧配列データ
*/
function price_before_tax_assoc_array($assoc_array) {
    //この時点で、controller.phpの$goods_dataの値(商品一覧データ)を受け取っている。
    
    //繰り返し処理($assoc_array変数を、キー(0~)を$key変数・値(商品名、価格)を$value変数に入れる連想配列として使用する)
  foreach ($assoc_array as $key => $value) {
    // 税込み価格へ変換(端数は切り上げ)
    $assoc_array[$key]['price'] = price_before_tax($assoc_array[$key]['price']);
    // var_dump($assoc_array[$key]['price']);    //中身はfloat(108) float(2160) float(540) float(108) float(108)
     //var_dump($assoc_array[$key]['name']);    //string(18) "マウスパッド" string(12) "イヤホン" string(3) "傘" string(6) "お茶" string(12) "サイダー"
  }
  return $assoc_array;
}
 
// /**
// * (4).特殊文字をHTMLエンティティに変換する(2次元配列の値)
// * @param array  $assoc_array 変換前配列
// * @return array 変換後配列
// */
// function entity_assoc_array($assoc_array) {
//     // var_dump($assoc_array);//①
//   foreach ($assoc_array as $key => $value) {
//     //   var_dump($key);//②
//     //   var_dump($value);//③
    
//     foreach ($value as $keys => $values) {//配列のままだとエンティティに変換できないので、さらに分割処理
//       // 特殊文字をHTMLエンティティに変換
//     //   var_dump($keys);//④
//     //   var_dump($values);//⑤
//         $assoc_array[$key][$keys] = h($values);//早退参照時は中身の変数を使用し、直接参照時(配列等で)はキーを指定する
//     }
//     // var_dump($keys);
//     // var_dump($values);
//   }
 
//   return $assoc_array;
// }

//サブ処理********************************************************************
/**
* (2サブ)クエリを実行しその結果を配列で取得する
*
* @param obj  $dbh DBハンドル
* @param str  $sql SQL文
* @return array 結果配列データ
*/
function get_as_array($dbh, $sql) {
 
  try {
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
  } catch (PDOException $e) {
    throw $e;
  }
 
  return $rows;
}

/**
*(3サブ) 税込み価格へ変換する(端数は切り上げ)
* @param str  $price 税抜き価格
* @return str 税込み価格→return ceil($price * TAX);のこと
*/
function price_before_tax($price) {
    //ceil():小数点以下切り捨上げ関数→税込み価格を小数点以下切り上げ
    return ceil($price * TAX);
}

/**
* (4サブ)特殊文字をHTMLエンティティに変換する
* @param str  $str 変換前文字
* @return str 変換後文字
*/
function h($str) {
 
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}
?>