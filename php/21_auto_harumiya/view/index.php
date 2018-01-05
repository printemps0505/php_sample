<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>自動販売機</title>
    <style>
        .drink_flex{
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
    <h1>自動販売機</h1>
    <form action="result.php" method="post">
        <div>金額<input type="text" name="money" value=""></div>
        <div class="drink_flex">
        <?php foreach ($data as $read)  { ?>
                <figure>
                    <img src="<?php print h(IMG_DIR . $read['img']); ?>" class="img_size">
                    <figcaption><?php print h($read['drink_name']); ?></figcaption>
                    <figcaption><?php print h($read['price']); ?>円</figcaption>
                    <?php if ($read['stock'] > 0) { ?>
                        <figcaption><input type="radio" name="drink_id" value="<?php print h($read['drink_id']); ?>"></figcaption>
                    <?php } else { ?>
                        <figcaption class="red">売り切れ</figcaption>
                    <?php } ?>
                </figure>
        <?php } ?>
        </div>
        <input type="submit" value="購入">
    </form>
<?php } else { ?>
    <?php foreach ($errors as $read) { ?>
    <p><?php print h($read); ?></p>
    <?php } ?>
<?php } ?>
</body>
</html>