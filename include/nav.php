<!--TOGGLE MOBILE-->

<div class="menu-wrap">
    <input type="checkbox" class="toggler">
    <div class="hamburger">
        <div></div>
    </div>
    <div class="menu">
        <div>
            <div>
                <ul>
                    <Li><a href="catalogue.php">Films</a></Li>
                    <?php
                        if ($_SESSION['sess'] == NULL){
                            echo '<li><a href="connexion.php">Connexion</a></li>';
                            echo '<Li><a href="register.php">Inscription</a></Li>';
                        }
                        else{
                            echo '<li><a href="dashboard.php">' . $_SESSION['iden'] . '</a></li>';
                            echo '<li><a href="discon.php">Déconnexion</a></li>';
                        }
                        ?>
                    <?php if($searchbar == 1){ ?>
                    <form action="catalogue-search.php">
                        <input type="text" placeholder="Recherche" name="search">
                        <button class="search-button" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <?php } ?> 

                </ul>
            </div>
        </div>
    </div>

</div>


<!--TITRE-->

<div class="title-dada">
    <h1> <a href="index.php"> ALLO SIMPLON</a></h1>
</div>


<!--NAV BAR-->

<div class="nav-dada">
    <div class="logo-dada">
        <h1><a class="lien-home" href="index.php">ALLO SIMPLON</a> </h1>
    </div>
    <div class="menu-nav">
        <?php if($searchbar == 1){ ?>
        <form class="search-bar" action="catalogue-search.php">
            <input type="text" placeholder="Recherche" name="search">
            <button class="search-button" type="submit"><i class="fa fa-search"></i></button>
        </form>
             <?php } ?>     
        <div class="menu-dada">
            <ul>
                <li><a href="catalogue.php">Films</a></li>
                <?php

                if ($_SESSION['sess'] == NULL){
                echo '<li><a href="connexion.php">Connexion</a></li>';
                echo '<Li><a href="register.php">Inscription</a></Li>';
                }
                else{
                    echo '<li><a href="dashboard.php">' . $_SESSION['iden'] . '</a></li>';
                    echo '<li><a href="discon.php">Déconnexion</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<div class="vide"></div>