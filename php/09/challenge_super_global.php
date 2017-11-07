<?php
//変数初期化
$gender = '';
$mail = '';
// 送信ボタンがクリックされた場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //名前処理
    if (isset($_POST['my_name']) === TRUE) {
    print 'ここに入力した名前を表示： ' . htmlspecialchars($_POST['my_name'], ENT_QUOTES, 'UTF-8');
    }
    
    //性別処理
    if (isset($_POST['gender']) === TRUE) {
     $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
    }
    // お知らせメール処理
     if (isset($_POST['mail']) === TRUE) {
     $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>課題</title>
</head>
<body>
    <!--結果-->
    <?php if ($gender === 'man' || $gender === 'woman') { ?>
   <p>ここに選択した性別を表示：<?php print $gender; ?></p>
<?php } ?>
    
     <?php if ($mail === 'OK') { ?>
   <p>ここにメールを受け取るかを表示：<?php print $mail; ?></p>
<?php } ?>



  <h1>課題</h1>
  <form method="post">
      <p>お名前: <input id="my_name" type="text" name="my_name" value=""></p>
      <p>性別: <input type="radio" name="gender" value="man" <?php if ($gender === 'man') { print 'checked'; } ?>>男
      <input type="radio" name="gender" value="woman" <?php if ($gender === 'woman') { print 'checked'; } ?>>女</p>
      <p><input type="checkbox" name="mail" value="OK" <?php if ($mail === 'OK') { print 'checked';} ?>>お知らせメールを受け取る</p>
      <input type="submit" name="submit" value="送信">
  </form>
</body>
</html>

<!--質問事項-->
<!--使用するラベルによって、決まった書き方があると考えてよいか？-->