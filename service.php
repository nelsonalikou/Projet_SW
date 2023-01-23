<?php
include './client.php';
$client = new client;
//var_dump($client->ditBonjour(['id' => '1']));
//var_dump($client->getAgentsList());
//var_dump($client->getClassesList());
//var_dump($client->getLocationsList());
//var_dump($client->getAgentClass(['agentName' => 'sage']));
//var_dump($client->getCityNameFromCP(['postalCode' => '51100']));
//var_dump($client->addAgent(['agentName' => 'Fade', 'agentGender' => 'F', 'agentClass' => 2, 'agentPosition' => 4]));
//var_dump($client->addClass(['className' => 'duelliste', 'classDescription' => 'celui qui va au combat']));
//var_dump($client->deleteAgent(['agentId' => 4]));
var_dump($client->updateAgentInfo(['agentId' => 1, 'agentName' => 'Fade', 'agentGender' => 'F', 'agentClass' => 3, 'agentPosition' => 5]));