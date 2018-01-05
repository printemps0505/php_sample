<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>自動販売機</title>
    <style>
        section {
            margin-bottom: 20px;
            border-top: solid 1px;
        }

        table {
            width: 660px;
            border-collapse: collapse;
        }

        table, tr, th, td {
            border: solid 1px;
            padding: 10px;
            text-align: center;
        }

        caption {
            text-align: left;
        }

        .text_align_right {
            text-align: right;
        }

        .drink_name_width {
            width: 100px;
        }

        .input_text_width {
            width: 60px;
        }

        .status_false {
            background-color: #A9A9A9;
        }
        .drink_image{
            height:200px;
        }
    </style>
</head>
<body>
<?php if (empty($result_msg) !== TRUE) { ?>
    <p><?php print $result_msg; ?></p>
<?php } ?>
<?php foreach ($err_msg as $value) { ?>
    <p><?php print $value; ?></p>
<?php } ?>
    <h1>自動販売機管理ツール</h1>
    <section>
        <h2>新規商品追加</h2>
        <form method="post" enctype="multipart/form-data">
            <div><label>名前: <input type="text" name="new_name" value=""></label></div>
            <div><label>値段: <input type="text" name="new_price" value=""></label></div>
            <div><label>個数: <input type="text" name="new_stock" value=""></label></div>
            <div><input type="file" name="new_img"></div>
            <p>
                <select name="new_status">
                    <option value="0">非公開</option>
                    <option value="1">公開</option>
                </select>
            </p>
            <input type="hidden" name="sql_kind" value="insert">
            <div><input type="submit" value="■□■□■商品追加■□■□■"></div>
        </form>
    </section>
    <section>
        <h2>商品情報変更</h2>
        <table>
            <caption>商品一覧</caption>
            <tr>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>ステータス</th>
            </tr>
<?php foreach ($data as $value)  { ?>
<?php if ($value['status'] === '1') { ?>
            <tr>
<?php } else { ?>
            <tr class="status_false">
<?php } ?>
                <form method="post">
                    <td><img class="drink_image" src="<?php print IMG_DIR . $value['img']; ?>"></td>
                    <td class="drink_name_width"><?php print $value['drink_name']; ?></td>
                    <td class="text_align_right"><?php print $value['price']; ?>円</td>
                    <td><input type="text"  class="input_text_width text_align_right" name="update_stock" value="<?php print $value['stock']; ?>">個&nbsp;&nbsp;<input type="submit" value="変更"></td>
                    <input type="hidden" name="drink_id" value="<?php print $value['drink_id']; ?>">
                    <input type="hidden" name="sql_kind" value="update">
                </form>
                <form method="post">
<?php if ($value['status'] === '1') { ?>
                    <td><input type="submit" value="公開 → 非公開"></td>
                    <input type="hidden" name="change_status" value="0">
<?php } else { ?>
                    <td><input type="submit" value="非公開 → 公開"></td>
                    <input type="hidden" name="change_status" value="1">
<?php } ?>
                    <input type="hidden" name="drink_id" value="<?php print $value['drink_id']; ?>">
                    <input type="hidden" name="sql_kind" value="change">
                </form>
            <tr>
<?php } ?>
        </table>
    </section>
</body>
</html>