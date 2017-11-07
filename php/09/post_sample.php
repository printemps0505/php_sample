<?php
// 変数初期化
$gender = '';//エラー起きないように
// 送信ボタンがクリックされた場合の処理
var_dump($_SERVER['REQUEST_METHOD']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['gender']) === TRUE) {
      $gender = $_POST['gender'];
     //$gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');//htmlspecialcharsはprintの直前(同時)。ブラウザ上に出力する必要がないものは実施不要。文字数が変わってしまうため。
//     var_dump($_SERVER);
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>スーパーグローバル変数使用例</title>
</head>
<body>
   <h2>性別を選択してください</h2>
<?php if ($gender === '男' || $gender === '女') { ?>
   <p>あなたの性別は「<?php print htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?>」です</p>
<?php } ?>

<!--ラジオボックス-->
 <form method="post">
      <p>性別：<input type="radio" name="gender" value="男" <?php if ($gender === '男') { print 'checked'; } ?>>男
       <input type="radio" name="gender" value="女" <?php if ($gender === '女') { print 'checked'; } ?>>女</p>
       <input type="submit" value="送信">
   </form>
  </body>
  </html>