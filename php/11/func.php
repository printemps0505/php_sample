<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>ユーザー定義関数</title>
  </head>
  <body>
      <pre>
          <?php
          //定義関数呼び出し
          print_hello();
          print_hello_name('山田');
          $return_hello_name = return_hello_name('鈴木');//return_hello_name関数が実行され、$strが戻り値として返ってくる。
          
          print $return_hello_name . "\n";
          
        function print_hello() {
            print 'print_hello関数: hello' . "\n";
        }
        function print_hello_name($name) {//returnを使用しないパターン
            print 'print_hello_name関数: hello ' . $name . "\n";
        }
        function return_hello_name($name) {//returnを使用するパターン
           $str = 'return_hello_name関数: hello ' . $name . "\n";
           return $str;
        //   return 'return_hello_name関数: hello ' . $name . "\n";これの方がすっきり
        }
          ?>
          
      </pre>
  </body>
  </html>
  
  <!--一行目に不可解な空白が入る-->