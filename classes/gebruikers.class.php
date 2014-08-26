<?php

/**
 * Description of gebruikers
 *
 * @author Ruben
 */
class User {

    private $sql;
    private $dbh;
    private $gebruikersID;
    private $gebruikersnaam;
    private $gebruikers;
    private $instrument;
    private $imagepath;
    private $rol;
    private $paswoord;
    private $gebruikerRecord;
    private $gebruikersRecords;
    private $gebruikersOpEmailHash;
    private $hash; 
    private $email;
    
    /**
     * @param type $dbh
     * @param integer $gebruikersID
     * @param string $gerbruikersnaam
     * @param string $paswoord
     * @param string $instrument
     * @param string $imagepath
     * @param integer $rol
     */
    public function __construct($dbh, $gebruikersID = NULL, $gebruikersnaam = NULL, $paswoord = NULL, $instrument = NULL, $imagepath = NULL, $rol = NULL, $hash = NULL, $email=NULL) {
        $this->dbh = $dbh;
        $this->gebruikerRecord = null;
        $this->gebruikersRecords = null;
        $this->gebruikersOpEmailHash = NULL;
        $this->gebruikersID = $gebruikersID === NULL ? $this->gebruikersID : $gebruikersID;
        $this->gebruikersnaam = $gebruikersnaam === NULL ? $this->gebruikersnaam : $gebruikersnaam;
        $this->paswoord = $paswoord === NULL ? $this->paswoord : $paswoord;
        $this->instrument = $instrument === NULL ? $this->instrument : $instrument;
        $this->imagepath = $imagepath === NULL ? $this->imagepath : $imagepath;
        $this->rol = $rol === NULL ? $this->rol : $rol;
        $this->hash = $hash === NULL ? $this->hash : $hash;
        $this->email = $email === NULL ? $this->email : $email;
        
    }

    public function getGebruikersID() {
        return $this->gebruikersID;
    }

    public function getGebruikersnaam() {
        return $this->gebruikersnaam;
    }

    public function getPaswoord(){
        return $this->paswoord;
    }
    
    public function getInstrument() {
        return $this->instrument;
    }

    public function getImagepath() {
        return $this->imagepath;
    }

    public function getRol() {
        return $this->rol;
    }
    
    public function getHash(){
        return $this->hash;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getGebruikerRecord() {
        if ($this->gebruikerRecord == NULL) { // caching
            $this->sql = "SELECT * FROM namen WHERE gebruikersnaam = '$this->gebruikersnaam'";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->gebruikerRecord = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->gebruikerRecord;
        } else {
            return $this->gebruikerRecord;
        }
    }

    public function getGebruikersRecords() {
        if ($this->gebruikersRecords == NULL) { // caching
            $this->sql = "SELECT * FROM namen";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->gebruikersRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->gebruikersRecords;
        } else {
            return $this->gebruikersRecords;
        }
    }

    public function getGebruikersOpEmailHash() {
        if($this->gebruikersOpEmailHash == NULL) { // caching
            $this->sql = "SELECT email, hash, active FROM namen WHERE email='".  $this->email."' AND hash='".  $this->hash."' AND active='0'";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->gebruikersRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->gebruikersRecords;
        } else {
            return $this->gebruikersRecords;
        }
    }
    
    public function activateGebruiker(){
        try {
            $this->sql = "UPDATE namen SET active='1' WHERE email=:email AND hash=:hash AND active='0'";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':hash', $this->hash, PDO::PARAM_INT);
            if($stmt->execute()){
               echo '<div class="alert alert-success">Uw account is geactiveerd, u kan zich nu aanmelden.</div>'; 
            }
            
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'Regel: ' . $e->getLine() . '<br>';
            echo 'Bestand: ' . $e->getFile() . '<br>';
            echo 'Foutmelding: ' . $e->getMessage();
            echo '</pre>';
        }

    }
    
    public function deleteGebruiker() {
        $this->sql = "DELETE FROM namen WHERE id = '$this->gebruikersID'";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        return '<META HTTP-EQUIV="Refresh" Content="0; ">';
    }
    
