<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
require '../include/class_bdd.php';
require '../include/connectBDD.php';
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
    $userid=$_POST['delete'];
    if($userid == $_SESSION['sess']){
        header('Location: ../usermanager.php');
        exit();
    }
    else{
    $deleteuser = $bdd->prepare(" DELETE FROM utilisateur WHERE id_utilisateur='$userid'");
    $deleteuser->execute();
    $deleteuser->closeCursor();
    header('Location: ../usermanager.php');
    exit();
}
}
?>