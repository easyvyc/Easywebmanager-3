<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lng}" lang="{lng}">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />

<title><block name="page_data.id">{page_data.page_title}</block name="page_data.id"><block name="page_data.id" no>{site.title}</block name="page_data.id" no></title>



<meta name="description" content="{page_data.description}" />
<meta name="abstract" content="{page_data.description}" />
<meta name="keywords" content="{page_data.keywords}" />
<meta name="GOOGLEBOT" content="index,follow" />
<meta name="ROBOTS" content="index,follow" />
<meta name="revisit_after" content="3 Days" />
<meta name="GENERATOR" content="easywebmanager" />


<base href="{config.site_url}" />

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/pr.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox.css" />
<link rel="stylesheet" type="text/css" href="css/main.css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.lightbox.js"></script>
<script type="text/javascript" src="js/jquery.timer.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>

<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/cufon-replace.js" type="text/javascript"></script>
<script src="js/Myriad_Pro_400.font.js" type="text/javascript"></script>
<script src="js/Myriad_Pro_600.font.js" type="text/javascript"></script>
<!--[if lt IE 7]>
	<script type="text/javascript" src="js/ie_png.js"></script>
	<script type="text/javascript">
		 ie_png.fix('.png');
	</script>
<![endif]-->


<call code="name=rss::set=loop::module=_main::method=listRss::params=">
<loop name="rss">
<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php?module={rss.table_name}&amp;lng={lng}"/>
</loop name="rss">

</head>
<body>


