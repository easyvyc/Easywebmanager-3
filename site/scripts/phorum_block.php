<?php
/*
 * Created on 2007.1.25
 * phorum_block.php
 * Vytautas
 */
 

$forum_obj = & new catalog("diskusijos");
/*
$forum_obj->fields = " U.loginname AS author_, IF(LENGTH(T.title)>50, CONCAT(SUBSTRING(T.title, 1, 47), '...'), T.title) AS short_title, SUBSTRING(R.create_date, 6, 11) AS insert_date, COUNT(IR.id) AS inner_count,  ";
$forum_obj->sqlQueryWhere = " R.parent_id!=0 AND R.is_category=1 AND T.active=1 AND ";
$forum_obj->sqlQueryJoin = " LEFT JOIN cms_record IR ON (IR.parent_id=R.id) " .
							" LEFT JOIN {$configFile->variable['sb_relations']} F ON (F.item_id=R.id) " .
							" LEFT JOIN cms_users U ON (F.list_item_id=U.record_id) ";
$forum_obj->sqlQueryOrder = " R.create_date DESC ";
$forum_obj->sqlQueryGroup = " GROUP BY R.id ";
$news_list = $forum_obj->listSearchItems(0, 5);
*/

$forum_obj->fields = " T2.title AS category_title, IF(LENGTH(T.title)>50, CONCAT(SUBSTRING(T.title, 1, 47), '...'), T.title) AS short_title, COUNT(R1.id) AS inner_count, MAX(R1.create_date) AS MAX_DATE, SUBSTRING(MAX(R1.create_date), 6, 11) AS insert_date, ";
$forum_obj->sqlQueryWhere = " R.is_category=1 AND R.parent_id!=0 AND T1.active=1 AND T.lng='$lng' AND ";
$forum_obj->sqlQueryJoins = " LEFT JOIN {$forum_obj->tables['record']} R1 ON (R.id=R1.parent_id) " .
							" LEFT JOIN {$forum_obj->tables['record']} R2 ON (R.parent_id=R2.id) " .
							" LEFT JOIN cms_diskusijos T1 ON (R1.id=T1.record_id AND T1.lng='$lng') " .
							" LEFT JOIN cms_diskusijos T2 ON (R2.id=T2.record_id AND T2.lng='$lng') ";
$forum_obj->sqlQueryGroup = " GROUP BY R.id  ";
$forum_obj->sqlQueryOrder = " ORDER BY MAX_DATE DESC ";
$forum_obj->sqlQueryLimit = " LIMIT 0, 5";
$news_list = $forum_obj->listSearchItems();

//	pae($news_list);
$n = count($news_list); //$user_object = & new catalog("users");
for($i=0; $i<$n; $i++){
	$forum_obj->fields = " U.loginname,";
	$forum_obj->sqlQueryJoins = " LEFT JOIN cms_turizmas U ON (T.author=U.record_id) ";
	$forum_obj->sqlQueryWhere = " R.is_category=0 AND R.parent_id={$news_list[$i]['id']} AND R.create_date='{$news_list[$i]['MAX_DATE']}' AND ";
	$lst = $forum_obj->listSearchItems(0,1);
	$news_list[$i]['author_'] = $lst[0]['loginname'];
}
$tpl->setLoop('newest_phorum_items', $news_list);
//pae($news_list);

?>
