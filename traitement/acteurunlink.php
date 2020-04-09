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


$acteur = !empty($_POST['acteurunlink']) ? $_POST['acteurunlink'] : NULL;
$film = !empty($_POST['filmunlink']) ? $_POST['filmunlink'] : NULL;


        //supprimer lien
        $deleteactorlink = $bdd->prepare(" DELETE FROM joue WHERE id_acteur='$acteur' AND id_film = $film");
        $deleteactorlink->execute();
        $deleteactorlink->closeCursor();
        header('Location: ../acteurmanager.php#addacteuranchor');
        exit();

?>