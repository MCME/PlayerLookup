<html>
	<head>
		<title>MCME whitelisted since</title>
		<link rel="stylesheet" type="text/css" href="assets/styles/style.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	</head>
	<body>
		<img id="logo" src="assets/img/MCME_logo.png"></img><h1>MCME whitelisted since</h1>
		<form action="index.php" method="post">
			<div class="w">
				<div class="nameinput">
			    	<input type="text" name="input" placeholder="username" class="nameinput_shadow">
				</div>
			<input class="checkbutton" type="submit" value="check">
		</form>
	</body>
</html>
<?php include_once("analyticstracking.php") ?>
<?php
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
	$json = file_get_contents('http://api.mcme.co/s/user/' . $input);
	$group = json_decode($json, true);

	if (!isset($group["group"]))
		return;

	if ($group != "root" && $whitelisted != "FALSE") {
		echo "<h2>" . "Rank: " . $group["group"] ."</h2>";
	}

	if ($group == "root" && $whitelisted != "FALSE"){
		echo "<h2>Rank: Eru Iluvatar</h2>";
	}

}
//getRank();

function getBuildPlayers() {

	global $json;
	$json = file_get_contents('http://mcme-api.appspot.com/server/build');
	$playerlist = json_decode($json, true);
	//echo $playerlist->build->PlayerList[0];

	foreach($playerlist["players"] as $player)
	{
		print($player . "<br>");
	}
}
//getBuildPlayers();

function getUserOnlineBuild() {

$json = file_get_contents('http://mcme-api.appspot.com/server/build');
$playerlist = json_decode($json, true);
global $input;

	if(in_array($input, $playerlist['players']))
	    echo "<h2>" . $input . " is online on <a href='http://build.mcmiddleearth.com:8123/index.html?playername=" . $input . "&zoom=8'>BuildServer</a></h2>";
	else
		return false;
    
}
getUserOnlineBuild();

function getUserOnlineFreeBuild() {

$json = file_get_contents('http://mcme-api.appspot.com/server/freebuild');
$playerlist = json_decode($json, true);
global $input;

	if(in_array($input, $playerlist['players']))
    	echo "<h2>" . $input . " is online on <a href='http://freebuild.mcmiddleearth.com:8123/index.html?playername=" . $input . "&zoom=8'>BuildServer</a></h2>";
	else
		return false;
    
}
getUserOnlineFreeBuild();

function WebsiteStatus() {

	$server = "mcme-api.appspot.com";
	$WebsiteStatus = "N/A";

	if (!$socket = @fsockopen($server, 80, $errno, $errstr, 30))
	{
	  $WebsiteStatus = "OFFLINE";
	  echo "<h2 id='offline-header1'>Sorry, this service is Temporarily unavailable.</h1>";
	  echo "<h2 id='offline-header2'>The Website of mcme seems <a href='/status/'><font color='red'>down</font></a>, we could not get information back from the server</h2><div id='OFFLINE'></div>";
	  echo "<a href='aaldim.tk/mcme/status'><h2 id='offline-header'>aaldim.tk/mcme/status</a> for a status page</h2>";
	}
	else 
	{
	  $WebsiteStatus = "ONLINE";
	}
}
WebsiteStatus();

	function skin() {

		global $input;
		global $whitelisted;
		$skin = "<div><img id='skin' src='http://build.mcmiddleearth.com:8123/tiles/faces/body/". $input .".png'></img></div>";

/*		if ($whitelisted == "TRUE") {
			echo $skin;
		}
		else {
			return false;
		}*/
		echo $skin;
	}
//skin();


?>
