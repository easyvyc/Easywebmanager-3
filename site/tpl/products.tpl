<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">

<h1>{item_data.title}</h1>
										

<block name="get.id">

<call code="name=product_data::set=var::module=products::method=loadItem::params={{get.id}}">

<div class="content">

	<div id="path">
	<loop name="id_path">
	<block name="id_path.first" no>
	&nbsp;&nbsp;»&nbsp;&nbsp;
	</block name="id_path.first" no>
	<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
	</loop name="id_path">
	&nbsp;&nbsp;»&nbsp;&nbsp;{product_data.title}
	</div>
	
	<div id="data_text">
	
	<h2>{product_data.title}</h2>

<div id="main_img_area">

<div id="main_img">
	<a class="img1" rel="lightbox[{product_data.id}]" href="{upload_url}big_{product_data.image}" style="background:url('{upload_url}{product_data.image}') center center no-repeat;"></a>
	
	<block name="product_data.image2">
	<a class="img2 hide" rel="lightbox[{product_data.id}]" href="{upload_url}big_{product_data.image2}" style="background:url('{upload_url}{product_data.image2}') center center no-repeat;"></a>
	</block name="product_data.image2">
	<block name="product_data.image3">
	<a class="img3 hide" rel="lightbox[{product_data.id}]" href="{upload_url}big_{product_data.image3}" style="background:url('{upload_url}{product_data.image3}') center center no-repeat;"></a>
	</block name="product_data.image3">
	<block name="product_data.image4">
	<a class="img4 hide" rel="lightbox[{product_data.id}]" href="{upload_url}big_{product_data.image4}" style="background:url('{upload_url}{product_data.image4}') center center no-repeat;"></a>
	</block name="product_data.image4">
</div>

<div id="thumb_img">
<block name="product_data.image">
<div class="thumbs " style="background:url('{upload_url}th1_{product_data.image}') center center no-repeat;" onclick="javascript: change_foto(1);"></div>
</block name="product_data.image">

<block name="product_data.image2">
<div class="thumbs " style="background:url('{upload_url}th1_{product_data.image2}') center center no-repeat;" onclick="javascript: change_foto(2);"></div>
</block name="product_data.image2">
<block name="product_data.image2" no>
<div class="thumbs no_img"></div>
</block name="product_data.image2" no>

<block name="product_data.image3">
<div class="thumbs " style="background:url('{upload_url}th1_{product_data.image3}') center center no-repeat;" onclick="javascript: change_foto(3);"></div>
</block name="product_data.image3">
<block name="product_data.image3" no>
<div class="thumbs no_img"></div>
</block name="product_data.image3" no>

<block name="product_data.image4">
<div class="thumbs last" style="background:url('{upload_url}th1_{product_data.image4}') center center no-repeat;" onclick="javascript: change_foto(4);"></div>
</block name="product_data.image4">
<block name="product_data.image4" no>
<div class="thumbs no_img last"></div>
</block name="product_data.image4" no>

</div>



