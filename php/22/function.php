<?php
function is_post(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function get_post($key) {
    if(isset($_POST[$key]) === TRUE) {
        return  $_POST[$key];
    }
    return  '';
}

function get_db_connect(){
    $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARACTER_SET));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $dbh;
}

function get_user_data($dbh,$user_id){
    $sql = 'SELECT 
              `user_name`,
              `e_mail`, 
              `password`,
              `user_id`
            FROM
              test_user_table
            WHERE
              user_id = :user_id';
              
    $params = array(':user_id' => $user_id);
    return sql_select_execution_one($dbh,$sql,$params);
}
function get_user_data_by_email_password($dbh,$email,$password){
    $sql = 'SELECT
                user_id
            FROM
                test_user_table
            WHERE
                e_mail = :e_mail
            AND
                password = :password';
    $params = array(':e_mail' => $email,':password' => $password);
    return sql_select_execution_one($dbh,$sql,$params);
}


function sql_select_execution_one($dbh,$sql,$params = array()){
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row;
}