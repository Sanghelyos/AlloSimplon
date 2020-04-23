<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require 'include/class_bdd.php';
require 'include/connectBDD.php';
require_once 'styleswitcher.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link rel="stylesheet" href="css/reset.css">

    <link rel="stylesheet" media="screen, projection" type="text/css" id="css" href="<?php echo $url; ?>" />

    <!--GOOGLE FONTS-->

    <link
        href="https://fonts.googleapis.com/css?family=Baloo+Tammudu+2:400,500,600,700,800|Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Rubik:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Asap:400,400i,500,500i,600,600i,700,700i|Bellota+Text:300,300i,400,400i,700,700i&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:700,800,900|Quicksand:300,400,500,600,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">




</head>

<body>

<?php
include 'include/nav.php'; ?>


    <!-- zone de connexion -->

    <div id="container">
        <?php


//err = erreur connexion
//rerr = erreur inscription
//ferr = erreur ajout film

$err = !empty($_GET['err']) ? $_GET['err'] : NULL;
$rerr = !empty($_GET['rerr']) ? $_GET['rerr'] : NULL;
$actediterr = !empty($_GET['actediterr']) ? $_GET['actediterr'] : NULL;
$acti = !empty($_GET['acti']) ? $_GET['acti'] : NULL;
if ($err == 1){
    echo "Bienvenue, " . $_SESSION['iden'] . ".";
    echo "<br>";
    echo 'Accéder à votre <a href="dashboard.php">Dashboard</a>';
}
if ($err == 3){
    echo "Vous êtes déjà connecté";
}
if ($err == 4){
    echo "Une erreur des survenue";
}
if ($rerr == 2){
    echo "Merci pour votre inscription";
    echo "<br>";
    echo "Un mail de confirmation vous a été envoyé";
}

if ($err == 3){
    echo "Vous êtes déjà connecté";
}

if ($err == 4){
    echo "Une erreur est survenue";
}
if ($err == 666){
    echo "Vous devez d'abord activer votre compte pour<br>pouvoir vous connecter.";
}
if ($actediterr == 1){
    echo "Une erreur est survenue";
}
if ($acti == 1){
    echo "Votre compte a été activé.<br>Vous pouvez vous connecter.";
}


?>

    </div>


    <?php 
include 'include/footer.php'; ?>

</body>

</html>