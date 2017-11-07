<?php
$filename = './review.txt';
//初期化：たとえ中身がなかったとしてもエラーにはならないための処理。エラーを起こさないことが重要。
$your_info = '';
$your_name = '';
$your_comment = '';
$errors = array();

// フォームからのデータ受け取り判定及び、./rebiew.txt'への書き込み処理*******************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST'){//フォームからデータが入力されたかどうかの判定
    if (isset($_POST['your_name']) === TRUE) {//入力されたデータの内容の判定
        $your_name = $_POST['your_name'];//4行目で初期化をしている変数に代入することによって、仮に $_POST['your_name']の中身が空だったとしてもエラーにはならない。
    }
    if ($your_name === ''){
        $errors[] = '名前を入力してください';
    }
    if(mb_strlen($your_name) > 20){
        $errors[] = '名前は20文字以内で入力してください。'; 
    }
    if (isset($_POST['your_comment']) === TRUE) {
        $your_comment = $_POST['your_comment'];
    }
    if ($your_comment === ''){
        $errors[] = 'コメントを入力してください';
    }
    if(mb_strlen($your_comment) > 100){
        $errors[] = 'コメントは100文字以内で入力してください。'; 
    }

    $your_info = $your_name.'：'."\t".$your_comment."\t".date('-Y-m-d H:i:s')."\n";
    
    if (count($errors) === 0){
        if (($fp = fopen($filename, 'a')) !== FALSE) {//ファイルを開けるかどうか判定
            if (fwrite($fp, $your_info) === FALSE) {//ファイルに書き込めるかどうか判定
                $errors[] = 'ファイル書き込み失敗:  ' . $filename;
            }
            fclose($fp);
        }
    }
}
 
//./file_write.txt'の内容を配列に追記していく処理******************************************************
$data = array();
 
if (is_readable($filename) === TRUE) {//読み込み可能判定
  if (($fp = fopen($filename, 'r')) !== FALSE) {//ファイルの開き方を指定
    while (($tmp = fgets($fp)) !== FALSE) {
        $data[] = $tmp;
    }
    fclose($fp);
    $data = array_reverse($data);

  }
} else {
  $errors[] = 'ファイルがありません';
}
?>
<!--表示処理-------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ファイル操作</title>
</head>
<body>
　<h1>一言掲示板</h1>
  <form method="post">
    <p>名前：<input type="text" name="your_name">ひとこと：<input type="text" name="your_comment"> <input type="submit" name="submit" value="送信"></p>
  </form>
  
    <!--エラー表示処理-->
    <?php if (count($errors) > 0) { ?>
        <?php foreach ($errors as $value) { ?>
            <p><?php print htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php } ?>
    <?php } ?>
    
    <!--結果表示処理-->
    <?php foreach ($data as $read) { ?>
      <p><?php print htmlspecialchars($read, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php } ?>
</body>
</html>