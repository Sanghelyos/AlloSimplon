<?php


include '../include/connectBDD.php';

    $nbactor = !empty($_POST['nbactor']) ? $_POST['nbactor'] : NULL;

    for($i=1; $i< $nbactor+1; $i++){
        $i= strval( $i );
        $acteuradd = "acteur".$i;
        ${'acteurnb'.$i} = !empty($_POST[$acteuradd ]) ? $_POST[$acteuradd] : NULL;
        var_dump(${'acteurnb'.$i});
        var_dump($acteuradd);
        var_dump($i);
    }




    ?>