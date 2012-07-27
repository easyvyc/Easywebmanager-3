<?php if($templateVariables->vars["elements_count"]){ ?>

<div id="debug_info___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>"></div>
<form action="javascript: void(PageClass.submitForm('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid', document.forms['filter___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>']));" name="filter___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>">
<table id="grid_area___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>" class="grid_area" border="0" cellspacing="1">

<script type="text/javascript">
gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?> = new gridClass('grid_area___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>', '<?php echo $templateVariables->vars["module.table_name"]; ?>', '<?php echo $templateVariables->vars["lng"]; ?>');
</script>

	<thead>
	<tr class="header">
	
	<?php foreach($templateVariables->loops["fields"] as $fields_key => $fields_val){ ?>
		<td rel="<?php echo $fields_val["column_name"]; ?>" id="header_<?php echo $fields_val["column_name"]; ?>" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			<div class="th">
			<?php if(!$fields_val["no_sort"]){ ?>
			<div class="sorter">
			<div><a href="javascript: void(PageClass.getPageContent('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&by=<?php echo $fields_val["column_name"]; ?>&order=ASC&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid'));"><img src="images/sort_up<?php if($fields_val["sort_up"]){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!$fields_val["sort_up"]){ ?>onmouseover="javascript: this.src='images/sort_up_a.gif';" onmouseout="javascript: this.src='images/sort_up.gif';"<?php } ?> /></a></div>
			<div><a href="javascript: void(PageClass.getPageContent('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&by=<?php echo $fields_val["column_name"]; ?>&order=DESC&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid'));"><img src="images/sort_down<?php if($fields_val["sort_down"]){ ?>_a<?php } ?>.gif" alt="" class="" border="0" <?php if(!$fields_val["sort_down"]){ ?>onmouseover="javascript: this.src='images/sort_down_a.gif';" onmouseout="javascript: this.src='images/sort_down.gif';"<?php } ?> /></a></div>
			</div>
			<?php } ?>
			
			<label title="<?php echo $fields_val["title"]; ?>"><?php echo $fields_val["title"]; ?></label>
			
			<?php if($fields_val["second_column_name"]){ ?>
			<div class="resize_column" id="resizer_<?php echo $fields_val["column_name"]; ?>" onmousedown="javascript: grid_mouseDownEvent(event, gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>, '<?php echo $fields_val["column_name"]; ?>', '<?php echo $fields_val["second_column_name"]; ?>', <?php echo $fields_val["_INDEX"]; ?>);" onmouseout="javascript: grid_mouseOutEvent(event, gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>);"></div>
			<?php } ?>
			</div>
		</td>
	
		<script type="text/javascript">
		gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.add('<?php echo $fields_val["column_name"]; ?>', <?php echo $fields_val["w"]; ?>, '<?php echo $fields_val["elm_type"]; ?>');

		<?php if($fields_val["elm_choice"]){ ?>
		
		<?php foreach($templateVariables->loops["fields"][$fields_key]["choice_arr"] as $fields_choice_arr_key => $fields_choice_arr_val){ ?>
		gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.cols[<?php echo $fields_val["I"]; ?>].optionArray[gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.cols[<?php echo $fields_val["I"]; ?>].optionArray.length] = {id:"<?php echo $fields_choice_arr_val["id"]; ?>", title:"<?php echo $fields_choice_arr_val["title"]; ?>"};
		<?php } ?>
		
		<?php } ?>
		
		</script>		


	<?php } ?>

		<?php if($templateVariables->vars["grid_data.edit_button"]){ ?>
		<td rel="editbutton" id="header_editbutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.add('editbutton', 1);
		</script>
		<?php } ?>

		<?php if($templateVariables->vars["grid_data.dublicate_button"]){ ?>
		<td rel="dublicatebutton" id="header_dublicatebutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.add('dublicatebutton', 1);
		</script>
		<?php } ?>

		<?php if($templateVariables->vars["grid_data.delete_button"]){ ?>
		<td rel="deletebutton" id="header_deletebutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.add('deletebutton', 1);
		</script>
		<?php } ?>

		<?php if($templateVariables->vars["grid_data.select_button"]){ ?>
		<td rel="selectbutton" id="header_selectbutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">
		<input type="checkbox" onclick="javascript: selectAllItems(0, this.checked);" style="vertical-align:top;" />
		</td>
		<script type="text/javascript">
		gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.add('selectbutton', 1);
		</script>
		<?php } ?>


		<!--div class="clear"></div-->
	</tr>
	

	<?php if($templateVariables->vars["grid_data.filter_form"]){ ?>
	<input type="hidden" name="action" value="filter" />
	<tr class="header">

	<?php foreach($templateVariables->loops["fields"] as $fields_key => $fields_val){ ?>
		<td rel="<?php echo $fields_val["column_name"]; ?>" id="filter_<?php echo $fields_val["column_name"]; ?>" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div id="filter___<?php echo $fields_val["column_name"]; ?>" class="list_item_filter">

				<?php if($fields_val["elm_text"]){ ?>
				<input type="text" name="filteritem___<?php echo $fields_val["column_name"]; ?>" id="filteritem___<?php echo $fields_val["column_name"]; ?>" value="<?php echo $fields_val["filter_value"]; ?>" class="vam" />
				<?php } ?>

				<?php if($fields_val["elm_custom"]){ ?>
				&nbsp;
				<?php } ?>

				<?php if($fields_val["elm_image"]){ ?>
				&nbsp;
				<?php } ?>

				<?php if($fields_val["elm_file"]){ ?>
				&nbsp;
				<?php } ?>

				<?php if($fields_val["elm_choice"]){ ?>
				<input type="text" name="filteritem___<?php echo $fields_val["column_name"]; ?>" id="filteritem___<?php echo $fields_val["column_name"]; ?>" value="<?php echo $fields_val["filter_value"]; ?>" class="vam" />
				<?php } ?>


				<?php if($fields_val["elm_button"]){ ?>
				<select name="filteritem___<?php echo $fields_val["column_name"]; ?>" id="filteritem___<?php echo $fields_val["column_name"]; ?>" class="vam" onchange="javascript: this.form.submit();">
					<option value="">-</option>
					<option value="1" <?php if($fields_val["value_1"]){ ?>selected<?php } ?>><?php echo $templateVariables->vars["phrases.common.yes"]; ?></option>
					<option value="0" <?php if($fields_val["value_0"]){ ?>selected<?php } ?>><?php echo $templateVariables->vars["phrases.common.no"]; ?></option>
				</select>
				<?php } ?>

				<?php if($fields_val["elm_date"]){ ?>
				<?php if($fields_val["filter_value"]){ ?>
				<input type="image" style="width:auto;height:auto;" src="images/back.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___from').value!='') document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___from').value='<?php echo $fields_val["filter_value_back_from"]; ?>'; if(document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___to').value!='') document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___to').value='<?php echo $fields_val["filter_value_back_to"]; ?>'; document.forms['filter___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>'].submit();" />
				<?php } ?>
				<input type="text" dir="rtl" name="filteritem___<?php echo $fields_val["column_name"]; ?>[from]" id="filteritem___<?php echo $fields_val["column_name"]; ?>___from" class="date vam" value="<?php echo $fields_val["filter_value_from"]; ?>" onclick="javascript: scwShow(this, event); " onchange="javascript: this.form.submit();" />
				<input type="text" dir="rtl" name="filteritem___<?php echo $fields_val["column_name"]; ?>[to]" id="filteritem___<?php echo $fields_val["column_name"]; ?>___to" class="date vam" value="<?php echo $fields_val["filter_value_to"]; ?>" onclick="javascript: scwShow(this, event); " onchange="javascript: this.form.submit();" />
				<?php if($fields_val["filter_value"]){ ?>
				<input type="image" style="width:auto;height:auto;" src="images/forward.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___from').value!='') document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___from').value='<?php echo $fields_val["filter_value_fwd_from"]; ?>'; if(document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___to').value!='') document.getElementById('filteritem___<?php echo $fields_val["column_name"]; ?>___to').value='<?php echo $fields_val["filter_value_fwd_to"]; ?>'; document.forms['filter___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>'].submit();" />
				<?php } ?>
				<!--input type="hidden" name="filteritem___<?php echo $fields_val["column_name"]; ?>" id="filteritem___<?php echo $fields_val["column_name"]; ?>" value="<?php echo $fields_val["filter_value"]; ?>" class="vam" /-->
				<?php } ?>

			</div>
			
		</td>
		
		
	<?php } ?>

		<?php if($templateVariables->vars["grid_data.edit_button"]){ ?>
		<td rel="editbutton" id="filter_editbutton" class="column w10 center">&nbsp;</td>
		<?php } ?>

		<?php if($templateVariables->vars["grid_data.dublicate_button"]){ ?>
		<td rel="dublicatebutton" id="filter_dublicatebutton" class="column w10 center">&nbsp;</td>
		<?php } ?>

		<?php if($templateVariables->vars["grid_data.delete_button"]){ ?>
		<td rel="deletebutton" id="filter_deletebutton" class="column w10 center">&nbsp;</td>
		<?php } ?>

		<?php if($templateVariables->vars["grid_data.select_button"]){ ?>
		<td rel="selectbutton" id="filter_selectbutton" class="column w10 center" >&nbsp;</td>
		<?php } ?>

		<input type="submit" style="position:absolute;width:0px;height:0px;top:-20px;left:-50px;" />

	</tr>

	<?php } ?>
	</thead>

	<tbody>
	
	<?php if($templateVariables->vars["filter_elements_count"]){ ?>
	<?php foreach($templateVariables->loops['items'] as $k_items=>$v_items){ 
			$i=0; ?>
	<tr class="item" id="item_row_<?php echo $v_items['id']; ?>" onmouseover="javascript: this.className='item a'" onmouseout="javascript: this.className='item'">
		
		<div id="contextmenu_<?php echo $v_items['id']; ?>" class="contextMenu">
			<div class="title"><?php echo $v_items['title']; ?></div>
			<div class="text">
				<?php foreach($v_items['context'] as $context_k=>$context_v){ ?>
				<div><a <?php if($context_v['action']){ ?>href="javascript: void(eval('<?php echo $context_v['action']; ?>'));"<?php } ?>><img src="images/<?php echo $context_v['img']; ?>.gif" alt="" class="vam" border="0" /> <?php echo $context_v['title']; ?></a></div>
				<?php } ?>
			</div>
		</div>
		
		<?php foreach($templateVariables->loops['fields'] as $k_fields=>$v_fields){ ?>
		
		<td title="<?php echo (isset($v_items[$v_fields['column_name'].'_ALT'])?$v_items[$v_fields['column_name'].'_ALT']:htmlspecialchars($v_items[$v_fields['column_name']])); ?>" class="column" rel="<?php echo $v_fields['column_name']; ?>" id="item___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>ondblclick="javascript: gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.cellEditItem_<?php echo $v_fields['elm_type']; ?>(this, event);"<?php } ?> >
			
			<?php if($v_fields['elm_text']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<textarea name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="vam" ><?php echo $v_items[$v_fields['column_name']]; ?></textarea>
				<div class="edit_text_save">
					<a href="javascript: void(gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));"><?php echo $templateVariables->vars["phrases.common.close"]; ?></a>
					<a href="javascript: void(ajaxChangeFieldText('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["grid_data.script"]; ?>', document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '<?php echo $templateVariables->vars["module.table_name"]; ?>', '<?php echo $templateVariables->vars["lng"]; ?>', window.event, 0));"><?php echo $templateVariables->vars["phrases.common.save"]; ?></a>
				</div>
				<!--input type="text" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam" onblur="javascript: gridObject.cellBlurEvent(this);" onkeydown="javascript: ctrlKeyPressed = isCtrlKeyPressed(event);" onkeyup="javascript: ctrlKeyPressed=0;" onkeypress="javascript: ajaxChangeFieldText('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["grid_data.script"]; ?>', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '<?php echo $templateVariables->vars["module.table_name"]; ?>', '<?php echo $templateVariables->vars["lng"]; ?>', event, ctrlKeyPressed);" /-->
			</div>
			<?php } ?>
			<?php } ?>

			<?php if($v_fields['elm_custom']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value">
			<?php echo ereg_replace("<id>", $v_items['id'], $v_fields['tpl']); ?>
			</div>
			<?php } ?>

			<?php if($v_fields['elm_image']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value">
			<?php echo "<img id=\"img___{$v_fields['column_name']}___{$v_items['id']}\" src=\"".($v_items[$v_fields['column_name']]?"file.php?module={$templateVariables->vars['module.table_name']}&column=".$v_fields['column_name']."&id=".$v_items['id']."&lng={$templateVariables->vars['lng']}&w=100&h=40&t=1":"images/0.gif")."\" alt=\"".$v_items[$v_fields['column_name']]."\" border=0 />"; ?>
			</div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<input type="hidden" id="old_img_<?php echo $v_fields['column_name']; ?>_<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" />
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				
				<span id="btn___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>"></span>
				<span id="btnCancel"></span>
				<span id="fsUploadProgress"></span>
				
				<?php if($templateVariables->vars["no"]){ ?>
				<input type="file" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="vam" style="width:auto;height:auto;" />
				<div class="edit_text_save">
					<a href="javascript: void(gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));"><?php echo $templateVariables->vars["phrases.common.close"]; ?></a>
					<a href="javascript: void(ajaxChangeFieldImage('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["grid_data.script"]; ?>', document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '<?php echo $templateVariables->vars["module.table_name"]; ?>', '<?php echo $templateVariables->vars["lng"]; ?>', window.event, 0));"><?php echo $templateVariables->vars["phrases.common.save"]; ?></a>
				</div>
				<?php } ?>
				
			</div>
			<?php } ?>
			<?php } ?>

			<?php if($v_fields['elm_file']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value">
			<?php echo "<a id=\"file_link_{$v_fields['column_name']}_{$v_items['id']}\" href=\"file.php?module={$templateVariables->vars['module.table_name']}&column=".$v_fields['column_name']."&id=".$v_items['id']."&lng={$templateVariables->vars['lng']}&w=60&h=40&t=1\" target=\"_blank\">".$v_items[$v_fields['column_name']]."</a>"; ?>
			<?php echo "<img id=\"img___{$v_fields['column_name']}___{$v_items['id']}\" src=\"images/0.gif\" alt=\"\" />"; ?>
				<input type="hidden" id="old_img_<?php echo $v_fields['column_name']; ?>_<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" />
				<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">	
					<span id="btn___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>"></span>
					<span id="btnCancel"></span>
					<span id="fsUploadProgress"></span>
				</div>
			
			</div>
			<?php } ?>

			<?php if($v_fields['elm_choice']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<select name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="fo_select vam" onblur="javascript: gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.cellBlurEvent(this);" onchange="javascript: ajaxChangeFieldSelect('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["grid_data.script"]; ?>', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '<?php echo $templateVariables->vars["module.table_name"]; ?>', '<?php echo $templateVariables->vars["lng"]; ?>', event);" />
				</select>
				<input type="hidden" name="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name'].'_ids']; ?>" />
			</div>
			<?php } ?>
			<?php } ?>


			<?php if($v_fields['elm_button']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value center">
			<input type="hidden" id="chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" />
			<img id="buttonImg_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" src="images/status_<?php echo $v_items[$v_fields['column_name']]; ?>.gif" border="0" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>style="cursor:pointer;" onclick="javascript: ajaxChangeFieldCheckbox('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["grid_data.script"]; ?>', document.getElementById('chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>').value, <?php echo $v_items['id']; ?>, <?php echo ($v_items['parent_id']?$v_items['parent_id']:0); ?>, '<?php echo $v_fields['column_name']; ?>', '<?php echo $templateVariables->vars["module.table_name"]; ?>', '<?php echo $templateVariables->vars["lng"]; ?>', event);"<?php } ?> alt="" />
			</div>
			<?php } ?>
			
			
			<?php if($v_fields['elm_date']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<input type="text" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam"  onchange="javascript: ajaxChangeFieldText('<?php echo $templateVariables->vars["config.site_url"]; ?>', '<?php echo $templateVariables->vars["grid_data.script"]; ?>', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '<?php echo $templateVariables->vars["module.table_name"]; ?>', '<?php echo $templateVariables->vars["lng"]; ?>', event);" />
			</div>
			<?php } ?>
			<?php } ?>


		</td>


		<?php } ?>


		<?php if($templateVariables->vars["grid_data.edit_button"]){ ?>
		<td class="column w10 center" rel="editbutton" id="item___editbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.edit_page"]; ?>&id=<?php echo $v_items['id']; ?><?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>#edit"><img src="images/<?php if($v_items['lng_saved']){ ?>edit<?php }else { ?>not_saved<?php } ?>.gif" border="0"></a>
			<?php } ?>
		</td>
		<?php } ?>


		<?php if($templateVariables->vars["grid_data.dublicate_button"]){ ?>
		<td class="column w10 center" rel="dublicatebutton" id="item___dublicatebutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.edit_page"]; ?>&id=0&parent_id=<?php echo $templateVariables->vars["parent_id"]; ?>&new=1&duplicate=<?php echo $v_items['id']; ?><?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>"><img src="images/duplicate.gif" border="0"></a>
			<?php } ?>
		</td>
		<?php } ?>

		<?php if($templateVariables->vars["grid_data.delete_button"]){ ?>
		<td class="column w10 center" rel="deletebutton" id="item___deletebutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.edit_page"]; ?>&id=<?php echo $v_items['id']; ?><?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>#delete"><img src="images/delete.gif" border="0" alt="" /></a>
			<?php } ?>
		</td>
		<?php } ?>
		
		
		<?php if($templateVariables->vars["grid_data.select_button"]){ ?>
		<td class="column w10 center" rel="selectbutton" id="item___selectbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<input type="checkbox" name="chk[]" id="chk_<?php echo $k_items; ?>" value="<?php echo $v_items['id']; ?>" style="vertical-align:top;" />
			<?php } ?>
		</td>
		<?php } ?>

		<!--div class="clear"></div-->
	</tr>
	<?php } ?>
	<?php } ?>

	</tbody>
