<!DOCTYPE html> 
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<link rel="stylesheet" type="text/css" href="{config.site_url}clientside.php?f=css" />
<link rel="stylesheet" type="text/css" href="{config.site_url}css/pdf.css" />

<style>
* {
	font-family:Georgia;
}
</style>

</head>
<body>

<a href="{lng}/"><img src="{config.site_url}images/logo.jpg" alt="{phrases.alt_logo}" /></a>

<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">
<h1>{item_data.title}</h1>
		
<div>
	{item_data.description}
</div>



</body>
</html>

