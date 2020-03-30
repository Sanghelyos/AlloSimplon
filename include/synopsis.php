


<h2 class="page-film"><?= $donnees['nom_film']; ?></h2>

    <!--SYNOPSIS-->

    <div class="img-resume">
        <img class="img-film" src="./img/film_img/<?= $donnees['image_film']; ?>" alt="">
        
        <div class="synop">
                <p class="synop-title">Synopsis</p>
                <?= $donnees['synopsis']; ?><?php echo $_SESSION['sess']; ?>
        </div>
    </div>
