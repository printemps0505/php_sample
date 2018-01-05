<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>課題</title>
  </head>
  <body>
    <?php
    // Catクラス定義
    class Cat {
      public $name;
      public $height;
      public $weight;
      
       // コンストラクタ
      function __construct($name, $height, $weight) {
        $this->name   = $name;
        $this->height = $height;
        $this->weight = $weight;
      }
      
      function show() {
        print "{$this->name}の身長は{$this->height}cm、体重は{$this->weight}kgです。<br>";
      }
    }
 
    // $toranekoインスタンス
    $toraneko = new Cat('たま',80,30);
    $toraneko->show();

 
    ?>
  </body>
</html>