</div>

	<div class="fleft" style="width:325px;">

	<block name="product_data.product_code">
	<div class="item_fields">{phrases.product_code}: <b>{product_data.product_code}</b></div>
	</block name="product_data.product_code">
	
	<div class="item_fields price">
		<div class="fleft">
			{phrases.price}: <b>{product_data.item_price} {currency.title}</b> <block name="product_data.is_old_price"><span>{product_data.item_old_price} {currency.title}</span></block name="product_data.is_old_price">
		</div>
		<div class="fright">
			<call code="name=modifications::set=loop::module=products::method=getModifData::params={{get.id}}">
			<call code="name=is_modif::set=var::module=products::method=isModif::params={{get.id}}">
			<loop name="modifications">
			<p class="item_modif"><span>{modifications.title}:</span> 
			<select id="select_value_{modifications.column_name}" name="{modifications.column_name}">
				<option value="">{phrases.select_modification}</option>
				<loop name="modifications.select_values">
				<option value="{modifications.select_values.id}">{modifications.select_values.title}</option>
				</loop name="modifications.select_values">
			</select>
			</p>
			</loop name="modifications">
			
			<block name="is_modif">
			<div class="orange">
			<a onclick="javascript: if(modifSelected()) add2cart('{config.site_url}ajax.php?content=cart&add={product_data.id}'+getAllModif()+'&ajax=1', 'cartcontent', before_func, addSuccess); else modif_not_selected('{phrases.please_select_modif}');">{phrases.add2cart}</a>
			</div>
			</block name="is_modif">
			
			<block name="is_modif" no>
			<div class="orange">
			<a class="add2cart" onclick="javascript: add2cart('{config.site_url}ajax.php?content=cart&add={product_data.id}&ajax=1', 'cartcontent', before_func, addSuccess);">{phrases.add2cart}</a>
			</div>
			</block name="is_modif" no>
		</div>
	</div>

	<call code="name=fields::set=loop::module=products::method=getFieldsData::params={{get.id}}">
	<loop name="fields">
	<p class="item_fields">{fields.title}: <b>{fields.value}</b></p>
	</loop name="fields">
	
	<div class="item_fields">{product_data.description}</div>
		
	</div>

	</div>
	
	<div class="clear"></div>	
	
	<call code="name=related_items::set=loop::module=products::method=listRelatedItems::params={{product_data.id}}">
	<call code="name=is_related_items::set=var::module=products::method=is_relatedItems::params={{product_data.id}}">
	<block name="is_related_items">
	<div class="recommend">
	
		<h3>{phrases.rekomenduojame}</h3>
	
		<loop name="related_items">
		<div class="product_thumb">
		<a href="{lng}{related_items.page_url}{related_items.product_url}-{related_items.id}.html" class="img" style="background:url('{upload_url}thumb_{related_items.image}') center center no-repeat;">
		</a>
		<a class="title" href="{lng}{related_items.page_url}{related_items.product_url}-{related_items.id}.html">{related_items.title}</a>
		<p class="desc">{related_items.short_description}</p>
		<p class="price">{related_items.item_price} {currency.title}<block name="related_items.is_old_price"> <span>{related_items.item_old_price} {currency.title}</span></block name="related_items.is_old_price"></p>
		<a class="add2cart" href="javascript: void(add2cart('{config.site_url}ajax.php?content=cart&add={related_items.id}&ajax=1', 'cartcontent', before_func, addSuccess));">{phrases.add2cart}</a>
		</div>
		</loop name="related_items">

		<div class="clear"></div>
	
	</div>
	</block name="is_related_items">
	
	

	
</div>



</block name="get.id">

<block name="get.id" no>

<call code="name=mainitems::set=loop::module=products::method=listCategoryItems::params={{data.id}},{{get.offset}}">
<call code="name=paging::set=loop::module=products::method=pagingItems::params={{get.offset}}">
<call code="name=is_paging::set=var::module=products::method=is_pagingItems::params=">


	<div id="path">
	<loop name="id_path">
	<block name="id_path.first" no>
	&nbsp;&nbsp;»&nbsp;&nbsp;
	</block name="id_path.first" no>
	<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
	</loop name="id_path">
	</div>

	<div class="mainitems_content">

		<loop name="mainitems">
		<div class="product_thumb">
		<a href="{lng}{mainitems.page_url}{mainitems.product_url}-{mainitems.id}.html" class="img" style="background:url('{upload_url}thumb_{mainitems.image}') center center no-repeat;">
		</a>
		<a class="title" href="{lng}{mainitems.page_url}{mainitems.product_url}-{mainitems.id}.html">{mainitems.title}</a>
		<p class="desc">{mainitems.short_description}</p>
		<p class="price">{mainitems.item_price} {currency.title}<block name="mainitems.is_old_price"> <span>{mainitems.item_old_price} {currency.title}</span></block name="mainitems.is_old_price"></p>
		<a class="add2cart" href="javascript: void(add2cart('{config.site_url}ajax.php?content=cart&add={mainitems.id}&ajax=1', 'cartcontent', before_func, addSuccess));">{phrases.add2cart}</a>
		</div>
		</loop name="mainitems">

		<div class="clear"></div>

	</div>

<block name="is_paging">
<div class="paging">
<loop name="paging">
<a href="{lng}/{page_data.page_url}offset/{paging.value}/" <block name="paging.active">class="a"</block name="paging.active">>{paging.title}</a>
</loop name="paging">
</div>
</block name="is_paging">


</block name="get.id" no>