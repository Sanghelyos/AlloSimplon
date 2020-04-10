<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
include '../include/connectBDD.php';

$id_film = $_GET['id'];
$id_user = $_SESSION['sess'];

$favinsert = $bdd->prepare(" INSERT INTO favoris ( id_film, id_utilisateur )
                            VALUES (:id_film,:id_utilisateur)");
$favinsert->execute(
            array(
                ':id_film' => $id_film,
                ':id_utilisateur' => $id_user
            ));
$favinsert->closeCursor();
header('Location: ../film.php?film='.$id_film);
exit();


?>