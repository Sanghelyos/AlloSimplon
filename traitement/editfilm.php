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
    $idfilm = !empty($_POST['idfilm']) ? $_POST['idfilm'] : NULL;
    $filmdatamerde = $bdd->prepare(" SELECT * FROM Film WHERE id_film = $idfilm");
    $filmdatamerde->execute();
    $filmdatamerde2 = $filmdatamerde->fetch();
    $filmdatamerde->closeCursor();

    $nom = !empty($_POST['nom']) ? $_POST['nom'] : $filmdatamerde2['nom_film'];
    $note = !empty($_POST['note']) ? $_POST['note'] : $filmdatamerde2['note_film'];
    $date = !empty($_POST['releasedate']) ? $_POST['releasedate'] : $filmdatamerde2['date_sortie'];
    $date = date('Y-m-d', strtotime($date));
    $duree = !empty($_POST['duree']) ? $_POST['duree'] : $filmdatamerde2['duree_film'];
    $trailer = !empty($_POST['trailer']) ? $_POST['trailer'] : $filmdatamerde2['bande_annonce'];
    $trailer = substr($trailer, -11);
    $synopsis = !empty($_POST['synopsis']) ? $_POST['synopsis'] : $filmdatamerde2['synopsis'];
    $genreid = !empty($_POST['genre']) ? $_POST['genre'] : NULL;
    $affiche = $filmdatamerde2['affiche_film'];
    $banniere = $filmdatamerde2['image_film'];
    $affichecheck = !empty($_FILES['affiche']) ? $_FILES['affiche'] : NULL;
    $bannierecheck = !empty($_FILES['banniere']) ? $_FILES['banniere'] : NULL;

    $nbactorreq = $bdd->prepare(" SELECT id_acteur FROM joue WHERE id_film = $idfilm");
    $nbactorreq->execute();
    $nbactor = $nbactorreq->rowCount();
    $nbactorreq->closeCursor();

    for($i=1; $i< $nbactor+1; $i++){
        $l= strval( $i );
        $acteuredit = "acteur".$l;
        ${'acteurid'.$l} = !empty($_POST[$acteuredit ]) ? $_POST[$acteuredit] : NULL;
    }

    $realid = !empty($_POST['real']) ? $_POST['real'] : NULL;


    if($genreid != NULL && $realid != NULL)
    {   


        if($affichecheck['name'] != ""){
        //téléchager image
        $content_dir = '../img/affiches/'; // dossier où sera déplacé le fichier
    
        $tmp_file = $_FILES['affiche']['tmp_name'];
    
        if( !is_uploaded_file($tmp_file) )
        {
            exit("L'affiche est introuvable<br>Le film n'a pas été modifié");
        }
    
        // on vérifie maintenant l'extension
        $type_file = $_FILES['affiche']['type'];
    
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
        {
            exit("L'affiche n'est pas une image<br>Le film n'a pas été modifié");
        }
    
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['affiche']['name'];
        $affiche=$name_file;
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir");
        }
    
        echo "L'affiche a bien été uploadée<br>";
    }


    if($bannierecheck['name'] != ""){
        $content_dir = '../img/film_img/'; // dossier où sera déplacé le fichier
    
        $tmp_file = $_FILES['banniere']['tmp_name'];
    
        if( !is_uploaded_file($tmp_file) )
        {
            exit("La bannière est introuvable<br>Le film n'a pas été modifié");
        }
    
        // on vérifie maintenant l'extension
        $type_file = $_FILES['banniere']['type'];
    
        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
        {
            exit("La bannière n'est pas une image<br>Le film n'a pas été modifié");
        }
    
        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['banniere']['name'];
        $banniere=$name_file;
        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir <br>Le film n'a pas été modifié");
        }
    
        echo "La bannière a bien été uploadée<br>";
    }


        //Insérer le film
        $filmpush = $bdd->prepare("UPDATE Film SET nom_film = ?, synopsis = ?, note_film = ?, bande_annonce = ?, affiche_film = ?, image_film = ?, date_sortie = ?, duree_film = ?
        WHERE id_film = '$idfilm'");

        $filmpush->execute(array(
        $nom,
        $synopsis,
        $note,
        $trailer,
        $affiche,
        $banniere,
        $date,
        $duree
        ));
        $filmpush-> closeCursor();

        //récupérer id dernier film ajouté
        $filmidgrab = $bdd->prepare(" SELECT id_film FROM Film ORDER BY id_film DESC LIMIT 1 ");
        $filmidgrab->execute();
        $filmidgrab2 = $filmidgrab->fetch();
        $filmidgrab->closeCursor();


        //créer lien genre
        $genrepush = $bdd->prepare("UPDATE appartient_a SET id_genre = ?
        WHERE id_film = $idfilm");

        $genrepush->execute(array($genreid));
        $genrepush->closeCursor();

        

        //supprimer lien des acteurs
        $deleteactor = $bdd->prepare(" DELETE FROM joue WHERE id_film='$idfilm'");
        $deleteactor->execute();
        $deleteactor->closeCursor();

        //créer lien acteur
        for ($i=1; $i < $nbactor+1; $i++){
            $acteurpush = $bdd->prepare("INSERT INTO joue ( id_film, id_acteur )
            VALUES (:id_film,:id_acteur)");
            $l= strval( $i );
            $acteurpush->execute(array(
            ':id_film' => $idfilm,
            ':id_acteur' => ${'acteurid'.$l}
            ));
            $acteurpush->closeCursor();
            }

        $realedit = $bdd->prepare("UPDATE realise SET id_film = ?, id_realisateur = ? WHERE id_film = $idfilm");
        $realedit->execute(array(
        $idfilm,
        $realid
        ));
        $realedit->closeCursor();

        echo "Film modifié !";
    }
    else{
        echo "Une erreur est survenue !";
    }
    
?>
    <br><a style="color: white;" href="../filmmanager.php">Retour au gestionnaire des films</a>
    </div>

</body>
</html>