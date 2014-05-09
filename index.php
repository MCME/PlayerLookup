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
	</body>
</html>
<?php //include_once("analyticstracking.php") ?>
<?php
	if (!isset($_POST["input"]))
		return;

	global $input;
	$input = $_POST["input"]; //declare the variable $input

	global $whitelisted;
	$whitelisted = "FALSE";

	function getPlayerInfo(){
		if (!isset($_POST["input"]))
			return;

		$whitelist_check  = "http://api.mcme.co/whitelist/whitelistedsince/"; //get the link
		$site = file_get_contents($whitelist_check . $input); //get the content

		if ($site == "not whitelisted") {
			echo "<h2>" . $input . " is not whitelisted" ."</h2>";
			global $whitelisted; $whitelisted = "FALSE";
		}
		if ($site == "no name provided") {
			echo "<h2>no name provided</h2>";
			global $whitelisted; $whitelisted = "FALSE";
		}
		if ($site !== "not whitelisted" && $site != "no name provided" && $site != "Before Sept 14th 2012") {
			echo "<h2>" . $input . " was whitelisted on: " . $site  ."</h2>"; //echo the content 
			echo "<a href='http://palantir.mcme.co/index.html?playername=" . $input . "&zoom=8'><h2>Build-server Dynmap</h2></a>";
			echo "<a href='http://map.mcme.co/index.html?playername=" . $input . "&zoom=8'><h2>FreeBuild-server Dynmap</h2></a>";
			global $whitelisted; $whitelisted = "TRUE";
		}
		if ($site == "Before Sept 14th 2012") {
			echo "<h2>" . $input . " was whitelisted: " . $site  ."</h2>";
			echo "<a href='http://palantir.mcme.co/index.html?playername=" . $input . "&zoom=8'><h2>Build-server Dynmap</h2></a>";
			echo "<a href='http://map.mcme.co/index.html?playername=" . $input . "&zoom=8'><h2>FreeBuild-server Dynmap</h2></a>";
			global $whitelisted; $whitelisted = "TRUE";
		}
	}
	//getPlayerInfo();

	function getRank() {
		if (!isset($_POST["input"]))
			return;

		global $whitelisted;
		$input = $_POST["input"];
		if(strstr($input, '/'))  {$json = "";} else {$json = file_get_contents('http://mcme.joshr.hk/export/user/' . strtolower($input));}
		$group = json_decode($json, true);

		if (!isset($group["group"]))
			return;

		if ($input != "q220" && $json != ""/* && $whitelisted != "FALSE"*/) {
			echo "<h2>" . "Rank: " . $group["group"] ."</h2>";
		}

		if ($input == "q220"/* && $whitelisted != "FALSE"*/){
			echo "<h2>Rank: Eru Iluvatar</h2>";
		}
	}
	getRank();

	function getBuildPlayers() {

		global $json;
		$json = file_get_contents('http://mcme-api.appspot.com/server/build');
		$playerlist = json_decode($json, true);

		foreach($playerlist["players"] as $player)
		{
			print($player . "<br>");
		}
	}
	//getBuildPlayers();

	function getUserOnlineBuild() {    

	$json = file_get_contents('http://mcme.joshr.hk/server/build');
	$playerlist = json_decode($json, true);
	global $input;

		if(in_array($input, $playerlist['players']))
		    echo "<h2>" . $input . " is online on <a href='http://build.mcmiddleearth.com:8123/index.html?playername=" . $input . "&zoom=8'>BuildServer</a></h2>";
		else
			return false;
	    
	}
	getUserOnlineBuild();

	function getUserOnlineFreeBuild() {

	$json = file_get_contents('http://mcme.joshr.hk/server/freebuild');
	$playerlist = json_decode($json, true);
	global $input;

		if(in_array($input, $playerlist['players']))
	    	echo "<h2>" . $input . " is online on <a href='http://freebuild.mcmiddleearth.com:8123/index.html?playername=" . $input . "&zoom=8'>FreeBuildServer</a></h2>";
		else
			return false;
	    
	}
	getUserOnlineFreeBuild();

	function skin() {

		global $input;
		global $whitelisted;
		$skin = "<div><img id='skin' src='http://build.mcmiddleearth.com:8123/tiles/faces/body/". $input .".png'></img></div>";

	/*	if ($whitelisted == "TRUE") {
			echo $skin;
		}
		else {
			return false;
		}*/
	}
	//skin();

	function ServerStatus() {

		function BuildServerStatus() {

			$server = "build.mcmiddleearth.com";

			if (!$socket = @fsockopen($server, 25565, $errno, $errstr, 60))
			{
				echo "<strong><h1 id='ServerDown'>The Build Server is Unexpected offline</h1></strong>";
			}
		}
		BuildServerStatus();

		function FreeBuildServerStatus() {

			$server = "freebuild.mcmiddleearth.com";

			if (!$socket = @fsockopen($server, 25565, $errno, $errstr, 60))
			{
				echo "<strong><h1 id='ServerDown'>The FreeBuild Server is Unexpected offline</h1></strong>";
			}
		}

		function PVPServerStatus() {

			$server = "pvp.mcmiddleearth.com";

			if (!$socket = @fsockopen($server, 25565, $errno, $errstr, 60))
			{
				echo "<strong><h1 id='ServerDown'>The PVP Server is Unexpected offline</h1></strong>";
			}
		}
		PVPServerStatus();

		function APIstatus() {

			$server = "mcme.joshr.hk";

			if (!$socket = @fsockopen($server, 80, $errno, $errstr, 60))
			{
				echo "<strong><h1 id='ServerDown'>The API is Unexpected offline</h1></strong>";
				echo "<div id='offline_bg'></div>";
			}
		}
		APIstatus();
    }
	ServerStatus();

	function RankLookup() {

		global $input;
		if(strstr($input, '/')) {$json = file_get_contents('http://mcme.joshr.hk/export'.$input);} else {$json = "";}
		$playerlist = json_decode($json, true);

		if ($json != "") {
			foreach($playerlist["players"] as $player)
			{
				echo "<h3>" . $player . "<br></h3>";
			}
		}
	}
	RankLookup();
?>