</table>
</form>
	
	
<div style="padding:5px;padding-right:12px;padding-left:0px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
			<div class="paging">

			<span class="all_items_count"><?php echo $templateVariables->vars["phrases.catalog.import_data_items_count"]; ?>: <b><?php echo $templateVariables->vars["filter_elements_count"]; ?></b></span>


			<?php if(!$templateVariables->vars["grid_data.no_paging"]){ ?>
			<?php if($templateVariables->vars["items_in_one_page"]){ ?>
			
			<form method="post" style="display:inline;" name="paging___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>">
			<input type="hidden" name="action" value="paging">
			<?php echo $templateVariables->vars["phrases.common.display_paging"]; ?>: 
			<select name="paging_items" onchange="javascript: PageClass.submitForm('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid', document.forms['paging___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>']);" class="fo_select">
				
				<?php foreach($templateVariables->loops["items_in_one_page"] as $items_in_one_page_key => $items_in_one_page_val){ ?>
				<option value="<?php echo $items_in_one_page_val["value"]; ?>" <?php if($items_in_one_page_val["active"]){ ?>selected<?php } ?>> - <?php echo $items_in_one_page_val["value"]; ?> - </option> 
				<?php } ?>
				
			</select>
			</form>	
			
			<?php if($templateVariables->vars["paging.paging_start_arrow"]){ ?>
			<a href="javascript: void(PageClass.getPageContent('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&offset=<?php echo $templateVariables->vars["paging.paging_start_arrow_value"]; ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid'));" class="paging_0">«</a> 
			<?php } ?>
				
			<?php foreach($templateVariables->loops["paging"] as $paging_key => $paging_val){ ?>
				<?php if(!$paging_val["active"]){ ?>
				<a href="javascript: void(PageClass.getPageContent('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&offset=<?php echo $paging_val["value"]; ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid'));" class="paging_0"><?php echo $paging_val["title"]; ?></a> 
				<?php } ?>
				<?php if($paging_val["active"]){ ?>
				<span class="paging_1"><?php echo $paging_val["title"]; ?></span> 
				<?php } ?>
			<?php } ?>

			<?php if($templateVariables->vars["paging.paging_end_arrow"]){ ?>
			<a href="javascript: void(PageClass.getPageContent('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&offset=<?php echo $templateVariables->vars["paging.paging_end_arrow_value"]; ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid'));" class="paging_0">»</a> 
			<?php } ?>
			
			<?php } ?>
			<?php } ?>

			</div>
		</td>	
		<td align="right">
			
			<?php if($templateVariables->vars["grid_data.select_button"]){ ?>
			<form name="btn_actions___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>" style="display:inline;">
			<?php echo $templateVariables->vars["phrases.common.action_with_selected_items"]; ?>: 
			<input type="hidden" name="action_elements" value="1">
			<input type="hidden" name="action" value="action_with_selected_items">
			
			<select name="action_choice" style="width:70px;" onchange="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.common.confirm_action_with_selected_items"]; ?>')) PageClass.submitForm('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["grid_data.list_page"]; ?>&id=<?php echo $templateVariables->vars["parent_id"]; ?>&action=action_with_selected_items&action_choice='+this.options[this.selectedIndex].value+'&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', '<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>_grid', document.forms['filter___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>']); else this.selectedIndex=0; " class="fo_select vam">
				<option value="">-----</option>
				<?php foreach($templateVariables->loops["fields"] as $fields_key => $fields_val){ ?>
				<?php if($fields_val["editable"]){ ?>
				<?php if($fields_val["button"]){ ?>
					<option value="<?php echo $fields_val["column_name"]; ?>"><?php echo $fields_val["title"]; ?></option>
				<?php } ?>
				<?php } ?>
				<?php } ?>
				<?php if($templateVariables->vars["grid_data.delete_button"]){ ?><option value="delete"><?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></option><?php } ?>
			</select>
			</form>
			<?php } ?>
			
		</td>
	</tr>
