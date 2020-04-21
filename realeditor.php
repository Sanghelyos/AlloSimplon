<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: connexion.php');
    exit();
}
require 'include/class_bdd.php';
require 'include/connectBDD.php';
$typeid=$_SESSION['type'];
$checkprivilege = $bdd->prepare(" SELECT type_utilisateur FROM typeuser WHERE id_type='$typeid'");
$checkprivilege->execute();
$checkprivilege2 = $checkprivilege->fetch();
$checkprivilege->closeCursor();

if($checkprivilege2['type_utilisateur'] != 1){
    header('Location: index.php');
    exit();
}
header('Content-type: text/html; charset=utf-8');
require_once 'styleswitcher.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des réalisateurs</title>

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

    <style>
        td,
        th {
            border: 1px solid white;
        }

        th {
            color: red;
        }

        @media only screen and (min-width:768px) {
            #container {
                width: 80%;
            }
        }

        @media only screen and (min-width:1000px) {
            #container {
                margin-top: 50px;
                width: 80%;
                padding-top: 50px;
                padding-bottom: 50px;
                padding-right: 50px;
                padding-left: 50px;
            }
        }
    textarea{
    border: 5px solid #FF7200;
    background-color: black;
    color:white;
    font-family: 'Ubuntu', Arial, Helvetica, sans-serif;
}
    </style>


</head>

<body>

    <div>
        <?php
$idreal = !empty($_POST['edit']) ? $_POST['edit'] : NULL;
if($idreal == NULL){
    header('Location: ../connland.php?actediterr=1');
    exit();
}
$real = $bdd->prepare(" SELECT * FROM realisateur WHERE id_realisateur='$idreal'");
$real->execute();
$real2 = $real->fetch();
$real->closeCursor();
?>


        <!-- zone de connexion -->

        <div id="container">

            <h2>Modifier réalisateur</h2>
        <form id="editacteur" enctype="multipart/form-data" action="traitement/editreal.php" method="POST">
            <label>Nom du réalisateur :</label><br>
            <input class="login" type="text" placeholder="<?= $real2['nom_realisateur']; ?>" value="<?= $real2['nom_realisateur']; ?>" name="nom" tabindex="1"> <br>
            <label>Description du réalisateur :</label><br>
            <textarea class="login"  type="text" placeholder="<?= $real2['desc_realisateur']; ?>" name="desc" tabindex="2"><?= $real2['desc_realisateur']; ?></textarea><br>
            <label>Biographie du réalisateur :</label><br>
            <textarea class="login"  type="text" placeholder="<?= $real2['bio_realisateur']; ?>" name="biographie" tabindex="3"><?= $real2['bio_realisateur']; ?></textarea><br>
            <label>Photo :</label><br>
            <input class="login"  type="file" accept=".jpg,.jpeg,.bmp,.gif,.png" placeholder="Photo realisateur" name="photo" tabindex="4"><br>
            <input style="display:none;" type="number" name="idreal" value="<?= $idreal ?>" required>
            <input class="ok"type="submit" name="edit" id='submit' value='MODIFIER'> <br>


        </form>
        </div>
        <?php
include 'include/footer.php'; ?>
</body>

</html>