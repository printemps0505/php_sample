<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta charset="UTF-8">
        <title>商品管理</title>
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
            <h1>商品管理ツール</h1>
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
                <div>
                    <select name="item_type" class="top-space">
                        <?php foreach ($item_types as $results) { ?>
                            <option value="<?php print h($results); ?>"><?php print h($results); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div><input type="file" name="item_img" class="top-space"></div>
                <div><label>名前：<input type="text" name="item_name" value=""></label></div>
                <div><label>値段：<input type="text" name="item_price" value=""></label></div>
                <div><label>個数：<input type="text" name="item_stock" value=""></label></div>
                <div><label>詳細：<textarea name="item_comment"></textarea></label></div>
                <div>
                    <select name="item_status" class="top-space">
                        <option value="0">非公開</option>
                        <option value="1">公開</option>
                    </select>
                </div>
                <input type="hidden" name="process_kind" value="insert_item">
                <div><input type="submit" name="submit" value="商品を追加" class="style top-space"></div>
            </form>
        </section>
        <section>
            <h3>商品情報変更</h3>
            <p>商品一覧</p>
            <table>
                <tr>
                    <th>カテゴリ</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>詳細</th>
                    <th>ステータス</th>
                </tr>
                <?php foreach ($rows as $reads)  { ?>
                <?php if ($reads['item_status'] === 1) { ?>
                    <tr>
                <?php } else { ?>
                    <tr class="status_false">
                <?php } ?>
                        <td>
                            <form method="post">
                                <input type="hidden" name="item_id" value="<?php print h($reads['item_id']); ?>">
                                <p>現在のステータス:<?php print h($reads['item_type']); ?></p>
                                <select name="item_type" class="top-space">
                                    <?php foreach ($item_types as $results) { ?>
                                        <option value="<?php print h($results); ?>"><?php print h($results); ?></option>
                                    <?php } ?>
                                    <input type="submit" value="変更">
                                    <input type="hidden" name="process_kind" value="change_type">
                                </select>
                            </form>
                        </td>
                        <td><img src="<?php print h(IMG_DIR . $reads['item_img']); ?>" class="img_size"></td>
                        <td><?php print h($reads['item_name']); ?></td>
                        <td><?php print h($reads['item_price']); ?>円</td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="item_id" value="<?php print h($reads['item_id']); ?>">
                                <input type="text" class="form_size" name="item_stock" value=<?php print h($reads['item_stock']); ?>>個
                                <input type="submit" value="変更">
                                <input type="hidden" name="process_kind" value="update_stock">
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="item_id" value="<?php print h($reads['item_id']); ?>">
                                <textarea class="form_size" name="item_comment"><?php print h($reads['item_comment']); ?></textarea>
                                <input type="submit" value="変更">
                                <input type="hidden" name="process_kind" value="update_comment">
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="item_id" value="<?php print $reads['item_id']; ?>">
                                <?php if ($reads['item_status'] === 1) { ?>
                                    <input type="submit" value="公開 → 非公開">
                                    <input type="hidden" name="item_status" value="0">
                                <?php } else { ?>
                                    <input type="submit" value="非公開 → 公開">
                                    <input type="hidden" name="item_status" value="1">
                                <?php } ?>
                                <input type="hidden" name="process_kind" value="change_status">
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="item_id" value="<?php print $reads['item_id']; ?>">
                                <input type="submit" value="削除">
                                <input type="hidden" name="process_kind" value="delete">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </section>
    </body>
</html>