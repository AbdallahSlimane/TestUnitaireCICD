<?php

use PHPUnit\Framework\TestCase;

/**
 * @method assertSame(string $string, mixed|string $_nom)
 * @method expectException(User $monUtilisateur)
 */

require("../class/User.php");

class TestUserClassTest extends TestCase
{
    public function testUtilisateurAvecTout()
    {
        $monUtilisateur = new User("2008-08-16", "Robin", "rothomas@waytolearnx.com", "Esgi2022AL2", 14);
        $this->assertNotEquals(null,$monUtilisateur);
    }
    //création d'une ToDoList pour cet utilisateur

    public function testUtilisateurMauvaisDateDeNaissance(){
        $this->expectException(exception::class);
        $this->expectExceptionMessage("format de la date invalide");
        $monUtilisateur = new User("2154.58.74", "Robin", "rothomas@waytolearnx.com", "Esgi2022AL2", 13);
    }

    public function testUtilisateurSansDateDeNaissance(){
        $this->expectException(exception::class);
        $this->expectExceptionMessage("format de la date invalide");
        $monUtilisateur = new User("", "Robin", "rothomas@waytolearnx.com", "Esgi2022AL2", 13);
    }

    public function testUtilisateurSansEmail(){
        $this->expectException(exception::class);
        $this->expectExceptionMessage("format de l\'email invalide");
        $monUtilisateur = new User("2008-08-16", "Robin", "", "Esgi2022AL2", 13);
    }

    public function testUtilisateurAvecMauvaisMotDePasse(){
        $this->expectException(exception::class);
        $this->expectExceptionMessage("format du mot de passe invalide");
        $monUtilisateur = new User("2008-08-16", "Robin", "rothomas@waytolearnx.com", "", 13);
    }

    public function testUtilisateurAvecMauvaisAge(){
        $this->expectException(exception::class);
        $this->expectExceptionMessage("Vous êtes trop jeune.");
        $monUtilisateur = new User("2008-08-16", "Robin", "robin.esgi@gmail.com", "Esgi2022AL2", 12);
    }

    public function testUtilisateurAvecAgeNegatif(){
        $this->expectException(exception::class);
        $this->expectExceptionMessage("Vous êtes trop jeune.");
        $monUtilisateur = new User("2008-08-16", "Robin", "robin.esgi@gmail.com", "Esgi2022AL2", -42);
    }
    public function testUtilisateurAvecAgeTropGrand(){
        $this->expectException(exception::class);
        $this->expectExceptionMessage("Vous êtes trop vieu.");
        $monUtilisateur = new User("2008-08-16", "Robin", "robin.esgi@gmail.com", "Esgi2022AL2", 10000);
    }
}
