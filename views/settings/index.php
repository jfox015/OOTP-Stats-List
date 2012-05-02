<?php if (validation_errors()) : ?>
<div class="notification error">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div class="admin-box">

    <h3><?php echo lang('statslist_settings') ?></h3>

    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

    <fieldset>
			<!-- RESTRICT TO PRIMARY OR NOT -->
		<div class="control-group <?php echo form_error('limit_to_primary') ? 'error' : '' ?>">
            <label class="control-label"><?php echo lang('sl_limit_to_primary') ?></label>
            <div class="controls">
			<?php
			$use_selection = ((isset($settings['statslist.limit_to_primary']) && $settings['statslist.limit_to_primary'] == 1) || !isset($settings['statslist.limit_to_primary'])) ? true : false;
			echo form_checkbox('limit_to_primary',1, $use_selection,'id="limit_to_primary"');
			?>
			</div>
        </div>
	</fieldset>
    <div class="form-actions">
        <input type="submit" name="submit" class="btn primary" value="<?php echo lang('bf_action_save') ?> " /> <?php echo lang('bf_or') ?> <?php echo anchor(SITE_AREA .'/settings', lang('bf_action_cancel')); ?>
    </div>

</div>
<?php echo form_close(); ?>
