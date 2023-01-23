<?php
include './client.php';


$client = new client;

$title = 'Projet Web Service';

$agentsList = $client->getAgentsList();

$locationsList = $client->getLocationsList();
$dataLocationsList = "";
foreach ($locationsList as $key => $location) {
    $dataLocationsList.="<option value=".$location["id"].">".$location["cp"]."</option>";
}

$classesList = $client->getClassesList();
$dataClassesList = "";
foreach ($classesList as $key => $class) {
    $dataClassesList.="<option value=".$class["id"].">".$class["name"]."</option>";
}

//Affichage des données de tous les agents
$dataAgentsList = "";
if (isset($_GET["agentsList"])) {
    $content = "";
    foreach ($agentsList as $key => $agent) {
        $content.="<tr>";
        $content.="<td>".$agent["name"]."</td>";
        $content.="<td>".$agent["gender"]."</td>";
        $content.="<td>".$agent["class"]."</td>";
        $content.="<td>".$agent["cp"]."</td>";
        //update agent
        $updateForm ='<!-- Modal -->
        <div class="modal fade" id="agentUpdateModal'.$agent['id'].'" tabindex="-1" role="dialog" aria-labelledby="agentUpdateModal'.$agent['id'].'Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agentUpdateModal'.$agent['id'].'Label">Add Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="interface.php?agentsList=" method="POST" id="addAgent'.$agent['id'].'">
                        <input type="hidden" class="form-control" name="updateAgentInfo">
                        <input type="hidden" class="form-control" name="agentId" value="'.$agent['id'].'">
                        <div class="form-group">
                            <label for="agentName">Nom de l\'agent</label>
                            <input type="text" class="form-control" id="agentName" value="'.$agent['name'].'" name="agentName" Required>
                        </div>
                        <div class="form-group">
                            <label for="agentGender">Genre</label>
                            <select class="form-control" id="agentGender" name="agentGender">';
                                if($agent['gender'] == 'F'){
                                    $updateForm .= '<option value="F" selected>Female</option>';
                                    $updateForm .= '<option value="M">Male</option>';
                                }else{
                                    $updateForm .= '<option value="F">Female</option>';
                                    $updateForm.='<option value="M" selected>Male</option>';
                                }
                            $updateForm.='</select>
                        </div>
                        <div class="form-group">
                            <label for="agentClass">Classes</label>
                            <select class="form-control" id="agentClass" name="agentClass">';
                            foreach ($classesList as $key => $class) {
                                if($class['name'] == $agent['class']){
                                    $updateForm .= '<option value='.$class["id"].' selected>'.$class["name"].'</option>';
                                }else{
                                    $updateForm.="<option value=".$class["id"].">".$class["name"]."</option>";
                                }
                                
                            }
                            $updateForm.='</select>
                        </div>
                        <div class="form-group">
                            <label for="agentPosition">Localisation</label>
                            <select class="form-control" id="agentPosition" name="agentPosition">';
                            foreach ($locationsList as $key => $location) {
                                if($location['cp'] == $agent['cp']){
                                    $updateForm .= '<option value='.$location["id"].' selected>'.$location["cp"].'</option>';
                                }else{
                                    $updateForm.="<option value=".$location["id"].">".$location["cp"]."</option>";
                                }
                                
                            }
                            $updateForm.='</select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" form="addAgent'.$agent['id'].'" value="Mettre à jour"/>
                </div>
                </div>
            </div>
        </div>';
        $content.='<td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#agentUpdateModal'.$agent['id'].'">
                        Mettre à jour les données de l\'agent
                    </button>
                    '.$updateForm.'
                   </td>';

        //delete agent
        $content.='<td>
                    <form action="interface.php?agentsList=" method="POST">
                        <input type="hidden" name="deleteAgent">
                        <input type="hidden" name="agentId" value='.$agent["id"].'>
                        <button type="submit" class="btn btn-danger">Supprimer l\' agent</button>
                    </form> 
                   </td>';
        $content.="</tr>";
    }
    $dataAgentsList = 'Liste des agents
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Nom</th>
            <th scope="col">Genre</th>
            <th scope="col">Classe</th>
            <th scope="col">Localisation</th>
            <th scope="col"></th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            '.$content.'        
        </tbody>
    </table>';
}

//affichage de la classe d'un agent
$dataAgentClass = "";
if (isset($_GET["agentName"])) {
    $agentClass = $client->getAgentClass(['agentName' => $_GET["agentName"]]);
    $content = "";
    foreach ($agentClass as $key => $agent) {
        $content.="<tr>";
        $content.="<td>".$agent["name"]."</td>";
        $content.="<td>".$agent["class"]."</td>";
        $content.="</tr>";
    }
    $dataAgentClass = "<table class='table'
                    <thead>
                        <tr>
                        <th scope='col'>Nom</th>
                        <th scope='col'>Classe</th>
                        </tr>
                    </thead>
                    <tbody>
                        $content         
                    </tbody>
                </table>";
}


