<?php
/*
 * Created on 2006.11.13
 * debug.php
 * Vytautas
 */

echo "<div class='clear'></div>";
echo "<div style='font-size:10px;text-align:left;padding:5px;'>";

echo "<b>MySQL debug:</b><br> ".$database->debugger['info']['query']."<br>";
echo "<b>MySQL execution time:</b> ".$database->debugger['info']['time']."<br><br><br>";

echo "<b>TPL debug:</b><br> ".$_SESSION['tpl_debugger_info']."<br>";
echo "<b>TPL execution time:</b> ".$_SESSION['tpl_debugger_all_time']."<br><br><br>";

$TIME_END = getmicrotime();
$TIME = $TIME_END - $TIME_START;

echo "All time: $TIME";

echo "</div>";

unset($_SESSION['tpl_debugger_info']);
unset($_SESSION['tpl_debugger_all_time']);

?>
