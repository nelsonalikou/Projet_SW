<?php
require 'vendor/autoload.php';
require 'server.php';
//require 'client.php';

//$class = "Vendor\\MonServeur";
$class = new MonServeur;
//$class = new Client;
$serviceURI = "http://localhost/Projet_SW/soap-api/php/server/server.php";
$wsdlGenerator = new PHP2WSDL\PHPClass2WSDL($class, $serviceURI);
// Generate the WSDL from the class adding only the public methods that have @soap annotation.
$wsdlGenerator->generateWSDL(true);
// Dump as string
$wsdlXML = $wsdlGenerator->dump();
// Or save as file
$wsdlXML = $wsdlGenerator->save('wsdl/MonServeur.wsdl');

/*$generator = new Wsdl2PhpGenerator\Generator();
$generator->generate(
    new Wsdl2PhpGenerator\Config(array(
        'inputFile' => 'wsdl/monserveur.wsdl',
        'outputDir' => 'php/server'
    ))
);*/