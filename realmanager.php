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
include 'include/nav.php'; ?>


        <!-- zone de connexion -->

        <div id="container">


            <h2>Gestion des réalisateurs</h2>
            <a style="color: #ff7200; border: 4px solid #ff7200; text-decoration: none; padding: 3px;" href="#addrealanchor">AJOUTER UN REALISATEUR</a><br><br><br>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Photo</th>
                    <th>Description</th>
                    <th>Biographie</th>
                    <th>Filmographie</th>
                    <th>Gestion</th>
                </tr>
                <?php




$reallist = $bdd->prepare(" SELECT * FROM realisateur");
$reallist->execute();

while( $reallist2 = $reallist->fetch() ) {
        $realise = $bdd->prepare("SELECT id_film FROM realise WHERE id_realisateur=".$reallist2['id_realisateur']);
        $realise->execute();
        $realise2 = $realise->fetch();
        $realise->closeCursor();

?>

                <tr>
                    <td><?= $reallist2['id_realisateur'] ?></td>
                    <td><?= $reallist2['nom_realisateur'] ?></td>
                    <td style="vertical-align: middle;"><?= '<a href="img/real/' . $reallist2['image_realisateur'].'"><img height="60px" width="60px" src="img/real/'.$reallist2['image_realisateur'].'"></a>' ?></td>
                    <td><?= $reallist2['desc_realisateur'] ?></td>
                    <td><?= $reallist2['bio_realisateur'] ?></td>
                    <td>
                    <?php
                    $realise2idfilm=$realise2['id_film'];
                    $filmlist = $bdd->prepare(" SELECT id_film,nom_film FROM Film WHERE id_film='$realise2idfilm'");
                    $filmlist->execute();
                        while($filmlist2 = $filmlist->fetch()){ ?>
                        
                        <a style="font-size:70%; color:white;" href="film.php?film=<?= $filmlist2['id_film']; ?>"><?= $filmlist2['nom_film']; ?></a><br><hr><br>

                    <?php 
                    }
                    $filmlist->closeCursor(); ?>
                    </td>
                    <td style="vertical-align: middle;">
                        <form action="realeditor.php" method="post">
                            <button style="width:100%; height: 100%;" type="submit" formmethod="post" value="<?= $reallist2['id_realisateur'] ?>"
                                name="edit" id="edit">Modifier</button>
                        </form><br>
                        <!--<form action="traitement/edit_film.php" method="post">
                            <button style="width:100%;" type="submit" formmethod="post" value="<?= $reallist2['id_realisateur'] ?>"
                                name="edit" id="edit">Modifier</button>
                        </form>-->
                    </td>
                </tr>
<?php
}
$reallist->closeCursor();
?>
            </table>
            <h2 id="addrealanchor">Ajouter un réalisateur</h2>

        <form id="addacteur" enctype="multipart/form-data" action="traitement/addreal.php" method="POST">
            <label>Nom du réalisateur :</label><br>
            <input class="login" type="text" placeholder="Nom" name="nom" tabindex="1" required> <br>
            <label>Description du réalisateur :</label><br>
            <textarea class="login"  type="text" placeholder="Description" name="desc" tabindex="2" required></textarea><br>
            <label>Biographie du réalisateur :</label><br>
            <textarea class="login"  type="text" placeholder="Biographie" name="biographie" tabindex="3" required></textarea><br>
            <label>Photo :</label><br>
            <input class="login"  type="file" accept=".jpg,.jpeg,.bmp,.gif,.png" placeholder="Photo realisateur" name="photo" tabindex="4" required><br>

            <input class="ok"type="submit" name="add" id='submit' value='AJOUTER'> <br>


        </form>
        </div>
        <?php
include 'include/footer.php'; ?>
</body>

</html>