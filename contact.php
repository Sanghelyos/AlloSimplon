<?php
session_start();
header('Content-type: text/html; charset=utf-8');
include 'include/connectBDD.php';
require_once 'styleswitcher.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi de mail</title>

    <link rel="stylesheet" href="css/reset.css">
    
    <link rel="stylesheet" media="screen, projection" type="text/css" id="css" href="<?php echo $url; ?>" />

    <!--GOOGLE FONTS-->

    <link
        href="https://fonts.googleapis.com/css?family=Baloo+Tammudu+2:400,500,600,700,800|Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Rubik:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Asap:400,400i,500,500i,600,600i,700,700i|Bellota+Text:300,300i,400,400i,700,700i&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:700,800,900|Quicksand:300,400,500,600,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
   textarea{
    border: 5px solid #FF7200;
    background-color: black;
    color:white;
    font-family: 'Ubuntu', Arial, Helvetica, sans-serif;
}
</style>


</head>

<body>

<?php 
include 'include/nav.php'; ?>


  <!-- zone de connexion -->

    <div id="container">
      
    <h2>Nous contacter</h2>
        <form id="sendmsg" enctype="multipart/form-data" action="traitement/sendmail.php" method="POST">
            <label>Votre adresse mail :</label><br>
            <input class="login" type="text" placeholder="exemple@mail.com" name="mail" tabindex="1" required> <br>
            <label>Votre numéro de téléphone :</label><br>
            <input class="login"  type="text" placeholder="Numéro" name="tel" tabindex="2" required></input><br>
            <label>Objet :</label><br>
            <input class="login" type="text" placeholder="Objet" name="obj" tabindex="3" required> <br>
            <label>Message :</label><br>
            <textarea style="width: 100%;" class="login"  type="text" placeholder="Message" name="msg" tabindex="4" required></textarea><br>
            <input class="ok"type="submit" name="sendmsg" id='submit' value='ENVOYER'> <br>
        </form>
    </div>


<?php 
include 'include/footer.php'; ?>

</body>
</html>