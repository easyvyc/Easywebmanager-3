<block name="success" no>

{form}

<block name="data.isNew" no>
<div class="edit_item_info">

	{phrases.common.created}: {data.create_date} ({data.create_by_ip})
	<block name="record_author_create.id">{record_author_create.id} - {record_author_create.title} ({record_author_create.module_title})</block name="record_author_create.id">
	<block name="record_author_create.id" no> - {phrases.common.anonymous_record_author}</block name="record_author_create.id" no>
	<br />
	{phrases.common.modificated}: {data.last_modif_date} ({data.last_modif_by_ip})
	<block name="record_author_modify.id">{record_author_modify.id} - {record_author_modify.title} ({record_author_modify.module_title})</block name="record_author_modify.id">
	<block name="record_author_modify.id" no>{phrases.common.anonymous_record_author}</block name="record_author_modify.id" no>

</div>
</block name="data.isNew" no>

</block name="success" no>

<block name="success">
<script type="text/javascript">
//parent.document.getElementById('formContent_{form_name}').innerHTML = '{phrases.catalog.item_add_success}';
parent.PageClass.getPageContent('{config.site_admin_url}main.php?content={get.content}&module={module.table_name}&page=list&id={get.parent_id}&ajax=1&area=tpl_grid', 'items_list_grid');
top.modules.TreeObj_{module.table_name}_s.create({get.parent_id});
parent.PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions/edit&content={get.content}&module={module.table_name}&id={get.id}', 'EDIT_area__action', 'edit');
</script>
</block name="success">