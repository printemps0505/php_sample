<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta charset="UTF-8">
        <title>カート一覧</title>
        <style>
            table {
                border-collapse: collapse;
            }
            table, tr, th, td {
                border: solid 1px;
                padding: 10px;
                text-align: center;
            }
            .black_under_line{
                margin-bottom: 20px;;
                border-bottom:solid 1px;
            }
            .under-space{
                padding-bottom:20px;
            }
            .style{
                border-radius:30px;
            }
            .img_size{
                height:100px;
            }
            .form_size{
                width:50px;
                text-align:right;
            }
            .status_false {
                background-color: #A9A9A9;
            }
            .top-space{
                margin-top:10px;
            }
            .flex{
                display:flex;
            }
        </style>
    </head>
    <body>
        <section class="black_under_line">
            <h1>カート一覧</h1>
             <!--エラー表示処理-->
            <?php foreach ($errors as $value) { ?>
                <p><?php print h($value); ?></p>
            <?php } ?>
            <?php foreach ($success as $result) { ?>
                <p><?php print h($result); ?></p>
            <?php } ?>
        </section>
        <section class="flex">
            <table>
                <?php foreach ($data as $reads)  { ?>
                    <tr>
                        <td><img src="<?php print h(IMG_DIR . $reads['item_img']); ?>" class="img_size"></td>
                        <td><?php print h($reads['item_name']); ?></td>
                        <td><?php print h($reads['item_price']); ?>円</td>
                        <td>
                            <form method="post">
                                <input type="text" class="form_size" name="carts_amount" value=<?php print h($reads['carts_amount']); ?>>個<input type="submit" value="変更">
                                <input type="hidden" name="item_id" value="<?php print h($reads['item_id']); ?>">
                                <input type="hidden" name="process_kind" value="update_carts_amount">
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="submit" value="削除">
                                <input type="hidden" name="item_id" value="<?php print h($reads['item_id']); ?>">
                                <input type="hidden" name="process_kind" value="delete_carts">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <div>
                <form action="purchase_confirm.php" method="post">
                <input type="submit" value="購入処理へ進む">
                </form>
                <form action="display_item.php" method="post">
                <input type="submit" value="商品一覧画面へ">
                </form>
            </div>
        </section>
    </body>
</html>