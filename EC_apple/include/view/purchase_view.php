<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta charset="UTF-8">
        <title>購入完了</title>
        <style>
            
        </style>
    </head>
    <body>
        <!--購入一覧を出してあげた方が親切-->
        <?php if(count($errors) === 0){ ?>
            <?php foreach ($success as $reads) { ?>
                    <p><?php print h($reads); ?></p>
            <?php } ?>
            <h1>購入処理が完了しました。</h1>
            <h3>商品が届くまでしばらくお待ちください。</h3>
        <?php }else{ ?>
            <?php foreach ($errors as $values) { ?>
                    <p><?php print h($values); ?></p>
            <?php } ?>
        <?php } ?>
        <form action="display_item.php" method="post">
            <input type="submit" value="トップページへ">
            <!--リンクでいい-->
        </form>
        <a href="logout.php" class="logout">ログアウト</a>
    </body>
</html>