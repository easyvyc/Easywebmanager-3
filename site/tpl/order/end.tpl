<h1>{phrases.order_title}</h1>								

<call code="name=order_text::set=var::module=orders::method=endOrder::params={{get.id}}">
<p>{order_text}</p>