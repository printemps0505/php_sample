<?php
//変数初期化
$battle = '';
$opponent = array('グー','チョキ','パー');
$result = '';
// $i = '';


// 勝負ボタンがクリックされた場合の処理*********************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //自分処理
    if (isset($_POST['battle']) === TRUE) {//issetにより$_POST['battle'が空でないかどうかを判定
     $battle = htmlspecialchars($_POST['battle'], ENT_QUOTES, 'UTF-8');//セキュリティ対策を施して、変数に代入
    //  $i = mt_rand(0,2);
    }else{
        $battle = '未選択';
    }
}
//***********************************************************************************
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>課題</title>
</head>
<body>
    
    <!--表示内容-->
    <h1>じゃんけん勝負</h1>
    <p>自分：<?php print $battle; ?></p>
    <p>相手：<?php print $opponent[mt_rand(0,2)]; ?></p>

        
    <!--<p>相手：<?php print $opponent[$i]; ?></p>-->

    
    <!--自分処理-->
    <?php if ($battle === 'グー'){
            $battle = 'グー';
        }else if ($battle === 'チョキ'){
            $battle = 'チョキ';  
        }else if ($battle === 'パー'){
            $battle = 'パー';
        }
    ?>
    
    <!--結果処理-->
     <?php if (($battle === 'グー' && $opponent[1]) || ($battle === 'チョキ' && $opponent[2]) || ($battle === 'パー' && $opponent[0])){
            $result = 'win!!';
        }else if (($battle === 'グー' && $opponent[2]) || ($battle === 'チョキ' && $opponent[0]) || ($battle === 'パー' && $opponent[1])){
            $result = 'lose..';  
        }else{
            $result = 'draw';
            
        }
        // var_dump($result);
        ?>
        
        <p>結果：<?php print $result; ?></p>
        
    
     <!--form-->    
    <form method="post">
        <p><input type="radio" name="battle" value="グー" <?php if ($battle === 'グー') { print 'checked'; } ?>>グー
          <input type="radio" name="battle" value="チョキ" <?php if ($battle === 'チョキ') { print 'checked'; } ?>>チョキ
          <input type="radio" name="battle" value="パー" <?php if ($battle === 'パー') { print 'checked'; } ?>>パー</p>
          <input type="submit" name="submit" value="勝負!">
      </form>
</body>
</html>