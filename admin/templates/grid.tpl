<block name="elements_count">

<div id="debug_info___{grid_data.grid_name}"></div>
<form action="javascript: void(PageClass.submitForm('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid', document.forms['filter___{grid_data.grid_name}']));" name="filter___{grid_data.grid_name}">
<table id="grid_area___{grid_data.grid_name}" class="grid_area" border="0" cellspacing="1">

<script type="text/javascript">
gridObject___{grid_data.grid_name} = new gridClass('grid_area___{grid_data.grid_name}', '{module.table_name}', '{lng}');
</script>

	<thead>
	<tr class="header">
	
	<loop name="fields">
		<td rel="{fields.column_name}" id="header_{fields.column_name}" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			<div class="th">
			<block name="fields.no_sort" no>
			<div class="sorter">
			<div><a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&by={fields.column_name}&order=ASC&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid'));"><img src="images/sort_up<block name="fields.sort_up">_a</block name="fields.sort_up">.gif" alt="" class="" border="0" <block name="fields.sort_up" no>onmouseover="javascript: this.src='images/sort_up_a.gif';" onmouseout="javascript: this.src='images/sort_up.gif';"</block name="fields.sort_up" no> /></a></div>
			<div><a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&by={fields.column_name}&order=DESC&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid'));"><img src="images/sort_down<block name="fields.sort_down">_a</block name="fields.sort_down">.gif" alt="" class="" border="0" <block name="fields.sort_down" no>onmouseover="javascript: this.src='images/sort_down_a.gif';" onmouseout="javascript: this.src='images/sort_down.gif';"</block name="fields.sort_down" no> /></a></div>
			</div>
			</block name="fields.no_sort" no>
			
			<label title="{fields.title}">{fields.title}</label>
			
			<block name="fields.second_column_name">
			<div class="resize_column" id="resizer_{fields.column_name}" onmousedown="javascript: grid_mouseDownEvent(event, gridObject___{grid_data.grid_name}, '{fields.column_name}', '{fields.second_column_name}', {fields._INDEX});" onmouseout="javascript: grid_mouseOutEvent(event, gridObject___{grid_data.grid_name});"></div>
			</block name="fields.second_column_name">
			</div>
		</td>
	
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('{fields.column_name}', {fields.w}, '{fields.elm_type}');

		<block name="fields.elm_choice">
		
		<loop name="fields.choice_arr">
		gridObject___{grid_data.grid_name}.columns.cols[{fields.I}].optionArray[gridObject___{grid_data.grid_name}.columns.cols[{fields.I}].optionArray.length] = {id:"{fields.choice_arr.id}", title:"{fields.choice_arr.title}"};
		</loop name="fields.choice_arr">
		
		</block name="fields.elm_choice">
		
		</script>		


	</loop name="fields">

		<block name="grid_data.edit_button">
		<td rel="editbutton" id="header_editbutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('editbutton', 1);
		</script>
		</block name="grid_data.edit_button">

		<block name="grid_data.dublicate_button">
		<td rel="dublicatebutton" id="header_dublicatebutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('dublicatebutton', 1);
		</script>
		</block name="grid_data.dublicate_button">

		<block name="grid_data.delete_button">
		<td rel="deletebutton" id="header_deletebutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">&nbsp;</td>
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('deletebutton', 1);
		</script>
		</block name="grid_data.delete_button">

		<block name="grid_data.select_button">
		<td rel="selectbutton" id="header_selectbutton" class="column w10 center" onmouseover="javascript: this.className='column w10 center over';" onmouseout="javascript: this.className='column w10 center';">
		<input type="checkbox" onclick="javascript: selectAllItems(0, this.checked);" style="vertical-align:top;" />
		</td>
		<script type="text/javascript">
		gridObject___{grid_data.grid_name}.columns.add('selectbutton', 1);
		</script>
		</block name="grid_data.select_button">


		<!--div class="clear"></div-->
	</tr>
	

	<block name="grid_data.filter_form">
	<input type="hidden" name="action" value="filter" />
	<tr class="header">

	<loop name="fields">
		<td rel="{fields.column_name}" id="filter_{fields.column_name}" class="column" onmouseover="javascript: this.className='column over';" onmouseout="javascript: this.className='column';">
			
			<div id="filter___{fields.column_name}" class="list_item_filter">

				<block name="fields.elm_text">
				<input type="text" name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" value="{fields.filter_value}" class="vam" />
				</block name="fields.elm_text">

				<block name="fields.elm_custom">
				&nbsp;
				</block name="fields.elm_custom">

				<block name="fields.elm_image">
				&nbsp;
				</block name="fields.elm_image">

				<block name="fields.elm_file">
				&nbsp;
				</block name="fields.elm_file">

				<block name="fields.elm_choice">
				<input type="text" name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" value="{fields.filter_value}" class="vam" />
				</block name="fields.elm_choice">


				<block name="fields.elm_button">
				<select name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" class="vam" onchange="javascript: this.form.submit();">
					<option value="">-</option>
					<option value="1" <block name="fields.value_1">selected</block name="fields.value_1">>{phrases.common.yes}</option>
					<option value="0" <block name="fields.value_0">selected</block name="fields.value_0">>{phrases.common.no}</option>
				</select>
				</block name="fields.elm_button">

				<block name="fields.elm_date">
				<block name="fields.filter_value">
				<input type="image" style="width:auto;height:auto;" src="images/back.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___{fields.column_name}___from').value!='') document.getElementById('filteritem___{fields.column_name}___from').value='{fields.filter_value_back_from}'; if(document.getElementById('filteritem___{fields.column_name}___to').value!='') document.getElementById('filteritem___{fields.column_name}___to').value='{fields.filter_value_back_to}'; document.forms['filter___{grid_data.grid_name}'].submit();" />
				</block name="fields.filter_value">
				<input type="text" dir="rtl" name="filteritem___{fields.column_name}[from]" id="filteritem___{fields.column_name}___from" class="date vam" value="{fields.filter_value_from}" onclick="javascript: scwShow(this, event); " onchange="javascript: this.form.submit();" />
				<input type="text" dir="rtl" name="filteritem___{fields.column_name}[to]" id="filteritem___{fields.column_name}___to" class="date vam" value="{fields.filter_value_to}" onclick="javascript: scwShow(this, event); " onchange="javascript: this.form.submit();" />
				<block name="fields.filter_value">
				<input type="image" style="width:auto;height:auto;" src="images/forward.gif" alt="" class="vam" onclick="javascript: if(document.getElementById('filteritem___{fields.column_name}___from').value!='') document.getElementById('filteritem___{fields.column_name}___from').value='{fields.filter_value_fwd_from}'; if(document.getElementById('filteritem___{fields.column_name}___to').value!='') document.getElementById('filteritem___{fields.column_name}___to').value='{fields.filter_value_fwd_to}'; document.forms['filter___{grid_data.grid_name}'].submit();" />
				</block name="fields.filter_value">
				<!--input type="hidden" name="filteritem___{fields.column_name}" id="filteritem___{fields.column_name}" value="{fields.filter_value}" class="vam" /-->
				</block name="fields.elm_date">

			</div>
			
		</td>
		
		
	</loop name="fields">

		<block name="grid_data.edit_button">
		<td rel="editbutton" id="filter_editbutton" class="column w10 center">&nbsp;</td>
		</block name="grid_data.edit_button">

		<block name="grid_data.dublicate_button">
		<td rel="dublicatebutton" id="filter_dublicatebutton" class="column w10 center">&nbsp;</td>
		</block name="grid_data.dublicate_button">

		<block name="grid_data.delete_button">
		<td rel="deletebutton" id="filter_deletebutton" class="column w10 center">&nbsp;</td>
		</block name="grid_data.delete_button">

		<block name="grid_data.select_button">
		<td rel="selectbutton" id="filter_selectbutton" class="column w10 center" >&nbsp;</td>
		</block name="grid_data.select_button">

		<input type="submit" style="position:absolute;width:0px;height:0px;top:-20px;left:-50px;" />

	</tr>

	</block name="grid_data.filter_form">
	</thead>

	<tbody>
	
	<block name="filter_elements_count">
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
		
		<td title="<?php echo (isset($v_items[$v_fields['column_name'].'_ALT'])?$v_items[$v_fields['column_name'].'_ALT']:htmlspecialchars($v_items[$v_fields['column_name']])); ?>" class="column" rel="<?php echo $v_fields['column_name']; ?>" id="item___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>ondblclick="javascript: gridObject___{grid_data.grid_name}.cellEditItem_<?php echo $v_fields['elm_type']; ?>(this, event);"<?php } ?> >
			
			<?php if($v_fields['elm_text']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<textarea name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="vam" ><?php echo $v_items[$v_fields['column_name']]; ?></textarea>
				<div class="edit_text_save">
					<a href="javascript: void(gridObject___{grid_data.grid_name}.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));">{phrases.common.close}</a>
					<a href="javascript: void(ajaxChangeFieldText('{config.site_url}', '{grid_data.script}', document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', window.event, 0));">{phrases.common.save}</a>
				</div>
				<!--input type="text" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam" onblur="javascript: gridObject.cellBlurEvent(this);" onkeydown="javascript: ctrlKeyPressed = isCtrlKeyPressed(event);" onkeyup="javascript: ctrlKeyPressed=0;" onkeypress="javascript: ajaxChangeFieldText('{config.site_url}', '{grid_data.script}', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event, ctrlKeyPressed);" /-->
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
				
				<block name="no">
				<input type="file" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="vam" style="width:auto;height:auto;" />
				<div class="edit_text_save">
					<a href="javascript: void(gridObject___{grid_data.grid_name}.cellBlurEvent(document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>')));">{phrases.common.close}</a>
					<a href="javascript: void(ajaxChangeFieldImage('{config.site_url}', '{grid_data.script}', document.getElementById('edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>').value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', window.event, 0));">{phrases.common.save}</a>
				</div>
				</block name="no">
				
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
				<select name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="fo_select vam" onblur="javascript: gridObject___{grid_data.grid_name}.cellBlurEvent(this);" onchange="javascript: ajaxChangeFieldSelect('{config.site_url}', '{grid_data.script}', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event);" />
				</select>
				<input type="hidden" name="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititemvalue___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name'].'_ids']; ?>" />
			</div>
			<?php } ?>
			<?php } ?>


			<?php if($v_fields['elm_button']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value center">
			<input type="hidden" id="chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" />
			<img id="buttonImg_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>" src="images/status_<?php echo $v_items[$v_fields['column_name']]; ?>.gif" border="0" <?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>style="cursor:pointer;" onclick="javascript: ajaxChangeFieldCheckbox('{config.site_url}', '{grid_data.script}', document.getElementById('chk_<?php echo $v_items['id']; ?>_<?php echo $v_fields['column_name']; ?>').value, <?php echo $v_items['id']; ?>, <?php echo ($v_items['parent_id']?$v_items['parent_id']:0); ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event);"<?php } ?> alt="" />
			</div>
			<?php } ?>
			
			
			<?php if($v_fields['elm_date']==1){ ?>
			<div id="value___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_value"><?php echo $v_items[$v_fields['column_name']]; ?></div>
			<?php if($v_fields['editable']==1 && $v_items['editorship']){ ?>
			<div id="edit___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" class="list_item_edit">
				<input type="text" name="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" id="edititem___<?php echo $v_fields['column_name']; ?>___<?php echo $v_items['id']; ?>" value="<?php echo $v_items[$v_fields['column_name']]; ?>" class="vam"  onchange="javascript: ajaxChangeFieldText('{config.site_url}', '{grid_data.script}', this.value, <?php echo $v_items['id']; ?>, <?php echo $v_items['parent_id']; ?>, '<?php echo $v_fields['column_name']; ?>', '{module.table_name}', '{lng}', event);" />
			</div>
			<?php } ?>
			<?php } ?>


		</td>


		<?php } ?>


		<block name="grid_data.edit_button">
		<td class="column w10 center" rel="editbutton" id="item___editbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="main.php?content={get.content}&module={module.table_name}&page={grid_data.edit_page}&id=<?php echo $v_items['id']; ?><block name="get.filters">&filters={get.filters}</block name="get.filters">#edit"><img src="images/<?php if($v_items['lng_saved']){ ?>edit<?php }else { ?>not_saved<?php } ?>.gif" border="0"></a>
			<?php } ?>
		</td>
		</block name="grid_data.edit_button">


		<block name="grid_data.dublicate_button">
		<td class="column w10 center" rel="dublicatebutton" id="item___dublicatebutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="main.php?content={get.content}&module={module.table_name}&page={grid_data.edit_page}&id=0&parent_id={parent_id}&new=1&duplicate=<?php echo $v_items['id']; ?><block name="get.filters">&filters={get.filters}</block name="get.filters">"><img src="images/duplicate.gif" border="0"></a>
			<?php } ?>
		</td>
		</block name="grid_data.dublicate_button">

		<block name="grid_data.delete_button">
		<td class="column w10 center" rel="deletebutton" id="item___deletebutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<a href="main.php?content={get.content}&module={module.table_name}&page={grid_data.edit_page}&id=<?php echo $v_items['id']; ?><block name="get.filters">&filters={get.filters}</block name="get.filters">#delete"><img src="images/delete.gif" border="0" alt="" /></a>
			<?php } ?>
		</td>
		</block name="grid_data.delete_button">
		
		
		<block name="grid_data.select_button">
		<td class="column w10 center" rel="selectbutton" id="item___selectbutton___<?php echo $v_items['id']; ?>">
			<?php if($v_items['editorship']){ ?>
			<input type="checkbox" name="chk[]" id="chk_<?php echo $k_items; ?>" value="<?php echo $v_items['id']; ?>" style="vertical-align:top;" />
			<?php } ?>
		</td>
		</block name="grid_data.select_button">

		<!--div class="clear"></div-->
	</tr>
	<?php } ?>
	</block name="filter_elements_count">

	</tbody>
