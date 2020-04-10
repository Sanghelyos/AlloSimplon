

<style>
    .fav-star:hover{
    filter: brightness(75%);}
</style>
<h2 class="page-film"><?= $donnees['nom_film']; ?></h2>
<div style="text-align:center; margin-bottom:1em;margin-top:-2em;">
<a style="font-size: 100%;" class="page-film fav-star" 
<?php
$id_film = $donnees['id_film'];
$id_user = $_SESSION['sess'];

$fav=$bdd->prepare("SELECT * FROM favoris WHERE id_utilisateur = $id_user AND id_film = $id_film");
$fav->execute();
$fav2=$fav->fetch();
$fav->closeCursor();


if(!empty($fav2)){
    echo'href="traitement/delete_fav.php?id='.$id_film.'">Retirer des favoris <i style="color:gold;" class="fa fa-star">';
}
else{
    echo'href="traitement/addfav.php?id='.$id_film.'">Ajouter aux favoris <i style="color:white;" class="fa fa-star">';
}

?>
</i></a>
</div>
    <!--SYNOPSIS-->

    <div class="img-resume">
        <img class="img-film" src="./img/film_img/<?= $donnees['image_film']; ?>" alt="">
        
        <div class="synop">
                <p class="synop-title">Synopsis</p>
                <?= $donnees['synopsis']; ?>
        </div>
    </div>
