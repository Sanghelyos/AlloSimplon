<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
include '../include/connectBDD.php';
require_once '../styleswitcher.php';
$typeid=$_SESSION['type'];
$checkprivilege = $bdd->prepare(" SELECT type_utilisateur FROM typeuser WHERE id_type='$typeid'");
$checkprivilege->execute();
$checkprivilege2 = $checkprivilege->fetch();
$checkprivilege->closeCursor();

if($checkprivilege2['type_utilisateur'] != 1){
    header('Location: ../index.php');
    exit();
}


$acteur = !empty($_POST['acteurlink']) ? $_POST['acteurlink'] : NULL;
$film = !empty($_POST['filmlink']) ? $_POST['filmlink'] : NULL;


        //insérer ligne
        $jouepush = $bdd->prepare("INSERT INTO joue ( id_film, id_acteur )
        VALUES (:id_film,:id_acteur)");

        $jouepush->execute(array(
        ':id_film' => $film,
        ':id_acteur' => $acteur
        ));
        $jouepush->closeCursor();
        header('Location: ../acteurmanager.php#addacteuranchor');
        exit();
    

?>