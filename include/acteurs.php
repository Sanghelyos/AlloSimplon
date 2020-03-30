<!--Liste acteurs-->

<div class="acteurs-titre">Acteurs</div>
<section class="liste-acteurs">
<?php

    $joue = $bdd->prepare(" SELECT id_acteur FROM joue WHERE id_film=". $film_id);
    $joue->execute();


while($acteursjoue = $joue->fetch()){
    $acteurs = $bdd->prepare(" SELECT id_acteur,nom_acteur,image_acteur FROM acteur WHERE id_acteur=" . $acteursjoue['id_acteur']);
    $acteurs->execute();
        while( $acteursfilm = $acteurs->fetch() ) {

?>
    <div class="acteur">
        <img class="img-acteur" src="./img/acteurs/<?= $acteursfilm['image_acteur'] ?>" alt="">
        <div><?= $acteursfilm['nom_acteur'] ?></div>
    </div>
<?php
        }
}
$joue-> closeCursor();
$acteurs-> closeCursor();
?>

</section>
