<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
include '../include/connectBDD.php';
$typeid=$_SESSION['type'];
$checkprivilege = $bdd->prepare(" SELECT type_utilisateur FROM typeuser WHERE id_type='$typeid'");
$checkprivilege->execute();
$checkprivilege2 = $checkprivilege->fetch();
$checkprivilege->closeCursor();

if($checkprivilege2['type_utilisateur'] != 1){
    header('Location: ../index.php');
    exit();
}

else{
    $filmid=$_POST['delete'];
    //supprimer lien du genre
    $deletegenre = $bdd->prepare(" DELETE FROM appartient_a WHERE id_film='$filmid'");
    $deletegenre->execute();
    $deletegenre->closeCursor();
    //supprimer lien des acteurs
    $deleteactor = $bdd->prepare(" DELETE FROM joue WHERE id_film='$filmid'");
    $deleteactor->execute();
    $deleteactor->closeCursor();
    //supprimer lien du réalisateur
    $deletereal = $bdd->prepare(" DELETE FROM realise WHERE id_film='$filmid'");
    $deletereal->execute();
    $deletereal->closeCursor();
    //supprimer le film
    $deletefilm = $bdd->prepare(" DELETE FROM Film WHERE id_film='$filmid'");
    $deletefilm->execute();
    $deletefilm->closeCursor();
    header('Location: ../filmmanager.php');
    exit();
}
?>