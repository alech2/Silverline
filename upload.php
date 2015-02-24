<html lang="en">
<head>
<title>xxxxx</title>
<meta name="Description" content="xxx">
<meta charset="utf-8">
</head>

<style>
table, th, td {
    border: 1px solid black;
}
th, td {
    padding: 5px;
    text-align: left;
}
</style>
<table width="600">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
<td width="20%">Select file, <br>Not supporting other then *.xlsx or *.csv files.</td>
<td width="80%"><input type="file" name="file" id="file" /></td>
</tr>

<tr>
<td>Submit</td>
<td><input type="submit" name="submit" /></td>
</tr>

</form>
</table>
<?php
require_once 'external_php_modules/simplexlsx.class.php';
if ( isset($_POST["submit"]) ) {

   if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }else {
			//Print file details
			// echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			// echo "Type: " . $_FILES["file"]["type"] . "<br />";
			// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

			//if file already exists
			if (file_exists("upload/" . $_FILES["file"]["name"])) {
				echo $_FILES["file"]["name"] . " already exists. ";
			}
			else {
				//Store file in directory "upload" with the name of "uploaded_file.txt"
				$storagename = "uploaded_file_".substr(md5(rand()), 0, 15).".txt";
				move_uploaded_file($_FILES["file"]["tmp_name"], 'upload/' . $storagename);
				// echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
			}
		}
			
			
			
			//checking what is the extention of the file that been uploaded.
			$type = explode(".",$_FILES['file']['name']);
			
			
			echo '<form action="insert_data_from_file.php" method="post">';
			echo '<input type="submit" name="formSubmit" value="Submit" />';
			
			echo '<input type="text" name="f_name" value="'.$storagename.'" hidden>';
			echo '<input type="text" name="f_type" value="'.end($type).'" hidden>';
			
			if (strtolower(end($type)) == 'csv'){
				if ( $file = fopen( 'upload/' . $storagename , "r" ) ) {
					$COMMA_SIGN=',';

					$firstline = fgets ($file, 4096 );
					//Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
					$num = strlen($firstline) - strlen(str_replace($COMMA_SIGN, "", $firstline));

					//save the different fields of the firstline in an array called fields
					$fields = array();
					$fields = explode( $COMMA_SIGN, $firstline, ($num+1) );

					$line = array();
					$i = 0;

					//CSV: one line is one record and the cells/fields are seperated by ";"
					//so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
					while ( $line[$i] = fgets ($file, 4096) ) {

						$dsatz[$i] = array();
						$dsatz[$i] = explode( $COMMA_SIGN, $line[$i], ($num+1) );
						
						$i++;
					}
					
 

					//printing the table.
					echo '<table border="1" cellpadding="3" style="border-collapse: collapse" sortable="sortable">';
					
					//printing the combobox
					echo "<tr>";
					echo "<td>" . '' . "</td>";
					for ( $k = 0; $k != ($num+1); $k++ ) {
						echo '<td>'.'<select name="col_'.$k.'">';
						echo '<option value="-">-</option>';
						echo '<option value="phone">טלפון סלולארי ראשי</option>';
						echo '<option value="phone">טלפון סלולארי משני</option>';
						echo '<option value="first_name">שם פרטי</option>';
						echo '<option value="last_name">שם משפחה</option>';
						echo '<option value="group_1">1 - קבוצה</option>';
						echo '<option value="group_2">2 - קבוצה</option>';
						echo '<option value="group_3">3 - קבוצה</option>';
						echo '<option value="group_4">4 - קבוצה</option>';
						echo '<option value="sex">מין</option>';
						echo '<option value="language">שפה</option>';
						echo '<option value="sex">מין</option>';
						echo '<option value="date">תאריך</option>';
						echo '</select>'.'</td>';
					}
					echo "</tr>";
					
					//printing the schema of the table
					echo "<tr>";
					echo "<td>" . '' . "</td>";
					for ( $k = 0; $k != ($num+1); $k++ ) {
						echo "<td>" . $fields[$k] . "</td>";
					}
					echo "</tr>";
					//printing of the table itself
					foreach ($dsatz as $key => $number) {
								//new table row for every record
						echo "<tr>";
						$val = array_search($key,array_keys($dsatz)) + 1;
						echo "<td>" . '<input type="checkbox" name="row_number[]" value="'.$val.'" checked>' . "</td>";
						foreach ($number as $k => $content) {
										//new table cell for every field of the record
							echo "<td>" . $content . "</td>";
						}
					}

					echo "</table>";
					
				}
			} elseif (strtolower(end($type)) == 'xlsx') {
			
					$xlsx = new SimpleXLSX( 'upload/'.$storagename );
					
					echo '<table border="1" cellpadding="3" style="border-collapse: collapse" sortable="sortable">';
					
					list($cols,) = $xlsx->dimension();
					
					foreach( $xlsx->rows() as $k => $r) {
				//		if ($k == 0) continue; // skip first row
						// printing of the combobox 
						echo '<tr>';
						if ($k == 0){
							echo "<td>" . '' . "</td>";
							for( $i = 0; $i < $cols; $i++){
								echo '<td>'.'<select name="col_'.$i.'">';
								echo '<option value="-">-</option>';
								echo '<option value="phone">טלפון סלולארי ראשי</option>';
								echo '<option value="phone">טלפון סלולארי משני</option>';
								echo '<option value="first_name">שם פרטי</option>';
								echo '<option value="last_name">שם משפחה</option>';
								echo '<option value="group_1">1 - קבוצה</option>';
								echo '<option value="group_2">2 - קבוצה</option>';
								echo '<option value="group_3">3 - קבוצה</option>';
								echo '<option value="group_4">4 - קבוצה</option>';
								echo '<option value="sex">מין</option>';
								echo '<option value="language">שפה</option>';
								echo '<option value="sex">מין</option>';
								echo '<option value="date">תאריך</option>';
								echo '</select>'.'</td>';
							}
							echo '</tr>';
							echo '<tr>';
							echo "<td>" . '' . "</td>";
								// if $k != 0 it's data from table - not title row
						}else {echo "<td>" . '<input type="checkbox" name="row_number[]" value="'.$k.'" checked>' . "</td>";}
						// printing of table content
						for( $i = 0; $i < $cols; $i++)
							echo '<td>'.( (isset($r[$i])) ? $r[$i] : '&nbsp;' ).'</td>';
						echo '</tr>';
					}
					echo '</table>';
			} else{
				echo "Not supporting other then *.xlsx or *.csv files.";
		}
		echo '</form>';
	} else {
		echo "No file selected <br />";
		return;
	}
}

?>
