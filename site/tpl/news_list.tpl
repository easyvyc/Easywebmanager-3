<call code="name=item_data::set=var::module=pages::method=loadItem::params={{page_data.id}}">

<h1>{item_data.title}</h1>

<call code="name=news_list::set=loop::module=news::method=listItems::params={{item_data.id}},{{get.offset}},5">
<loop name="news_list">

<div class="news_item">
<div class="cal">
<div class="m">{news_list.month}</div>
<div class="d">{news_list.day}</div>
<div class="y">{news_list.year}</div>
</div>
<a class="news_title" href="{lng}{news_list.page_url}" title="{news_list.page_title}"><b>{news_list.title}</b></a> <br />
{news_list.summary} 
<a href="{lng}{news_list.page_url}">... {phrases.more}</a>
<div class="clear"></div>
</div>

</loop name="news_list">



<call code="name=news_paging::set=loop::module=news::method=pagingItems::params={{get.offset}},5,7">
<div class="paging">
<loop name="news_paging">
<a href="{lng}{data.page_url}{reserved_url_words.offset}/{news_paging.value}" <block name="news_paging.active">class="a"</block name="news_paging.active">>{news_paging.title}</a>
</loop name="news_paging">
</div>