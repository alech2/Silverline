<?php 


/**
* 
*/
class Issue extends MY_Model {

	const DB_TABLE = 'issues';
	const DB_TABLE_PK = 'issue_id'; 
	
	public $issue_id;
	public $publication_id;
	public $issue_number;
	public $issue_date_publication;
	public $issue_cover;


}

 ?>