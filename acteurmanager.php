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
    <title>Gestion des acteurs</title>

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

        textarea {
            border: 5px solid #FF7200;
            background-color: black;
            color: white;
            font-family: 'Ubuntu', Arial, Helvetica, sans-serif;
        }

        hr{
            border-color: orange;
        }
    </style>


</head>

<body>

    <div>
        <?php
include 'include/nav.php'; ?>


        <!-- zone de connexion -->

        <div id="container">


            <h2>Gestion des acteurs</h2>
            <a style="color: #ff7200; border: 4px solid #ff7200; text-decoration: none; padding: 3px;"
                href="#addacteuranchor">AJOUTER UN ACTEUR</a><br><br><br>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Photo</th>
                    <th>Biographie</th>
                    <th>Filmographie</th>
                    <th>Gestion</th>
                </tr>
                <?php




$acteurlist = $bdd->prepare(" SELECT * FROM acteur");
$acteurlist->execute();

while( $acteurlist2 = $acteurlist->fetch() ) {


?>

                <tr>
                    <td><?= $acteurlist2['id_acteur'] ?></td>
                    <td><?= $acteurlist2['nom_acteur'] ?></td>
                    <td style="vertical-align: middle;">
                        <?= '<a href="img/acteurs/' . $acteurlist2['image_acteur'].'"><img height="60px" width="60px" src="img/acteurs/'.$acteurlist2['image_acteur'].'"></a>' ?>
                    </td>
                    <td><?= $acteurlist2['Biographie_acteur'] ?></td>
                    <td style="vertical-align: middle;">
                        <?php


                    $joue = $bdd->prepare("SELECT id_film FROM joue WHERE id_acteur=".$acteurlist2['id_acteur']);
                    $joue->execute();
                    

                        while($joue2 = $joue->fetch()){ ?>
                    <?php
                    $joue2idfilm=$joue2['id_film'];
                    $filmlist = $bdd->prepare(" SELECT id_film,nom_film FROM Film WHERE id_film='$joue2idfilm'");
                    $filmlist->execute();
                    $filmlist2 = $filmlist->fetch();
                    $filmlist->closeCursor(); ?>
                        
                        <a style="font-size:70%; color:white;"
                            href="film.php?film=<?= $filmlist2['id_film']; ?>"><?= $filmlist2['nom_film']; ?></a>
                        <hr>

                        <?php 
                    }
                    $joue->closeCursor();
                     ?>
                    </td>
                    <td style="vertical-align: middle;">
                        <form action="acteureditor.php" method="post">
                            <button style="width:100%; height: 100%;" type="submit" formmethod="post"
                                value="<?= $acteurlist2['id_acteur'] ?>" name="edit" id="edit">Modifier</button>
                        </form><br>
                        <!--<form action="traitement/edit_film.php" method="post">
                            <button style="width:100%;" type="submit" formmethod="post" value="<?= $acteurlist2['id_acteur'] ?>"
                                name="edit" id="edit">Modifier</button>
                        </form>-->
                    </td>
                </tr>
                <?php
}
$acteurlist->closeCursor();
?>

            </table>


            <section id="editionsection" style="display:flex; justify-content: space-around;">

                <form id="addacteur" enctype="multipart/form-data" action="traitement/addacteur.php" method="POST">
                    <h2 id="addacteuranchor">Ajouter un acteur</h2>
                    <label>Nom de l'acteur :</label><br>
                    <input class="login" type="text" placeholder="Nom" name="nom" tabindex="1" required> <br>
                    <label>Biographie de l'acteur :</label><br>
                    <textarea class="login" type="text" placeholder="Biographie" name="biographie" tabindex="2"
                        required></textarea><br>
                    <label>Photo :</label><br>
                    <input class="login" type="file" accept=".jpg,.jpeg,.bmp,.gif,.png" placeholder="Photo acteur"
                        name="photo" tabindex="3" required><br>

                    <input class="ok" type="submit" name="add" id='submit' value='AJOUTER'> <br>
                </form>

                <div id="linkers" style="display: block;">
                <form id="linkactor" enctype="multipart/form-data" action="traitement/acteurlink.php" method="POST">
                    <h2 id="">Lier un film et un acteur</h2>
                    <div style="display:flex; justify-content: center; flex-wrap: wrap;">
                        <div style="display: block;">
                            <label>Acteur : </label><br>
                            <select name="acteurlink">';
                                <?php
            $acteurlist = $bdd->prepare(" SELECT id_acteur, nom_acteur FROM acteur");
            $acteurlist->execute();

            while( $acteurlist2 = $acteurlist->fetch() ) { ?>
                                <option value="<?= $acteurlist2['id_acteur'] ?>"><?= $acteurlist2['nom_acteur'] ?>
                                </option>
                                <?php
            }?>
                            </select> <br> <br>
                        </div>
                        <div style="display: block;">
                            <label>Film : </label><br>
                            <select name="filmlink">';
                                <?php
            $filmlist = $bdd->prepare(" SELECT id_film, nom_film FROM Film");
            $filmlist->execute();

            while( $filmlist2 = $filmlist->fetch() ) { ?>
                                <option value ="<?= $filmlist2['id_film'] ?>"><?= $filmlist2['nom_film'] ?>
                                </option>
                                <?php
            }?>
                            </select> <br> <br>
                        </div>

                        <?php $filmlist->closeCursor(); ?>

                    </div>



                    <input class="ok" type="submit" name="link" id='submit' value='LIER'> <br>
                </form>
                <form id="unlinkactor" enctype="multipart/form-data" action="traitement/acteurunlink.php" method="POST">
                    <h2 id="">Delier un film et un acteur</h2>
                    <div style="display:flex; justify-content: center; flex-wrap: wrap;">
                        <div style="display: block;">
                            <label>Acteur : </label><br>
                            <select name="acteurunlink">';
                                <?php
            $acteurlist = $bdd->prepare(" SELECT id_acteur, nom_acteur FROM acteur");
            $acteurlist->execute();

            while( $acteurlist2 = $acteurlist->fetch() ) { ?>
                                <option value="<?= $acteurlist2['id_acteur'] ?>"><?= $acteurlist2['nom_acteur'] ?>
                                </option>
                                <?php
            }?>
                            </select> <br> <br>
                        </div>
                        <div style="display: block;">
                            <label>Film : </label><br>
                            <select name="filmunlink">';
                                <?php
            $filmlist = $bdd->prepare(" SELECT id_film, nom_film FROM Film");
            $filmlist->execute();

            while( $filmlist2 = $filmlist->fetch() ) { ?>
                                <option value ="<?= $filmlist2['id_film'] ?>"><?= $filmlist2['nom_film'] ?>
                                </option>
                                <?php
            }?>
                            </select> <br> <br>
                        </div>

                        <?php $filmlist->closeCursor(); ?>

                    </div>



                    <input class="ok" type="submit" name="unlink" id='submit' value='DELIER'> <br>
                </form>
                
                </div>
            </section>
        </div>
        <?php
include 'include/footer.php'; ?>
</body>

</html>