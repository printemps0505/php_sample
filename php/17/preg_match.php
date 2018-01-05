<?php
$subject = "php,perl,apache,Linux";
$pattern = '/apache/';
$match_num = preg_match($pattern, $subject, $matches);
var_dump($match_num);
print "<br>";
var_dump($matches);
?>

<!--結果-->
<!--int(1) -->
<!--array(1) { [0]=> string(6) "apache" }-->