</table>


<div id="contextMenuArea" onmouseout="javascript: gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.hideItemContenxtMenu(event);"></div>



<?php if(!$templateVariables->vars["filter_elements_count"]){ ?>
<div>
<?php echo $templateVariables->vars["phrases.common.empty_items"]; ?>
</div>
<?php } ?>



<script type="text/javascript">

gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.init();

<?php if($templateVariables->vars["fields.elm_choice"]){ ?>
<?php foreach($templateVariables->loops["fields"][$fields_key]["choice_arr"] as $fields_choice_arr_key => $fields_choice_arr_val){ ?>
gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.cols[<?php echo $templateVariables->vars["fields.I"]; ?>].optionArray[gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.columns.cols[<?php echo $templateVariables->vars["fields.I"]; ?>].optionArray.length] = {id:"<?php echo $fields_choice_arr_val["id"]; ?>", title:"<?php echo $fields_choice_arr_val["title"]; ?>"};
<?php } ?>
<?php } ?>

<?php if($templateVariables->vars["grid_data.dragndrop"]){ ?>
var table = document.getElementById('grid_area___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>');
var tableDnD___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?> = new TableDnD();

tableDnD___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.url = 'main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php echo $templateVariables->vars["get.page"]; ?>&id=<?php echo $templateVariables->vars["get.id"]; ?>&action=change_order<?php if($templateVariables->vars["get.offset"]){ ?>&offset=<?php echo $templateVariables->vars["get.offset"]; ?><?php } ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>';
tableDnD___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.confirm_text = '<?php echo $templateVariables->vars["phrases.catalog.move_confirm_text"]; ?>';

tableDnD___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.init(table);

<?php } ?>

 
if(document.body.addEventListener){
	document.body.addEventListener('contextmenu', gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.mouseRightClick, true);
}else{
	$('grid_area___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>').oncontextmenu = gridObject___<?php echo $templateVariables->vars["grid_data.grid_name"]; ?>.mouseRightClick;
}

 
</script>

<?php } ?>


<?php if(!$templateVariables->vars["elements_count"]){ ?>
<div>
<?php echo $templateVariables->vars["phrases.common.empty_items"]; ?>
</div>
<?php } ?>

<?php if($templateVariables->vars["grid_data.filters"]){ ?>
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
<?php } ?>