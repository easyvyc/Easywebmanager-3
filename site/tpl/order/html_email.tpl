
<h3>{phrases.cart_confirm_title}</h3>
<table border="0" cellpadding="0" cellspacing="0" width="400">
	<tr>
		<th>&nbsp;</th>
		<th align="left">{phrases.o_data_item_title}</th>
		<th>{phrases.o_data_item_kiekis}</th>
		<th>{phrases.o_data_item_price}</th>
	</tr>
{loop o_items}
	<tr>
		<td><img src="{upload_url}thumb_{o_items.image}" title="{o_items.title}" /></td>
		<td><b><a href="{config.site_url}{lng}{o_items.item_url}">{o_items.title}</a></b></td>
		<td align="center">{o_items.kiekis}</td>
		<td align="center">{o_items.price} {o_data.currency}</td>
	</tr>
{-loop o_items}
</table>

<table border="0" cellpadding="0" cellspacing="0" width="400">
	<tr>
		<td align="right">{phrases.all_sum_no_pvm}</td>
		<td align="right" width="100">{o_data.order_sum_no_pvm} {o_data.currency}</td>
	</tr>
	<tr>
		<td align="right">{phrases.all_sum_pvm}</td>
		<td align="right">{o_data.order_sum_pvm} {o_data.currency}</td>
	</tr>
	<tr>
		<td align="right">{phrases.all_sum}</td>
		<td align="right">{o_data.order_sum} {o_data.currency}</td>
	</tr>
</table>
<br />

<h3>{phrases.user_shipping_form_title}</h3>
<table width="100%">
	{loop shipping_info}
	<tr>
		<td width="150">{shipping_info.title}</td>
		<td>{shipping_info.value}</td>
	</tr>
	{-loop shipping_info}
</table>

