<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="GENERATOR" content="" />
	<title>easywebmanager <?php echo $templateVariables->vars["easyweb_version"]; ?></title>
	
	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/forms.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/layout_1.css" />
	<link rel="stylesheet" type="text/css" href="css/tree.css" />
	<link rel="stylesheet" type="text/css" href="css/grid.css" />
	<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="css/pages.css" />
	
	<link rel="stylesheet" type="text/css" href="css/<?php echo $templateVariables->vars["get.content"]; ?>.css" />
	
	<script src="js/cookie.js" type="text/javascript"></script>
	<script src="js/admin.js" type="text/javascript"></script>
	<script src="js/window.js" type="text/javascript"></script>
	<script src="js/xmlhttprequest.js" type="text/javascript"></script>
	<script src="js/settings.js" type="text/javascript"></script>
	
	<script src="js/xmlsax/xmlsax.js" type="text/javascript"></script>
	<script src="js/xmlsax/scripts.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/listChangeFields.js" type="text/javascript"></script>

	<script src="js/tree.js" type="text/javascript"></script>
	
	<script src="js/sorting/prototype.js" type="text/javascript"></script>
	<script src="js/sorting/scriptaculous.js" type="text/javascript"></script>
	
	<script src="js/sorting/AutoComplete.js" type="text/javascript"></script>
	
	<script src="js/popup.js" type="text/javascript"></script>
	<script src="js/nav.js" type="text/javascript"></script>
	
	<script src="js/grid.js" type="text/javascript"></script>
	
	<script src="js/collapse.js" type="text/javascript"></script>
	
	<script src="js/datepicker.js" type="text/javascript"></script>
	
	<!--script src="js/resize.js" type="text/javascript"></script-->
	
	<script src="js/tablednd.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="lib/flv/swfobject.js"></script>
	
	<script type="text/javascript" src="lib/swfupload/swfupload.js"></script>
	<script type="text/javascript" src="lib/swfupload/handlers.js"></script>
	
	<script type="text/javascript">
	
	var edited_element = <?php if(!$templateVariables->vars["is_edited_element"]){ ?>false<?php } ?><?php if($templateVariables->vars["is_edited_element"]){ ?>true<?php } ?>;
	var languageCode = '<?php echo $templateVariables->vars["config.admin_interface_language"]; ?>';

	var selected = (sel=getCookie('selected')) ? sel : false;
	var first_id = (fid=getCookie('first_id')) ? fid : 0;
	//var parent_id = (pid=getCookie('parent_id')) ? pid : 0;
	
	var overRowColor = '#E9E9E9';
	var outRowColor = '#F3F3F3';
	
	var CONFIG_SITE_URL = '<?php echo $templateVariables->vars["config.site_url"]; ?>';
	
	var SystemMessages = new Array;
	SystemMessages[0] = '<?php echo $templateVariables->vars["phrases.system.server_error"]; ?>';
	SystemMessages[1] = '<?php echo $templateVariables->vars["phrases.system.system_error"]; ?>';
	SystemMessages[2] = '<?php echo $templateVariables->vars["phrases.system.wrong_ftp_data"]; ?>';
	
	</script>
	
	
<head/>
<body class="main" style="margin:0px;" scroll="auto" onbeforeunload="javascript: is_edited_element('<?php echo $templateVariables->vars["phrases.before_unload_text"]; ?>');"  oncontextmenu="javascript: return false;">

<div id="LOADING_overlay" style="display:none;">
<br /><br /><br /><br />
<?php echo $templateVariables->vars["phrases.common.loading"]; ?>
</div>