    public function updateGebruiker(){
        try {
            $this->sql = "UPDATE namen SET gebruikersnaam =:gebruikersnaam, instrument=:instrument, rol=:rol WHERE id=:gebruikersID";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(':gebruikersnaam', $this->gebruikersnaam, PDO::PARAM_STR);
            $stmt->bindParam(':instrument', $this->instrument, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $this->rol, PDO::PARAM_INT);
            $stmt->bindParam(':gebruikersID', $this->gebruikersID, PDO::PARAM_INT);
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

    public function updatePaswoord(){
        try {
            $this->sql = "UPDATE namen SET paswoord= :paswoord  WHERE id= :gebruikersID";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(':paswoord', $this->paswoord, PDO::PARAM_STR);
            $stmt->bindParam(':gebruikersID', $this->gebruikersID, PDO::PARAM_INT);
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
    public function upload() {
        if (isset($_FILES["file"])) {
            $allowedExts = array("jpg", "jpeg", "gif", "png");
            $extension = end(explode(".", $_FILES["file"]["name"]));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $bestandsnaam = $_FILES["file"]["name"];
            if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < 100000) && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                } else {
                    $this->sql = "UPDATE namen SET imagepath = 'upload/$this->gebruikersnaam.$ext' WHERE gebruikersnaam = '$this->gebruikersnaam'";
                    $stmt = $this->dbh->prepare($this->sql);
                    $stmt->execute();

                    if (file_exists("upload/" . $this->gebruikersnaam)) {
                        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $this->gebruikersnaam . '.' . $ext);
                        echo '<p><div class="alert alert-success">Foto is gewijzigd!</div></p>';
                    } else {
                        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $this->gebruikersnaam . '.' . $ext);
                        echo '<p><div class="alert alert-success">Foto is gewijzigd!</div></p>';
                    }
                }
            } else {
                echo "Invalid file";
            }
        }
    }

    public function uploadAvatar() {
        if (isset($_FILES["file"])) {
            $allowedExts = array("jpg", "jpeg", "gif", "png");
            $extension = end(explode(".", $_FILES["file"]["name"]));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $bestandsnaam = $_FILES["file"]["name"];
            if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < 50000) && in_array($extension, $allowedExts)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                } else {
                    $this->sql = "UPDATE namen SET imagepath = 'upload/$this->gebruikersnaam.$ext' WHERE gebruikersnaam = '$this->gebruikersnaam'";
                    $stmt = $this->dbh->prepare($this->sql);
                    $stmt->execute();

                    if (file_exists("upload/" . $this->gebruikersnaam)) {
                        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $this->gebruikersnaam . '.' . $ext);
                        echo '<META HTTP-EQUIV="Refresh" Content="0; ">';
                        echo "<p><div class=\"success\">Foto is gewijzigd!</div></p>";
                    } else {
                        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $this->gebruikersnaam . '.' . $ext);
                        echo '<META HTTP-EQUIV="Refresh" Content="0; ">';
                        echo '<p><div class="alert alert-success">Foto is gewijzigd!</div></p>';
                    }
                }
            } else {
                echo "Invalid file";
            }
        }
    }

    public function wijzigPaswoord($paswoord, $paswoord2) {
        $strSalt = 'eo57TB3';
        $this->paswoord = md5($paswoord . $strSalt);
        $paswoord2 = md5($paswoord2 . $strSalt);

        if ($this->paswoord == $paswoord2) {

            $this->gebruikersnaam = $_SESSION['username'];
            $this->sql = "UPDATE namen SET paswoord = :paswoord WHERE gebruikersnaam= :gebruikersnaam";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(':paswoord', $this->paswoord, PDO::PARAM_STR);
            $stmt->bindParam(':gebruikersnaam', $this->gebruikersnaam, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            echo '<div class="alert alert-error">De twee wachtwoorden zijn niet dezelfde!</div>';
        }
    }

    public function controleerGebruiker() {
        $this->sql = "SELECT count(*) FROM namen  WHERE gebruikersnaam = '$this->gebruikersnaam'";
        $result = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result->execute();
        $num_of_rows = $result->fetchColumn();

        if ($num_of_rows == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function addGebruiker() {
        $strSalt = 'eo57TB3';
        $this->paswoord = md5($_POST['password'] . $strSalt);
       
        $this->imagepath = 'upload/default.png';
        $this->hash = $this->hash;
        if($this->instrument==null){
            $this->instrument = "";
        }
        if($this->rol==null){
            $this->rol = "";
        }
        
        $this->sql = "INSERT INTO namen (gebruikersnaam, paswoord, instrument, imagepath, rol, hash, email) VALUES (:gebruikersnaam, :paswoord, :instrument, :imagepath, :rol, :hash, :email)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':gebruikersnaam', $this->gebruikersnaam);
        $stmt->bindParam(':paswoord', $this->paswoord);
        $stmt->bindParam(':instrument', $this->instrument);
        $stmt->bindParam(':imagepath', $this->imagepath);
        $stmt->bindParam(':rol', $this->rol);
        $stmt->bindParam(':hash',  $this->hash);
        $stmt->bindParam(':email',  $this->email);
        $stmt->execute();
        if ($stmt) {
            echo '<p><div class="alert alert-success">' . $this->gebruikersnaam . ' is succesvol toegevoegd.</div></p>';
        }
    }

    public function leden() {
        $this->sql = "SELECT instrument,rol FROM namen WHERE rol<>'1' AND instrument <>'' GROUP BY instrument ";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $counter = 0;
        echo '<ul><div class="column">';
        foreach ($row as $value) {

            if ($counter == 0) {
                echo '<li>';
            }

            if ($counter != 5) {

                echo'
                    <a href="leden&amp;show=' . $value['instrument'] . '">
                    <img class="listimage" src="../../images/' . $value['instrument'] . '.jpg" width="150" height="150">
                    </a>';
                $counter++;
            } else {
                echo'
                </li>';
                $counter = 0;
            }
        }
        echo'
               </div></ul>';
    }

    public function toonLeden($instrument) {
        $this->instrument = $instrument;
        $this->sql = "SELECT instrument,gebruikersnaam FROM namen WHERE instrument='$this->instrument'";

        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $arr_gegevens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<h3>' . $arr_gegevens[0]['instrument'] . '</h3>';
        foreach ($arr_gegevens as $value) {
            echo '<p>' . $value['gebruikersnaam'] . '</p>';
        }
        echo '<hr/>';
    }

    public function getGebruikers() {
        $this->sql = "SELECT gebruikersnaam FROM namen";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->execute();
        $this->gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->gebruikers;
    }

}

?>