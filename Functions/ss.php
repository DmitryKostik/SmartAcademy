<?php

$a = '12345';
$str1 = 1;
$str2 = 12;
$str3 = 13;
// This works:
echo "<br>qwe{$a}rty"; // qwe12345rty, using braces
echo "<br>qwe" . $a . "rty"; // qwe12345rty, concatenation used

// Does not work:
echo '<br>qwe{$a}rty'; // qwe{$a}rty, single quotes are not parsed
echo "<br>qwe$arty"; // qwe, because $a became $arty, which is undefined
echo "<br>{$str1}{$str2}{$str3}"; // one concat = fast
echo  $str1. $str2. $str3;   // two concats = slow

?>
