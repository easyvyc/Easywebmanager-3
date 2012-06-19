<call code="name=item_data::set=var::module=pages::method=loadItem::params={{page_data.id}}">

<h1>{item_data.title}</h1>

<call code="name=news_list::set=loop::module=products::method=listItems::params={{item_data.id}},{{get.offset}},5">
<loop name="news_list">

<div class="news_item">
<a class="news_title" href="{lng}{news_list.page_url}" title="{news_list.page_title}"><b>{news_list.title}</b></a> <br />
{news_list.short_description} 
<a href="{lng}{news_list.page_url}">... {phrases.more}</a>
<div class="clear"></div>
</div>

</loop name="news_list">



<call code="name=news_paging::set=loop::module=products::method=pagingItems::params={{get.offset}},5,7">
<div class="paging">
<loop name="news_paging">
<a href="{lng}{data.page_url}{reserved_url_words.offset}/{news_paging.value}" <block name="news_paging.active">class="a"</block name="news_paging.active">>{news_paging.title}</a>
</loop name="news_paging">
</div>