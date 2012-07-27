<?php
/*
 * Created on 2007.08.01
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


//include_once(CLASSDIR_."modules/poles.class.php");
//$vote_record = new poles("polls");


if(isset($_POST['action'])&&$_POST['action']=='poles'&&$_SESSION['user']['poles']!=1){
	//$vote_record->saveVote($_POST);
	$main_object->call("polls", "saveVote", array($_POST));
	$_SESSION['user']['poles'] = 1;
}


//$vote_record->sqlQueryWhere = " T.activated=1 AND R.is_category=1 AND ";
//$v_list = $vote_record->listSearchItems();

$main_object->set("polls", "sqlQueryWhere", " T.activated=1 AND R.is_category=1 AND ");
$v_list = $main_object->call("polls", "listSearchItems");

$tpl->setVar('empty_votes', empty($v_list)?1:0);

if(isset($v_list[0]['id'])){

	$v_list[0]['results'] = @$_SESSION['user']['poles'];
	$tpl->setVar('voting', $v_list[0]);
//	$vote_record->sqlQueryWhere = " R.is_category=0 AND R.parent_id={$v_list[0]['id']} AND ";
//	$v_list = $vote_record->listSearchItems();

	$main_object->set("polls", "sqlQueryWhere", " R.is_category=0 AND R.parent_id={$v_list[0]['id']} AND ");
	$v_list = $main_object->call("polls", "listSearchItems");

	$n = count($v_list);
	for($i=0, $all_votes=0; $i<$n; $i++){
		$all_votes += $v_list[$i]['vote_count'];
	}
	for($i=0; $i<$n; $i++){
		$v_list[$i]['green'] = round($v_list[$i]['vote_count']*100/$all_votes);
		$v_list[$i]['red'] = 100 - $v_list[$i]['green']; 
	}
	$tpl->setLoop('votes', $v_list);

}

?>