<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require 'include/class_bdd.php';
require 'include/connectBDD.php';
require 'include/classes.php';
require_once 'styleswitcher.php';
$global = new globalClass();
$global->sesscheck();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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

<div>
<?php
include 'include/nav.php'; ?>


    <!-- zone de connexion -->

    <div id="container">


<h2>Bonjour, <?= $_SESSION['iden'] ?></h2>
<hr>
<p>Sélection du thème</p>
<div style="list-style:none;" class="liens-couleurs">
            <ul style="display:flex;">

                <li style="display:inline;">
                    <div class="style_axel"><a style="display:inline-block; width:100%; height:100%;" href="<?php echo $actuel; ?>?style=axel/index4.css"></a>
                        <div>
                </li>
                <li style="display:inline;">
                    <div class="style_pol"><a style="display:inline-block; width:100%; height:100%;" href="<?php echo $actuel; ?>?style=pol/index2.css"></a></div>
                </li>
                <li style="display:inline;">
                    <div class="style_steven"><a style="display:inline-block; width:100%; height:100%;" href="<?php echo $actuel; ?>?style=steven/index3.css"></a></div>
                </li>
                <li style="display:inline;">
                    <div class="style_ilayda"><a style="display:inline-block; width:100%; height:100%;" href="<?php echo $actuel; ?>?style=index.css"></a></div>
                </li>
            </ul>
        </div>
<hr>
<p>Date de création du compte : <?= $_SESSION['date'] ?></p>
<hr>
<?php

$global->checkadmin($bdd);

if($global == 1){?>
<h2>Gestion Admin</h2>    
<a style="color: white;" href="usermanager.php"><p>Gérer les utilisateurs</p></a>
<a style="color: white;" href="filmmanager.php"><p>Gérer les films</p></a>
<a style="color: white;" href="acteurmanager.php"><p>Gérer les acteurs</p></a>
<a style="color: white;" href="realmanager.php"><p>Gérer les réalisateurs</p></a>


<?php
}?>


</div>

<?php 
include 'include/footer.php'; ?>
</body>

</html>