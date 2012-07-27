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
				<?php echo $templateVariables->vars["phrases.settings.modules_title"]; ?>
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>
	
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_module&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> <?php echo $templateVariables->vars["phrases.settings.module.new_module"]; ?></a></td>
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

<?php if($templateVariables->vars["refresh_tree"]){ ?>
<script language="javascript">
parent.frames.modules.TreeObj_catalog_c.create(0); //location.reload();
</script>
<?php } ?>