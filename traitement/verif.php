<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require '../include/class_bdd.php';
require '../include/connectBDD.php';
require '../include/classes.php';
$identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : NULL;
$mdp = !empty($_POST['password']) ? $_POST['password'] : NULL;
$mdp = md5($mdp);
$user = new UserMin($identifiant, $mdp);
$utilisateur = $user->login($bdd);


        
        


?>