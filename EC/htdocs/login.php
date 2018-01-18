<?php
// 設定ファイル読み込み
require_once '../include/conf/const.php';
// 関数ファイル読み込み
require_once '../include/model/function.php';


$errors = array();

$email_address = '';
$password = '';

session_start();
//postの受け取り
if(is_post()){
    $email_address = get_post('email_address');
    $password = get_post('password');

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
    
    if(count($errors) === 0){
        //ユーザーテーブルにinsert
        try{
            //DB接続
            $dbh = get_db_connect();
            $login_user_data = get_login_user_data($dbh,$email_address,$password);
            var_dump($login_user_data);
        }catch(PDOException $e){
            $errors[] = 'ログインに失敗しました。'.$e->getMessage();
        }
        // 登録データを取得できたか確認
        if (isset($login_user_data['user_id'])) {
          // セッション変数にuser_idを保存
          $_SESSION['user_id'] = $login_user_data['user_id'];
          // ログイン済みユーザのホームページへリダイレクト
          header('Location: display_item.php');
          exit;
        }
    }
}


include_once '../include/view/login_view.php';