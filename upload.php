<html lang="en">
<head>
	<title>xxxxx</title>
	<meta name="Description" content="xxx">
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="HandheldFriendly" content="true">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Import CSS -->
	<link rel="stylesheet" href="css/rtl/main.css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.easing.min.js"></script>
	<script src="js/jquery.scrollto.min.js"></script>
	<script src="js/slabtext.min.js"></script>
	<script src="js/jquery.nav.js"></script>
	<script src="js/main.js"></script>

	<script type="text/javascript">
		function textCounter( field, countfield, maxlimit ) {
			if ( field.value.length > maxlimit ) {
				field.value = field.value.substring( 0, maxlimit );
				field.blur();
				field.focus();
				return false;
			} else {
				countfield.value = maxlimit - field.value.length;
			}
		}
	</script>
</head>

<style>
table, th, td {
    word-wrap: break-word;
}





</style>
<!-- To change color change the class "color-1" to "color-2, color-3 ... color-6" -->
<body class="home color-2" >
	
	<?php require_once("header.php"); ?>

	<div class="container">
	<div class="content">
		<div class="row">
			<div class="span12">
				<div class="title">
					<h2>Gusts</h2>
					<div class="hr hr-small hr-center"><span class="hr-inner"></span></div>
					<p>...העלאה של רשימת אורחים/לקוחות לאתר</p>
				</div>
			</div>
		</div>

		<div style="direction: rtl;">
			<table width="600">
			<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
				<input type="file" name="file" id="file"/>
				<br>
				*בחר קובץ, המערכת תומכת בקבצים מסוג *.xlsx או *.csv .
				<br><br>

				<input type="submit" name="submit" class="btn btn-primary" value="העלה">
			</form>
			</table>
		</div>
	</div>
	</div>

	<div class="container">
	<div class="content">
		<div class="row">
			<div class="span12">
				<div class="title">
					<h2>Gusts</h2>
					<div class="hr hr-small hr-center"><span class="hr-inner"></span></div>
					<p>...הלאה של רשימת אורחים/לקוחות לאתר</p>
				</div>
			</div>
		</div>

		<div style="direction: rtl;">
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
					#echo '<table border="1" cellpadding="3" style="border-collapse: collapse" sortable="sortable">';
					echo '<table class="table table-bordered table-striped" >';
					
					//printing the combobox
					// echo "<thead>";
					// echo "<tr>";
					echo "<th>" . '' . "</th>";
					for ( $k = 0; $k != ($num+1); $k++ ) {
						echo '<th>'.'<select name="col_'.$k.'" style="width:105;">';
						echo '<option value="-">-</option>';
						echo '<option value="phone">נייד ראשי</option>';
						echo '<option value="phone">נייד משני</option>';
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
						echo '</select>'.'</th>';
					}
					// echo "</tr>";
					// echo "</thead>";
					
					//printing the schema of the table
					echo "<thead>";
					echo "<tr>";
					echo "<th>" . '' . "</th>";
					for ( $k = 0; $k != ($num+1); $k++ ) {
						echo "<th>" . $fields[$k] . "</th>";
					}
					echo "</tr>";
					echo "</thead>";
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
					
					#echo '<table border="1" cellpadding="3" style="border-collapse: collapse" sortable="sortable">';
					echo '<table class="table table-bordered table-striped" >';

					list($cols,) = $xlsx->dimension();
					
					foreach( $xlsx->rows() as $k => $r) {

						
						if ($k == 0){
							// echo "<thead>";
							// echo '<tr>';
							echo "<th>" . '' . "</th>";
							for( $i = 0; $i < $cols; $i++){
								echo '<th>'.'<select name="col_'.$i.'" style="width:105;">';
								echo '<option value="-">-</option>';
								echo '<option value="phone">נייד ראשי</option>';
								echo '<option value="phone">נייד משני</option>';
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
								echo '</select>'.'</th>';
								// echo '</tr>';
								// echo "</thead>";
							}
							

							echo '<thead><tr><th>' . '' . "</th>";
// echo "<th>'' . '' . "</th>";
	// if $k != 0 it's data from table - not title row

						}else {echo "<tr><td>" . '<input type="checkbox" name="row_number[]" value="'.$k.'" checked>' . "</td>";}

						// printing of table content
						for( $i = 0; $i < $cols; $i++){
							if ($k == 0) { 
								echo '<th>'.( (isset($r[$i])) ? $r[$i] : '&nbsp;' ).'</th>'; 
							}
							else { 
								echo '<td>'.( (isset($r[$i])) ? $r[$i] : '&nbsp;' ).'</td>'; 
							}
						}
						echo '</tr>';
						if ($k == 0) {echo "</thead>";}
						
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
		</div>
	</div>
	</div>
	<?php require_once("footer.php"); ?>
</body>
</html>




