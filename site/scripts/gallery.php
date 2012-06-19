<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

//$photo_obj->sqlQueryWhere = " R.parent_id=0 AND R.is_category=0 AND ";
//$photo_obj->sqlQueryOrder = " ORDER BY RAND() ";
//$photo_obj->sqlQueryLimit = " LIMIT 0, 6 ";

$main_object->create("galerija");
$main_object->set("galerija", "sqlQueryWhere", " R.parent_id=0 AND R.is_category=0 AND ");
$main_object->set("galerija", "sqlQueryOrder", " ORDER BY RAND() ");
$main_object->set("galerija", "sqlQueryLimit", " LIMIT 0, 6 ");
$list = $main_object->call("galerija", "listSearchItems");

?>