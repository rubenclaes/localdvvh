<?php

require_once 'gebruikers.class.php';

/**
 * Description of registratie
 *
 * @author Ruben
 */
class registratie {

    private $sql;
    private $dbh;
    private $gebruikersnaam;
    private $email;
    private $paswoord;
    private $herhalingpaswoord;
    private $code1;
    private $code2;

    public function __construct($dbh, $gebruikersnaam = NULL, $email = NULL, $paswoord = NULL, $herhalingpaswoord = NULL, $code1 = NULL, $code2 = NULL) {
        $this->dbh = $dbh;
        $this->gebruikersnaam = $gebruikersnaam === NULL ? $this->gebruikersnaam : $gebruikersnaam;
        $this->email = $email === NULL ? $this->email : $email;
        $this->paswoord = $paswoord === NULL ? $this->paswoord : $paswoord;
        $this->herhalingpaswoord = $herhalingpaswoord === NULL ? $this->herhalingpaswoord : $herhalingpaswoord;
        $this->code1 = $code1 === NULL ? $this->code1 : $code1;
        $this->code2 = $code2 === NULL ? $this->code2 : $code2;
    }

    private function isValidEmail() {
        return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $this->email);
    }

    public function insertNieuwsbrief() {
        $this->sql = "INSERT INTO nieuwsbrief (naam, email) VALUES (:gebruikersnaam, :email)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':gebruikersnaam', $this->gebruikersnaam);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function controleer_gegevens() {
        if (!$this->isValidEmail()) {
            echo '<div class="alert alert-error">Onjuist e-mail adres ingevoerd.</div>';
        } else {
            if ($this->code1 != $this->code2) {
                // What happens when the CAPTCHA was entered incorrectly
                echo '<div class="alert alert-error">De cijfers zijn niet correct ingevoerd. Ga terug en probeer het opnieuw.</div>';
            } else {
                if ($this->paswoord != $this->herhalingpaswoord) {
                    echo '<div class="alert alert-error">Wachtwoord is niet dezelfde.</div>';
                } else {
                    if (!preg_match('/^[a-z0-9.-_]+$/', $this->gebruikersnaam)) {
                        echo '<div class="alert alert-error">Gebruikersnaam kan enkel een punt, streepje of underscore (.-_)bevatten.</div>';
                    } else {
                        $objGebruiker = new User($this->dbh, NULL, $this->gebruikersnaam);
                        if (!$objGebruiker->controleerGebruiker()) {
                            echo '<div class="alert alert-error">Gebruiker bestaat al kies een andere gebruikersnaam.</div>';
                        } else {
                            return true;
                        }
                    }
                }
            }
        }
    }

    public function controleerEmail() {
        $this->sql = "SELECT * FROM nieuwsbrief WHERE email = '$this->email'";
        $result = $this->dbh->prepare($this->sql);
        $result->execute();
        $num_of_rows = $result->fetchColumn();

        if ($num_of_rows == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function captcha() {
        $code = rand(1000, 9999);
        return $code;
    }

    public function verstuurVerificatieMail($hash) {
        $to = $this->email; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject 
        
        $message = '
            
            Thanks for signing up!
            Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
            ------------------------
            Username: ' . $this->gebruikersnaam . '
            Password: ' . $this->paswoord . '
            ------------------------
 
            Please click this link to activate your account:
            http://www.deverenigdevriendenheusden.be/verifeer?email=' . $this->email . '&hash=' . $hash . '
 
            '; // Our message above including the link

        $headers = 'From:info@deverenigdevriendenheusden.be' . "\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email
    }

}
