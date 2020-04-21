<?php
session_start();
if($_SESSION['sess'] == NULL){
    header('Location: ../connexion.php');
    exit();
}
require '../include/class_bdd.php';
require '../include/connectBDD.php';
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
    <title>Ajout de réalisateur</title>

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



    $nom = !empty($_POST['nom']) ? $_POST['nom'] : NULL;
    $desc = !empty($_POST['desc']) ? $_POST['desc'] : NULL;
    $bio = !empty($_POST['biographie']) ? $_POST['biographie'] : NULL;


    if( isset($nom) && isset($desc) && isset($bio)) // si formulaire soumis
    {   
        //téléchager image
        $content_dir = '../img/real/'; // dossier où sera déplacé le fichier
    
        $tmp_file = $_FILES['photo']['tmp_name'];
    
        if( !is_uploaded_file($tmp_file) )
        {
            exit("La photo est introuvable<br>Le réalisateur n'a pas été ajouté");
        }
    
        // on vérifie maintenant l'extension
        $type_file = $_FILES['photo']['type'];
    
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
        {
            exit("La photo n'est pas une image<br>Le réalisateur n'a pas été ajouté");
        }
    
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['photo']['name'];
        $photo=$name_file;
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir");
        }
    
        echo "La photo a bien été uploadée<br>";

        
        //Insérer le film
        $realpush = $bdd->prepare("INSERT INTO realisateur(nom_realisateur, image_realisateur, desc_realisateur, bio_realisateur)
        VALUES (:nom_realisateur,:image_realisateur,:desc_realisateur,:bio_realisateur)");

        $realpush->execute(array(
        ':nom_realisateur' => $nom,
        ':image_realisateur' => $photo,
        ':desc_realisateur' => $desc,
        ':bio_realisateur' => $bio
        ));
        $realpush-> closeCursor();

        echo "Réalisateur ajouté !";
    }
    else{
        echo "Une erreur est survenue !";
    }
    
?>
    <br><a style="color: white;" href="../realmanager">Retour au gestionnaire des réalisateurs</a>
    </div>

</body>
</html>