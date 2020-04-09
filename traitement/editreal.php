<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
include '../include/connectBDD.php';
require_once '../styleswitcher.php';
$typeid=$_SESSION['type'];
$checkprivilege = $bdd->prepare(" SELECT type_utilisateur FROM typeuser WHERE id_type='$typeid'");
$checkprivilege->execute();
$checkprivilege2 = $checkprivilege->fetch();
$checkprivilege->closeCursor();

if($checkprivilege2['type_utilisateur'] != 1){
    header('Location: ../index.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de réalisateur</title>

    <link rel="stylesheet" href="../css/reset.css">
    
    <link rel="stylesheet" media="screen, projection" type="text/css" id="css" href="../<?php echo $url; ?>" />

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


  <!-- zone de connexion -->

    <div id="container">
<?php

    $idreal = !empty($_POST['idreal']) ? $_POST['idreal'] : NULL;
    $real = $bdd->prepare(" SELECT * FROM realisateur WHERE id_realisateur=" . $idreal);
    $real->execute();
    $real2 = $real->fetch();
    $real->closeCursor();
    $nom = !empty($_POST['nom']) ? $_POST['nom'] : $real2['nom_realisateur'];
    $desc = !empty($_POST['desc']) ? $_POST['desc'] : $real2['desc_realisateur'];
    $bio = !empty($_POST['biographie']) ? $_POST['biographie'] : $real2['bio_realisateur'];
    $photo = $real2['image_realisateur'];
    $photocheck = !empty($_FILES['photo']) ? $_FILES['photo'] : NULL;

    if(isset($idreal)) // si acteur
    {   

        if($photocheck['name'] != ""){
        //téléchager image
        $content_dir = '../img/real/'; // dossier où sera déplacé le fichier
    
        $tmp_file = $_FILES['photo']['tmp_name'];
    
        if( !is_uploaded_file($tmp_file) )
        {
            exit("La photo est introuvable<br>Le réalisateur n'a pas été modifié");
        }
    
        // on vérifie maintenant l'extension
        $type_file = $_FILES['photo']['type'];
    
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
        {
            exit("La photo n'est pas une image<br>Le réalisateur n'a pas été modifié");
        }
    
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['photo']['name'];
        $photo=$name_file;
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir <br>Le réalisateur n'a pas été modifié");
        }
    
        echo "La photo a bien été uploadée<br>";
        }
     

        $realedit = $bdd->prepare("UPDATE realisateur SET nom_realisateur = ?,image_realisateur = ?,desc_realisateur = ?,bio_realisateur = ?
                                    WHERE id_realisateur='$idreal'");
        $realedit->execute(array($nom,$photo,$desc,$bio));
        $realedit->closeCursor();


        echo "Réalisateur modifié !";
    }
    else{
        echo "Une erreur est survenue !";
    }
    
?>
    <br><a style="color: white;" href="../realmanager.php">Retour au gestionnaire des réalisateurs</a>
    </div>

</body>
</html>