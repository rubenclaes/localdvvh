<?php
require_once 'classes/registratie.class.php';
require_once 'classes/gebruikers.class.php';
$objRegistratie = new Registratie($dbh);
?>
<div class="hero-unit">
    <h1>Registratie</h1>
    <hr>

    <h3>Vul uw gegevens in</h3>
    <p><span class="label label-info">Opgelet!</span> Gegevens met een <span class="required">*</span> zijn verplicht!</p>
    <form method="post" class="form-horizontal" name="registratieform" autocomplete="off"> 

        <div id="div1" class="control-group">
            <label class="control-label" for="username">Gebruikersnaam (a-z.-_) <span class="required">*</span></label>
            <div class="controls">
                <input name="username" id="username" autocomplete="off" type="text">
                <span id="user-result" class="help-inline"></span>
            </div>
        </div>

        <div id="div2" class="control-group">              
            <label class="control-label" for="email">E-mail <span class="required">*</span></label>
            <div class="controls">
                <input autocomplete="off" name="email" id="email" type="email">
            </div>
        </div>

        <div id="div3" class="control-group">
            <label class="control-label" for="password">Wachtwoord <span class="required">*</span></label>
            <div class="controls"> 
                <input name="password" id="password" type="password">
                <span id="password-result" class="help-inline"></span>
            </div>
        </div>

        <div id="div4" class="control-group">
            <label class="control-label" for="password2">Herhaling Wachtwoord <span class="required">*</span></label>
            <div class="controls">
                <input name="password2" id="password2" type="password" >
                <span id="password-result" class="help-inline"></span>
            </div>
        </div>

        <div class="control-group" >            
            <label class="control-label" for="newsletter">Aanmelden nieuwsbrief </label>
            <div class="controls">
                <label class="checkbox inline">
                    <input type="checkbox" id="newsletter" name="newsletter" value="newsletter" checked="checked"> 
                    Via de nieuwsmail ontvangt u als eerste alle berichten en informatie over onze harmonie, in het bijzonder over de activiteiten.
                </label>
            </div>
        </div>

        <div class="control-group">                   
            <label class="control-label" for="code1">Typ volgende cijfers over <span class="required">*</span></label>
            <div class="controls">

                <?php $code = $objRegistratie->captcha(); ?>
                <span class="label label-inverse"><div><?php echo $code; ?></div></span>
                <input type="hidden" value="<?php echo $code; ?>" id="code1" name="code1">
                <br><input class="input-mini"  name="code2" type="text" maxlength="4" min="4" >
            </div>
        </div>

        <div class="control-group">
            <div class="controls">   
                <input type="submit" value="Registreer" name="Add" class="button">
            </div>
        </div>
    </form>

    <?php
    if (isset($_POST['Add'])
            AND isset($_POST['username']) && !empty($_POST['username'])
            AND isset($_POST['email']) && !empty($_POST['email'])
            AND isset($_POST['password']) && !empty($_POST['password'])
            AND isset($_POST['password2']) && !empty($_POST['password2'])
            AND isset($_POST['code1']) && !empty($_POST['code1'])
            AND isset($_POST['code2']) && !empty($_POST['code2'])) {

        $gebruikersnaam = $objRegistratie->testInput($_POST['username']);
        $email = $objRegistratie->testInput($_POST['email']);
        $paswoord = $objRegistratie->testInput($_POST['password']);
        $herhalingpaswoord = $objRegistratie->testInput($_POST['password2']);
        $code1 = $objRegistratie->testInput($_POST['code1']);
        $code2 = $objRegistratie->testInput($_POST['code2']);

        $objRegistratie = new Registratie($dbh, $gebruikersnaam, $email, $paswoord, $herhalingpaswoord, $code1, $code2);
        if ($objRegistratie->controleerGegevens()) {
            $hash = md5(rand(0, 1000));
            $objGebruiker = new User($dbh, NULL, $gebruikersnaam, $paswoord, NULL, NULL, NULL, $hash, $email);
            $objGebruiker->addGebruiker();

            if (isset($_POST['newsletter'])) {
                if (!$objRegistratie->controleerEmail()) {
                    echo '<div class="alert alert-error">E-mail bestaat al kies een ander e-mailadres.</div>';
                } else {
                    $objRegistratie->insertNieuwsbrief();
                }
            }

            $objRegistratie->verstuurVerificatieMail($objGebruiker->getHash());
            echo '<p><div class="success">U bent succesvol geregistreerd. '
            . 'Controleer dit door te klikken op de activatie link die is verstuurd naar uw e-mail. </div></p>';
        }
    } else {
        echo '<div class="alert alert-error">Alle velden moeten ingevuld worden!</div>';
    }
    echo '</div>';
    ?>
    <script type="text/javascript">

        $("#username").keyup(check_username_existence);
        $("#password").keyup(check_password_existence);
        $("#password2").keyup(check_password_existence);
        function check_username_existence() {
            var str = $(this).val(); //get the string typed by user
            var xmlhttp;
            if (str.length == 0)
            {
                document.getElementById("user-result").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest)
            {// code voor IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else
            {// code voor IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    if (xmlhttp.responseText == 1)
                    {
                        document.getElementById("div1").className = "control-group success";
                        document.getElementById("user-result").innerHTML = "Gebruikersnaam is ok!";
                    }
                    else {
                        document.getElementById("div1").className = "control-group warning";
                        document.getElementById("user-result").innerHTML = "Gebruikersnaam bestaat al!";
                    }

                }
            }
            xmlhttp.open("GET", "admin/gebruiker/check_username.php?username=" + str, true);
            xmlhttp.send();
        }
        function check_password_existence() {

            var password2 = $("#password2").val(); //get the string typed by user
            var password1 = $("#password").val();
            if (password1 !== "" && password2 !== "") {
                if (password2 !== password1)
                {
                    document.getElementById("div3").className = "control-group warning";
                    document.getElementById("div4").className = "control-group warning";
                    document.getElementById("password-result").innerHTML = "Beide wachtwoorden moeten hetzelfde zijn";
                }
                else {
                    document.getElementById("div3").className = "control-group";
                    document.getElementById("div4").className = "control-group";
                    document.getElementById("password-result").innerHTML = "";
                }
            }

        }
    </script>

