<?php
try{
$connexion = new database('db5000303648.hosting-data.io','dbs296635','dbu526595', 'Gb29;.Je');
$bdd = $connexion->PDOConnexion();
}
catch(Exception $e)
{
    // En cas d'erreur, un message s'affiche et tout s'arrête
          die('Erreur : '.$e->getMessage());
}
?>
