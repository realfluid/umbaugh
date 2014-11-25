<form method="post" id="low-find-replace" action="<?=$base_url?>&amp;method=find&amp;preview=yes">
	<div>
		<input type="hidden" name="<?=$csrf_token_name?>" value="<?=$csrf_token_value?>" />
	</div>

	<div id="low-filters">

		<ul id="low-tabs">
			<li class="active"><a href="#low-channel-fields"><?=lang('channels')?></a></li>
			<?php if ($categories): ?><li><a href="#low-categories"><?=lang('categories')?></a></li><?php endif; ?>
		</ul>

		<fieldset id="low-channel-fields" class="tab active">
			<div class="low-pane">
				<div class="low-boxes">
					<label><input type="checkbox" class="low-select-all" /> <?=lang('select_all')?></label>
				</div>
				<?php foreach ($channels AS $channel_id => $row): ?>
				<div class="low-boxes">
					<h4><span><?=htmlspecialchars($row['channel_title'])?></span></h4>
					<?php foreach ($row['fields'] AS $field_id => $field_name): ?>
						<label>
							<input type="checkbox" name="fields[<?=$channel_id?>][]" value="<?=$field_id?>" />
							<?=htmlspecialchars($field_name)?>
						</label>
					<?php endforeach; ?>
				</div>
				<?php endforeach; ?>
			</div>

		</fieldset>

		<?php if ($categories): ?>
		<fieldset id="low-categories" class="tab">
			<div class="low-pane">
				<div class="low-boxes">
					<label><input type="checkbox" class="low-select-all" /> <?=lang('select_all')?></label>
				</div>
				<?php foreach ($categories AS $group_id => $row): ?>
				<div class="low-boxes">
					<h4><span><?=htmlspecialchars($row['group_name'])?></span></h4>
					<?php foreach ($row['cats'] AS $cat_id => $cat): ?>
						<label>
							<?=$cat['indent']?>
							<input type="checkbox" name="cats[]" value="<?=$cat_id?>" />
							<?=$cat['name']?>
						</label>
					<?php endforeach; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</fieldset>
		<?php endif; ?>

	</div>
	<div id="low-find" class="low-inline-form">
		<label for="low-keywords"><?=lang('find')?>:</label>
		<input type="text" id="low-keywords" name="keywords" />
		<button class="submit" type="submit"><?=lang('show_preview')?></button>
	</div>
</form>

<div id="low-preview">
	<?php if (isset($feedback)) include(PATH_THIRD.'/low_search/views/ajax_replace_feedback.php'); ?>
	<?php if (isset($preview))  include(PATH_THIRD.'/low_search/views/ajax_preview.php'); ?>
</div>
