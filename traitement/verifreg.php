<?php
session_start();
header('Content-type: text/html; charset=utf-8');
include '../include/connectBDD.php';
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
            header('Location: ../register.php?rerr=1');
            exit();
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
            header('Location: ../connland.php?rerr=2');
            exit();
        }
    }
    else
    {
        header('Location: ../connland.php?rerr=3');
        exit();
    }

}
else
{
    header('Location: ../connland.php?rerr=4');
    exit();
}
?>