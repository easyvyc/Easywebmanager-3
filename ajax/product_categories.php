<?php
/*
 * Created on 2009.09.10
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

//echo '[{value:"AL", text:"Alabama", selected:true}, {value:"AK", text:"Alaska"}, {value:"AZ", text:"Arizona"}, {value:"AR", text:"Arkansas"}, {value:"CA", text:"California"}, {value:"CO", text:"Colorado"}, {value:"CT", text:"Connecticut"}, {value:"DE", text:"Delaware"}, {value:"FL", text:"Florida"}, {value:"GA", text:"Georgia"}, {value:"HI", text:"Hawaii"}, {value:"ID", text:"Idaho"}, {value:"IL", text:"Illinois"}, {value:"IN", text:"Indiana"}, {value:"IA", text:"Iowa"}, {value:"KS", text:"Kansas"}, {value:"KY", text:"Kentucky"}, {value:"LA", text:"Louisiana"}, {value:"ME", text:"Maine"}, {value:"MD", text:"Maryland"}, {value:"MA", text:"Massachusetts"}, {value:"MI", text:"Michigan"}, {value:"MN", text:"Minnesota"}, {value:"MS", text:"Mississippi"}, {value:"MO", text:"Missouri"}, {value:"MT", text:"Montana"}, {value:"NE", text:"Nebraska"}, {value:"NV", text:"Nevada"}, {value:"NH", text:"New Hampshire"}, {value:"NJ", text:"New Jersey"}, {value:"NM", text:"New Mexico"}, {value:"NY", text:"New York"}, {value:"NC", text:"North Carolina"}, {value:"ND", text:"North Dakota"}, {value:"OH", text:"Ohio"}, {value:"OK", text:"Oklahoma"}, {value:"OR", text:"Oregon"}, {value:"PA", text:"Pennsylvania"}, {value:"RI", text:"Rhode Island"}, {value:"SC", text:"South Carolina"}, {value:"SD", text:"South Dakota"}, {value:"TN", text:"Tennessee"}, {value:"TX", text:"Texas"}, {value:"UT", text:"Utah"}, {value:"VT", text:"Vermont"}, {value:"VA", text:"Virginia"}, {value:"WA", text:"Washington"}, {value:"WV", text:"West Virginia"}, {value:"WI", text:"Wisconsin"}, {value:"WY", text:"Wyoming"}]';


include_once(CLASSDIR_."cache.class.php");
$cache_obj = & new cache(CACHEDIR."data/");

//$main_object->call("pages", "listCatalogMenu", 3757);

$page_obj = $main_object->create("pages");

$cache_file = CACHEDIR."data/listCatalogMenu.json.data";

if($cache_obj->is_loadCache($cache_file, $page_obj->module_info['last_modify_time'])){
	echo $cache_obj->getContent($cache_file);
}else{
	$res = $page_obj->listCatalogMenu(3757);
	$data_content = "["; $first = true;
	foreach($res as $i=>$val1){
		if(!$first) $data_content .= ",";
		$first = false;
		$data_content .= "{value:\"{$val1['id']}\", text:\"{$val1['title']}\"}";
		foreach($val1['sub'] as $j=>$val2){
			$data_content .= ",";
			$data_content .= "{value:\"{$val2['id']}\", text:\"&nbsp;&nbsp;{$val2['title']}\"}";
		}
	}
	$data_content .= "]";
	$cache_obj->createCache($cache_file, $data_content);
	echo $data_content;
}
exit;

?>