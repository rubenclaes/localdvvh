<?php

/**
 * Repertoire Class
 *
 * @author Ruben
 */
class Repertoire {

    private $sql;
    private $dbh;
    private $repertoireID;
    private $naam;
    private $componist;
    private $beschrijving;
    private $repertoireRecords;
    private $repertoireOpNaam;

    /**
     * 
     * @param type $dbh
     * @param integer $repertoireID het unieke id van elk muziekstuk
     * @param string $naam de naam van elk muziekstuk
     * @param string $componist de componist van het muziekstuk
     * @param string $beschrijving korte beschrijving van het muziekstuk
     */
    public function __construct($dbh, $repertoireID = NULL, $naam = NULL, $componist = NULL, $beschrijving = NULL) {
        $this->dbh = $dbh;
        $this->repertoireRecords = NULL;
        $this->repertoireOpNaam = NULL;
        $this->repertoireID = $repertoireID === NULL ? $this->repertoireID : $repertoireID;
        $this->naam = $naam === NULL ? $this->naam : $naam;
        $this->componist = $componist === NULL ? $this->componist : $componist;
        $this->beschrijving = $beschrijving === NULL ? $this->beschrijving : $beschrijving;
    }

    public function getRepertoireID() {
        return $this->repertoireID;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function getComponist() {
        return $this->componist;
    }

    public function getBeschrijving() {
        return $this->beschrijving;
    }

    public function getRepertoireRecords() {
        if ($this->repertoireRecords == NULL) { // caching
            $this->sql = "SELECT * FROM repertoire ORDER BY naam ASC";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->repertoireRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->repertoireRecords;
        } else {
            return $this->repertoireRecords;
        }
    }

    public function getRepertoireOpNaam() {
        if ($this->repertoireOpNaam == NULL) { // caching
            $this->sql = "SELECT * FROM repertoire WHERE naam='$this->naam'";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->repertoireOpNaam = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->repertoireOpNaam;
        } else {
            return $this->repertoireOpNaam;
        }
    }

    public function deleteRepertoire() {
        $this->sql = "DELETE FROM repertoire WHERE id = '$this->repertoireID'";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        return '<META HTTP-EQUIV="Refresh" Content="0; ">';
    }

    public function updateRepertoire() {
        try {
            $this->sql = "UPDATE repertoire SET naam =:naam ,componist=:componist, beschrijving=:beschrijving WHERE id=:repertoireID";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(':naam', $this->naam, PDO::PARAM_STR);
            $stmt->bindParam(':componist', $this->componist, PDO::PARAM_STR);
            $stmt->bindParam(':beschrijving', $this->beschrijving, PDO::PARAM_STR);
            $stmt->bindParam(':repertoireID', $this->repertoireID, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'Regel: ' . $e->getLine() . '<br>';
            echo 'Bestand: ' . $e->getFile() . '<br>';
            echo 'Foutmelding: ' . $e->getMessage();
            echo '</pre>';
        }
    }

    public function insertRepertoire() {
        $this->sql = "INSERT INTO repertoire (naam, componist, beschrijving) VALUES (:naam, :componist, :beschrijving)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':naam', $this->naam);
        $stmt->bindParam(':componist', $this->componist);
        $stmt->bindParam(':beschrijving', $this->beschrijving);
        $stmt->execute();
        if ($stmt) {
            echo '<p><div class="alert alert-success">Repertoire aangepast!</div></p>';
        }
    }

}
