<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require '../include/class_bdd.php';
require '../include/connectBDD.php';
require '../include/classes.php';
$token = !empty($_GET['key']) ? $_GET['key'] : NULL;
$identifiant = !empty($_GET['username']) ? $_GET['username'] : NULL;


$activate = new UserMax($identifiant, NULL, NULL, NULL, $token, NULL, NULL);
$activate->activate($bdd);
header('Location: ../connland.php?acti=1');
exit();
?>