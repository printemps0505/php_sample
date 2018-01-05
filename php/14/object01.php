<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>オブジェクト指向</title>
        
    </head>
    <body>
        <?php
        //Dogクラス定義
        class Dog {
            public $name;
            public $height;
            public $weight;
            function show(){
                print "{$this->name}の身長は{$this->height}cm、体重は{$this->weight}です。<br>";//<brで>htmlで見ると改行されるされるようになる
            }
        }
        
        //$taroインスタンス
        $taro = new Dog();//インスタンス生成
        $taro->name = '太郎';//プロパティ設定
        $taro->height = '100';
        $taro->weight = '50';
        $taro->show();//メソッド呼び出し
        
        //$jiroインスタンス
        $jiro = new Dog();
        $jiro->name = '次郎';
        $jiro->height = '90';
        $jiro->weight = '45';
        $jiro->show();
        ?>
    </body>
</html>