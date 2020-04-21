<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require '../include/class_bdd.php';
require '../include/connectBDD.php';
require '../include/classes.php';
$identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : NULL;
$nom = !empty($_POST['nom']) ? $_POST['nom'] : NULL;
$prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : NULL;
$mdp = !empty($_POST['password']) ? $_POST['password'] : NULL;
$mdp = md5($mdp);
if ($identifiant != NULL || $mdp != NULL || $prenom != NULL || $nom != NULL)
{
    if ($_SESSION['sess'] == NULL)
    {


        $regver = new UserRegister($identifiant, $mdp, $prenom, $nom);
        $regver2 = $regver->checkidentifiant($bdd);

        if ($identifiant == $regver2['identifiant'])
        {
            header('Location: ../register.php?rerr=1');
            exit();
        }
        else
        {
            $regver->register($bdd);
            header('Location: ../connland.php?rerr=2');
            exit();
        }
    }
    else
    {
        header('Location: ../connland.php?rerr=3');
        exit();
    }

}
else
{
    header('Location: ../connland.php?rerr=4');
    exit();
}
?>