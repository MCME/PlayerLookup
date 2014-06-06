<?php include_once("analyticstracking.php") ?>
<?php require_once("/includes/MainFunctions.php") ?>
<?php require_once("/includes/UUIDFunctions.php") ?>
<html>
	<head>
		<title>MCME lookup</title>
		<link rel="stylesheet" type="text/css" href="assets/styles/style.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<img id="logo" src="assets/img/MCME_logo.png"></img><h1>MCME lookup</h1>
		<form action="index.php" method="post">
			<div class="w">
				<div class="nameinput">
			    	<input type="text" name="input" placeholder="username" class="nameinput_shadow">
				</div>
			<input class="checkbutton" type="submit" value="check">
		</form>
		<div id="side">	
			<div id="sidebar">
				<h1>Information</h1>
				<p><strong>/(rankhere)</strong> displays the users with that rank</p>
				<p><strong>(userhere)</strong> displays information about a user</p>
				<p><strong>/build</strong> displays information about the buildserver</p>
				<p><strong>/freebuild</strong> displays information about the freebuildserver</p>
				<p><strong>/teamspeak</strong> displays information about Teamspeak</p>
			</div>	
			<div id="offline">
	<?php
		ServerStatus();
	?>
			</div>
		</div>
	</body>
</html>
<?php
	userLookup();
	serverCheck();
?>
