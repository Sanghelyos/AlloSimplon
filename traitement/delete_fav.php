<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
include '../include/connectBDD.php';

$id_film = $_GET['id'];
$id_user = $_SESSION['sess'];

$favinsert = $bdd->prepare(" DELETE FROM favoris WHERE id_utilisateur=$id_user AND id_film = $id_film");
$favinsert->execute();
$favinsert->closeCursor();
header('Location: ../film.php?film='.$id_film);
exit();


?>