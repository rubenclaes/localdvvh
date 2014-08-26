<?php

echo' <div class="hero-unit">';

if (isset($_SESSION['username']) && isset($_SESSION['userrole'])) {
    $objAuthentication->logoutform();
} else {
    $objAuthentication->loginform();
}

if (isset($_POST['logon']) && $_POST['logon'] == "Aanmelden") {
    if ((!empty($_POST['frmUsername'])) && (!empty($_POST['frmPassword']))) {
        $strUsername = $_POST['frmUsername'];
        $strSalt = 'eo57TB3';
        $strPassword = md5($_POST['frmPassword'] . $strSalt); //ms5 encryptie om het passwoord te encrypteren
        if ($objAuthentication->login($strUsername, $strPassword)) {
            header("Location: http://www.deverenigdevriendenheusden.be/");
        } else {
            echo '<div class="alert alert-error">Foute combinatie wachtwoord/gebruikersnaam ofwel is uw account niet geactiveerd.</div>';
        }
    } else {
        if (empty($_POST['frmUsername']) && empty($_POST['frmPassword'])) {
            echo '<div class="alert alert-error">Geef een gebruikersnaam en wachtwoord in!</div>';
        } else {
            if (empty($_POST['frmUsername'])) {
                echo '<div class="alert alert-error">Geef een gebruikersnaam in!</div>';
            }
            if (empty($_POST['frmPassword'])) {
                echo '<div class="alert alert-error">Geef een wachtwoord in!</div>';
            }
        }
    }
} elseif (isset($_POST['logoff']) && $_POST['logoff'] == "Afmelden") {
    $objAuthentication->logoff();
}
echo '</div>';

