<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>カテゴリ一覧</title>
</head>
<body>
    <h1>カテゴリ一覧</h1>
    <section>
        <?php foreach($item_types as $reads){ ?>
            <a href="display_item_by_category.php?item_type=<?php print h($reads['item_type']); ?>">
                <?php print h($reads['item_type']); ?><br />
            </a>
        <?php } ?>
    </section>
    <section>
        <a href="logout.php" class="logout">ログアウト</a>
    </section>
</body>
</html>