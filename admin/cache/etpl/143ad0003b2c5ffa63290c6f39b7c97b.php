
<?php if(!$templateVariables->vars["data.no_standart_tpl"]){ ?>
<style>
#area_id_area_html {
	display:none;
}
</style>
<?php } ?>

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
				<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=modules" class="path"><?php echo $templateVariables->vars["phrases.settings.modules_title"]; ?></a> → <?php if(!$templateVariables->vars["data.isNew"]){ ?><?php echo $templateVariables->vars["data.title"]; ?> (<?php echo $templateVariables->vars["data.table_name"]; ?>)<?php } ?><?php if($templateVariables->vars["data.isNew"]){ ?><?php echo $templateVariables->vars["phrases.settings.module.new_module"]; ?><?php } ?>
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>

	<tr>
		<td height="30" valign="middle"><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit_module&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> <?php echo $templateVariables->vars["phrases.settings.module.new_module"]; ?></a></td>
	</tr>
		
	<tr>
		<td colspan="3">
					
	
				<?php echo $templateVariables->vars["form"]; ?>

			
		</td>
	</tr>
	


</table>

<script language="javascript">
if(location.hash=='#delete'){
	if(confirm('<?php echo $templateVariables->vars["phrases.common.delete_confirm"]; ?>')) location = "main.php?content=mod&page=modules&action=delete&deleteid=<?php echo $templateVariables->vars["data.id"]; ?>";
}
</script>

<?php if($templateVariables->vars["get.tree_reload"]){ ?>
<script language="javascript">
top.frames.modules.TreeObj_catalog_c.create(0); //location.reload();
top.frames.content.edited_element = false;
</script>
<?php } ?>