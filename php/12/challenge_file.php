<?php
$filename = './challenge_log.txt';
 
// ./challenge_log.txt'への書き込み処理*******************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST'){//フォームからデータが飛んできているかどうかの判定
  $comment = date('m月d日 H:i:s')."\t".$_POST['comment']."\n";//'commentはname='comment'のこと？
  if (($fp = fopen($filename, 'a')) !== FALSE) {//ファイルを開いて、追記していく判定
    if (fwrite($fp, $comment) === FALSE) {//ファイルに書き込めるかどうか
      print 'ファイル書き込み失敗:  ' . $filename;
    }
    fclose($fp);
  }
}
 
//./file_write.txt'の内容を配列に追記していく処理******************************************************
$data = array();
 
if (is_readable($filename) === TRUE) {//読み込み可能判定
  if (($fp = fopen($filename, 'r')) !== FALSE) {//ファイルの開き方を指定
    while (($tmp = fgets($fp)) !== FALSE) {//fgets:読み込み処理,fwrite:書き込み処理
      $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');//不特定多数の値を追加する場合は、配列のキーを空白にして、自動割り振りにしておくこと便利。
    }
    fclose($fp);//保存して閉じる
  }
} else {
  $data[] = 'ファイルがありません';
}
?>
<!--表示処理-->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ファイル操作</title>
</head>
<body>
  <h1>課題</h1>
  <form method="post">
    <p>発言:<input type="text" name="comment"></p>
    <input type="submit" name="submit" value="送信">
  </form>
  <p>発言一覧</p>
<?php foreach ($data as $read) { ?>
  <p><?php print $read; ?></p>
<?php } ?>
</body>
</html>