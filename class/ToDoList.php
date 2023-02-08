<?php

require("EmailSenderService.php");

class ToDoList
{
    protected int $_countItem;
    protected $_list;
    //_list[name] = message
    protected $_DernierTemps;
    protected EmailSenderService $_serviceMail;

    function __construct(){
        $this->_countItem = 0;
        $this->_DernierTemps = time() - 1801;   //pour laisser a l'utilisateur le loisir de modifier sa liste dés la création de sa todoList
        $this->_list = array();
    }
    /**
     * @throws exception
     */

    private function Verification($nom,$phraseMessage){ //si la verification passe alors modif sinon exception
        if(strlen($phraseMessage)> 1000){
            throw new exception("The new message is greater than 1000 characters");
        }

        //taille de _list < 10 & list[nom] n'existe pas sinon passer
        if(!array_key_exists($nom, $this->_list)) {
            if(count($this->_list) >= 10 ){
                throw new exception("erreur : la limite du nb chose a faire a ete atteinte");
            }
            if($this->_DernierTemps >= time() - 1800){   //dans ce cas la on modifie trop tot sa todoList
                throw new exception("erreur : il faut attendre encore moins de 30 min pour faire des modifs.");
            }
            $this->_countItem++;
            if($this->_countItem == 8){ //envoyer un email (directive du sujet)
                $this->_serviceMail->sendEmail();
            }
        }
        $this->_DernierTemps = time();
        $this->_list[$nom] = $phraseMessage;
    }

    public function overwriteMessage($nom, $phraseMessage)
    {
        return $this->Verification($nom,$phraseMessage);
    }
    public function cMessage($nom, $phraseMessage){

        //verifier la taille du message
        $phraseMessage =  $this->_list[$nom] + $phraseMessage;
        return $this->verification($nom,$phraseMessage);
    }

    public function DestroyItem($name){
        if(key_exists($name, $this->_list)){
            unset($this->_list[$name]);
            $this->_countItem--;
        }
    }
    /**
     * @throws exception
     */
    public function ChangerListeEntiere($nouvelArray){
        $validList = count($nouvelArray) <= 10;
        if($validList){
            foreach ($nouvelArray as $id => $choseAFaire){
                $validList = ($validList and (strlen($choseAFaire) <= 1000));
            }
            if($validList){                             //dans ce cas la la nouvelle liste respecte les prérequis pour remplacer la derniere liste
                $this->_list = $nouvelArray;
                $this->_countItem = count($nouvelArray);
            }
            else{
                throw new exception("La nouvelle toDoList a un message trop grand (>1000 char veuillez verifier le texte de vos todo");
            }
        }
        else{
            throw new exception("La nouvelle toDoList possède trop de case (>10 id) veuillez la retravailler");
        }
    }

    //TOVERIFY
    public function __get($nom) {
        //echo "Get:$name"; //DEBUG
        return $this->$nom;    //récupère la variable $nom si elle est protected ou private
    }


    /**
     * @throws exception
     */
    public function __set($nom, $valeur) { //TODO

        if($nom === '_serviceMail'){
            $this->$nom = $valeur;
        }
    }
        /*if(preg_match("\_list\[.*\]",$nom)) {
            return $this->overwriteMessage($nom, $valeur);
        }
        else if($nom ==='_list'){
            $validList = count($valeur) <= 10;
            if($validList){
                foreach ($valeur as $id => $choseAFaire){
                    $validList = $validList and (strlen($choseAFaire) < 1000);
                }
                if($validList){                             //dans ce cas la la nouvelle liste respecte les prérequis pour remplacer la derniere liste
                    $this->_list = $valeur;
                    $this->_countItem = count($valeur);
                    return;                                 //on ne veux pas renvoyer d'exception après un remplacement réussit
                }
            }
            //si un prérequis manque il faut informer l'utilisateur que son opération a échoué.
            throw new exception("erreur : la nouvelle list donnee ne respecte pas les condition pour remplacer l\'ancienne.");

        }
        else if($nom === '_countItem' or $nom === '_DernierTemps'){ //on ne veux pas modifier directement ces 2 attributs
            throw new exception("erreur : countItem et dernierTemps ne doivent en aucun cas etre modifie par les utilisateurs");
        }
        else{
            $this->$nom = $valeur;
        }
    }*/
}


/*    private function MessageCorrect($nom, $phraseMessage): bool
    {
        //verif si $phraseMessage < 1000 char
        if($phraseMessage > 1000){
            throw new Exception("Le message est supérieur à 1000 caractère");
        }

        //verif si $nom existe
        if($this->_countItem < 10 && $this->AjouterToDoList()){
            $this->_list[$nom] = $phraseMessage;
            $this->_countItem++;
            $this->_DernierTemps = time();
        }
        return true;
    }

    public function AjouterToDoList(): bool
    {
        if (!isset($this->_DernierTemps)){
            return true;
        }
        $currentTime = time();
        return  ($currentTime - $this->_DernierTemps) >= 1800 ;
    }*/