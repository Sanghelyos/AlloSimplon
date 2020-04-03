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
    <title>Modification d'acteur</title>

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

<?php include '../include/nav.php'; ?>

  <!-- zone de connexion -->

    <div id="container">
<?php

    $idactor = !empty($_POST['idactor']) ? $_POST['idactor'] : NULL;
    $acteur = $bdd->prepare(" SELECT * FROM acteur WHERE id_acteur=" . $idactor);
    $acteur->execute();
    $acteur2 = $acteur->fetch();
    $acteur->closeCursor();
    $nom = !empty($_POST['nom']) ? $_POST['nom'] : $acteur2['nom_acteur'];
    $bio = !empty($_POST['biographie']) ? $_POST['biographie'] : $acteur2['Biographie_acteur'];
    $photo = $acteur2['image_acteur'];

    if(isset($idactor)) // si acteur
    {   

        if(isset($_POST['photo'])){
        //téléchager image
        $content_dir = '../img/acteurs/'; // dossier où sera déplacé le fichier
    
        $tmp_file = $_FILES['photo']['tmp_name'];
    
        if( !is_uploaded_file($tmp_file) )
        {
            exit("La photo est introuvable<br>L'acteur n'a pas été ajouté");
        }
    
        // on vérifie maintenant l'extension
        $type_file = $_FILES['photo']['type'];
    
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
        {
            exit("La photo n'est pas une image<br>L'acteur n'a pas été modifié");
        }
    
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['photo']['name'];
        $photo=$name_file;
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir <br>L'acteur n'a pas été modifié");
        }
    
        echo "La photo a bien été uploadée<br>";
        }
     

        $acteuredit = $bdd->prepare("UPDATE acteur SET nom_acteur = ?,image_acteur = ?,Biographie_acteur = ?
                                    WHERE id_acteur='$idactor'");
        $acteuredit->execute(array($nom,$photo,$bio));
        $acteuredit->closeCursor();


        echo "Acteur modifié !";
    }
    else{
        echo "Une erreur est survenue !";
    }
    
?>
    <br><a style="color: white;" href="../acteurmanager">Retour au gestionnaire des acteurs</a>
    </div>

</body>
</html>