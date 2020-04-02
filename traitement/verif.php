<?php
session_start();
header('Content-type: text/html; charset=utf-8');
include '../include/connectBDD.php';
$identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : NULL;
$mdp = !empty($_POST['password']) ? $_POST['password'] : NULL;
$mdp = md5($mdp);

if ($identifiant != NULL || $mdp != NULL)
{

    if ($_SESSION['sess'] == NULL)
    {

        $login = $bdd->prepare(" SELECT * FROM utilisateur WHERE identifiant='$identifiant' AND mdp_utilisateur='$mdp'");
        $login->execute();
        $utilisateur = $login->fetch();

        if ($utilisateur['identifiant'] == $identifiant && $utilisateur['mdp_utilisateur'] == $mdp)
        {
            $_SESSION['sess'] = $utilisateur['id_utilisateur'];
            $_SESSION['iden'] = $utilisateur['identifiant'];
            $_SESSION['date'] = date("d-m-Y",strtotime($utilisateur['date_creation']));
            $_SESSION['type'] = $utilisateur['id_type'];
            header('Location: ../connland.php?err=1');
            exit();
        }
        else
        {
            header('Location: ../connexion.php?err=2');
            exit();
        }
        $login->closeCursor();
    }
    else
    {
             header('Location: ../connland.php?err=3');
            exit();
    }
}
else
{
    header('Location: ../connland.php?err=4');
    exit();
}
?>