
<block name="data.no_standart_tpl" no>
<style>
#area_id_area_html {
	display:none;
}
</style>
</block name="data.no_standart_tpl" no>

<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			{menu}
		</td>
	</tr>

	<tr>
		<td>	
<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<a href="main.php?content={get.content}&module={module.table_name}&page=modules" class="path">{phrases.settings.modules_title}</a> → <block name="data.isNew" no>{data.title} ({data.table_name})</block name="data.isNew" no><block name="data.isNew">{phrases.settings.module.new_module}</block name="data.isNew">
			</td>
			
		</tr>
	</table>
</div>	
		</td>
	</tr>

	<tr>
		<td height="30" valign="middle"><a href="main.php?content=settings&page=<block name="menu_module">menu_</block name="menu_module">edit_module&id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> {phrases.settings.module.new_module}</a></td>
	</tr>
		
	<tr>
		<td colspan="3">
					
	
				{form}

			
		</td>
	</tr>
	


</table>