<?php
header('Content-Type: application/json');

global $input;
$input = $_REQUEST["in"];

function getUserUUID() { //rewrite it

	global $input; 
	global $list; $list = file_get_contents("https://ammar.pw/uuid.php?in=" . $input);
	if (strlen($input) == 32) {$input = $list;} else {$input = $_REQUEST["in"];}
}
getUserUUID(); 

function OnlineTS() {

	require_once("/ts3/libraries/TeamSpeak3/TeamSpeak3.php");

	$ts3_VirtualServer = TeamSpeak3::factory("serverquery://ts.mcmiddleearth.com:10011/?server_port=9987");

	global $input;
	global $list;

	if (strlen($input) != 32) {

		$client = $ts3_VirtualServer->clientGetByName($input);

	 		if ($ts3_VirtualServer->clientGetByName($input) == true) {

				echo "{ " . '"username":"' . $input . '","channel":"' . $ts3_VirtualServer->channelGetById($client['cid']) . '","online":true,"UUID":"'.$list.'"}';
			}
			else {
				echo "{ " . '"username":"' . $input . '","channel":false,"online":false}';
			}
		}
	}	
OnlineTS();


?>