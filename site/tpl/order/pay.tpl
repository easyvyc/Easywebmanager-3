<call code="name=payments::set=var::module=orders::method=setPay::params=">

<h1>{phrases.order_title}</h1>

<div id="order_steps">
	
	<call code="name=steps::set=loop::module=orders::method=loadSteps::params=">
	<loop name="steps">
	<div class="radius10 step<block name="steps.complited"> c</block name="steps.complited"><block name="steps.active"> a</block name="steps.active">">
		<p>{steps.title}</p>
	</div>
	</loop name="steps">

</div>										

	<form name="payment" action="{lng}/order/step/{get.step}/" method="post">
	<call code="name=payments::set=loop::module=payments::method=listSearchItems::params=0">
	<loop name="payments">
	<div class="pay">
	<input type="radio" name="payment" value="{payments.id}" id="id_{payments.id}" class="fo_radio vam" <block name="payments.selected">checked</block name="payments.selected"> />
	<label for="id_{payments.id}">{payments.title}</label>
	<p>{payments.short_description}</p>
	</div>
	</loop name="payments">
	</form>

	<div class="clear"></div>
	
	
	<div id="payment_select_error">{phrases.please_select_payment}</div>
	


<form name="cart" action="{lng}/order/step/{get.step}/" method="post">
<table class="order_next">
	<tr>
		<td>

<input type="button" onclick="javascript: location='{config.site_url}{lng}/order/step/shipping/';" value="{phrases.order_prev_step}" class="btn" />

		</td>
		<td align="right">
	
<input type="button" onclick="if($('input:checked').val()) document.forms['payment'].submit(); else $('#payment_select_error').show(500);" value="{phrases.order_next_step}" class="btn" />
		
		</td>
	</tr>
</table>
</form>