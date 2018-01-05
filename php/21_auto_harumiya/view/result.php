<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>自動販売機結果</title>
</head>
<body>
    <h1>自動販売機結果</h1>
    <?php if(count($errors) === 0){ ?>
            <img src="<?php print IMG_DIR.$drink['img']; ?>">
            <p>がしゃん！【<?php print h($drink['drink_name']); ?>】が買えました！</p>
            <p>おつりは【<?php print h($change); ?>円】です</p>
    <?php }else{ ?>
    <?php foreach($errors as $read){ ?>
            <p><?php print h($read); ?></p>
    <?php } ?>
    <?php } ?>
    <footer><a href="index.php">戻る</a></footer>
    
</body>
</html>