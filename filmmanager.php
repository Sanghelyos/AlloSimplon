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
    <title>Gestion films</title>

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
include 'include/nav.php'; ?>


        <!-- zone de connexion -->

        <div id="container">


            <h2>Gestion des films</h2>
            <form id="ajoutfilm" action="ajoutfilm.php" method="GET">
            <input class="login" style="width: 20%;" type="number" placeholder="Nombre d'acteurs prévus" name="nbactor" step="1" min="1" max="10" tabindex="1" required> <br>
            <input class="ok"type="submit" value='Ajouter un film'><br><br><br>
            </form>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Note</th>
                    <th>Synopsis</th>
                    <th style="width: 10%;">Date sortie</th>
                    <th>Durée</th>
                    <th>Gestion</th>
                </tr>
                <?php
$filmlist = $bdd->prepare(" SELECT id_film, nom_film, synopsis, note_film, date_sortie, duree_film FROM Film");
$filmlist->execute();

while( $filmlist2 = $filmlist->fetch() ) {
?>

                <tr>
                    <td><?= $filmlist2['id_film'] ?></td>
                    <td><a style="color:white;" href="film.php?film=<?= $filmlist2['id_film'] ?>"> <?= $filmlist2['nom_film'] ?></a></td>
                    <td><br><?= $filmlist2['note_film'] ?><br><hr>5</td>
                    <td><?= $filmlist2['synopsis'] ?></td>
                    <td><?= date('d-m-Y', strtotime($filmlist2['date_sortie'])); ?></td>
                    <td><?= date('H:i', strtotime($filmlist2['duree_film'])); ?></td>
                    <td style="vertical-align: middle;">
                        <form action="traitement/delete_film.php" method="post">
                            <button style="width:100%; height: 100%;" type="submit" formmethod="post" value="<?= $filmlist2['id_film'] ?>"
                                name="delete" id="delete">Supprimer</button>
                        </form><br>
                        <form action="modifilm.php" method="post">
                            <button style="width:100%;" type="submit" formmethod="post" value="<?= $filmlist2['id_film'] ?>"
                                name="edit" id="edit">Modifier</button>
                        </form>
                    </td>
                </tr>
<?php
}
$filmlist->closeCursor();
?>
            </table>

        </div>
        <?php
include 'include/footer.php'; ?>
</body>

</html>