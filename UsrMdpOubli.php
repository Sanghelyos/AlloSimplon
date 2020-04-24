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
    <title>Change identifiant ou mdp</title>

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

if ($_SESSION['sess'] == NULL)
{
?>
        <form action="traitement/mdp_change.php" method="POST">
            <h2>Changement d'identifiant ou de mot de passe</h2>

            <input class="login" type="email" placeholder="Adresse mail" name="mail" tabindex="1" required> <br>

            <input type="radio" name="oublitype" value="1" checked>Identifiant<br>
            <input type="radio" name="oublitype" value="2">Mot de passe<br><br>

            <input class="ok"type="submit" id='submit' value='CHANGER'> <br><br>
            
            <?php
            $err = !empty($_GET['err']) ? $_GET['err'] : NULL;
            if ($err == 2){
                echo "Identifiant ou mot de passe incorrect";
            }
}
else
{
    echo "Vous êtes déjà connecté";
}

            ?>

            <?php
            if(isset($_GET['erreur'])){
                $err = $_GET['erreur'];
                if($err==1 || $err==2)
                    echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
            }
            ?> 


        </form>
    </div>


<?php 
include 'include/footer.php'; ?>

</body>
</html>