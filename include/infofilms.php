<!--INFO FILM-->


<div class="rond-titre">Infos</div>

<h3 class="info-film"></h3>

<div class="ronds-info">

    <div class="ronds-bis">
        <div class="ronds-ronds">
            <?= date('H:i', strtotime($donnees['duree_film'])); ?>
        </div>
        Durée
    </div>


    <div class="ronds-bis">
        <div class="ronds-ronds">
        <?= $donnees['note_film'] ?>/5
        </div>
        Note
    </div>


    <div class="ronds-bis">
        <div class="ronds-ronds">
        <?= date('d-m-Y', strtotime($donnees['date_sortie'])); ?>
        </div>
        Date de sortie
    </div>


</div>
