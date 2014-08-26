<?php

/**
 * Reaction klasse
 *
 * @author Ruben
 */
class Reaction {

    private $sql;
    private $dbh;
    private $gebruiker;
    private $tekst;
    private $reactieID;
    private $nieuwsID;
    private $datum;
    private $reactieRecords;
    private $reactieEnGebruikerRecords;
    
    /**
     * 
     * @param type $dbh databaseverbinding 
     * @param integer $reactieID unieke id van de reactie
     * @param string $gebruiker gebruiker die reactie heeft upgeload
     * @param string $tekst de tekst van de reactie
     * @param integer $nieuwsID het unieke nieuwsid dat bij de reactiehoort
     * @param string $datum datum wanneer reactie is gepost
     */
    public function __construct($dbh, $reactieID=NULL, $gebruiker=NULL, $tekst=NULL, $nieuwsID=NULL, $datum=NULL) {
        $this->dbh = $dbh;
        $this->reactieRecords = NULL;
        $this->reactieEnGebruikerRecords = NULL;
        $this->reactieID = $reactieID === NULL ? $this->reactieID : $reactieID;
        $this->gebruiker = $gebruiker === NULL ? $this->gebruiker : $gebruiker;
        $this->tekst = $tekst == NULL ? $this->tekst : $tekst;
        $this->nieuwsID = $nieuwsID === NULL ? $this->nieuwsID : $nieuwsID;
        $this->datum = $datum === NULL ? $this->datum : $datum;
    }

    public function getReactieRecords() {
        if ($this->reactieRecords == NULL) { // caching
            $this->sql = "SELECT * FROM reacties ORDER BY datum DESC";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->reactieRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->reactieRecords;
        } else {
            return $this->reactieRecords;
        }
    }

    public function getGebruiker() {
        return $this->gebruiker;
    }

    public function getTekst() {
        return $this->tekst;
    }

    public function getReactieID() {
        return $this->reactieID;
    }

    public function getNieuwsID() {
        return $this->nieuwsID;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function deleteReactie() {
        $this->sql = "DELETE FROM reacties WHERE nummer = '$this->reactieID'";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        return '<META HTTP-EQUIV="Refresh" Content="0; ">';
    }

    public function updateReactie() {
        try {
            $this->sql = "UPDATE reacties SET reactie = :tekst WHERE nummer=:reactieID";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(':tekst', $this->tekst, PDO::PARAM_STR);
            $stmt->bindParam(':reactieID', $this->reactieID, PDO::PARAM_INT);
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

    public function getAantalReacties() {
        $this->sql = "SELECT count(*) FROM reacties WHERE itemnumber = $this->nieuwsID";
        $result = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result->execute();
        $aantalreacties = $result->fetchColumn();
        return $aantalreacties;
    }

    public function getReactiesEnGebruiker() {
         if ($this->reactieEnGebruikerRecords == NULL) { // caching
            $this->sql = "
                SELECT namen.imagepath,
                      reacties.datum,
                      reacties.gebruiker,
                      reacties.reactie,
                      reacties.itemnumber,
                      reacties.nummer 
               FROM   namen INNER JOIN
                      reacties ON reacties.gebruiker = namen.gebruikersnaam
               WHERE  itemnumber = $this->nieuwsID";

            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->reactieEnGebruikerRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->reactieEnGebruikerRecords;
        } else {
            return $this->reactieEnGebruikerRecords;
        }
    }

    public function getRecenteReacties(){
        if ($this->reactieEnGebruikerRecords == NULL) { // caching
        $this->sql = "SELECT n.imagepath,
                               r.datum,
                               r.gebruiker,
                               r.itemnumber, 
                               r.reactie
                      FROM namen n, reacties r
                      where r.gebruiker = n.gebruikersnaam
                      ORDER BY r.datum DESC 
                      LIMIT 5";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->reactieEnGebruikerRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->reactieEnGebruikerRecords;
        } else {
            return $this->reactieEnGebruikerRecords;
        }  
        
    }
    public function lastReaction() {
        $this->sql = "SELECT datum, gebruiker, reactie FROM reacties WHERE datum = (SELECT MAX(datum) FROM reacties)";

        $result = $this->dbh->query($this->sql);
        $result->setFetchMode(PDO::FETCH_OBJ);
        if ($result) {
            echo '<p><div class="alert alert-success">Onderstaande reactie werd succesvol gepost!</div></p>';
        }
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            echo '<p><strong>Datum: </strong>' . $row[0] . '</p>
                  <p><strong>Gebruiker: </strong>' . $row[1] . '</p>
                  <p><strong>Reactie: </strong>' . $row[2] . '</p>
                <hr/>';
        }
    }

    public function insertReaction() {
        $this->sql = "INSERT INTO reacties (datum, gebruiker, reactie, itemnumber) VALUES (NOW(), :gebruiker, :reactie,:itemnumber)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':gebruiker', $this->gebruiker);
        $stmt->bindParam(':reactie', $this->tekst);
        $stmt->bindParam(':itemnumber', $this->nieuwsID);
        $stmt->execute();
    }

    public function tabelComment() {
        echo '<h3>Plaats een reactie</h3><hr>
        <form method = "post" id="contactform">
            <label>Bericht <span class="required">*</span></label>
            <textarea rows="10" cols= "45" name="message" id="message"></textarea> <br>
            <input type="submit" name="submit" value="Reageer" class="btn"/>
        </form>';
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}