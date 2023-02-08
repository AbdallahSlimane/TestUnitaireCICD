<?php

use PHPUnit\Framework\TestCase;

require("../class/ToDoList.php");

class ToDoListTest extends TestCase
{
    public function testInitDeLObjet(){
        $maList = new ToDoList();
        $this->assertEquals(true,getType($maList) != "null");
    }

    public function testListeModifieUneFoisAvecTout()
    {
        $maList = new ToDoList();
        //$maList->_list['exemple'] = 'here some text';
        $maList->overwriteMessage('exemple', 'here some text');
        $this->assertNotEquals(null,$maList);
    }

    public function testListeChangeTropViteAvecTout()
    {
        $maList = new ToDoList();
        $maList->overwriteMessage('exemple', 'here some text');
        $this->expectException(exception::class);
        $this->expectExceptionMessage("erreur : il faut attendre encore moins de 30 min pour faire des modifs.");
        $maList->overwriteMessage('autreExemple','et  bhe voila C casse');
    }

    public function testAjoutDUn11emeElement()
    {
        $maList = new ToDoList();
        $toDoListArray = array();
        for ($i = 0; $i <= 9; $i++) {
            $toDoListArray['item'.$i] = 'content '.$i;
        }
        $maList->ChangerListeEntiere($toDoListArray);
        $this->expectException(exception::class);
        $this->expectExceptionMessage("erreur : la limite du nb chose a faire a ete atteinte");
        $maList->overwriteMessage('autreExemple','Et bhe C bien Nils');
    }

    public function testAjoutDUn10emeElement()
    {
        $maList = new ToDoList();
        $toDoListArray = array();
        for ($i = 0; $i < 9; $i++) {
            $toDoListArray['item'.$i] = 'content '.$i;
        }
        $maList->ChangerListeEntiere($toDoListArray);
        $maList->overwriteMessage('autreExemple','Et bhe C bien Nils');
        $this->assertEquals(10,count($maList->_list));
    }

    public function testChangerListTropLongue()
    {
        $maList = new ToDoList();
        $toDoListArray = array();
        for ($i = 0; $i <= 11; $i++) {
            $toDoListArray['item'.$i] = 'content '.$i;
        }
        $this->expectException(exception::class);
        $this->expectExceptionMessage("La nouvelle toDoList possède trop de case (>10 id) veuillez la retravailler");
        $maList->ChangerListeEntiere($toDoListArray);
    }

    public function testChangerListTropAvecUneDescriptionTropLongue()
    {
        $maList = new ToDoList();
        $toDoListArray = array();
        $str = "";
        for ($i = 0; $i <= 1000; $i++) {
            $str = $str.'1';
        }
        for ($i = 0; $i < 9; $i++) {
            $toDoListArray['item'.$i] = 'content '.$i;
        }
        $toDoListArray['exemple'] = $str;
        $this->expectException(exception::class);
        $this->expectExceptionMessage("La nouvelle toDoList a un message trop grand (>1000 char veuillez verifier le texte de vos todo");
        $maList->ChangerListeEntiere($toDoListArray);
    }

    public function testNouveauStrTropGrand(){
        $maList = new ToDoList();
        $str = "";
        for ($i = 0; $i <= 1000; $i++) {
            $str = $str.'1';
        }
        $this->expectException(exception::class);
        $this->expectExceptionMessage("The new message is greater than 1000 characters");
        $maList->overwriteMessage('tropLongue',$str);
    }

    public function testAjouterUn8emeElement(){
        $maList = new ToDoList();
        $toDoListArray = array();
        for ($i = 0; $i < 7; $i++) {
            $toDoListArray['item'.$i] = 'content '.$i;
        }

        $maList->ChangerListeEntiere($toDoListArray);
        $mailCorrect = $this->createMock(EmailSenderService::class);
        $mailCorrect->expects ($this->once())
                    ->method('sendEmail')
                    ->willReturn(null); //dans ce cas email correct


        //lier l'element mocker a $maList
        $maList->_serviceMail = $mailCorrect;
        $maList->overwriteMessage("exemple","here some text");
        //puis normalement pas d'exception
        $this->assertEquals(8, count($maList->_list));
    }
}
