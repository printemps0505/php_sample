
<!--表示処理-------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>DB操作</title>
</head>
<body>
　<h1>一言掲示板(DB使用)</h1>
  <form method="post">
    <p>名前：<input type="text" name="your_name">ひとこと：<input type="text" name="your_comment"> <input type="submit" name="submit" value="送信"></p>
  </form>
  
    <!--エラー表示処理-->
    <?php foreach ($errors as $value) { ?>
        <p><?php print h($value); ?></p>
    <?php } ?>
    
    <!--結果表示処理-->
    <?php foreach ($db_data as $reads) { ?>
        <p>
            <?php print h($reads['user_name']); ?>
            <?php print h($reads['user_comment']); ?>
            <?php print h($reads['create_datetime']); ?>
        </p>
    <?php } ?>
</body>
</html>