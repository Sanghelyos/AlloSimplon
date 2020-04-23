<?php


class globalClass{ //fonctions globales
    public function sesscheck() { //vérifier si session active
        if($_SESSION['sess'] == NULL){
            header('Location: connexion.php');
            exit();
        }
    }
    public function checkadmin($bdd) { //vérifier si user est admin
        $typeid=$_SESSION['type'];
        $checkprivilege = $bdd->prepare(" SELECT type_utilisateur FROM typeuser WHERE id_type='$typeid'");
        $checkprivilege->execute();
        $checkprivilege2 = $checkprivilege->fetch();
        return $checkprivilege2['type_utilisateur']; //retourne la valeur du type user
        $checkprivilege->closeCursor();
        }
}

class UserMin { //classe user minimale
    //nos variables
    protected $_username;
    protected $_password;

    // Créer l'object à partir du constructeur
    public function __construct($username, $password) {
        $this->_username = $username;
        $this->_password = $password;

    }



    // Fonction permettant de se connecter
    public function login($bdd) {
        if ($this->_username != NULL || $this->_password != NULL)
        {

        if ($_SESSION['sess'] == NULL)
        {

        $identifiant = $this->_username;
        $mdp = $this->_password;
        $login = $bdd->prepare(" SELECT * FROM utilisateur WHERE identifiant='$identifiant' AND mdp_utilisateur='$mdp'");
        $login->execute();
        $utilisateur = $login->fetch();
        $login->closeCursor();
        if ($utilisateur['identifiant'] == $identifiant && $utilisateur['mdp_utilisateur'] == $mdp && $utilisateur['user_activated'] ==1)
        {
            $_SESSION['sess'] = $utilisateur['id_utilisateur'];
            $_SESSION['iden'] = $utilisateur['identifiant'];
            $_SESSION['date'] = date("d-m-Y",strtotime($utilisateur['date_creation']));
            $_SESSION['type'] = $utilisateur['id_type'];
            header('Location: ../connland.php?err=1');
            exit();
        }
        else if ($utilisateur['identifiant'] == $identifiant && $utilisateur['mdp_utilisateur'] == $mdp && $utilisateur['user_activated'] !=1)
        {
            header('Location: ../connland.php?err=666');
            exit();
        }
        else
        {
            header('Location: ../connexion.php?err=2');
            exit();
        }
        
    }
    else
    {
             header('Location: ../connland.php?err=3');
            exit();
    }
}
else
{
    header('Location: ../connland.php?err=4');
    exit();
}
    }
}
class UserMax extends UserMin { //classe user étendue
    //nos variables
    private $_firstname;
    private $_lastname;
    private $_token;
    private $_activation;
    private $_mail;

    // Créer l'object à partir du constructeur
    public function __construct($identifiant, $password, $_firstname, $_lastname, $_token, $_activation, $_mail) {
        $this->_username = $identifiant;
        $this->_password = $password;
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;
        $this->_token = $_token;
        $this->_activation = $_activation;
        $this->_mail = $_mail;

    }






    // Fonction d'inscription
    public function register($bdd) {
        if ($this->_username != NULL || $this->_password != NULL || $this->_firstname != NULL || $this->_lastname != NULL || $this->_mail != NULL)
        {
        if ($_SESSION['sess'] == NULL)
        {
        $identifiant = $this->_username;
        $mdp = $this->_password;
        
        $checklogin = $bdd->prepare(" SELECT identifiant FROM utilisateur WHERE identifiant='$identifiant'");
        $checklogin->execute();
        $checklogin2 = $checklogin->fetch();
        $checklogin->closeCursor();

        if ($identifiant == $checklogin2['identifiant'])
        {
            header('Location: ../register.php?rerr=1');
            exit();
        }
        else
        {
        $prenom = $this->_firstname;
        $nom = $this->_lastname;
        $token=substr(str_shuffle(str_repeat('0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN', 15)), 0, 15);
        $regpush = $bdd->prepare("INSERT INTO utilisateur (identifiant, nom_utilisateur, prenom_utilisateur, mdp_utilisateur, id_type, user_token, user_activated)
                                VALUES ( :identifiant, :nom_utilisateur, :prenom_utilisateur, :mdp_utilisateur, :id_type, :user_token, :user_activated)");

        $regpush->execute(array(
            ':identifiant' => $identifiant,
            ':nom_utilisateur' => $nom,
            ':prenom_utilisateur' => $prenom,
            ':mdp_utilisateur' => $mdp,
            ':id_type' => 2,
            ':user_token' => $token,
            ':user_activated' => $this->_activation
        ));
        $regpush-> closeCursor();
        $message=
        'Bonjour, '.$prenom.' '.$nom.', 
        veuillez cliquer sur le lien suivant pour activer votre compte : 
        http://pecheux.simplon-charleville.fr/allosimplon/traitement/accountActivation?key='.$token.'&username='.$identifiant;
        mail($this->_mail, "Activation de votre compte : ".$identifiant, $message, "De : Allosimplon");
        header('Location: ../connland.php?rerr=2');
            exit();
        }
    }
    else
    {
        header('Location: ../connland.php?rerr=3');
        exit();
    }

}
else
{
    header('Location: ../connland.php?rerr=4');
    exit();
}
    }

    public function activate($bdd) { //vérifier si user est admin
        $token=$this->_token;
        $identifiant=$this->_username;
        $activate = $bdd->prepare(" UPDATE utilisateur SET user_activated=1 WHERE identifiant='$identifiant' AND user_token='$token'");
        $activate->execute();
        $activate->closeCursor();
        }    

}

class Mail {

    //nos variables
    protected $_to;
    protected $_subject;
    protected $_message;
    protected $_headers;

    // Créer l'object à partir du constructeur
    public function __construct($_to, $_subject, $_message, $_headers) {
        $this->_to = $_to;
        $this->_t_subjecto = $_subject;
        $this->_message = $_message;
        $this->_headers = $_headers;

    }

    public function contactMail(){
        mail($this->_to, $this->_subject, $this->_message, $this->_headers);
        echo 'Votre mail a bien été envoyé.<br><a style="color:white;" href="../index.php">Cliquez ici pour retourner à l\'accueil</a>';
    }




}

?>