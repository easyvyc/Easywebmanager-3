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

<?php } ?>

<?php if($templateVariables->vars["success"]){ ?>
<script type="text/javascript">
parent.PageClass.getPageContent_action('<?php echo $templateVariables->vars["config.site_admin_url"]; ?>ajax.php?get=pages/actions&action=block&content=pages&module=<?php echo $templateVariables->vars["module.table_name"]; ?>&page_id=<?php echo $templateVariables->vars["get.page_id"]; ?>&area=<?php echo $templateVariables->vars["get.area"]; ?>', 'EDIT_area__action', 'edit');
</script>
<?php } ?>