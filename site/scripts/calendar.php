<?php
/*
 * Created on 2007.09.25
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$tpl_block_calendar = & new easytpl(TPLDIR_."templates/blocks/calendar.tpl", "templateVariables", CACHETPLDIR_);




$tpl_block_header_c = & new easytpl(TPLDIR_."templates/blocks/header.tpl", "templateVariables", CACHETPLDIR_);
$tpl_block_header_c->setFastVar('block_name', 'calendar');
$tpl_block_header_c->setVar('header_title.calendar', $phrases['title_main_calendar']);

$tpl_block_header_c->parse();
$tpl_block_calendar->setCodeBlock('block_calendar_header', 'include $tpl_block_header_c->cacheFile;');


$tpl_part_calendar = & new easytpl(TPLDIR_."templates/parts/calendar.tpl", "templateVariables", CACHETPLDIR_);


$CALENDAR['year'] = date("Y");
$CALENDAR['month'] = date("m");
$CALENDAR['day'] = date("d");
include(TPLDIR_."templates/parts/calendar.php");
$tpl_block_calendar->setCodeBlock('part_calendar', 'include $tpl_part_calendar->cacheFile;');



$tpl_block_calendar->parse();
$tpl->setCodeBlock('block_calendar', 'include $tpl_block_calendar->cacheFile;');

?>