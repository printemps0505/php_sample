<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta varchar="utf-8">
        <title>自動販売機</title>
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
        </style>
    </head>
    <body>
    <section class="black_under_line">
        <h1>自動販売機管理ツール</h1>
        <!--エラー表示処理-->
            <?php foreach ($errors as $value) { ?>
                <p><?php print h($value); ?></p>
            <?php } ?>
            <?php foreach ($success as $result) { ?>
                <p><?php print h($result); ?></p>
            <?php } ?>
    </section>
    <section class="black_under_line under-space">
        <h3>新規商品追加</h3>
        <form method="post" enctype="multipart/form-data">
            <div><label>名前：<input type="text" name="form_product_name" value=""></label></div>
            <div><label>値段：<input type="text" name="form_product_price" value=""></label></div>
            <div><label>個数：<input type="text" name="form_product_stock" value=""></label></div>
            <div><input type="file" name="form_product_img"></div>
            <div>
                <select name="form_product_status"  class="top-space">
                    <option value="1">公開</option>
                    <option value="0">非公開</option>
                </select>
            </div>
            <input type="hidden" name="process_kind" value="register_product">
            <div><input type="submit" name="submit" value="商品を追加" class="style top-space"></div>
        </form>
    </section>
    <section>
        <h3>商品情報変更</h3>
        <p>商品一覧</p>
        <table>
            <tr>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>ステータス</th>
            </tr>
            <?php foreach ($data as $reads)  { ?>
            <?php if ($reads['master_drink_status'] === '1') { ?>
                <tr>
            <?php } else { ?>
                <tr class="status_false">
            <?php } ?>
                <form method="post">
                    <input type="hidden" name="form_product_id" value="<?php print $reads['master_drink_id']; ?>">
                    <td><img src="<?php print h(IMG_DIR.$reads['master_drink_img']); ?>" class="img_size"></td>
                    <td><?php print h($reads['master_drink_name']); ?></td>
                    <td><?php print h($reads['master_drink_price']); ?>円</td>
                    <td><input type="text"　class="form_size" name="form_update_stock" value=<?php print h($reads['stock_drink_stock']); ?>>個&nbsp;&nbsp;<input type="submit" value="変更"></td>
                    <input type="hidden" name="process_kind" value="update_stock">
                </form>
                <form method="post">
                    <input type="hidden" name="form_product_id" value="<?php print $reads['master_drink_id']; ?>">
                        <?php if ($reads['master_drink_status'] === '1') { ?>
                            <td><input type="submit" value="公開 → 非公開"></td>
                            <input type="hidden" name="form_change_status" value="0">
                        <?php } else { ?>
                            <td><input type="submit" value="非公開 → 公開"></td>
                            <input type="hidden" name="form_change_status" value="1">
                        <?php } ?>
                        <input type="hidden" name="process_kind" value="change_status">
                </form>
            </tr>
            <?php } ?>
        </table>
    </section>
    </body>
</html>