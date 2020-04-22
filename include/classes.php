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
        if ($utilisateur['identifiant'] == $identifiant && $utilisateur['mdp_utilisateur'] == $mdp)
        {
            $_SESSION['sess'] = $utilisateur['id_utilisateur'];
            $_SESSION['iden'] = $utilisateur['identifiant'];
            $_SESSION['date'] = date("d-m-Y",strtotime($utilisateur['date_creation']));
            $_SESSION['type'] = $utilisateur['id_type'];
            header('Location: ../connland.php?err=1');
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

    // Créer l'object à partir du constructeur
    public function __construct($identifiant, $password, $_firstname, $_lastname) {
        $this->_username = $identifiant;
        $this->_password = $password;
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;

    }

    // Fonction d'inscription
    public function register($bdd) {
        if ($this->_username != NULL || $this->_password != NULL || $this->_firstname != NULL || $this->_lastname != NULL)
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
        $regpush = $bdd->prepare("INSERT INTO utilisateur (identifiant, nom_utilisateur, prenom_utilisateur, mdp_utilisateur, id_type)
                                VALUES ( :identifiant, :nom_utilisateur, :prenom_utilisateur, :mdp_utilisateur, :id_type)");

        $regpush->execute(array(
            ':identifiant' => $identifiant,
            ':nom_utilisateur' => $nom,
            ':prenom_utilisateur' => $prenom,
            ':mdp_utilisateur' => $mdp,
            ':id_type' => 2
        ));
        $regpush-> closeCursor();
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

}

?>