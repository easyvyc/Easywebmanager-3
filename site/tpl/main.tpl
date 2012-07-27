<div class="blokas">

	<div class="top">
	<div><div>
	{phrases.pop_items_title}
	</div></div>
	</div>

	<call code="name=popitems::set=loop::module=products::method=listPopItems::params=">

	<table class="nav" cellpadding="0" cellsapcing="0" width="100%" border="0">
		<tr>
			<td class="r">
	<a href="javascript: void(slider('popitems_content_container', 'popitems_content', -1));">«</a>
			</td>
			<td class="m">
	<div class="container" id="popitems_content">
	<div class="rel" id="popitems_content_container">
		<loop name="popitems">
		<div class="product_thumb">
		<div class="img" style="background:url('{upload_url}thumb_{popitems.image}') center center no-repeat;">
		<a href="{lng}{popitems.page_url}id/{popitems.id}/"><img src="images/0.gif" alt="" /></a>
		</div>
		<a class="title" href="{lng}{popitems.page_url}id/{popitems.id}/">{popitems.title}</a>
		<p class="price">{popitems.price}<block name="popitems.is_old_price"> <span>{popitems.old_price}</span></block name="popitems.is_old_price"></p>
		</div>
		</loop name="popitems">

		<div class="clear"></div>
		
	</div>
	</div>
			</td>
			<td class="r">
	<a href="javascript: void(slider('popitems_content_container', 'popitems_content', 1));">»</a>
			</td>
		</tr>
	</table>
	
	<div class="bottom"><div><div></div></div></div>

</div>
<br />

<div class="blokas">
	<div class="top">
	<div><div>
	{phrases.new_items_title}
	</div></div>
	</div>
	
	<call code="name=newitems::set=loop::module=products::method=listNewItems::params=">
	
	<table class="nav" cellpadding="0" cellsapcing="0" width="100%" border="0">
		<tr>
			<td class="r">
	<a href="javascript: void(slider('newitems_content_container', 'newitems_content', -1));">«</a>
			</td>
			<td class="m">
		<div class="container" id="newitems_content">
		<div class="rel" id="newitems_content_container">
		<loop name="newitems">
		<div class="product_thumb">
		<div class="img" style="background:url('{upload_url}thumb_{newitems.image}') center center no-repeat;">
		<a href="{lng}{newitems.page_url}id/{newitems.id}/"><img src="images/0.gif" alt="" /></a>
		</div>
		<a class="title" href="{lng}{newitems.page_url}id/{newitems.id}/">{newitems.title}</a>
		<p class="price">{newitems.price}<block name="newitems.is_old_price"> <span>{newitems.old_price}</span></block name="newitems.is_old_price"></p>
		</div>
		</loop name="newitems">
		
		<div class="clear"></div>
		
		</div>
		</div>
			</td>
			<td class="r">
	<a href="javascript: void(slider('newitems_content_container', 'newitems_content', 1));">»</a>
			</td>
		</tr>
	</table>

	
		
		<div class="bottom"><div><div></div></div></div>

</div>
<br />



<div class="blokas">
	
	<div class="blacktop"><div><div></div></div></div>

	<div class="content">

		<div class="mainitems_content">

			<call code="name=mainitems::set=loop::module=products::method=listMainItems::params=">
			
			<loop name="mainitems">
			<div class="product_thumb">
			<div class="img" style="background:url('{upload_url}thumb_{mainitems.image}') center center no-repeat;">
			<a href="{lng}{mainitems.page_url}id/{mainitems.id}/"><img src="images/0.gif" alt="" /></a>
			</div>
			<a class="title" href="{lng}{mainitems.page_url}id/{mainitems.id}/">{mainitems.title}</a>
			<p class="price">{mainitems.price}<block name="mainitems.is_old_price"> <span>{mainitems.old_price}</span></block name="mainitems.is_old_price"></p>
			</div>
			</loop name="mainitems">

			<div class="clear"></div>

		</div>
		
	</div>

	<div class="bottom"><div><div></div></div></div>

</div>