</table>
</form>
	
	
<div style="padding:5px;padding-right:12px;padding-left:0px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
			<div class="paging">

			<span class="all_items_count">{phrases.catalog.import_data_items_count}: <b>{filter_elements_count}</b></span>


			<block name="grid_data.no_paging" no>
			<block name="items_in_one_page">
			
			<form method="post" style="display:inline;" name="paging___{grid_data.grid_name}">
			<input type="hidden" name="action" value="paging">
			{phrases.common.display_paging}: 
			<select name="paging_items" onchange="javascript: PageClass.submitForm('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid', document.forms['paging___{grid_data.grid_name}']);" class="fo_select">
				
				<loop name="items_in_one_page">
				<option value="{items_in_one_page.value}" <block name="items_in_one_page.active">selected</block name="items_in_one_page.active">> - {items_in_one_page.value} - </option> 
				</loop name="items_in_one_page">
				
			</select>
			</form>	
			
			<block name="paging.paging_start_arrow">
			<a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&offset={paging.paging_start_arrow_value}&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid'));" class="paging_0">«</a> 
			</block name="paging.paging_start_arrow">
				
			<loop name="paging">
				<block name="paging.active" no>
				<a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&offset={paging.value}&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid'));" class="paging_0">{paging.title}</a> 
				</block name="paging.active" no>
				<block name="paging.active">
				<span class="paging_1">{paging.title}</span> 
				</block name="paging.active">
			</loop name="paging">

			<block name="paging.paging_end_arrow">
			<a href="javascript: void(PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&offset={paging.paging_end_arrow_value}&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid'));" class="paging_0">»</a> 
			</block name="paging.paging_end_arrow">
			
			</block name="items_in_one_page">
			</block name="grid_data.no_paging" no>

			</div>
		</td>	
		<td align="right">
			
			<block name="grid_data.select_button">
			<form name="btn_actions___{grid_data.grid_name}" style="display:inline;">
			{phrases.common.action_with_selected_items}: 
			<input type="hidden" name="action_elements" value="1">
			<input type="hidden" name="action" value="action_with_selected_items">
			
			<select name="action_choice" style="width:70px;" onchange="javascript: if(confirm('{phrases.common.confirm_action_with_selected_items}')) PageClass.submitForm('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page={grid_data.list_page}&id={parent_id}&action=action_with_selected_items&action_choice='+this.options[this.selectedIndex].value+'&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">', '{grid_data.grid_name}_grid', document.forms['filter___{grid_data.grid_name}']); else this.selectedIndex=0; " class="fo_select vam">
				<option value="">-----</option>
				<loop name="fields">
				<block name="fields.editable">
				<block name="fields.button">
					<option value="{fields.column_name}">{fields.title}</option>
				</block name="fields.button">
				</block name="fields.editable">
				</loop name="fields">
				<block name="grid_data.delete_button"><option value="delete">{phrases.common.delete_title}</option></block name="grid_data.delete_button">
			</select>
			</form>
			</block name="grid_data.select_button">
			
		</td>
	</tr>
