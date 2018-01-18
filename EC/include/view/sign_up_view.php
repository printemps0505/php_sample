<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録</title>
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
                名前
                <input type="text" name="name" >
            </label>
        </div>
        <div>
            <label>
                フリガナ    
                <input type="text" name="name_kana" >
            </label>
        </div>
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
        <div>
            <label>
                もう一度パスワードを入力してください
                <input type="text" name="password_confirm" >
            </label>
        </div>
        <div>
            <label>
                郵便番号
                <input type="text" name="zip_code" placeholder="012-3456">
            </label>
        </div>
        <div>
            <label>
                住所(番地まで)
                <input type="text" name="address" >
            </label>
        </div>
        <div>
            <label>
                住所(番地以降)
                <input type="text" name="address_detail" >
            </label>
        </div>
        <div>
            <label>
                電話番号
                <input type="text" name="telephone" >
            </label>
        </div>
        <input type="submit" value="アカウント作成">
    </form>
</body>
</html>