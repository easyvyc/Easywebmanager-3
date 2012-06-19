<call code="name=users::set=loop::module=users::method=listLombardai::params={{get.city}},{{get.offset}},5">

<div class="top"><div><div>
	<call code="name=news_paging::set=loop::module=users::method=pagingItems::params={{get.offset}},5,7">
	<div class="paging">
	<loop name="news_paging">
	<a href="{lng}{data.page_url}{reserved_url_words.offset}/{news_paging.value}" <block name="news_paging.active">class="a"</block name="news_paging.active">>{news_paging.title}</a>
	</loop name="news_paging">
	</div>	
</div></div></div>

<div class="content">

	<div id="path">
	<a href="{lng}/">{phrases.pradzia}</a>
	<loop name="id_path">
	<block name="id_path.first" no>
	<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
	</block name="id_path.first" no>
	</loop name="id_path">
	</div>

	<div id="data_text">
	
	<h1>{data.title}</h1>
	
	<call code="name=cities::set=loop::module=filters::method=listItems::params=3803">
	<div class="float">
	{phrases.city}: <select name="city" id="ar_city">
	<option value="0">{phrases.all_cities}</option>
	<loop name="cities">
		<option value="{cities.id}">{cities.title}</option>
	</loop name="cities">	
	</select>		

	<script type="text/javascript">
	$("#ar_city").sexyCombo({ suffix:'sc', hiddenSuffix:'sc' });
	</script>
	</div>
	
	<div class="float">
	&nbsp;<br />&nbsp;<input type="button" value="  OK  " onclick="javascript: location='{config.site_url}{lng}{data.page_url}city/'+document.getElementById('ar_city').options[document.getElementById('ar_city').selectedIndex].value+'/';" class="fo_submit vam" style="margin-top:1px;" />
	</div>
	
	<div class="clear"></div>
	
	<table class="users" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<loop name="users">
	<tr>
		<td width="150">
			<img src="{upload_url}thumb_{users.logo}" alt="" />
		</td>
		<td width="350">
			<p class="title">{users.title}</p>
			<p>{users.short_description}</p>
			<b>{phrases.viso_prekiu}:</b> <a href="{lng}/{reserved_url_words.users}/{users.loginname}/">({users.items_count})</a>
		</td>
		<td>
			<b>{phrases.user_address}</b><br />
			{users.address}, {users.city}<br />
			{phrases.phone} {users.phone}<br />
			{phrases.email} <a href="mailto:{users.email}">{users.email}</a>
		</td>
	</tr>
	</loop name="users">
	</table>
	
	</div>

</div>

<div class="bottom"><div><div>
	<div class="paging">
	<loop name="news_paging">
	<a href="{lng}{data.page_url}{reserved_url_words.offset}/{news_paging.value}" <block name="news_paging.active">class="a"</block name="news_paging.active">>{news_paging.title}</a>
	</loop name="news_paging">
	</div>	
</div></div></div>
