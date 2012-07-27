<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<?php if(!$templateVariables->vars["filter_module"]){ ?><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["filter_page"]; ?>list&id=0" class="path"><?php echo $templateVariables->vars["module.title"]; ?></a> → <?php } ?><?php foreach($templateVariables->loops["path"] as $path_key => $path_val){ ?><a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["filter_page"]; ?>list&id=<?php echo $path_val["id"]; ?>" class="path"><?php echo $path_val["title"]; ?> (<?php echo $path_val["id"]; ?>)</a> → <?php } ?>                             <?php if(!$templateVariables->vars["data.isNew"]){ ?><?php echo $templateVariables->vars["data.title"]; ?> <?php if($templateVariables->vars["data.id"]){ ?>(<?php echo $templateVariables->vars["data.id"]; ?>)<?php } ?><?php } ?>
			</td>
			
		</tr>
	</table>
</div>