</table>


<div id="contextMenuArea" onmouseout="javascript: gridObject___{grid_data.grid_name}.hideItemContenxtMenu(event);"></div>



<block name="filter_elements_count" no>
<div>
{phrases.common.empty_items}
</div>
</block name="filter_elements_count" no>



<script type="text/javascript">

gridObject___{grid_data.grid_name}.init();

<block name="fields.elm_choice">
<loop name="fields.choice_arr">
gridObject___{grid_data.grid_name}.columns.cols[{fields.I}].optionArray[gridObject___{grid_data.grid_name}.columns.cols[{fields.I}].optionArray.length] = {id:"{fields.choice_arr.id}", title:"{fields.choice_arr.title}"};
</loop name="fields.choice_arr">
</block name="fields.elm_choice">

<block name="grid_data.dragndrop">
var table = document.getElementById('grid_area___{grid_data.grid_name}');
var tableDnD___{grid_data.grid_name} = new TableDnD();

tableDnD___{grid_data.grid_name}.url = 'main.php?content={get.content}&module={module.table_name}&page={get.page}&id={get.id}&action=change_order<block name="get.offset">&offset={get.offset}</block name="get.offset">&ajax=1&area=tpl_grid<block name="get.filters">&filters={get.filters}</block name="get.filters">';
tableDnD___{grid_data.grid_name}.confirm_text = '{phrases.catalog.move_confirm_text}';

tableDnD___{grid_data.grid_name}.init(table);

</block name="grid_data.dragndrop">

 
if(document.body.addEventListener){
	document.body.addEventListener('contextmenu', gridObject___{grid_data.grid_name}.mouseRightClick, true);
}else{
	$('grid_area___{grid_data.grid_name}').oncontextmenu = gridObject___{grid_data.grid_name}.mouseRightClick;
}

 
</script>

</block name="elements_count">


<block name="elements_count" no>
<div>
{phrases.common.empty_items}
</div>
</block name="elements_count" no>

<block name="grid_data.filters">
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="grid_data.filters">