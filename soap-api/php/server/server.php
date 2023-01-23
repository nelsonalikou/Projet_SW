<?php

require_once('pdo.php');

class MonServeur {

    private $conn;

    function __construct(){
        //connection à la base de données
        $pdo = new \Database;
        $this->conn = $pdo->connect();
    }

    /**
     * Récuperation de la liste des agents contenus dans notre base de données ainsi que leur classe
     * 
     * @soap
     * 
     * @return array $data
     */
    public function getAgentsList() {
        $sth = $this->conn->prepare('SELECT a.id as id, a.name as name, c.name as class, gender,  l.cp as cp  FROM agents as a INNER JOIN classes as c on (a.class=c.id) INNER JOIN localisation as l on (a.position=l.id)');
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }
    
    /**
     * Récuperation de la classe d'un agent à partir de son nom donné en paramètre
     *
     * @soap
     * 
     * @param  string $agentName
     * @return array
     */
    public function getAgentClass(string $agentName) {
        $stmt = $this->conn->prepare("SELECT a.name as name, c.name as class FROM agents as a INNER JOIN classes as c on (a.class=c.id) WHERE a.name =  :agentName");
        $stmt->execute(['agentName' => $agentName]); 
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }

    /**
     * Recuperer la liste des localisations
     *
     * @soap
     * 
     * @param  string $agentName
     * @return array
     */
    public function getLocationsList(){
        $sth = $this->conn->prepare('SELECT * FROM localisation');
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }

    /**
     * Recuperer la liste des classes
     *
     * @soap
     * 
     * @return array
     */
    public function getClassesList(){
        $sth = $this->conn->prepare('SELECT * FROM classes');
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }

    
    /**
     * addAgent
     *
     * @soap
     * 
     * @param  mixed $agentName
     * @param  mixed $agentGender
     * @param  mixed $agentClass
     * @param  mixed $agentPosition
     * @return array $result
     */
    public function addAgent(string $agentName, string $agentGender, int $agentClass, int $agentPosition){
        $stmt = $this->conn->prepare("INSERT INTO agents (name, gender, class, position) VALUES (:agentName, :agentGender, :agentClass, :agentPosition)");
        $stmt->execute(['agentName' => $agentName, 'agentGender' => $agentGender, 'agentClass' => $agentClass, 'agentPosition' => $agentPosition]); 
        if (!$stmt) {
            $result = [ "message" => "Failed to add the agent" ];
        }else{
            $result = [ "message" => "Agent added successfully" ];
        }
        return json_encode($result);
    }


    /**
     * Ajouter une nouvelle classe d'agent
     * 
     * @soap
     * 
     * @param string $className nom de la classe
     * @param string $classDescription description de la classe
     * @return array $result
     */
    public function addClass(string $className, string $classDescription){
        $stmt = $this->conn->prepare("INSERT INTO classes (name, description) VALUES (:className, :classDescription)");
        $stmt->execute(['className' => $className, 'classDescription' => $classDescription]); 
        if (!$stmt) {
            $result = [ "message" => "Failed to add the agent class" ];
        }else{
            $result = [ "message" => "Agent class added successfully" ];
        }
        return json_encode($result);
    }
    
    /**
     * deleteAgent
     *
     * @soap
     * 
     * @param  mixed $agentId
     * @return array
     */
    public function deleteAgent(int $agentId){
        $stmt = $this->conn->prepare("DELETE FROM agents WHERE id=:agentId");
        $stmt->execute(['agentId' => $agentId]);
        if (!$stmt) {
            $result = [ "message" => "Failed to delete the agent" ];
        }else{
            $result = [ "message" => "Agent delete added successfully" ];
        }
        return json_encode($result);
    }
    
    /**
     * updateAgentInfo
     *
     * @soap
     * 
     * @param  mixed $agentId
     * @param  mixed $agentName
     * @param  mixed $agentGender
     * @param  mixed $agentClass
     * @param  mixed $agentPosition
     * @return array $result
     */
    public function updateAgentInfo(int $agentId, string $agentName, string $agentGender, int $agentClass, int $agentPosition){
        $stmt = $this->conn->prepare("UPDATE agents SET name=:agentName, gender=:agentGender, class=:agentClass, position=:agentPosition  WHERE id=:agentId");
        $stmt->execute(['agentName' => $agentName, 'agentGender' => $agentGender, 'agentClass' => $agentClass, 'agentPosition' => $agentPosition, 'agentId' => $agentId]); 
        if (!$stmt) {
            $result = [ "message" => "Failed to update agent informations the agent" ];
        }else{
            $result = [ "message" => "Agent informations updated successfully" ];
        }
        return json_encode($result);
    }

    /**
     * Appel à l'API du gouvernement pour retrouver le nom d'une ville à partir de son code postal
     * Lien vers l'API : https://geo.api.gouv.fr/decoupage-administratif/communes#name
     * 
     * @soap
     * 
     * @param int $postalCode
     */
    public function getCityNameFromCP(int $postalCode){
        $ch = curl_init();

        $url = "https://geo.api.gouv.fr/communes";
    
        $dataArray = array("codePostal"=>$postalCode);
        $data = http_build_query($dataArray);
        $getUrl = $url."?".$data;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
    
        $response = curl_exec($ch);
    
        if(curl_error($ch)){
            $res = 'Request Error:' . curl_error($ch);
        }else{
            $res = json_decode($response, true);
        }
        curl_close($ch);
        
        return json_encode($res);
    }

}
$newServeur = new MonServeur;
//$options = ['uri' => 'Projet_SW/server.php'];
$options = ['uri' => 'http://localhost/Projet_SW/soap-api/php/server/server.php'];
$server = new \SoapServer(NULL, $options);
$server->setClass('MonServeur'); //Nom de la classe qui gère les demandes
$server->handle();
//print_r($newServeur->getAgentClass("sage"));