<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta charset="UTF-8">
        <title>購入前確認</title>
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
            <h1>以下の内容で購入しますか？</h1>
             <!--エラー表示処理-->
            <?php foreach ($errors as $value) { ?>
                <p><?php print h($value); ?></p>
            <?php } ?>
        </section>
        <section class="flex">
            <table>
                <?php foreach ($data as $reads)  { ?>
                    <tr>
                        <td><img src="<?php print h(IMG_DIR . $reads['item_img']); ?>" class="img_size"></td>
                        <td><?php print h($reads['item_name']); ?></td>
                        <td><?php print h($reads['item_price']); ?>円</td>
                        <td><?php print h($reads['carts_amount']); ?>個</td>
                    </tr>
                <?php } ?>
            </table>
            <div><h3>合計金額：<?php print h($sum_price); ?>円</3></div>
            <div>
                <form action="purchase.php" method="post">
                <input type="submit" value="購入を確定する">
                </form>
                <p></p>
                <p></p>
                <form action="cart_list.php" method="post">
                <input type="submit" value="中身を編集する">
                </form>
                <form action="display_item.php" method="post">
                <input type="submit" value="トップページへ">
                </form>
            </div>
        </section>
    </body>
</html>