<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">
<div class="inner">
	
	<h1>{phrases.search_title}</h1>
	
	<div class="desc">
		
		<block name="short_key">
		{phrases.to_short_key}
		</block name="short_key">
		
		<block name="short_key" no>
		<block name="no_results">
		{phrases.no_search_results}
		</block name="no_results">
		
		<loop name="search_results">
		<div class="search_res">
		<block name="search_results.image">
		<a href="{search_results.lng}{search_results.page_url}"><img alt="{search_results._title_}" src="{upload_url}thumb_{search_results.image}" /></a>
		</block name="search_results.image">
		<a href="{search_results.lng}{search_results.page_url}">{search_results._title_}</a>
		<p>...{search_results._description_}...</p>
		</div>
		</loop name="search_results">
		
		</block name="short_key" no>
		
	</div>
	
</div>