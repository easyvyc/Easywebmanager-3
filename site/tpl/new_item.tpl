<div class="top"><div><div>
</div></div></div>

<div class="content">

	<div id="path">
	<a href="{lng}/">{phrases.pradzia}</a>
	{phrases.add_item}
	</div>

	<div id="data_text">
	
		<h1>{phrases.add_item}</h1>
	
		<block name="get.thanks" no>
		<block name="get.category" no>
		<table>
			<tr>
				<td>
			{phrases.select_category}
				</td>
				<td>
			<select name="category" id="ar_category">
			<option value="0">{phrases.all_categories}</option>
			<loop name="c_menu">
				<option value="{c_menu.id}">{c_menu.title}</option>
				<loop name="c_menu.sub">
				<option value="{c_menu.sub.id}">&nbsp;&nbsp;&nbsp;{c_menu.sub.title}</option>
				</loop name="c_menu.sub">
			</loop name="c_menu">	
			</select>		
			</td>
			<td>
			<input type="button" value="  ok  " class="fo_submit vam" onclick="javascript: location='{config.site_url}{lng}/{reserved_url_words.new_item}/?category='+document.getElementById('category').options[document.getElementById('category').selectedIndex].value" />
			</td>
			</tr>
		</table>
			<script type="text/javascript">
			$("#ar_category").sexyCombo({ suffix:'sc', hiddenSuffix:'sc' });
			</script>		
		</block name="get.category" no>
	
		<block name="get.category">
		<call code="name=form::set=var::module=products::method=loadEditForm::params={{get.edit_item}}">
		{form}
		</block name="get.category">
		</block name="get.thanks" no>
		
		<block name="get.thanks">
		{phrases.new_item_success}
		</block name="get.thanks">

	</div>

</div>

<div class="bottom"><div><div>
</div></div></div>


