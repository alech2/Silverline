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
<!-- To change color change the class "color-1" to "color-2, color-3 ... color-6" -->
<body class="home color-2" >
	
	<?php require_once("header.php"); ?>

	<div class="container">
	<div class="content">
		<div class="row">
			<div class="span12">
				<div class="title">
					<h2>SMS</h2>
					<div class="hr hr-small hr-center"><span class="hr-inner"></span></div>
					<p>...הודעת הסמס שלך לחברים, אורחים וכ"ו</p>
				</div>
			</div>
		</div>

		<div style="direction: rtl;">
		<h4 style="display: inline;">הזן כותרת הסבר להודעה:   </h4>
		<input name="msg_name" type="text" style="width:350px">
		<h6>למשל: חתונה 05.08.2058, מבצע פורים 2015...</h6>
		

		<br>
		<h4>אנא רשום הודעה:</h4>

		<form>
			נשארו עוד
			<input onblur="textCounter(this.form.recipients,this,160);" style="width: 28px;" disabled  onfocus="this.blur();" tabindex="999" maxlength="3" size="3" value="160" name="counter">
			תוים להודעה.<br>
			<textarea onblur="textCounter(this,this.form.counter,160);" onkeyup="textCounter(this,this.form.counter,160);" style="WIDTH: 608px; HEIGHT: 270px;" name="message" rows="1" cols="15" >
			</textarea>
			<br><br>
			<button type="button" class="btn btn-primary">בחר הודעה זו לשליחה</button>
		</form>
		</div>
	</div>
	</div>
	<?php require_once("footer.php"); ?>
</body>
</html>