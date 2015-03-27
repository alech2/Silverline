<html lang="en">
<head>
<title>xxxxx</title>
<meta name="Description" content="xxx">
<meta charset="utf-8">
</head>

<a href="http://localhost/silverline/upload.php">link text</a>
<a href="upload.php">index</a>

<?php
require_once 'external_php_modules/simplexlsx.class.php';

if ( isset($_POST["formSubmit"]) ) {
  
  if(empty($_POST['row_number'])) 
  {
    echo("You didn't select any buildings.");
  } else{
	$rows = $_POST['row_number'];
	$NUM = count($rows);
    echo $NUM;
	if ( $_POST['f_type'] == 'csv'){
		if ( $file = fopen( 'upload/' . $_POST['f_name'] , "r" ) ) {
			$COMMA_SIGN=',';
			
			$line = array();
			$i = 0;

			//CSV: one line is one record and the cells/fields are seperated by ";"
			//so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
			while ( $line[$i] = fgets ($file, 4096) ) {
				if ( $i == 0 ){$num = strlen($line[$i]) - strlen(str_replace($COMMA_SIGN, "", $line[$i]));}
				$dsatz[$i] = array();
				$dsatz[$i] = explode( $COMMA_SIGN, $line[$i], ($num+1) );
				
				$i++;
			}
			
			//printing the table.
			echo '<table border="1" cellpadding="3" style="border-collapse: collapse" sortable="sortable">';
			//printing of the table itself
			$j = 0;
			foreach ($dsatz as $key => $number) {
				echo "<tr>";
				$val = array_search($key,array_keys($dsatz));
				//printing one row
				if ($rows[$j] == $val){
					if(!empty($rows[$j])){
						foreach ($number as $k => $content) {
							//printing of each column in a row
							$col_num = 'col_'.array_search($k,array_keys($number));
							if ($_POST[$col_num] != '-'){
								echo "<td>".$content."</td>";
							}
						}
					}
					$j++;
				}
				echo '</tr>';
				
			}

			echo "</table>";
			
		}		
		
		
	}
	if ( $_POST['f_type'] == 'xlsx'){
		$xlsx = new SimpleXLSX( 'upload/'.$_POST['f_name'] );
		
		echo '<table border="1" cellpadding="3" style="border-collapse: collapse" sortable="sortable">';
		
		list($cols,) = $xlsx->dimension();
		$j = 0;
		foreach( $xlsx->rows() as $k => $r) {
           
			echo '<tr>';
			if ($k != 0){
				if(!empty($rows[$j])){
					//printing one row
					if ($rows[$j] == $k){
						for( $i = 0; $i < $cols; $i++){
							$col_num = 'col_'.$i;
							//printing of each column in a row
							if ($_POST[$col_num] != '-'){
								echo '<td>'.( (isset($r[$i])) ? $r[$i] : '&nbsp;' ).'</td>';
							}
						}
						$j++;
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