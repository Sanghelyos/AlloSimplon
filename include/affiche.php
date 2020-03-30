 <!--AFFICHE-->

 <div class="title-dada-affiche">
    <h2>A l'affiche</h2>
</div>

<div class="center slider">
<?php
$filmlist = $bdd->prepare(" SELECT id_film,affiche_film FROM Film");
$filmlist->execute();

while( $affichesslider = $filmlist->fetch() ) { 
?>
    <a class="link-poster" href="film.php?film=<?= $affichesslider['id_film']; ?>"><img src="img/affiches/<?= $affichesslider['affiche_film']; ?>" alt=""></a> 
<?php
}
$filmlist-> closeCursor();
?>
 </div>