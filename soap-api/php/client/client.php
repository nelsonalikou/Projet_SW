<?php
class Client
{
    private $instance; 
    
    public function __construct()
    {
        $options = [
            'location' => 'http://localhost/Projet_SW/soap-api/php/server/server.php',
            'uri' => 'urn://Projet_SW/server.php',
            'wsdl_cache' => 0,
            'trace' => 1
        ];
        $this->instance = new SoapClient(NULL, $options);
        //$this->instance = new SoapClient('http://localhost/Projet_SW/wsdl/monserveur.wsdl', $options,true);
    }

    public function getCityNameFromCP($cp_array){
        return json_decode($this->instance->__soapCall('getCityNameFromCP', $cp_array),true);
    }

    public function getAgentsList(){
        return json_decode($this->instance->__soapCall('getAgentsList', []),true);
    }

    public function addAgent($data_array){
        return json_decode($this->instance->__soapCall('addAgent', $data_array),true);
    }

    public function addClass($data_array){
        return json_decode($this->instance->__soapCall('addClass', $data_array),true);
    }

    public function getAgentClass($array_names){
        return json_decode($this->instance->__soapCall('getAgentClass', $array_names),true);
    }

    public function getClassesList(){
        return json_decode($this->instance->__soapCall('getClassesList', []),true);
    }

    public function getLocationsList(){
        return json_decode($this->instance->__soapCall('getLocationsList', []),true);
    }

    public function deleteAgent($data_array){
        return json_decode($this->instance->__soapCall('deleteAgent', $data_array),true);
    }

    public function updateAgentInfo($data_array){
        return json_decode($this->instance->__soapCall('updateAgentInfo', $data_array),true);
    }
}