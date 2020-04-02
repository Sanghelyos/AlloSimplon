<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: connexion.php');
    exit();
}
include 'include/connectBDD.php';
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
    <title>Ajout de film</title>

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
include 'include/nav.php'; ?>


        <!-- zone de connexion -->

        <div id="container">

        <form id="addfilm" enctype="multipart/form-data" action="traitement/addfilm.php" method="POST">
            <h2>Ajouter un film</h2>
            <label>Nom du film :</label><br>
            <input class="login" type="text" placeholder="Nom" name="nom" tabindex="1" required> <br>
            <label>Note du film :</label><br>
            <input class="login" type="number" placeholder="Note /5" name="note" step="0.1" min="0" max="5" tabindex="2" required> <br>

            <label>Genre :</label><br>
            <select name="genre">
<?php
          
$genrelist = $bdd->prepare(" SELECT * FROM Genre");
$genrelist->execute();

while( $genrelist2 = $genrelist->fetch() ) { ?>
            <option value ="<?= $genrelist2['id_genre'] ?>"><?= $genrelist2['nom_genre'] ?></option>
<?php
}
$genrelist->closeCursor();
?>
            </select> <br> <br>
<div style="display:flex; justify-content: center; flex-wrap: wrap;">
<?php
    $nbactor= $_GET['nbactor']; 
    for ($i=1; $i < $nbactor+1 ; $i++){  
            echo '<div style="display:block; justify-content: center;">';     
           echo '<label>Acteur ' . $i .  ':</label><br>';
        echo '<select name="acteur' . $i .'">';




$acteurlist = $bdd->prepare(" SELECT id_acteur, nom_acteur FROM acteur");
$acteurlist->execute();

while( $acteurlist2 = $acteurlist->fetch() ) { ?>
            <option value ="<?= $acteurlist2['id_acteur'] ?>"><?= $acteurlist2['nom_acteur'] ?></option>
<?php
}

            echo '</select> <br> <br>';
            echo '</div>';
}
$acteurlist->closeCursor();
?>
</div>
            <label>Réalisateur :</label><br>
            <select name="real">
<?php            
$reallist = $bdd->prepare(" SELECT id_realisateur, nom_realisateur FROM realisateur");
$reallist->execute();

while( $reallist2 = $reallist->fetch() ) { ?>
            <option value ="<?= $reallist2['id_realisateur'] ?>"><?= $reallist2['nom_realisateur'] ?></option>
<?php
}
$reallist->closeCursor();
?>
            </select> <br> <br>

            <label>Date de sortie :</label><br>
            <input class="login" type="date" placeholder="Date de sortie (JJ-MM-AAAA)" name="releasedate" tabindex="3" required> <br>
            <label>Durée :</label><br>
            <input class="login"  type="time" placeholder="Durée du film (HH:MM:SS)" name="duree" tabindex="4" required><br>
            <label>Bande annonce :</label><br>
            <input class="login"  type="text" placeholder="Lien Youtube" name="trailer" tabindex="5" required><br>
            <label>Synopsis :</label><br>
            <textarea class="login"  type="text" placeholder="Synopsis" name="synopsis" tabindex="6" required></textarea><br>
            <label>Affiche :</label><br>
            <input class="login"  type="file" accept=".jpg,.jpeg,.bmp,.gif,.png" placeholder="Affiche" name="affiche" tabindex="7" required><br>

            <label>Bannière :</label><br>
            <input class="login"  type="file" accept=".jpg,.jpeg,.bmp,.gif,.png" placeholder="Bannière" name="banniere" tabindex="8" required><br>

            <input style="display:none;" type="number" placeholder="" name="nbactor" value="<?= $nbactor ?>" required>

            <input class="ok"type="submit" name="add" id='submit' value='AJOUTER'> <br>


        </form>
        </div>
        <?php
include 'include/footer.php'; ?>
</body>

</html>