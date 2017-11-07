<?php
$i = 1900;
$date = date('Y'); // 現在の西暦を取得
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ループの使用例</title>
</head>
<body>
    <form aciton="#">
    生まれた西暦を選択してください
    <select name="born_year">
        <?php
            while ($i <= $date){
        ?>
            <option value="<?php print $i; ?>"><?php print $i; ?>年</option>
        <?php
            $i++;
        }?>
    </select>
</body>
</html>