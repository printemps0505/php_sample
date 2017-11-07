<?php
$filename = './tokyo.csv';
 
//./file_write.txt'の内容を配列に追記していく処理******************************************************
$data = array();
 
if (is_readable($filename) === TRUE) {//読み込み可能判定
  if (($fp = fopen($filename, 'r')) !== FALSE) {//ファイルの開き方を指定
    while (($tmp = fgetcsv($fp)) !== FALSE) {//fgets:読み込み処理,fwrite:書き込み処理
        $data[] = $tmp;
     // $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');//不特定多数の値を追加する場合は、配列のキーを空白にして、自動割り振りにしておくこと便利。
    }
    fclose($fp);//保存して閉じる
    //var_dump($data[0]);
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
    <p>以下にファイルから読み込んだ住所データを表示<p>
    <p>住所データ</p>
    
    <table border="1">
        <tr>
            <th>郵便番号</th>
            <th>都道府県</th>
            <th>市区町村</th>
            <th>町域</th>
        </tr>
        <?php foreach ($data as $read) { ?>
            <tr>
                <td><?php print htmlspecialchars($read[2], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php print htmlspecialchars($read[6], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php print htmlspecialchars($read[7], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php print htmlspecialchars($read[8], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php } ?>
        
    </table>

</body>
</html>