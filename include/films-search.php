<!--CATALOGUE FILMS-->
        
<div class="axeldroite">
<?php
if(isset($_GET['search']) AND !empty ($_GET['search'])){
    $search=htmlspecialchars($_GET['search']);
    $research=$bdd->prepare('SELECT f.id_film, f.nom_film, f.note_film, f.duree_film, f.affiche_film, appartient_a.id_genre, Genre.nom_genre
                            FROM Film f
                            INNER JOIN appartient_a ON f.id_film = appartient_a.id_film
                            INNER JOIN Genre ON appartient_a.id_genre = Genre.id_genre
                            WHERE f.nom_film
                            LIKE "%'.$search.'%"');
    $research->execute();
    if($research->rowCount()>0){

        while($donnees=$research->fetch()){


?>          
            <a href="film.php?film=<?= $donnees['id_film']; ?>" class="versfilm">
            <div class="cardaxel">
            <img class="poster-img" src="./img/affiches/<?= $donnees['affiche_film']; ?>" alt="">
                <div class="titrefilm"><?= $donnees['nom_film']; ?></div>
                <div class="infoaxel">
                    <div class="textaxel">
                       <p><?= $donnees['note_film']; ?></p>
                       <p>|</p>
                       <p><?= date('H:i', strtotime($donnees['duree_film'])); ?></p>
                       <p>|</p>
                       <p><?= $donnees['nom_genre']; ?></p>    
                    </div>
                </div>
            </div>
</a>

<?php
        }
    }
    else{
        echo '<br><h2 style="color:white;">Aucun résultat</h2>';
    }

}

?>

        </div>
    </div>