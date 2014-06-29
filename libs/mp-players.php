<?php

/**
 * Settings
 */
 $settings['name'][0] = 'server - 1';
 $settings['ip'][0] = '127.0.0.1';
 $settings['port'][0] = '5005';
 $settings['login'][0] = 'Admin';
 $settings['pwd'][0] = 'Admin';

require_once __DIR__.'/mp-libs/GbxRemote.inc.php';
 
function ParseArgument($ArgumentName, $DefaultValue, $argv)
{
	if (array_key_exists($ArgumentName, $argv)) {
		$ArgumentValue = $argv[$ArgumentName];
	} else {
		$ArgumentValue = $DefaultValue;
	}
	
	return $ArgumentValue;
}

if(ParseArgument(1,'', $argv) == 'config'){
	for($i = 0; $i < sizeof( $settings['name']); $i++){
		echo "multigraph mp_players_$i\n\n"; 
		echo "graph_title ManiaPlanet Players - ". $settings['name'][$i]."\n";
		echo "graph_category ManiaPlanet\n";
		echo "players.label Number of players  \n";
		echo "specs.label Number of Spectators  \n\n";
	}
	echo "multigraph mp_players_total\n\n"; 
	echo "graph_title ManiaPlanet Players - TOTAL\n";
	echo "graph_category ManiaPlanet\n";
	echo "players.label Number of players  \n";
	echo "specs.label Number of Spectators  \n";
		
}else{
	$playersCountTotal = 0;
	$specCountTotal = 0;
	for($i = 0; $i < sizeof( $settings['name']); $i++){
		echo "multigraph mp_players_$i\n\n"; 
		$playerCount = 0;
		$specCount = 0;
		$client = new IXR_Client_Gbx;
		if ($client->Init($settings['port'][$i]) && $client->query("Authenticate", $settings['login'][$i], $settings['pwd'][$i])) {
		echo "Connected\n";
			if ($client->query('GetPlayerList', 500, 0)) {
				$PlayerList = $client->getResponse();
				foreach($PlayerList as $player){
					if($player['IsSpectator']){
						$specCount++;
					}else{
						$playerCount++;
					}
				}
			}
		}
		
		echo "players.value $playerCount\n";
		echo "specs.value $specCount\n\n";
		
		$playersCountTotal += $playerCount;
		$specCountTotal += $specCount;
		$client->Terminate();
	}
	
	echo "multigraph mp_players_total\n\n"; 
	echo "players.value $playersCountTotal\n";
	echo "specs.value $specCountTotal\n";
}