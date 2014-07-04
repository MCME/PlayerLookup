<?php
header('Content-Type: application/json');

global $input;
$input = $_REQUEST["in"];

function getUserUUID() { //rewrite it

	global $input; 
	global $username; 
	global $list;

	if (strlen($input) != 32) {
		$list = file_get_contents("http://connorlinfoot.com/uuid/api/?user=" . $input."&get=uuid");
		$username = file_get_contents("http://connorlinfoot.com/uuid/api/?uuid=".$list);
	}
	else {
		$username = file_get_contents("http://connorlinfoot.com/uuid/api/?uuid=" . $input);
		$list = file_get_contents("http://connorlinfoot.com/uuid/api/?user=" . $username."&get=uuid");
	}
}
getUserUUID(); 

require_once("/ts3/libraries/TeamSpeak3/TeamSpeak3.php");

$ts3_VirtualServer = TeamSpeak3::factory("serverquery://ts.mcmiddleearth.com:10011/?server_port=9987");

try {

	$client = $ts3_VirtualServer->clientGetByName($username);

    $TsOnline = "true";
    $TsChannel = $ts3_VirtualServer->channelGetById($client['cid']);

} catch (Exception $e) { 

    $TsOnline = "false";

}
if ($TsOnline == "true"){
    echo '{"online":"'.$TsOnline.'",';
    echo '"channel":"'.$TsChannel.'",';
    echo '"username":"'.$username.'",';
    global $list; echo '"UUID":"'.$list.'"}';
}
else {
	echo '{"online":"'.$TsOnline.'",';
	echo '"channel": "false",';
	echo '"username":"'.$username.'",';
	global $list; echo '"UUID":"'.$list.'"}';
}

?>
