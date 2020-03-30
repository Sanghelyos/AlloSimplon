 <!--REAL BA-->

 <div class="real-real">Réalisateur</div>

<div class="real-ba">


    

    <div class="real">
<?php
    $realise = $bdd->prepare(" SELECT id_realisateur FROM realise WHERE id_film=". $film_id);
    $realise->execute();


while($realrealise = $realise->fetch()){
    $realisateur = $bdd->prepare(" SELECT * FROM realisateur WHERE id_realisateur=" . $realrealise['id_realisateur']);
    $realisateur->execute();
        while( $realisateurfilm = $realisateur->fetch() ) {

?>
        <div class="img-real">
            <img src="./img/real/<?= $realisateurfilm['image_realisateur'] ?>" alt="">
            <div><?= $realisateurfilm['nom_realisateur'] ?></div>
        </div>
        <div class="text-real">
        <?= $realisateurfilm['desc_realisateur'] ?>
        </div>
    </div>
<?php
        }
    }
?>

    <div class="ba-yt">
        <iframe width="400" height="250" src="https://www.youtube.com/embed/<?= $donnees['bande_annonce'] ?>" frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
    </div>

</div>
