<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
require '../include/class_bdd.php';
require '../include/connectBDD.php';
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


$real = !empty($_POST['realunlink']) ? $_POST['realunlink'] : NULL;
$film = !empty($_POST['filmunlink']) ? $_POST['filmunlink'] : NULL;


        //supprimer lien
        $deleterreallink = $bdd->prepare(" DELETE FROM realise WHERE id_realisateur='$real' AND id_film = $film");
        $deleterreallink->execute();
        $deleterreallink->closeCursor();
        header('Location: ../realmanager.php#addrealanchor');
        exit();

?>