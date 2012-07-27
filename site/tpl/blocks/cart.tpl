<call code="name=cart::set=var::module=orders::method=loadCart::params=">

<div class="box-cart-heading">
	<img class="vam" src="images/box-cart-title.png" alt="" />
	{phrases.cart_title}
</div>

<div class="box-cart-line"></div>

<div class="box-cart-content">
		
	<block name="cart.is_cart">
	<div id="cart_sum">
	{phrases.all_items} <b>{cart.is_cart}</b><br />
	{phrases.all_sum} <b>{cart.sum} {currency.title}</b>
	</div>
	
	<div class="orange">
		<a href="{lng}/{reserved_url_words.order}/">{phrases.order_title}</a>
	</div>
	</block name="cart.is_cart">
	
	<block name="cart.is_cart" no>
	<div class="empty">{phrases.empty_cart}</div>
	</block name="cart.is_cart" no>		
		
</div>