<ul>
	<call code="name=bmenu::set=loop::module=pages::method=listMenu::params=3345">
	<loop name="bmenu">
	<li <block name="bmenu.selected">class="a"</block name="bmenu.selected">><a href="{lng}{bmenu.page_url}" title="{bmenu.page_title}">{bmenu.title}</a></li>
	</loop name="bmenu">
</ul>



<call code="name=banners_right_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'banners_right'">
{banners_right_data}



<div class="fleft">{phrases.copyrights}</div>
<div class="fright">

	<a href="http://www.adme.lt" target="_blank" title="Interneto svetainių kūrimas">Interneto svetainių kūrimas adme</a>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<block name="lng_lt">
	<a href="http://www.easywebmanager.lt" target="_blank" title="Turinio Valdymo Sistema">Turinio valdymo sistema easywebmanager</a>
	</block name="lng_lt">
	<block name="lng_lt" no>
	<a href="http://www.easywebmanager.com" target="_blank" title="Content Management System">Content management system easywebmanager</a>
	</block name="lng_lt" no>

</div>


<div id="lang">
	<loop name="languages">
	<block name="languages.active" no>
	<a href="{languages.value}/">{languages.title}</a><br />
	</block name="languages.active" no>
	</loop name="languages">
</div>			