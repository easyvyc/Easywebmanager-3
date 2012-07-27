<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="GENERATOR" content="" />

	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/forms.css" />
	<link rel="stylesheet" type="text/css" href="css/layout_1.css" />
	<link rel="stylesheet" type="text/css" href="css/tree.css" />
	
	<base target="content">

	<script language="JavaScript" type="text/javascript" src="js/admin.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/nav.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/tree.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/sorting/prototype.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/sorting/scriptaculous.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/sorting/dragdrop.js"></script>
	
	<script type="text/javascript" src="js/collapse.js"></script>
	
	<script language="JavaScript" type="text/javascript">
		var language_state = '<?php echo $templateVariables->vars["lng"]; ?>';
	</script>

<head/>
<body class="main" oncontextmenu="javascript: return false;">

		<ul class="modulesMain" id="secondlist">
		
		<?php foreach($templateVariables->loops["mod_list_tree"] as $mod_list_tree_key => $mod_list_tree_val){ ?>

		<li class="dragLayer" id="secondlist_secondlist<?php echo $mod_list_tree_val["id"]; ?>">
		<div class="tbltop" <?php if($mod_list_tree_val["is_categories"]){ ?>ondblclick="javascript: togglePannelAnimatedStatus('<?php echo $mod_list_tree_val["table_name"]; ?>_tree_id',10,40);"<?php } ?>>
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="10"></td>
				<td class="round"><img src="images/flag.png" class="png" alt="" class="vam" /></td>
				<td>
		&nbsp;<a style="cursor:pointer;" onclick="javascript: <?php if($mod_list_tree_val["is_categories"]){ ?>togglePannelAnimatedStatus('<?php echo $mod_list_tree_val["table_name"]; ?>_tree_id',10,40); TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.create(0);<?php } ?> parent.content.location='main.php?content=<?php if($mod_list_tree_val["tree"]){ ?>catalog<?php } ?><?php if(!$mod_list_tree_val["tree"]){ ?><?php echo $mod_list_tree_val["table_name"]; ?><?php } ?>&module=<?php echo $mod_list_tree_val["table_name"]; ?>&page=list&id=0';"><?php echo $mod_list_tree_val["title"]; ?></a>
				</td>
				<td align="right">
		<?php if($mod_list_tree_val["is_categories"]){ ?>
		<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('<?php echo $mod_list_tree_val["table_name"]; ?>_tree_id',10,40); <?php if(!$mod_list_tree_val["active"]){ ?>if(!TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.opened) TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.create(0);<?php } ?>"><img id="img_<?php echo $mod_list_tree_val["table_name"]; ?>_tree_id" src="images/<?php if(!$mod_list_tree_val["active"]){ ?>plus<?php } ?><?php if($mod_list_tree_val["active"]){ ?>minus<?php } ?>.gif" border="0" align="absmiddle" vspace="0" hspace="0"></a>&nbsp;
		<?php } ?>
				</td>
			</tr>
		</table>
		</div>
		
		<?php if($mod_list_tree_val["is_categories"]){ ?>
		<div id="<?php echo $mod_list_tree_val["table_name"]; ?>_tree_id" <?php if(!$mod_list_tree_val["active"]){ ?>style="display:none;"<?php } ?>>
		
		<div id="module_tree_<?php echo $mod_list_tree_val["table_name"]; ?>_s"  class="module_tree_box"></div>


		</div>
		<?php } ?>
		
		</li>

<?php if($mod_list_tree_val["is_categories"]){ ?>
<script type="text/javascript">
	
	var TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s = new TreeClass('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["config.admin_dir"]; ?>', 'module_tree', '<?php echo $mod_list_tree_val["table_name"]; ?>', 's', '<?php echo $templateVariables->vars["lng"]; ?>');
	TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.phrases.move_confirm_text = '<?php echo $templateVariables->vars["phrases.move_confirm_text1"]; ?>';
	
	<?php if($mod_list_tree_val["active"]){ ?>
	TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.create(id);
	<?php } ?>

	TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.param.dragndrop = 1;
	TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.param.checkbox = 0;
	TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.param.context = 1;
	
	if($('<?php echo $mod_list_tree_val["table_name"]; ?>_tree_id')){
		if(document.body.addEventListener){
			document.body.addEventListener('contextmenu', TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.mouseRightClick, true);
		}else{
			$('<?php echo $mod_list_tree_val["table_name"]; ?>_tree_id').oncontextmenu = TreeObj_<?php echo $mod_list_tree_val["table_name"]; ?>_s.mouseRightClick;
		}
	}
				
</script>
<?php } ?>

		<?php } ?>


		
<?php if($templateVariables->vars["is_admin_prm"]){ ?>
		<li class="dragLayer" id="secondlist_secondlist_catalog">
		<div class="tbltop" ondblclick="javascript: switchMode('catalog_tree_id');">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="10"></td>
				<td class="round"><img src="images/flag.png" class="png" alt="" class="vam" /></td>
				<td>
		&nbsp;<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('catalog_tree_id',10,40); TreeObj_catalog_c.create(0); parent.content.location='main.php?content=mod&page=modules';"><?php echo $templateVariables->vars["phrases.catalogs"]; ?></a>
				</td>
				<td align="right">
		<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('catalog_tree_id',10,40); if(!TreeObj_catalog_c.opened) TreeObj_catalog_c.create(0);"><img id="img_catalog_tree_id" src="images/plus.gif" border="0" align="absmiddle" vspace="0" hspace="0"></a>&nbsp;
				</td>
			</tr>
		</table>
		</div>
		
		<div id="catalog_tree_id" style="display:none;">
		
		<div id="module_tree_catalog_c"  class="module_tree_box"></div>


		</div>
		
		</li>


<script type="text/javascript">
	
	var TreeObj_catalog_c = new TreeClass('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["config.admin_dir"]; ?>', 'catalog', 'catalog', 'c', '<?php echo $templateVariables->vars["lng"]; ?>');
	//TreeObj_catalog_c.phrases.move_confirm_text = '<?php echo $templateVariables->vars["phrases.move_confirm_text1"]; ?>';
	
	TreeObj_catalog_c.param.dragndrop = 0;
	TreeObj_catalog_c.param.checkbox = 0;
	TreeObj_catalog_c.param.context = 1;
	
	//TreeObj_catalog_c.create(id);
	
	if(document.body.addEventListener){
		document.body.addEventListener('contextmenu', TreeObj_catalog_c.mouseRightClick, true);
	}else{
		$('catalog_tree_id').oncontextmenu = TreeObj_catalog_c.mouseRightClick;
	}

	
				
</script>
<?php } ?>

		
		</ul>


<pre id="secondlist_debug"></pre>

<script type="text/javascript">
 
Sortable.create("secondlist", {dropOnEmpty:true,handle:'tbltop',containment:["secondlist"],constraint:false, onChange:function(){}});

</script>


<div id="contextMenuArea" onmouseout="javascript: hideTreeItemContenxtMenu(event);"></div>

</body>

<?php if($templateVariables->vars["main_reload"]){ ?>
<script language="javascript">
parent.frames.content.location = 'main.php?content=<?php echo $templateVariables->vars["easyweb.content"]; ?>';
</script>
<?php } ?>
</html>
