<div class="top"><div><div>
</div></div></div>

<div class="content">

	<div id="path">
	<a href="{lng}/">{phrases.pradzia}</a>
	{phrases.user_stat}
	</div>

	<div id="data_text">
	
		<h1>{phrases.user_stat}</h1>
	
		<h3>{phrases.prekes_top10}</h3>
		
		<call code="name=most_clicks::set=loop::module=products::method=listPopItems_user::params={{loged_user.id}}">
		<table class="users" cellpadding="0" cellspacing="0">
		<tr>
			<td width="80">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="50">{phrases.clicks_title}</td>
		</tr>
		<loop name="most_clicks">
		<block name="most_clicks.clicks">
		<tr>
			<td >
				<div class="thumb" style="background:url('{upload_url}thumb_{most_clicks.image}') center center no-repeat;"></div>
			</td>
			<td >
				<p class="title">{most_clicks.title} - {most_clicks.price}</p>
				<p>{most_clicks.short_description}</p>
			</td>
			<td align="center">
				<b>{most_clicks.clicks}</b>
			</td>
		</tr>
		</block name="most_clicks.clicks">
		</loop name="most_clicks">
		</table>

	</div>

</div>

<div class="bottom"><div><div>
</div></div></div>


