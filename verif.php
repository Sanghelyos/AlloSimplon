<?php
include 'include/connectBDD.php';

$identifiant = $_POST['identifiant'];
$mdp = $_POST['password'];

$login = $bdd->prepare(" SELECT * FROM utilisateur WHERE identifiant='$identifiant' AND mdp_utilisateur='$mdp'");
$login->execute();
$utilisateur = $login->fetch();

if($utilisateur['identifiant']==$identifiant && $utilisateur['mdp_utilisateur']==$mdp){
echo $utilisateur['identifiant'];
echo "<br>";
echo "date de création : " . $utilisateur['date_creation'];
session_start();
$_SESSION['identifiant'] = "bite";
header('Location: http://pecheux.simplon-charleville.fr/allosimplon/index.php');
}
else{
    echo "Identifiant ou mot de passe incorrect.";
}




?>