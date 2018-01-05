<?php
//フォームからのデータ受け取り判定
function get_post_data($key) {
  $str = '';
  if (isset($_POST[$key]) === TRUE) {
    $str = $_POST[$key];
  }
  return $str;
}

// データベースに接続
function get_db_connect(){
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARSET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $dbh;
}

//DBへのデータ書き込み
function sql_insert($dbh,$your_name,$your_comment){
$sql = 'INSERT INTO post
    (user_name,user_comment)
    VALUES
    (:user_name,:user_comment)';
    $params = array(
        'user_name' => $your_name,
        'user_comment' => $your_comment
        );
        
    return sql_execute($dbh,$sql,$params);    
}

function sql_execute($dbh,$sql,$params){
    $stmt = $dbh->prepare($sql);
    return $stmt->execute($params);
    //32~34と42の引数で$paramsを指定することで、通常の以下のエスケープ処理をするのと同意になる。
    // $stmt_insert->bindValue(':user_name', $your_name,    PDO::PARAM_STR);
    // $stmt_insert->bindValue(':user_comment', $your_comment,    PDO::PARAM_STR)
}


//DBからデータの取得準備
function sql_select($dbh){
$sql = 'SELECT user_name,user_comment,create_datetime
                FROM post
                ORDER BY create_datetime DESC';
                
    return select_execution($dbh,$sql);
}

//DBからデータ取得sql実行
function select_execution($dbh,$sql,$params = array()){//$params = array()を入れておくことで・・
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute($params);
    // レコードの取得
    $rows = $stmt->fetchAll();
    return $rows;
}

// //htmlエンティティ変換前準備
// function entity_array($records){
//     foreach ($records as $record_num => $record){
//         foreach ($record as $column_name => $value) {//$keysはカラム名('user_nameとか')
//             $records[$record_num][$column_name] = h($value);
//         }
//     }
//     return $records;
// }

//htmlエンティティ変換処理
function h($str){
     return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);//return ~で、～の値を返すという意味
}