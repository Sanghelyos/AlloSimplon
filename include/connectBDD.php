<?php
try   {
  $user = "dbu526595";
  $pass = "Gb29;.Je";
  // Je me connecte à ma bdd
  $bdd = new PDO('mysql:host=db5000303648.hosting-data.io;dbname=dbs296635;charset=utf8', $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  return $bdd;
}catch(Exception $e)
{
  // En cas d'erreur, un message s'affiche et tout s'arrête
        die('Erreur : '.$e->getMessage());
}


?>
