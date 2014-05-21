<h1>The Functions of the MCME lookup</h1>
<?php
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
	?>
<?php
	function userLookup() {

		if (!isset($_POST["input"]))
			return;

		global $input;
		$input = $_POST["input"]; //declare the variable $input.

		function getRank() {

			global $input;
			global $whitelisted;
			$input = $_POST["input"];
			if(strstr($input, '/') || $input == "") {$json = "";} else {$json = file_get_contents('http://mcme.joshr.hk/export/user/' . strtolower($input));}
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

		function getUserOnlineBuild() {    

		$json = file_get_contents('http://mcme.joshr.hk/server/build');
		$playerlist = json_decode($json, true);
		global $input;

			if(in_array($input, $playerlist['players'])) {
			    echo "<h2>" . $input . " is online on <a href='http://build.mcmiddleearth.com:8123/index.html?playername=" . $input . "&zoom=8'>BuildServer</a></h2>";
			}
			else {
				return false;
			}
		    
		}
		getUserOnlineBuild();

		function getUserOnlineFreeBuild() {

		$json = file_get_contents('http://mcme.joshr.hk/server/freebuild');
		$playerlist = json_decode($json, true);
		global $input;

			if(in_array($input, $playerlist['players'])) {
		    	echo "<h2>" . $input . " is online on <a href='http://freebuild.mcmiddleearth.com:8123/index.html?playername=" . $input . "&zoom=8'>FreeBuildServer</a></h2>";
			}
			else {
				return false;
			}	    
		}
		getUserOnlineFreeBuild();

		function RankLookup() {

			global $input;
			if($input != "/build" && $input != "/freebuild" && $input != "/pvp" && $input != "/PVP" && strstr($input, '/')) {$json = file_get_contents('http://mcme.joshr.hk/export'.$input);} else {$json = "";}
			$playerlist = json_decode($json, true);

			if ($json != "") {
				foreach($playerlist["players"] as $player)
				{
					echo "<h3>" . $player . "<br></h3>";
				}
			}
		}
		RankLookup();

		function skin() {

			global $input;
			global $whitelisted;
			$skin = "<div><img src='http://build.mcmiddleearth.com:8123/tiles/faces/32x32/". strtolower($input) .".png'></img></div>";

		/*	if ($whitelisted == "TRUE") {
				echo $skin;
			}
			else {
				return false;
			}*/
			echo $skin;
		}
		//skin();

		function getUserOnlineTS() {

			require_once("includes/ts3/libraries/TeamSpeak3/TeamSpeak3.php");

			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://ts.mcmiddleearth.com:10011/?server_port=9987");

			global $input;
			global $onlineList; $onlineList = $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html());

			if (strpos(strtolower($onlineList),strtolower($input)) !== false) {
			    echo "<h2>" . $input . " is online on Teamspeak</h2>";
			}
			else {
				$TeamspeakOnline = "FALSE";
			}
		}
		getUserOnlineTS();

		function getUserUUID() {

			global $input;
			$list = file_get_contents("https://ammar.pw/uuid.php?in=" . $input);

			if ($list != "Username not valid!") {
				echo "<h2>UUID: " . $list . "</h2>";
			}
			else {
				$userUUID = "not found";
			}
		}
		getUserUUID();
	}

	function serverCheck() {

		global $input;
		if (strtolower($input) != "/pvp" && strstr($input, '/')) {$json = file_get_contents('http://mcme.joshr.hk/server' . $input);} else {$json = "";}
		$server = json_decode($json, true);

		if ($input == "/build") {

			echo "<h2>BuildServer</h2>";
			echo "<h3>Status: " . $server["status"] . "</h2>";
			echo "<h3>" . $server["num_players"] . "/" . $server["maxplayers"] . "</h3>";
			echo "<h2>Online List:</h2>";

			foreach($server["players"] as $player)
			{
				echo "<img src='http://build.mcmiddleearth.com:8123/tiles/faces/16x16/".$player.".png'></img>".$player . "<br>";
			}
		}
		if ($input == "/freebuild") {

			echo "<h2>FreeBuildServer</h2>";
			echo "<h3>Status: " . $server["status"] . "</h2>";
			echo "<h3>" . $server["num_players"] . "/" . $server["maxplayers"] . "</h3>";
			echo "<h2>Online List:</h2>";

			foreach($server["players"] as $player)
			{
				echo "<img src='http://freebuild.mcmiddleearth.com:8123/tiles/faces/16x16/".$player.".png'></img>".$player . "<br>";
			}
		}
		if (strtolower($input) == "/pvp") {
			echo "<h2>nothing found</h2>";
		}
	}
?>
