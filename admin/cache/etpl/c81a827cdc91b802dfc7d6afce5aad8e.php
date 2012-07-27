<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			<?php include $tpl_menu->cacheFile; ?>
		</td>
	</tr>
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=settings&page=template&tpl_id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> Naujas šablonas</a></td>
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
		<td height="30" valign="middle">Įrašų nėra.</td>
	</tr>	
	<?php } ?>
</table>