<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			
			<?php include $tpl_menu->cacheFile; ?>
			
		</td>
	</tr>

	<tr>
		<td>	
<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=modules" class="path"><?php echo $templateVariables->vars["phrases.settings.modules_title"]; ?></a> → <?php echo $templateVariables->vars["module_data.title"]; ?> 
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>

	<tr>
		<td height="30" valign="middle"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_column&parent_id=<?php echo $templateVariables->vars["module_id"]; ?>&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> <?php echo $templateVariables->vars["phrases.settings.module.new_column"]; ?></a></td>
	</tr>
		
	<?php if(!$templateVariables->vars["empty"]){ ?>
	<tr>
		<td>

	<div id="items_list_grid">
		
		<?php include $grid_obj->tpl->cacheFile; ?>
	
	</div>

		</td>
	</tr>
	<?php } ?>

	<?php if($templateVariables->vars["empty"]){ ?>
	<tr>
		<td height="30" valign="middle"><?php echo $templateVariables->vars["phrases.common.empty_items"]; ?></td>
	</tr>	
	<?php } ?>
</table>