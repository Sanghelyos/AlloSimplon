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
    <title>Ajout de film</title>

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
    $note = !empty($_POST['note']) ? $_POST['note'] : NULL;
    $date = !empty($_POST['releasedate']) ? $_POST['releasedate'] : NULL;
    $date = date('Y-m-d', strtotime($date));
    $duree = !empty($_POST['duree']) ? $_POST['duree'] : NULL;
    $trailer = !empty($_POST['trailer']) ? $_POST['trailer'] : NULL;
    $trailer = substr($trailer, -11);
    $synopsis = !empty($_POST['synopsis']) ? $_POST['synopsis'] : NULL;
    $genreid = !empty($_POST['genre']) ? $_POST['genre'] : NULL;

    $nbactor = !empty($_POST['nbactor']) ? $_POST['nbactor'] : NULL;

    for($i=1; $i< $nbactor+1; $i++){
        $l= strval( $i );
        $acteuradd = "acteur".$l;
        ${'acteurid'.$l} = !empty($_POST[$acteuradd ]) ? $_POST[$acteuradd] : NULL;
    }

    $realid = !empty($_POST['real']) ? $_POST['real'] : NULL;

    if( $nom != NULL && $note != NULL && $date != NULL && $duree != NULL && $trailer != NULL && $synopsis != NULL && $genreid != NULL && $realid !=NULL) // si formulaire soumis
    {   
        //téléchager image
        $content_dir = '../img/affiches'; // dossier où sera déplacé le fichier
    
        $tmp_file = $_FILES['affiche']['tmp_name'];
    
        if( !is_uploaded_file($tmp_file) )
        {
            exit("L'affiche est introuvable<br>Le film n'a pas été ajouté");
        }
    
        // on vérifie maintenant l'extension
        $type_file = $_FILES['affiche']['type'];
    
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
        {
            exit("L'affiche n'est pas une image<br>Le film n'a pas été ajouté");
        }
    
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['affiche']['name'];
        $affiche=$name_file;
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir");
        }
    
        echo "L'affiche a bien été uploadée<br>";

        $content_dir = '../img/film_img'; // dossier où sera déplacé le fichier
    
        $tmp_file = $_FILES['banniere']['tmp_name'];
    
        if( !is_uploaded_file($tmp_file) )
        {
            exit("La bannière est introuvable<br>Le film n'a pas été ajouté");
        }
    
        // on vérifie maintenant l'extension
        $type_file = $_FILES['banniere']['type'];
    
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
        {
            exit("La bannière n'est pas une image<br>Le film n'a pas été ajouté");
        }
    
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['banniere']['name'];
        $banniere=$name_file;
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir <br>Le film n'a pas été ajouté");
        }
    
        echo "La bannière a bien été uploadée<br>";


        //Insérer le film
        $filmpush = $bdd->prepare("INSERT INTO Film(nom_film, synopsis, note_film, bande_annonce, affiche_film, image_film, date_sortie, duree_film)
        VALUES (:nom_film,:synopsis,:note_film,:bande_annonce,:affiche_film,:image_film,:date_sortie,:duree_film)");

        $filmpush->execute(array(
        ':nom_film' => $nom,
        ':synopsis' => $synopsis,
        ':note_film' => $note,
        ':bande_annonce' => $trailer,
        ':affiche_film' => $affiche,
        ':image_film' => $banniere,
        ':date_sortie' => $date,
        ':duree_film' => $duree
        ));
        $filmpush-> closeCursor();

        //récupérer id dernier film ajouté
        $filmidgrab = $bdd->prepare(" SELECT id_film FROM Film ORDER BY id_film DESC LIMIT 1 ");
        $filmidgrab->execute();
        $filmidgrab2 = $filmidgrab->fetch();
        $filmidgrab->closeCursor();


        //créer lien genre
        $genrepush = $bdd->prepare("INSERT INTO appartient_a ( id_film, id_genre )
        VALUES (:id_film,:id_genre)");

        $genrepush->execute(array(
        ':id_film' => $filmidgrab2['id_film'],
        ':id_genre' => $genreid
        ));
        $genrepush->closeCursor();

        //créer lien acteur

        for ($i=1; $i < $nbactor+1; $i++){
        $acteurpush = $bdd->prepare("INSERT INTO joue ( id_film, id_acteur )
        VALUES (:id_film,:id_acteur)");
        $l= strval( $i );
        $acteurpush->execute(array(
        ':id_film' => $filmidgrab2['id_film'],
        ':id_acteur' => ${'acteurid'.$l}
        ));
        $acteurpush->closeCursor();
        }
        

        //créer lien réalisateur
        $realpush = $bdd->prepare("INSERT INTO realise ( id_film, id_realisateur )
        VALUES (:id_film,:id_realisateur)");

        $realpush->execute(array(
        ':id_film' => $filmidgrab2['id_film'],
        ':id_realisateur' => $realid
        ));
        $realpush->closeCursor();

        echo "Film ajouté !";
    }
    else{
        echo "Une erreur est survenue !";
    }
    
?>
    <br><a style="color: white;" href="../filmmanager">Retour au gestionnaire des films</a>
    </div>

</body>
</html>