//affichage de la localisation d'un agent
$dataAgentLocalisation = "";
if (isset($_GET["cp"])) {
    $agentLocation = $client->getCityNameFromCP(['cp' => $_GET["cp"]]);
    $content = "";
    foreach ($agentLocation as $key => $location) {
        $content.="<tr>";
        $content.="<td>".$_GET["cp"]."</td>";
        $content.="<td>".$location["nom"]."</td>";
        $content.="</tr>";
    }
    $dataAgentLocalisation = "<table class='table'
                    <thead>
                        <tr>
                        <th scope='col'>Code Postal</th>
                        <th scope='col'>Ville</th>
                        </tr>
                    </thead>
                    <tbody>
                        $content         
                    </tbody>
                </table>";
}

//Ajout d'un agent à partir des données récupérer du $_POST
if (isset($_POST["addAgent"])) {
    //var_dump($_POST);
    $result = $client->addAgent(array_slice($_POST, 1));
}

//Ajout d'une classe d'agent à partir des données récupérer du $_POST
if (isset($_POST["addClass"])) {
    //var_dump($_POST);
    $result = $client->addClass(array_slice($_POST, 1));
}

//Suppression d'un agent à partir de son id contenu dans $_POST
if (isset($_POST["deleteAgent"])) {
    //var_dump($_POST, array_slice($_POST, 1));
    $result = $client->deleteAgent(array_slice($_POST, 1));
}

//Mise à jour des données de l'agent
if (isset($_POST["updateAgentInfo"])) {
    //var_dump($_POST, array_slice($_POST, 1));
    $result = $client->updateAgentInfo(array_slice($_POST, 1));
}

$html =<<<HTML
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>{$title}</title>
  </head>
  <body>
    <div class="container m-5">
        <h1>{$title}</h1>
    </div>

    <div class="container m-2">
        <div class="row">
            <div class="col">
                <form action="interface.php?" method="GET">
                    <input type="hidden" class="form-control" id="agentsList" placeholder="sage" name="agentsList">
                    <button type="submit" class="btn btn-primary">Afficher la liste des agents</button>
                </form>
            </div>
            <div class="col">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agentModal">
                    Ajouter un agent
                </button>
            </div>
            <div class="col">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agentClassModal">
                    Ajouter une classe
                </button>
            </div>
        </div>
        <div class="mt-2">
            {$dataAgentsList}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="agentModal" tabindex="-1" role="dialog" aria-labelledby="agentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="agentModalLabel">Add Agent</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="interface.php?agentsList=" method="POST" id="addAgent">
            <input type="hidden" class="form-control" name="addAgent">
                <div class="form-group">
                    <label for="agentName">Nom de l'agent</label>
                    <input type="text" class="form-control" id="agentName" placeholder="sage" name="agentName" Required>
                </div>
                <div class="form-group">
                    <label for="agentGender">Genre</label>
                    <select class="form-control" id="agentGender" name="agentGender">
                    <option value="F">Female</option>
                    <option value="M">Male</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="agentClass">Classes</label>
                    <select class="form-control" id="agentClass" name="agentClass">
                    {$dataClassesList}
                    </select>
                </div>
                <div class="form-group">
                    <label for="agentPosition">Localisation</label>
                    <select class="form-control" id="agentPosition" name="agentPosition">
                    {$dataLocationsList}
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" form="addAgent" value="Ajouter un agent"/>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="agentClassModal" tabindex="-1" role="dialog" aria-labelledby="agentClassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="agentClassModalLabel">Add Agent Class</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="interface.php" method="POST" id="addClass">
            <input type="hidden" class="form-control" value="addClass" name="addClass">
                <div class="form-group">
                    <label for="className">Nom de la classe</label>
                    <input type="text" class="form-control" id="className" placeholder="sentinel" name="className" Required>
                </div>
                <div class="form-group">
                    <label for="classDescription">Description de la classe</label>
                    <textarea class="form-control" id="classDescription" rows="3" name="classDescription" Required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" form="addClass" value="Ajouter un agent"/>
        </div>
        </div>
    </div>
    </div>

    
    <div class="container m-2">
        <form action="interface.php?" method="GET">
            <div class="form-group">
                <label for="agentName">Saisir le nom d'un agent (si vous n'en connaissez aucun vous pouvez afficher la liste des agents)</label>
                <input type="text" class="form-control" id="agentName" placeholder="sage" name="agentName">
            </div>
            <button type="submit" class="btn btn-primary">Afficher la classe de l'agent</button>
        </form>
        <div class="mt-2">
            {$dataAgentClass}
        </div>          
    </div>

    <div class="container m-2">
        <form action="interface.php" method="GET">
            <div class="form-group">
                <label for="agentName">Saisir le code postal d'un agent (si vous n'en connaissez aucun vous pouvez afficher la liste des agents)</label>
                <input type="text" class="form-control" id="cp" placeholder="51100" name="cp">
            </div>
            <button type="submit" class="btn btn-primary">Afficher la localisation de l'agent</button>
        </form>
        <div class="mt-2">
            {$dataAgentLocalisation}
        </div>          
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
HTML;

echo $html;