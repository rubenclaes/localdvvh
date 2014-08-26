<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dirigent
 *
 * @author Ruben
 */
class dirigent {
    private $sql;
    private $dbh;
    private $tekst;
    private $afbeelding;
    
    public function __construct($dbh, $tekst, $afbeelding) {
           $this->dbh = $dbh;
           $this->tekst = $tekst;
           $this->afbeelding = $afbeelding;
    }
    
    public function insert_dirigent()
    {        
        $this->sql = "INSERT INTO dirigent (tekst, afbeelding) VALUES (:tekst, :afbeelding)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':tekst', $this->tekst);
        $stmt->bindParam(':afbeelding', $this->afbeelding);
        $stmt->execute();

        if ($stmt) {
            echo '<p><div class="success">Repertoire aangepast!</div></p>';
        }
    }
    
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
