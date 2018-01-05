<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>オブジェクト指向</title>
  </head>
  <body>
      <?php
      class Dog {
          public $name;
          public $height;
          public $weight;
          
             //コンストラクタ
            function ＿construct($name, $height, $weight) {//コンストラクタの_がうまく機能していないのか？
                 $this->name = $name;
                 $this->height = $height;
                 $this->weight = $weight;
                 
             }
         
          function show() {
        print "{$this->name}の身長は{$this->height}cm、体重は{$this->weight}kgです。<br>";
      }
      }
      
      // $taroインスタンス
    $taro = new Dog('太郎', 100, 50);
    $taro->show();
      ?>
    </body>
</html>
