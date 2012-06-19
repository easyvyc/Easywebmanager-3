<!DOCTYPE html> 
<html>
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

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<base href="{config.site_url}" />

<link rel="stylesheet" type="text/css" href="clientside.php?f=css" />
<script type="text/javascript" src="clientside.php?f=js"></script>

<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/ie.css" />
	<script type="text/javascript" src="js/ie_png.js"></script>
	<script type="text/javascript">
		 ie_png.fix('.png');
	</script>
<![endif]-->

<call code="name=rss::set=loop::module=_main::method=listRss::params=">
<loop name="rss">
<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php?module={rss.table_name}&amp;lng={lng}"/>
</loop name="rss">

<!--[if IE]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


{xml_config.google}

</head>
<body>


<div id="main">
<!-- HEADER -->
	<div id="header">
		<div class="container">
			<div class="row-1">
				<div class="fleft">
					<form action="{url_prefix}/{reserved_url_words.search}/" method="get" id="search-form">
						<fieldset>
							<div>
								<input name="q" type="text" value="{phrases.search}" onfocus="if(this.value=='{phrases.search}'){this.value=''}" onblur="if(this.value==''){this.value='{phrases.search}'}" />
								<a href="#" onclick="document.getElementById('search-form').submit()"><em><b>{phrases.search_submit}<span>{phrases.search_submit}</span></b></em></a>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="fright">
					<ul>
						<call code="name=bmenu::set=loop::module=pages::method=listMenu::params=3345">
						<loop name="bmenu">
						<li <block name="bmenu.selected">class="a"</block name="bmenu.selected">><a href="{lng}{bmenu.page_url}" title="{bmenu.page_title}">{bmenu.title}</a></li>
						</loop name="bmenu">
					</ul>
				</div>
			</div>
			<div class="row-2">
				<div class="fleft"><a href="{lng}/"><img src="images/logo.gif" alt="" /></a></div>
				<div class="fright">
				
						<div id="loginblock" class="blokas float">
		
							<div class="nav" id="logincontent">
				
							<block name="loged_user.id" no>
							<div id="login_form"></div>

							<div class="center">
							<a href="javascript: void(ajax('{config.site_url}ajax.php?content=login&lng={lng}', 'login_form'));">{phrases.login}</a>
							&nbsp;|&nbsp;
							<a href="javascript: void(ajax('{config.site_url}ajax.php?content=login&forget=1&lng={lng}', 'login_form'));">{phrases.forget_password}</a>
							&nbsp;|&nbsp;
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
										
						</div>
				
						<div class="cart float radius10" id="cartcontent">{cart_content}</div>
						
						<div class="clear"></div>
				
				</div>
			</div>
		</div>
	</div>
<!-- CONTENT -->
	<div id="content">
		<div class="container">
			<div class="indent">
				<div class="wrapper">
					<div class="col-1">
						<h3>{phrases.products_menu}</h3>
						<call code="name=c_menu::set=loop::module=pages::method=listCatalogMenu::params=3757">
						<ul>
							<loop name="c_menu">
							<li><a href="{lng}{c_menu.page_url}" title="{c_menu.page_title}">{c_menu.title}</a>&nbsp;({c_menu.count})
							<ul>
								<loop name="c_menu.sub">
								<li><a href="{lng}{c_menu.sub.page_url}" title="{c_menu.sub.page_title}">{c_menu.sub.title}</a>&nbsp;({c_menu.sub.count})</li>
								</loop name="c_menu.sub">
							</ul>
							</li>
							</loop name="c_menu">
						</ul>
						<div class="banner">
						
							<call code="name=banners_right_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'banners_right'">
							{banners_right_data}
						
						</div>
					</div>
					<div class="col-2" id="page_content">
						
						{page_content}
						
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- FOOTER -->
	<div id="footer">
		<div class="container">
			<div class="indent">
				<div class="fleft">{phrases.copyrights}</div>
				<div class="fright">
				
					<a href="http://www.adme.lt" target="_blank" title="Interneto svetainių kūrimas">Interneto svetainių kūrimas adme</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="http://www.easywebmanager.lt" target="_blank" title="Turinio Valdymo Sistema">Turinio valdymo sistema easywebmanager</a>
				
				</div>
			</div>
		</div>
	</div>
</div>
<!--script type="text/javascript"> Cufon.now(); </script-->

<!--[if lte IE 6]> 
<script type="text/javascript" src="js/png.js"></script>
<![endif]-->

</body>
</html>
