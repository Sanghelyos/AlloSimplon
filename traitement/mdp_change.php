<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require '../include/class_bdd.php';
require '../include/connectBDD.php';
require '../include/classes.php';
$type = !empty($_POST['oublitype']) ? $_POST['oublitype'] : NULL;
$mail = !empty($_POST['mail']) ? $_POST['mail'] : NULL;


$change = new UserMax(NULL, NULL, NULL, NULL, NULL, NULL, $mail);
$change->oubliUpdate($bdd, $type);
?>