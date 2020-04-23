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
$mail = !empty($_POST['mail']) ? $_POST['mail'] : NULL;


$register = new UserMax($identifiant, $mdp, $prenom, $nom, NULL, NULL, $mail);
$register->register($bdd);
?>