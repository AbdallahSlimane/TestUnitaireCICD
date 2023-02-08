<?php
require("ToDoList.php");

class User
{
    // déclaration d'une propriété
    protected string $_nom;
    protected string $_dateDeNaissance;
    protected ?string $_email = null;
    protected string $_age;
    protected string $_motDePasse;
    private ToDoList $_toDoList;

    /**
     * @throws Exception
     */

    function __construct($_dateDeNaissance, $_nom = "", $_email = "", $_motDePasse = "", $_age = 0) {
        //verif date    
        $dt = DateTime::createFromFormat('Y-m-d',$_dateDeNaissance);
        if(!$dt){
            throw new exception("format de la date invalide");
        }
        $this->_dateDeNaissance = $_dateDeNaissance;

        $this->_nom = $_nom;

        //utiliser expression regulière pour email.
        if(!filter_var($_email,FILTER_VALIDATE_EMAIL)){
            throw new exception("format de l\'email invalide");
        }
        $this->_email = $_email;
        // verif mot de passe
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,40}$/", $_motDePasse)) {
            throw new exception("format du mot de passe invalide");
        }
        // Vérifier l'âge de l'utilisateur
        if ($_age < 13) {
            throw new exception("Vous êtes trop jeune.");
        }
        if($_age > 120){
            throw new exception("Vous êtes trop vieu.");
        }
        $_toDoList = new ToDoList();
    }

    public function __get($_nom) {
        //echo "Get:$nom"; //DEBUG
        return $this->$_nom;    //récupère la variable $name si elle est protected ou private
    }

    public function __set($_nom, $value) {
        $this->$_nom = $value;
    }
}

?>


hello world.