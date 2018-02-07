<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--<link rel="stylesheet" href="reset.css">-->
    <title>商品一覧</title>
    <style>
        body{
            margin:0px;
        }
        .container {
            width:960px;
            margin: 0 auto;
        }
        .item_flex{
            width:1000px;
            display:flex;
            flex-wrap: wrap;
        }
        figure{
            text-align:center;
            margin:0px;
        }
        .img_size{
            width: 130px;
        }
        .red {
            color: #FF0000;
        }
        .black_background_color{                                        
            background-color:#222222;
        }
        .header_flex1{/**/
            display:flex;
        }
        .header_logo{/**/
            flex:1;
            margin-top:10px;
        }
        .header_research{/**/
            flex:1;
            text-align:right;
            margin-top:15px;
        }
        .search_style{
            border-radius:30px;
        }
        .header_flex2{
            display:flex;
        }
        /*リスト編集*/
        ul {
          list-style-type: none;
          margin:0px;
        }
        .li_header {
          flex:1;
          text-align: center;
        }
        .header_link{
            /*文字周囲に等倍余白を設ける設定（3行）*/
            display:block;
            text-align:center;
            margin:3px;
            
            text-decoration:none;
            color:#FFFFFF;
        　  font-weight:bold;
        }
        li:last-child {
          border-right: 0;
        }
        /*about main***********************************************/
        .black_background_color{
            background-color: #000000;
        }
        .red_background_color{
            background-color:#FF0000;
        }
        .mainview_image_height{
            height:400px;
        }
        .headline{
            font-size:40px;
            margin:0px;
        }
        .subhead{
            font-size:20px;
            margin:0px;
        }
        .font_white_color{
            color:#FFFFFF;
        }

        /*about footer*******************************************/
        .footer_flex{
            display:flex;
            margin-top:30px;
            margin-bottom:30px;
        }
        ul{
            list-style:none;
        }
        .li_footer{
            flex:1;
            text-align:center;
            border-right:1px solid #cccccc;
        }
        .a_footer{
            text-decoration:none;
            color:#664433;
            font-weight:bold;
        }
        /*最終リスト調整（navにも適用）*/
        li:last-child{
            border-right:0;
            border-bottom:0;
        }
        .copyright_positon_color{
            text-align:center;
            color:#cccccc;
            margin-bottom:10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="black_background_color">
            <div class="container">
                <ul class="header_flex2">
                    <li class="li_header"><a href="category_list.php" class="header_link">カテゴリ一覧</a></li>
                    <li class="li_header"><a href="display_item_by_category.php?item_type=食品" class="header_link">料理</a></li>
                    <li class="li_header"><a href="display_item_by_category.php?item_type=飲み物" class="header_link">飲み物</a></li>
                    <li class="li_header"><a href="display_item_by_category.php?item_type=貴金属" class="header_link">貴金属</a></li>
                    <li class="li_header"><a href="display_item_by_category.php?item_type=甘い物" class="header_link">甘い物</a></li>
                    <li><input type="search" placeholder="料理名・食材名で検索"></li>
                    <li><input type="submit" value="検索" class="search_style"></li>
                    <li><a href="logout.php">ログアウト</a></li>
                </ul>
            </div>
        </div>
    </header>
    <main>
        <div class="black_background_color">
            <figure>
                <h2 class="headline font_white_color">Luxury</h2>
                <h3 class="subhead font_white_color">記念日に大切な人へ</h3>
                <figcaption><img src="<?php print h(IMG_DIR . $luxury_data[11]['item_img']); ?>" class="mainview_image_height"></figcaption>
            </figure>
        </div>
        <div class="white_background_color">
            <figure>
                <h2 class="headline">Dessert</h2>
                <h3 class="subhead">ご機嫌取りに♪</h3>
                <figcaption><img src="<?php print h(IMG_DIR . $dessert_data[1]['item_img']); ?>" class="mainview_image_height"></figcaption>
            </figure>
        </div>
        <div class="red_background_color">
            <figure>
                <h2 class="headline font_white_color">Food</h2>
                <h3 class="subhead font_white_color">たまにはがっつり食べてもいいかも</h3>
                <figcaption><img src="<?php print h(IMG_DIR . $food_data[3]['item_img']); ?>" class="mainview_image_height"></figcaption>
            </figure>
        </div>
        <!--<div class="container">-->
        <!--    <?php if (count($errors) === 0) { ?>-->
        <!--    <h1>おすすめ商品</h1>-->
        <!--    <a href="category_list.php">カテゴリ一覧へ</a>-->
        <!--    <div class="item_flex">-->
        <!--    <?php foreach ($data as $read)  { ?>-->
        <!--        <a href="display_item_detail.php?item_id=<?php print h($read['item_id']); ?>">-->
        <!--            <figure>-->
        <!--                <img src="<?php print h(IMG_DIR . $read['item_img']); ?>" class="img_size">-->
        <!--                <figcaption><?php print h($read['item_name']); ?></figcaption>-->
        <!--                <figcaption><?php print h($read['item_price']); ?>円</figcaption>-->
        <!--                <?php if ($read['item_stock'] === 0) { ?>-->
        <!--                    <figcaption class="red">売り切れ</figcaption>-->
        <!--                <?php } ?>-->
        <!--            </figure>-->
        <!--        </a>-->
        <!--    <?php } ?>-->
        <!--    </div>-->
        <!--    <?php } else { ?>-->
        <!--        <?php foreach ($errors as $read) { ?>-->
        <!--            <p><?php print h($read); ?></p>-->
        <!--        <?php } ?>-->
        <!--    <?php } ?>-->
        <!--</div>-->
    </main>
    <footer>
        <div class="white_background_color">
            <div class="container">
                <ul class="footer_flex">
                    <li class="li_footer"><a  href="#" class="a_footer">サイトマップ</a></li>
                    <li class="li_footer"><a  href="#" class="a_footer">プライバシーポリシー</a></li>
                    <li class="li_footer"><a  href="#" class="a_footer">お問い合わせ</a></li>
                    <li class="li_footer"><a  href="#" class="a_footer">ご利用ガイド</a></li>
                </ul>
                <p class="copyright_positon_color"><small>Copyright &copy; Printemps0505 All Rights Reserved.</small></p>
            </div>
        </div>
    </footer>
</body>
</html>