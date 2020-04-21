<?php

class UserLogin {
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
        $identifiant = $this->_username;
        $mdp = $this->_password;
        $login = $bdd->prepare(" SELECT * FROM utilisateur WHERE identifiant='$identifiant' AND mdp_utilisateur='$mdp'");
        $login->execute();
        return $login->fetch();
        $login->closeCursor();
    }
}
class UserRegister extends UserLogin {
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

    // Fonction permettant de vérifier l'existence d'un identifiant
    public function checkidentifiant($bdd) {
        $identifiant = $this->_username;
        $mdp = $this->_password;
        $checklogin = $bdd->prepare(" SELECT identifiant FROM utilisateur WHERE identifiant='$identifiant'");
        $checklogin->execute();
        return $checklogin->fetch();
        $checklogin->closeCursor();
    }
        // Fonction permettant de s'inscrire
        public function register($bdd) {
            $identifiant = $this->_username;
            $mdp = $this->_password;
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
        }
}

?>