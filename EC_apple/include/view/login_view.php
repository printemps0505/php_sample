<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログイン</title>
</head>
<body>
    <?php if(count($errors === 0)){ ?>
        <?php foreach($errors as $reads){ ?>
            <p><?php print h($reads); ?></p>
        <?php } ?>
    <?php } ?>
    <form method="post">
        <div>
            <label>
                Eメールアドレス
                <input type="text" name="email_address" >
            </label>
        </div>
        <div>
            <label>
                パスワード
                <input type="text" name="password" >
            </label>
        </div>
        
        <input type="submit" value="ログイン">
    </form>
    <a href="sign_up.php" class="sign_up">会員登録</a>
</body>
</html>