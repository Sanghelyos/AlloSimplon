<!--CATALOGUE FILMS-->
        
<div class="axeldroite">
<?php

$filmlist = $bdd->prepare(" SELECT id_film,nom_film,note_film,duree_film,affiche_film FROM Film");
$filmlist->execute();

while( $donnees = $filmlist->fetch() ) {
    $appartient = $bdd->prepare(" SELECT id_genre FROM appartient_a WHERE id_film=" . $donnees['id_film']);
    $appartient->execute();
    $templink = $appartient->fetch();
    $appartient-> closeCursor();
    $genre = $bdd->prepare(" SELECT nom_genre FROM Genre WHERE id_genre=" . $templink['id_genre']);
    $genre->execute();
    $donnees2 = $genre->fetch();
    $genre-> closeCursor();

    $id_film=$donnees['id_film'];
    $id_user=$_SESSION['sess'];
    
?>
            
            <a href="film.php?film=<?= $donnees['id_film']; ?>" class="versfilm">
            <div class="cardaxel">
            <img class="poster-img" src="./img/affiches/<?= $donnees['affiche_film']; ?>" alt="">

            <?php
                if($_SESSION['sess'] != NULL){
                    $favcheck = $bdd->prepare("SELECT id_film FROM favoris
                                                WHERE id_film=$id_film
                                                AND id_utilisateur=$id_user");
                    $favcheck->execute();
                    $favcheck2 = $favcheck->fetch();
                    $favcheck->closeCursor();
                    if(isset($favcheck2['id_film'])){
                        ?>
                        <div style="position:absolute; left: 3%; top: 3%; font-size: 100%; color: gold;"><i class="fa fa-star"></i></div>
                        <?php
                    }
                }
            ?>
                <div class="titrefilm"><?= $donnees['nom_film']; ?></div>
                <div class="infoaxel">
                    <div class="textaxel">
                       <p><?= $donnees['note_film']; ?></p>
                       <p>|</p>
                       <p><?= date('H:i', strtotime($donnees['duree_film'])); ?></p>
                       <p>|</p>
                       <p><?= $donnees2['nom_genre']; ?></p>
                    </div>
                </div>
            </div>
</a>
            
            
<?php
}
$filmlist-> closeCursor();
?>


        </div>


    </div>