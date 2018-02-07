<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品詳細</title>
    <style>
        .img_size{
            width: 130px;
        }
        .flex{
            display:flex;
        }
    </style>
</head>
<body>
    <h1><?php print h($items['item_name']); ?></h1>
    <?php if(count($errors) === 0){ ?>
        <?php foreach($success as $reads){ ?>
                <p><?php print h($reads); ?></p>
        <?php } ?>
    <section class="flex">
        <div>
            <img src="<?php print IMG_DIR.$items['item_img']; ?>" class="img_size">
            <p><?php print h($items['item_comment']); ?></p>
                <form method="post">
                        <input type="submit" value="カゴに入れる">
                        <input type="hidden" name="process_kind" value="add_to_carts">
                </form>
                <form action="display_item.php" method="post">
                        <input type="submit" value="商品一覧に戻る">
                </form>
                <form action="cart_list.php" method="post">
                        <input type="submit" value="カート一覧へ">
                </form>
        </div>
        <form action="purchase_confirm.php" method="post">
                    <input type="submit" value="購入画面へ">
        </form>
    </section>
    <?php }else{ ?>
    <?php foreach($errors as $reads){ ?>
            <p><?php print h($reads); ?></p>
    <?php } ?>
    <?php } ?>
    <a href="logout.php" class="logout">ログアウト</a>
</body>
</html>