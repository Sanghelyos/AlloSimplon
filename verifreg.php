
<?php
session_start();
header('Content-type: text/html; charset=utf-8');
include 'include/connectBDD.php';
require_once 'styleswitcher.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

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




</head>

<body>

<?php include 'include/nav.php'; ?>


  <!-- zone de connexion -->

    <div id="container">
    <?php
$identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : NULL;
$nom = !empty($_POST['nom']) ? $_POST['nom'] : NULL;
$prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : NULL;
$mdp = !empty($_POST['password']) ? $_POST['password'] : NULL;
$mdp = md5($mdp);
if ($identifiant != NULL || $mdp != NULL || $prenom != NULL || $nom != NULL)
{
    if ($_SESSION['sess'] == NULL)
    {

        $regver = $bdd->prepare(" SELECT identifiant FROM utilisateur WHERE identifiant='$identifiant'");
        $regver->execute();
        $regver2 = $regver->fetch();
        $regver->closeCursor();

        if ($identifiant == $regver2['identifiant'])
        {
            echo "Cet identifiant est déjà utilisé.";
        }
        else
        {
            $regpush = $bdd->prepare("INSERT INTO utilisateur (identifiant, nom_utilisateur, prenom_utilisateur, mdp_utilisateur, id_type)
                                    VALUES ( :identifiant, :nom_utilisateur, :prenom_utilisateur, :mdp_utilisateur, :id_type)");

            $regpush->execute(array(
                ':identifiant' => $identifiant,
                ':nom_utilisateur' => $nom,
                ':prenom_utilisateur' => $prenom,
                ':mdp_utilisateur' => $mdp,
                ':id_type' => 2
            ));
            $regpush-> closeCursor();
            echo "Merci pour votre inscription !<br>";
            echo "Vous pouvez vous connecter";
        }
    }
    else
    {
        echo "Vous êtes déjà connecté";
    }

}
else
{
    echo "Une erreur est survenue.";
}
?>       
    </div>


<?php include 'include/footer.php'; ?>

</body>
</html>