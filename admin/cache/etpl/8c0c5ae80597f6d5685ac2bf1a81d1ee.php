<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	<tr>
		<td>

<?php if(!$templateVariables->vars["filter_module"]){ ?>
<?php if($templateVariables->vars["main_menu_block"]){ ?>
<?php include $tpl_menu->cacheFile; ?>
<br />
<?php } ?>

<?php include $tpl_path->cacheFile; ?>
<?php } ?>

<div style="width:100%;">
		
	<div class="modulesMain" id="secondlist" style="width:100%;">
	



		<!--div class="block_title" ondblclick="javascript: switchMode('categories_list');">
		<table width="100%" cellpadding="0" cellspacing="4" border="0">
			<tr>
				<td>
			&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('categories_list');"><b><?php echo $templateVariables->vars["phrases.catalog.categories_list"]; ?></b></a> <span style="font-weight:normal;"><?php if($templateVariables->vars["not_empty_categories"]){ ?>(<?php echo $templateVariables->vars["not_empty_categories"]; ?>)<?php } ?><?php if(!$templateVariables->vars["not_empty_categories"]){ ?>(<?php echo $templateVariables->vars["phrases.catalog.empty_categories"]; ?>)<?php } ?></span> 
				</td>
				<td align="right">
			<a href="javascript: switchMode('categories_list');"><img id="img_categories_list" src="images/minus.gif" border="0" align="absmiddle" vspace="0" hspace="0"></a>&nbsp;
				</td>
			</tr>
		</table>
		</div-->
		
		<div id="categories_list">

	<div style="padding-top:10px;padding-bottom:10px;">
		
		<table class="list_menu" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			
			<?php if(!$templateVariables->vars["module.forbid_delete"]){ ?>
			
			<?php foreach($templateVariables->loops["mod_actions"] as $mod_actions_key => $mod_actions_val){ ?>
			<td id="__<?php echo $mod_actions_val["name"]; ?>">
			<a href="javascript: void(eval('<?php echo $mod_actions_val["action"]; ?>'));" class="path"><img src="images/<?php echo $mod_actions_val["img"]; ?>.gif" border="0" class="vam" /> <?php echo $mod_actions_val["title"]; ?></a>
			</td>
			<td width="1">&nbsp;</td>
			<?php } ?>			
	
			<?php } ?>
			
			<td width="99%">&nbsp;</td>
			
			</tr>
		</table>
		<div id="EDIT_area__action" class="list_menu_area"></div>
		<div id="close_EDIT_area" class="switch_area" onclick="javascript: togglePannelAnimatedStatus('EDIT_area__action',10,40);" onmouseover="javascript: if($('EDIT_area__action').style.display!='none') this.className='switch_area_close'; else  this.className='switch_area_open';" onmouseout="javascript: this.className='switch_area';"></div>

		<script type="text/javascript">

			var mod_actions = new Array;
			<?php foreach($templateVariables->loops["mod_actions"] as $mod_actions_key => $mod_actions_val){ ?>
			mod_actions[mod_actions.length] = '<?php echo $mod_actions_val["name"]; ?>';
			if(location.hash=='#<?php echo $mod_actions_val["name"]; ?>'){ PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions&action=<?php echo $mod_actions_val["name"]; ?>&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["get.id"]; ?><?php if($templateVariables->vars["filter_module"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', 'EDIT_area__action', '<?php echo $mod_actions_val["name"]; ?>'); }
			<?php } ?>

		</script>

		
	</div>

		

<?php if($templateVariables->vars["no"]){ ?>
	<div style="padding-top:10px;padding-bottom:10px;" id="LIST_menu">
		
		<table class="list_menu" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			
			<?php if(!$templateVariables->vars["module.forbid_delete"]){ ?>
			
			
			<td id="__newinner">
			<a href="javascript: void(PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/edit&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=0&parent_id=<?php echo $templateVariables->vars["parent_id"]; ?>&new=1', 'LIST_area__action', 'newinner'));" class="path"><img src="images/new_element.gif" border="0" class="vam" /> <?php echo $templateVariables->vars["phrases.catalog.new_element"]; ?></a>
			</td>

			<!--td id="__list">
			<a href="javascript: void(PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/list&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&parent_id=<?php echo $templateVariables->vars["parent_id"]; ?>', 'LIST_area__action', 'list'));" class="path"><img src="images/inner.gif" border="0" class="vam" /> <?php echo $templateVariables->vars["phrases.catalog.elements_list"]; ?></a>
			</td-->

			<?php if($templateVariables->vars["import_from_zip"]){ ?>
			<td id="__zip">
			<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["filter_page"]; ?>zip&id=<?php echo $templateVariables->vars["parent_id"]; ?>" class="path"><img src="images/zip.gif" border="0" class="vam" /> <?php echo $templateVariables->vars["phrases.catalog.import_zip"]; ?></a>
			</td>
			<?php } ?>
		
			<td id="__import">
			<a href="javascript: void(PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/import&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>', 'LIST_area__action', 'import'));" class="path"><img src="images/import.gif" border="0" class="vam" /> <?php echo $templateVariables->vars["phrases.catalog.import"]; ?></a>
			</td>
	
			<?php if($templateVariables->vars["items_count"]){ ?>
			<td id="__export">
			<a href="javascript: void(PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/export&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>', 'LIST_area__action', 'export'));" class="path"><img src="images/export.gif" border="0" class="vam" /> <?php echo $templateVariables->vars["phrases.catalog.export"]; ?></a>
			</td>
			
			<td id="__pdf">
			<a href="javascript: void(PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/pdf&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>', 'LIST_area__action', 'pdf'));" class="path"><img src="images/pdf.gif" border="0" class="vam" /> <?php echo $templateVariables->vars["phrases.catalog.pdf_print"]; ?></a>
			</td>
			
			<td id="__search">
			<a href="" class="path"><img src="images/preview.gif" border="0" alt="" class="vam" /> <?php echo $templateVariables->vars["phrases.catalog.search"]; ?></a>
			</td>
			<?php } ?>
	
			<?php } ?>
			
			<td width="99%">&nbsp;</td>
			
			</tr>
		</table>
		
		<div id="LIST_area__action" class="list_menu_area"></div>
		<div id="close_LIST_area" class="switch_area_close" onclick="javascript: togglePannelAnimatedStatus('LIST_area__action',10,40);"></div>


		<!--script type="text/javascript">
			if(location.hash=='#new_inner') PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/edit&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=0&parent_id=<?php echo $templateVariables->vars["parent_id"]; ?>&new=1', 'LIST_area__action', 'new');
			//if(location.hash=='#new_inner') PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/edit&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=0&parent_id=<?php echo $templateVariables->vars["parent_id"]; ?>&new=1', 'LIST_area__action', 'list');
			if(location.hash=='#zip') PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/edit&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=0&parent_id=<?php echo $templateVariables->vars["parent_id"]; ?>&new=1', 'LIST_area__action', 'zip');
			if(location.hash=='#import') PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/import&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>', 'LIST_area__action', 'import');
			if(location.hash=='#export') PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/export&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>', 'LIST_area__action', 'export');
			if(location.hash=='#pdf') PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/pdf&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>', 'LIST_area__action', 'pdf');
			if(location.hash=='#search') PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/edit&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=0&parent_id=<?php echo $templateVariables->vars["parent_id"]; ?>&new=1', 'LIST_area__action', 'edit');
		</script-->


		
	</div>	
<?php } ?>


<?php if($templateVariables->vars["nomorefolders"]){ ?>
	<div id="items_list_grid">
		
		<?php include $grid_obj->tpl->cacheFile; ?>
	
	</div>
<?php } ?>
	
	
	</div>




	</div>
	
</div>

		</td>
	</tr>
</table>


<?php if($templateVariables->vars["filter_module"]){ ?>
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $templateVariables->vars["filter_arr.get_column_name.value"]; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
<?php } ?>

<?php if($templateVariables->vars["filters_reload"]){ ?>
<script type="text/javascript">
window.opener.parent.frames.modules.reloadSelect('<?php echo $templateVariables->vars["lng"]; ?>', '<?php echo $templateVariables->vars["filters.column_name"]; ?>'); //location.reload();
</script>
<?php } ?>

<?php if($templateVariables->vars["tree_reload"]){ ?>
<script type="text/javascript">
//parent.frames.modules.createTree_<?php echo $templateVariables->vars["module.table_name"]; ?>('<?php echo $templateVariables->vars["lng"]; ?>', <?php echo $templateVariables->vars["parent_id"]; ?>); //location.reload();
parent.modules.parent.modules.TreeObj_<?php echo $templateVariables->vars["module.table_name"]; ?>_s.create(<?php echo $templateVariables->vars["parent_id"]; ?>);
</script>
<?php } ?>