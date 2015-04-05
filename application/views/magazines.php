<h2>My Magazines</h2>
<?php // Using table object to show table using array
$this->table->set_heading('Publication', 'Issue', 'Date', 'Cover', 'Actions');
echo $this->table->generate($magazines);