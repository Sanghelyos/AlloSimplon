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


$real = !empty($_POST['reallink']) ? $_POST['reallink'] : NULL;
$film = !empty($_POST['filmlink']) ? $_POST['filmlink'] : NULL;


        //insérer ligne
        $realpush = $bdd->prepare("INSERT INTO realise ( id_film, id_realisateur )
        VALUES (:id_film,:id_realisateur)");

        $realpush->execute(array(
        ':id_film' => $film,
        ':id_realisateur' => $real
        ));
        $realpush->closeCursor();
        header('Location: ../realmanager.php#addrealanchor');
        exit();
    

?>