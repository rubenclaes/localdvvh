<?php
require_once 'classes/gebruikers.class.php';
?>
<div class="hero-unit">      
    <ul class="nav nav-tabs">
        <li><a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a></li>
        <li><a href="nieuws"><span>Voeg nieuws toe</span></a></li>
        <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
        <li class="active"><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
        <li><a href="repertoires"><span>Repertoire</span></a></li>
        <li><a href="jaarprogramma"><span>Agenda</span></a></li>
        <li><a href="fotos"><span>Foto\'s</span></a></li>
    </ul>

    <?php
    if (isset($_POST['Add'])) {
        if (($_POST['username'] == NULL) || ($_POST['password'] == NULL) || $_POST['rol'] == NULL) {
            echo '<div class="alert alert-error">Alle velden moeten ingevuld worden!</div>';
        } else {
            $hash = md5(rand(0, 1000));
            $paswoord = $_POST['password'];
            $rol = $_POST['rol'];
            $instrument = $_POST['instrument'];
            $email = $_POST['email'];
            $objGebruiker = new User($dbh, NULL, $_POST['username'], $paswoord, $instrument, NULL, $rol, $hash, $email);
            if ($objGebruiker->controleerGebruiker()) {
                $objGebruiker->addGebruiker();
            } else {
                echo '<div class="alert alert-error">De gebruikersnaam: ' . $_POST['username'] . ' bestaat al! Kies een andere gebruikersnaam.</div>';
            }
        }
    } else {
        $objGebruiker = new User($dbh);
    }
    ?>
    <h3>Voeg een gebruiker toe</h3>
    <form method="post" id="contactform" class="form-horizontal" name="gebruikersform" autocomplete="off">
        <div id="div1" class="control-group">
            <label class="control-label" for="username">Gebruikersaam <span class="required">*</span></label>
            <div class="controls">
                <input id="username" name="username" type="text">
                <span id="user-result" class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password">Paswoord <span class="required">*</span></label>
            <div class="controls">
                <input name="password" id="password" type="text">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="instrument">Instrument <span class="required">*</span></label>
            <div class="controls">
                <input name="instrument" id="instrument" type="text">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="rol">Rol <span class="required">*</span></label>
            <div class="controls">
                <select name="rol" id="rol">
                    <option value="2">Lid</option>
                    <option value="3">Bestuurslid</option>
                    <option value="4">Administrator</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="email">E-mail <span class="required">*</span></label>
            <div class="controls">
                <input name="email" id="email"  title="Vul de e-mail in van de gebruiker" type="text">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <input type="submit" value="Voeg Toe" name="Add" class="btn">
            </div>
        </div>
    </form>
    <?php
    $gebruikersRecords = $objGebruiker->getGebruikersRecords();
    ?>

    <h3>Gebruikers</h3>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th scope="col" ><input type="checkbox" /></th>
                <th>Gebruiker</th>
                <th>Instrument</th>
                <th>Gebruikersrol</th>
                <th>Acties</th>
            </tr>
        </thead>
        <?php
        foreach ($gebruikersRecords as $record) {
            $gebruiker = new User($dbh, $record['id'], $record['gebruikersnaam'], $record['paswoord'], $record['instrument'], $record['imagepath'], $record['rol']);
            echo '
                                <tr>
                                <td><input type="checkbox"></td>
                                <td>' . htmlspecialchars($gebruiker->getGebruikersnaam()) . '</td>
    				<td>' . $gebruiker->getInstrument() . '</td>
                                <td>' . $gebruiker->getRol() . '</td>
                                <td>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Bewerk
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                         <form method="post">
                                        <li><input type="submit" name="edit" class="btn btn-link" value="Verander naam">
                                            <input type="hidden" name="' . $gebruiker->getGebruikersID() . '" value="' . $gebruiker->getGebruikersID() . '">
                                        </li>

                                </form>
                                <form method="post">
                                <input type="submit" name="delete" class="btn btn-link" value="Verwijder">
                                <input type="hidden" name="' . $gebruiker->getGebruikersID() . '" value="' . $gebruiker->getGebruikersID() . '">
                                </form>
                                <form method="post">
                                <input type="submit" name="editpaswoord"  class="btn btn-link" value="Wijzig wachtwoord">
                                <input type="hidden" name="' . $gebruiker->getGebruikersID() . '" value="' . $gebruiker->getGebruikersID() . '">
                                </form>

                                 </ul>
                                </td>
				</tr>';
            if (isset($_POST[$gebruiker->getGebruikersID()]) && isset($_POST['delete'])) {
                echo $gebruiker->deleteGebruiker();
            }
            if (isset($_POST[$gebruiker->getGebruikersID()]) && isset($_POST['edit'])) {
                echo'<form method="post" autocomplete="off">
                    <tr>
                    <td></td>
                    <td>Naam:<input name="gebruikersnaam" value="' . $gebruiker->getGebruikersnaam() . '" type="text"></td>
                    <td>Instrument:<input name="instrument" value="' . $gebruiker->getInstrument() . '" type="text"></td>
                    <td>Rol:<input name="rol" value="' . $gebruiker->getRol() . '" type="text"></td>
                    <td><input type="submit" name="update" value="update"><input type="hidden" name="' . $gebruiker->getGebruikersID() . '" value="' . $gebruiker->getGebruikersID() . '"> </td>
                    </tr></form>';
            }
            if (isset($_POST[$gebruiker->getGebruikersID()]) && isset($_POST['editpaswoord'])) {
                echo'<form method="post">
                    <tr>
                    <td></td>
                    <td>Paswoord :<input name="paswoord" value="' . $gebruiker->getPaswoord() . '" type="text"></td>
                    <td><input type="submit" name="updatepaswoord" value="update"><input type="hidden" name="' . $gebruiker->getGebruikersID() . '" value="' . $gebruiker->getGebruikersID() . '"> </td>
                    </tr></form>';
            }
            if (isset($_POST[$gebruiker->getGebruikersID()]) && isset($_POST['update'])) {
                $nummer = $gebruiker->getGebruikersID();
                $gebruikersnaam = $_POST['gebruikersnaam'];
                $instrument = $_POST['instrument'];
                $rol = $_POST['rol'];

                $objGebruiker = new User($dbh, $nummer, $gebruikersnaam, NULL, $instrument, NULL, $rol);
                if ($objGebruiker->updateGebruiker()) {
                    echo '<META HTTP-EQUIV="Refresh" Content="0; ">';
                }
            }
            if (isset($_POST[$gebruiker->getGebruikersID()]) && isset($_POST['updatepaswoord'])) {
                $nummer = $gebruiker->getGebruikersID();
                $strSalt = 'eo57TB3';
                $paswoord = md5($_POST['paswoord'] . $strSalt);

                $objGebruiker = new User($dbh, $nummer, NULL, $paswoord);
                if ($objGebruiker->updatePaswoord()) {
                    echo '<META HTTP-EQUIV="Refresh" Content="0; ">';
                }
            }
        }
        ?>
    </table>

</div>
<script type="text/javascript">

    $("#username").keyup(check_username_existence);
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

</script>
