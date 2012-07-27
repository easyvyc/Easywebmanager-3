<?php if(!$templateVariables->vars["success"]){ ?>

<?php echo $templateVariables->vars["form"]; ?>

<?php if(!$templateVariables->vars["data.isNew"]){ ?>
<div class="edit_item_info">

	<?php echo $templateVariables->vars["phrases.common.created"]; ?>: <?php echo $templateVariables->vars["data.create_date"]; ?> (<?php echo $templateVariables->vars["data.create_by_ip"]; ?>)
	<?php if($templateVariables->vars["record_author_create.id"]){ ?><?php echo $templateVariables->vars["record_author_create.id"]; ?> - <?php echo $templateVariables->vars["record_author_create.title"]; ?> (<?php echo $templateVariables->vars["record_author_create.module_title"]; ?>)<?php } ?>
	<?php if(!$templateVariables->vars["record_author_create.id"]){ ?> - <?php echo $templateVariables->vars["phrases.common.anonymous_record_author"]; ?><?php } ?>
	<br />
	<?php echo $templateVariables->vars["phrases.common.modificated"]; ?>: <?php echo $templateVariables->vars["data.last_modif_date"]; ?> (<?php echo $templateVariables->vars["data.last_modif_by_ip"]; ?>)
	<?php if($templateVariables->vars["record_author_modify.id"]){ ?><?php echo $templateVariables->vars["record_author_modify.id"]; ?> - <?php echo $templateVariables->vars["record_author_modify.title"]; ?> (<?php echo $templateVariables->vars["record_author_modify.module_title"]; ?>)<?php } ?>
	<?php if(!$templateVariables->vars["record_author_modify.id"]){ ?><?php echo $templateVariables->vars["phrases.common.anonymous_record_author"]; ?><?php } ?>

</div>
<?php } ?>

<?php if($templateVariables->vars["get.filters"]){ ?>
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
<?php } ?>

<?php } ?>

<?php if($templateVariables->vars["success"]){ ?>
<script type="text/javascript">
<?php if($templateVariables->vars["module.maxlevel"]){ ?>
parent.PageClass.getPageContent('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php if($templateVariables->vars["get.filters"]){ ?>filters<?php } ?><?php if(!$templateVariables->vars["get.filters"]){ ?>list<?php } ?>&id=<?php if(!$templateVariables->vars["get.filters"]){ ?><?php echo $templateVariables->vars["data.id"]; ?><?php } ?><?php if($templateVariables->vars["get.filters"]){ ?><?php echo $templateVariables->vars["data.parent_id"]; ?><?php } ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', 'items_list_grid');
<?php if(!$templateVariables->vars["get.filters"]){ ?>
if(top.modules.TreeObj_<?php echo $templateVariables->vars["module.table_name"]; ?>_s) top.modules.TreeObj_<?php echo $templateVariables->vars["module.table_name"]; ?>_s.create(<?php echo $templateVariables->vars["data.id"]; ?>);
<?php } ?>
<?php } ?>
<?php if($templateVariables->vars["data.isNew"]){ ?>
parent.PageClass.getPageContent('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=<?php if($templateVariables->vars["get.filters"]){ ?>filters<?php } ?><?php if(!$templateVariables->vars["get.filters"]){ ?>list<?php } ?>&id=<?php if(!$templateVariables->vars["get.filters"]){ ?><?php echo $templateVariables->vars["data.parent_id"]; ?><?php } ?><?php if($templateVariables->vars["get.filters"]){ ?><?php echo $templateVariables->vars["data.parent_id"]; ?><?php } ?>&ajax=1&area=tpl_grid<?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', 'items_list_grid');
parent.document.getElementById('formContent_<?php echo $templateVariables->vars["form_name"]; ?>').innerHTML = '<p><?php echo $templateVariables->vars["phrases.catalog.item_add_success"]; ?>&nbsp;&nbsp;<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page=list&id=<?php echo $templateVariables->vars["data.id"]; ?>#edit"><img src="images/edit.gif" border="0" class="vam" alt="" /> <?php echo $templateVariables->vars["phrases.catalog.edit_element"]; ?></a></p>';
<?php } ?>
<?php if(!$templateVariables->vars["data.isNew"]){ ?>
parent.PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=<?php echo $templateVariables->vars["get.content"]; ?>/actions/module&content=<?php echo $templateVariables->vars["get.content"]; ?>&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&id=<?php echo $templateVariables->vars["data.id"]; ?><?php if($templateVariables->vars["get.filters"]){ ?>&filters=<?php echo $templateVariables->vars["get.filters"]; ?><?php } ?>', 'EDIT_area__action', 'edit');
<?php } ?>
</script>
<?php if($templateVariables->vars["get.filters"]){ ?>
<script type="text/javascript">
parent.parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (parent.document.documentElement.scrollHeight+10) + 'px';
</script>
<?php } ?>

<?php } ?>