<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: connexion.php');
    exit();
}
include 'include/connectBDD.php';
$typeid=$_SESSION['type'];
$checkprivilege = $bdd->prepare(" SELECT type_utilisateur FROM typeuser WHERE id_type='$typeid'");
$checkprivilege->execute();
$checkprivilege2 = $checkprivilege->fetch();
$checkprivilege->closeCursor();

if($checkprivilege2['type_utilisateur'] != 1){
    header('Location: index.php');
    exit();
}

else{
    $userid=$_POST['promotion'];
    if($userid == $_SESSION['sess']){
        header('Location: usermanager.php');
        exit();
    }
    else{
    $updateprivilege = $bdd->prepare(" UPDATE utilisateur SET id_type=1 WHERE id_utilisateur='$userid'");
    $updateprivilege->execute();
    $updateprivilege->closeCursor();
    header('Location: usermanager.php');
    exit();
}
}
?>