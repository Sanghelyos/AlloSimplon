<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require '../include/class_bdd.php';
require '../include/connectBDD.php';
require '../include/classes.php';
$identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : NULL;
$mdp = !empty($_POST['password']) ? $_POST['password'] : NULL;
$mdp = md5($mdp);

if ($identifiant != NULL || $mdp != NULL)
{

    if ($_SESSION['sess'] == NULL)
    {
        $user = new UserLogin($identifiant, $mdp);
        $utilisateur = $user->login($bdd);

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