<?php if(!$templateVariables->vars["filter_module"]){ ?>
<div class="tbltop" id="languagesBar">
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="10"></td>
		<td>
			<?php echo $templateVariables->vars["module.title"]; ?>&nbsp;
			<?php if($templateVariables->vars["show_video_help"]){ ?>
			<a href="javascript: void(show('page_video_help'));" title="<?php echo $templateVariables->vars["phrases.common.video_help"]; ?>" id="show_video_help_link">&nbsp;</a>
			<?php } ?>
		</td>
		<td></td>
		
		<?php foreach($templateVariables->loops["languages"] as $languages_key => $languages_val){ ?>
		<td class="lang<?php if($languages_val["active"]){ ?> round<?php } ?>">
		<?php if($templateVariables->vars["filter_module"]){ ?>
		<a href="main.php?<?php echo $templateVariables->vars["QUERY_STRING"]; ?>&filter_lang=<?php echo $languages_val["lng"]; ?>"><?php echo $languages_val["lng"]; ?></a>
		<?php } ?>
		
		<?php if(!$templateVariables->vars["filter_module"]){ ?>
		<a href="top.php?lng=<?php echo $languages_val["lng"]; ?>" target="toper"><?php echo $languages_val["lng"]; ?></a>
		<?php } ?>
		
		</td>
		<?php } ?>
		
		<td width="10"></td>
	</tr>
</table>
</div>
<?php } ?>

<?php if(!$templateVariables->vars["filter_module"]){ ?>
<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
	
	<tr>
		<td height="25"></td>
	</tr>
	
	<tr>
		<td align="left" valign="top" style="padding:10px;" id="inner_content">
<?php } ?>


<?php include $tpl->cacheFile; ?>

<?php if(!$templateVariables->vars["filter_module"]){ ?>
		</td>
	</tr>
</table>
<?php } ?>

<?php if($templateVariables->vars["show_video_help"]){ ?>
<div class="formElementsFieldWYSIWYG" id="page_video_help">

	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('page_video_help_id',10,40);" id="page_video_help_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td align="left">
	&nbsp;<span style="cursor:default;" ><?php echo $templateVariables->vars["phrases.common.video_help"]; ?></span>
			</td>
			<td align="right">
	<a style="cursor:pointer;" onclick="javascript: document.getElementById('page_video_help').style.display='none';" ><img src="images/close.gif" border="0" style="vertical-align:middle;" vspace="0" hspace="0" alt="" /></a>&nbsp;
			</td>
		</tr>
	</table>
	</div>
	
	
	<div id="page_video_help_id">
		<object id="flv_container_pages" height="337" width="640" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
		<param value="lib/flv/player.swf" name="movie" />
		<param value="transparent" name="wmode" />
		<param value="true" name="allowfullscreen" />
		<param value="always" name="allowscriptaccess" />
		<param value="file=<?php echo $templateVariables->vars["show_video_help"]; ?>" name="flashvars" /><!--[if !IE]>--><object height="337" width="640" data="lib/flv/player.swf" type="application/x-shockwave-flash">
		<param value="transparent" name="wmode" />
		<param value="true" name="allowfullscreen" />
		<param value="always" name="allowscriptaccess" />
		<param value="file=<?php echo $templateVariables->vars["show_video_help"]; ?>" name="flashvars" /><!--<![endif]--><!--[if !IE]>--></object><!--<![endif]--></object>	
	</div>
	
</div>

<script type="text/javascript">
popup_show('page_video_help', 'page_video_help_drag', '', 'screen-top', 10, 250);
</script>
<?php } ?>


<div id="NORIGHTS_overlay" style="<?php if(!$templateVariables->vars["no_permission_block"]){ ?>display:none;<?php } ?>">
<br /><br /><br /><br />
<?php echo $templateVariables->vars["phrases.common.no_rights"]; ?>
</div>



<div id="SysMsg">
	<span id="SysMsg_text"></span><br /><br />
	<input type="button" value="<?php echo $templateVariables->vars["phrases.common.close"]; ?>" onclick="javascript: closeSystemMessage();" class="vam btn" />
</div>

<!--[if lte IE 6]> 
<link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]--> 	

</body>

</html>

<?php if($templateVariables->vars["filter_module"]){ ?>
<script type="text/javascript">
	//setIframeHeight('list_iframe_<?php echo $templateVariables->vars["get.parent_column"]; ?>');
</script>
<?php } ?>

<script type="text/javascript">
	<?php if($templateVariables->vars["restart_session"]){ ?>
	//window.showModalDialog("frame.php?url=login.php?session_restart=1", "", "dialogWidth:370px; dialogHeight:300px; center:yes");
	top.content.showLoginForm();
	<?php } ?>
</script>