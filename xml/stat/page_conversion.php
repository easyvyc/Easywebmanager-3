<?php
/*
 * Created on 2010.05.14
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$sql = "SELECT SUM(V.conversion_id)*100/COUNT(V.conversion_id) AS conv, V.visit_time AS title, LEFT(V.visit_time, 10) AS day " .
		" FROM {$configFile->variable['sb_stat_visitor']} V " .
		" WHERE V.robot!=1 ".
		" GROUP BY LEFT(V.visit_time, 10) " .
		" ORDER BY day ";
$database->exec($sql, __FILE__, __LINE__);
$arr = $database->arr();


foreach($arr as $key => $val){
	echo "{$val['day']},{$val['conv']}\r\n";
}

?>
<?php
exit;
?>
