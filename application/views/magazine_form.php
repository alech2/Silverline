<?= validation_errors(); ?>
<?= $this->upload->display_errors('<div class="alert alert-error">','</div>'); ?>
<?= form_open_multipart(); ?>
<!-- <?= form_open(); ?>  REGULAR FORM -->
<div>
	<?= form_label('Publication_name','publication_id'); ?>
	<?= form_dropdown('publication_id', $publication_form_options, set_value('publication_id'));  ?>
</div>
<div>
    <?= form_label('Issue Number', 'issue_number'); ?>
    <?= form_input('issue_number', set_value('issue_number')); ?>
</div>
<div>
    <?= form_label('Date Published', 'issue_date_publication'); ?>
    <?= form_input('issue_date_publication', set_value('issue_date_publication')); ?>
</div>
<div>
    <?= form_label('Cover Scan', 'issue_cover'); ?>
    <?= form_upload('issue_cover'); ?>
</div>
<div>
    <?= form_submit('save', 'Save'); ?>
</div>
<?= form_close(); ?>


<!-- PLAIN HTML FORM -->
<!-- <form method="post">
	<div>
		<label for="publication_id">Publication name</label>
		<select name="publication_id">
			<?php 
				foreach ($publication_form_options as $publication_id => $publication_name) {
					echo '<option value="' .html_escape($publication_id) .'">' . html_escape($publication_name) . '</option>';
				}
			 ?>
		</select>
	</div>
	<div>
		<label for="issue_number">Issue Number</label>
		<input type="text" name="issue_number" value="">
	</div>
	<div>
		<label for="issue_date_publication">Data Published</label>
		<input type="text" name="issue_date_publication" value="">
	</div>
	<div>
		<input type="submit" value="Save"/>
	</div>
</form> -->