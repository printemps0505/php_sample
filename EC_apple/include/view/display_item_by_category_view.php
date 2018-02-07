<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>カテゴリ別商品一覧</title>
    <style>
        .item_flex{
            width:1000px;
            display:flex;
            flex-wrap: wrap;
        }
        figure{
            text-align:center;
        }
        .img_size{
            width: 130px;
        }
        .red {
            color: #FF0000;
        }

    </style>
</head>
<body>
    <?php if (count($errors) === 0) { ?>
    <h1>おすすめ商品</h1>
    <h3><?php print h($item_type); ?></h3>
    <div class="item_flex">
    <?php foreach ($data as $read)  { ?>
        <a href="display_item_detail.php?item_id=<?php print h($read['item_id']); ?>">
            <figure>
                <img src="<?php print h(IMG_DIR . $read['item_img']); ?>" class="img_size">
                <figcaption><?php print h($read['item_name']); ?></figcaption>
                <figcaption><?php print h($read['item_price']); ?>円</figcaption>
                <?php if ($read['item_stock'] === 0) { ?>
                    <figcaption class="red">売り切れ</figcaption>
                <?php } ?>
            </figure>
        </a>
    <?php } ?>
    </div>
    <?php } else { ?>
        <?php foreach ($errors as $read) { ?>
            <p><?php print h($read); ?></p>
        <?php } ?>
    <?php } ?>
    <section>
        <a href="display_item.php">トップページへ</a>
    </section>
    <section>
        <a href="logout.php" class="logout">ログアウト</a>
    </section>
   
</body>
</html>