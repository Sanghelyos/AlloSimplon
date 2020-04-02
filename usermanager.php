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
    <title>Gestion utilisateur</title>

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
        th{
            color:red;
        }

        @media only screen and (min-width:768px) {
            #container {
                width: 50%;
            }
        }

        @media only screen and (min-width:1000px) {
            #container {
                margin-top: 50px;
                width: 50%;
                padding-top: 50px;
                padding-bottom: 50px;
                padding-right: 50px;
                padding-left: 50px;
            }
        }
    </style>


</head>

<body>

    <div>
        <?php
include 'include/nav.php'; ?>


        <!-- zone de connexion -->

        <div id="container">


            <h2>Gestion des utilisateurs</h2>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Identifiant</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Date de création</th>
                    <th>Droits</th>
                    <th>Gestion droits</th>
                    <th>Suppression</th>
                </tr>
                <?php
$userlist = $bdd->prepare(" SELECT id_utilisateur, identifiant, prenom_utilisateur, nom_utilisateur, id_type, date_creation FROM utilisateur");
$userlist->execute();

while( $userlist2 = $userlist->fetch() ) {
?>

                <tr>
                    <td><?= $userlist2['id_utilisateur'] ?></td>
                    <td><?= $userlist2['identifiant'] ?></td>
                    <td><?= $userlist2['prenom_utilisateur'] ?></td>
                    <td><?= $userlist2['nom_utilisateur'] ?></td>
                    <td><?= date('d-m-Y H:i:s', strtotime($userlist2['date_creation'])); ?></td>

                    <?php
if($userlist2['id_type'] == 1){
    echo '<td>Admin</td>';
}
else{
    echo '<td>Pas admin</td>';
}

$checkprivilege = $bdd->prepare(" SELECT type_utilisateur FROM typeuser WHERE id_type=" . $userlist2['id_type']);
$checkprivilege->execute();
$checkprivilege2 = $checkprivilege->fetch();
$checkprivilege->closeCursor();
    
if($checkprivilege2['type_utilisateur'] == 1){ ?>

                    <td>
                        <form action="traitement/retrogradation.php" method="post">
                            <button style="width:100%" type="submit" formmethod="post" value="<?= $userlist2['id_utilisateur'] ?>"
                                name="retrogradation" id="retrogradation">Rétrograder</button>
                        </form>
                    </td>

                    <?php  
}
else{
?>
                    <td>
                    <form action="traitement/promotion.php" method="post">
                            <button style="width:100%" type="submit" formmethod="post" value="<?= $userlist2['id_utilisateur'] ?>"
                                name="promotion" id="promotion">Promouvoir</button>
                        </form>
                    </td>
                    <?php 
} 
?>
                    <td>
                        <form action="traitement/delete_user.php" method="post">
                            <button style="width:100%" type="submit" formmethod="post" value="<?= $userlist2['id_utilisateur'] ?>"
                                name="delete" id="delete">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php
}
?>

            </table>
        </div>
        <?php
include 'include/footer.php'; ?>
</body>

</html>