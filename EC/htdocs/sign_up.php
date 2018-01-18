<?php
// 設定ファイル読み込み
require_once '../include/conf/const.php';
// 関数ファイル読み込み
require_once '../include/model/function.php';

$name = '';
$name_kana = '';
$email_address = '';
$password = '';
$password_confirm = '';
$zip_code = '';
$address = '';
$address_detail = '';
$telephone = '';
$errors = array();


//postの受け取り
if(is_post()){
    $name = get_post('name');
    $name_kana = get_post('name_kana');
    $email_address = get_post('email_address');
    $password = get_post('password');
    $password_confirm = get_post('password_confirm');
    $zip_code = get_post('zip_code');
    $address = get_post('address');
    $address_detail = get_post('address_detail');
    $telephone = get_post('telephone');

    if ($name === ''){
            $errors[] = '名前を入力してください';
    }
    if ($name_kana === ''){
            $errors[] = 'フリガナを入力してください';
    //utf-8 文字コード　表でわかる
    }else if(preg_match("/^[ァ-ヶー]+$/u", $name_kana) !== 1){
            $errors[] = '入力できるのはカタカナのみです';
    }
    if ($email_address === ''){
            $errors[] = 'アドレスを入力してください';
    //D:複数行の判定の際に、文末のみを判定する。
    }else if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD", $email_address) !== 1){
            $errors[] = '不正なアドレスです';
    }
    if ($password === ''){
            $errors[] = 'パスワードを入力してください';
    }else if(preg_match("/^[a-z0-9]{8,}$/i", $password) !== 1){
            $errors[] = '不正なパスワードです';
    }
    if ($password_confirm === ''){
            $errors[] = 'パスワード(確認用)を入力してください';
    }else if($password !== $password_confirm){
            $errors[] = '最初に入力されたパスワードと異なります。';    
    }
    if ($zip_code === ''){
            $errors[] = '郵便番号を入力してください';
    }else if(preg_match("/^[0-9]{3}-[0-9]{4}$/", $zip_code) !== 1){
            $errors[] = '不正な郵便番号です';
    }
    if ($address === ''){
            $errors[] = '住所を入力してください';
    }
    if ($adress_detail === ''){
            $errors[] = '住所を入力してください';
    }
    if ($telephone === ''){
            $errors[] = '電話番号を入力してください';
    }else if(preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $telephone) !== 1){
            $errors[] = '不正な電話番号です';
    }
    
    if(count($errors) === 0){
        //ユーザーテーブルにinsert
        try{
            //DB接続
            $dbh = get_db_connect();
            insert_user_data($dbh,$name,$password,$email_address,$name_kana,$telephone,$address,$address_detail,$zip_code);
        }catch(PDOException $e){
            $errors[] = 'データの更新に失敗しました。'.$e->getMessage();
        }
    }
}

//DB切断(保留)

include_once '../include/view/sign_up_view.php';

