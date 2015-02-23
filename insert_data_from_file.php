<a href="http://localhost/silverline/upload.php">link text</a>

<?php
require_once 'external_php_modules/simplexlsx.class.php';

if ( isset($_POST["formSubmit"]) ) {
  
  if(empty($_POST['row_number'])) 
  {
    echo("You didn't select any buildings.");
  } else{
	$rows = $_POST['row_number'];
	$NUM = count($rows);

	if ( $_POST['f_type'] == 'csv'){
	}
	if ( $_POST['f_type'] == 'xlsx'){
		$xlsx = new SimpleXLSX( 'upload/'.$_POST['f_name'] );
		
		echo '<table border="1" cellpadding="3" style="border-collapse: collapse" sortable="sortable">';
		
		list($cols,) = $xlsx->dimension();
		
		foreach( $xlsx->rows() as $k => $r) {
 
			echo '<tr>';
			if ($k != 0){
				if(!empty($rows[$k-1])){
					echo '<td>'.$rows[$k-1].'</td>';
					for( $i = 0; $i < $cols; $i++){
						$col_num = 'col_'.$i;
						if ($_POST[$col_num] != '-'){
							echo '<td>'.( (isset($r[$i])) ? $r[$i] : '&nbsp;' ).'</td>';
						}
					}
				}
				
			}
			echo '</tr>';
		}
		echo '</table>';
	}
	
    for($j=0; $j < $NUM; $j++)
    {
      echo($rows[$j] . " ");
    }
  }
}