<div id="main">

	<div id="banners">
		<call code="name=banners_top_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'banners_top'">
		{banners_top_data.title}
	</div>
	
	<div id="logo">
	<a href="."><img src="images/logo.png" class="png" alt="" /></a>
	</div>
	
	<call code="name=c_menu::set=loop::module=pages::method=listCatalogMenu::params=3757">
	
	<div id="top">
		
		<ul id="top_menu">
			<call code="name=bmenu::set=loop::module=pages::method=listMenu::params=3345">
			<loop name="bmenu">
			<li <block name="bmenu.selected">class="a"</block name="bmenu.selected">><div><div><a href="{lng}{bmenu.page_url}" title="{bmenu.page_title}">{bmenu.title}</a></div></div></li>
			</loop name="bmenu">
		</ul>

		<div id="search">
			<form action="{lng}/{reserved_url_words.search}/" method="get">
			<div class="float">
			<input type="hidden" name="q_" value="0" />
			<input type="text" name="q" class="fo_text vam" style="width:123px;" value="<block name="get.q">{get.q}</block name="get.q"><block name="get.q" no>{phrases.search_default_value}</block name="get.q" no>" <block name="get.q" no>onfocus="javascript: inputFocus(this);" onblur="javascript: inputBlur(this, '{phrases.search_default_value}');"</block name="get.q" no> />
			</div>
			<div class="float">
			<select name="c" id="ar_c">
			<option value="0">{phrases.all_categories}</option>
			<loop name="c_menu">
				<option value="{c_menu.id}">{c_menu.title}</option>
				<loop name="c_menu.sub">
				<option value="{c_menu.sub.id}">&nbsp;&nbsp;&nbsp;{c_menu.sub.title}</option>
				</loop name="c_menu.sub">
			</loop name="c_menu">	
			</select>		

			<script type="text/javascript">
			<block name="get.c">
			setSelected(document.getElementById('ar_c'), '{get.c}');
			</block name="get.c">
			$("#ar_c").sexyCombo({ suffix:'sc', hiddenSuffix:'sc' });
			</script>
			
			</div>
			<div class="float" style="margin-right:0px;">
			{phrases.price_from}
			<input type="text" name="price_from" class="fo_text vam" style="width:25px;" value="{get.price_from}" />
			{phrases.price_to}
			<input type="text" name="price_to" class="fo_text vam" style="width:25px;" value="{get.price_to}" />

			<input type="submit" class="fo_submit vam" value="{phrases.search_submit}" />
			</div>
			</form>
		</div>
		
		<div class="shadow"></div>
		
	</div>
	
	<div id="call">
		<call code="name=call_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'call'">
		{call_data.title}
	</div>
	
	<div class="clear"></div>
	
	<div id="info">
	
	<div id="left">

		<div id="catalog" class="blokas">
		
			<div class="top">
			<div><div>
			{phrases.catalog}
			</div></div>
			</div>
		
			<div class="menu nav">
			<ul>
				<loop name="c_menu">
				<li><a href="{lng}{c_menu.page_url}" title="{c_menu.page_title}">{c_menu.title}</a>&nbsp;({c_menu.count})
				<ul>
					<loop name="c_menu.sub">
					<li><img src="images/ro.gif" class="vam" alt="" /> <a href="{lng}{c_menu.sub.page_url}" title="{c_menu.sub.page_title}">{c_menu.sub.title}</a>&nbsp;({c_menu.sub.count})</li>
					</loop name="c_menu.sub">
				</ul>
				</li>
				</loop name="c_menu">
			</ul>
			</div>
			
			<div class="bottom"><div><div></div></div></div>
						
		</div>
		
		<!--div class="block_title"><div><div><a href="#">{phrases.siulyk_preke}</a></div></div></div>

		<div class="block_title"><div><div><a href="#">{phrases.reikia_preke}</a></div></div></div-->
		
		<br />
		<div id="reklamablock" class="blokas">
		
			<div class="top">
			<div><div>
			{phrases.reklama_block_title}
			</div></div>
			</div>
		
			<div class="nav">

			<call code="name=banners_left_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'banners_left'">
			{banners_left_data.title}

			</div>
			
			<div class="bottom"><div><div></div></div></div>
						
		</div>

			
	</div>
	
	<div id="content">
		{page_content}
	</div>

	<div id="right">

		<div id="cartblock" class="blokas">
		
			<div class="top">
			<div><div>
			{phrases.cart_block_title}
			</div></div>
			</div>
		
			<div class="nav" id="cartcontent">

			{cart_content}

			</div>
			
			<div class="bottom"><div><div></div></div></div>
						
		</div>	
		
		<br />
		
		<div id="loginblock" class="blokas">
		
			<div class="top">
			<div><div>
			{phrases.login_block_title}
			</div></div>
			</div>
		
			<div class="nav" id="logincontent">

			<block name="loged_user.id" no>
			<div id="login_form"></div>
			
			<div class="center">
			<a href="javascript: void(ajax('{config.site_url}ajax.php?content=login&lng={lng}', 'login_form'));">{phrases.login}</a>
			&nbsp;|&nbsp;
			<a href="javascript: void(ajax('{config.site_url}ajax.php?content=login&forget=1&lng={lng}', 'login_form'));">{phrases.forget_password}</a>
			<a href="{lng}/register/">{phrases.new_user}</a>
			</div>
			
			</block name="loged_user.id" no>
			
			<block name="loged_user.id">
				<b>{loged_user.title}</b><br />
				{loged_user.create_date}<br /><br />
				<table>
					<tr>
						<td><img src="images/lazdele.gif" alt="" class="vam" /></td><td><a href="{lng}/{reserved_url_words.user}/">{phrases.change_user}</a></td>
					</tr>
					<tr>
						<td><img src="images/logout.gif" alt="" class="vam" /></td><td><a href="{lng}/logout/">{phrases.logout}</a></td>
					</tr>
				</table>
			</block name="loged_user.id">

			</div>
			
			<div class="bottom"><div><div></div></div></div>
						
		</div>
		
		<br />
		<div id="reklama_right_block" class="blokas">
		
			<div class="top">
			<div><div>
			{phrases.reklamaright_block_title}
			</div></div>
			</div>
		
			<div class="nav">

			<call code="name=banners_right_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'banners_right'">
			{banners_right_data.title}

			</div>
			
			<div class="bottom"><div><div></div></div></div>
						
		</div>
		
	
	</div>
	
	<div class="clear"></div>
	
		
	<div id="bmenu">
	<loop name="bmenu">
	<a href="{lng}{bmenu.page_url}" title="{bmenu.page_title}">{bmenu.title}</a>&nbsp;&nbsp;
	</loop name="bmenu">
	</div>

	<div id="payments">
		<call code="name=banners_bottom_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'banners_bottom'">
		{banners_bottom_data.title}
	</div>
		
	<div id="copyrights">
		{phrases.copyrights}
		&nbsp;&nbsp;&nbsp;&nbsp;
		{phrases.solution}: <a href="http://www.acceptus.lt" target="_blank" title="Interneto svetainių kūrimas">acceptus.lt</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="http://www.easywebmanager.lt" target="_blank" title="Turinio Valdymo Sistema">Turinio valdymo sistema easywebmanager</a>
	</div>
		
</div>

<!--[if lte IE 6]> 
<script type="text/javascript" src="js/png.js"></script>
<![endif]-->

</body>
</html>
