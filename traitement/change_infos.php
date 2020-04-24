<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require '../include/class_bdd.php';
require '../include/connectBDD.php';
require '../include/classes.php';
$type = !empty($_POST['type']) ? $_POST['type'] : NULL;
$token = !empty($_GET['key']) ? $_GET['key'] : NULL;
$identifiant = !empty($_POST['username']) ? $_POST['username'] : NULL;
$mdp = !empty($_POST['password']) ? $_POST['password'] : NULL;


$change = new UserMax(NULL, NULL, NULL, NULL, $token, NULL, NULL);
$change->oubliUpdateAction($bdd, $type, $identifiant, $mdp);
?>