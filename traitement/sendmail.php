<?php session_start();
header('Content-type: text/html; charset=utf-8');
require_once '../styleswitcher.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi de mail</title>

    <link rel="stylesheet" href="../css/reset.css">
    
    <link rel="stylesheet" media="screen, projection" type="text/css" id="css" href="../<?php echo $url; ?>" />

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




</head>

<body>


  <!-- zone de connexion -->

    <div id="container">
<?php
 
    ini_set( 'display_errors', 1 );
 
    error_reporting( E_ALL );
 
    
    $from = $_POST['mail'];

    $tel = $_POST['tel'];
 
    $to = 'pecheux@simplon-charleville.fr';
    
    $subject = $_POST['obj'];
 
    $message = $_POST['mail'] . "<br>". $_POST['mail'] . "<br>" . $_POST['msg'];
 
    $headers = "De:" . $_POST['mail'];
 
    mail($to, $subject, $message, $headers);
    echo 'Votre mail a bien été envoyé.<br><a style="color:white;" href="../index.php">Cliquez ici pour retourner à l\'accueil</a>';
?>
</div>
</body>
</html>