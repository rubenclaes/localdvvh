<?php

/**
 * Een eenvoudige authenticatie klasse waarmee je een authenticatie
 * systeem kan bouwen om gebruikers op basis van hun gebruikersrol
 * toegang te geven tot bepaalde delen van een site.
 *
 * de gebruikergegevens (userid, password and userrole) zijn opgeslagen in een
 * array die uit de database wordt gehaald.
 *
 *
 *  @author     Ruben Claes
 *  
 */
class Authorization {

    private $strUsername;
    private $strPassword;
    private $intRol;
    private $dbh;
    private $sql;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    private function validate($strUsername, $strPassword) {
        $this->sql = "SELECT * FROM namen  WHERE gebruikersnaam = '$strUsername' AND active='1'";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // deze functie controleert of de username bestaat in de array en controleert
        // vervolgens het password.
        if ($row != null) {
            foreach ($row as $value) {
                if ($strPassword == $value['paswoord']) {
                    $this->intRol = $value['rol'];
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public function login($strUsername, $strPassword) {
        //deze functie controleert de gebruiker en het password.
        if ((!empty($strUsername)) && (!empty($strPassword))) {
            $this->strUsername = $strUsername;
            $this->strPassword = $strPassword;
            $valid = $this->validate($strUsername, $strPassword);
        }

        if ($valid) {
            //stelt de sessie variabelen username en userrole in
            $_SESSION['username'] = $this->strUsername;
            $_SESSION['userrole'] = $this->intRol;
            return true;
        } else {
            return false;
        }
    }

    public function logoff() {
        header("Location: http://www.deverenigdevriendenheusden.be/");
        unset($_SESSION['username']);
        unset($_SESSION['userrole']);
    }

    public function authenticate($intUserRole) {
        //controleert of het gaat om een geldige gebruiker en of
        //het gebruikers niveau groter is dan het opgegeven niveau
        if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] >= $intUserRole)) {
            return true;
        }
        return false;
    }

    public function logoutform() {
        echo '<form method="post">
                        <input name="logoff" value="Afmelden" type="submit" class="btn">
                    </form>';
    }

    public function loginform() {
        echo '<h3>Vul onderstaande gegevens in om u aantemelden.</h3>
            <p><span class="label label-info">Opgelet!</span> Gegevens met een <span class="required">*</span> zijn verplicht!</p>
 <form method="post" class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="username">Gebruikersnaam <span class="required">*</span></label>
    <div class="controls">
      <input id="username" placeholder="gebruikersnaam" name="frmUsername" type="text"/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="password">Wachtwoord <span class="required">*</span></label>
    <div class="controls">
      <input id="password" name="frmPassword" placeholder="Wachtwoord" type="password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <input type="submit" value="Aanmelden" name="logon" class="btn">
    </div>
  </div>
</form>';
    }
   

}
