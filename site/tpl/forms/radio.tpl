<div id="id_{elm.name}" class="formElementsField" {elm.extra_params}>
	<span class="{elm.style}">{elm.title}:{block elm.required_field}*{-block elm.required_field}</span>
	{block elm.show_error}<span class="error_message">{elm.error_message}</span><br>{-block elm.show_error}
	<br>
		{loop list}
		<div style="float:left;width:250px;">
		<input type='radio' name='{elm.name}' value='{list.value}' class='{style}_{elm.elm_type}' id='id_{elm.name}_{list.value}' {block list.checked}checked{-block list.checked} />
		<label for="id_{elm.name}_{list.value}">{list.title}</label>
		</div>
		{-loop list}
		<div style="clear:left;"></div>	
</div>
