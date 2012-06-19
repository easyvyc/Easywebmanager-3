<?php

$tpl_inner = & new easytpl(TPLDIR_."blocks/user_info.tpl", "templateVariables");
$record = $user_obj = $main_object->create("users");



$tpl_inner->setVar('get', $_GET);
$tpl_inner->setVar('phrases', $phrases);
include $tpl_inner->parse();
exit;

?>