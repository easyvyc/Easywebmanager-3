<div id="id_{elm.name}" class="formElementsField">
	<div >
		
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
			
	</div>
	<div class="e">
	
		<input type='password' name='{elm.name}_1' value='' placeholder="{phrases.password1}" class='{style}_text {elm.style}'> {block elm.required_field}*{-block elm.required_field}
	
	</div>
	<div class="e" style="margin:3px 0px;">
	
		<input type='password' name='{elm.name}_2' value='' placeholder="{phrases.password2}" class='{style}_text {elm.style}'> {block elm.required_field}*{-block elm.required_field}
	
	</div>
</div>
