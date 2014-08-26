<?php
require_once 'classes/repertoire.class.php';
?>
<div class="hero-unit">      
    <ul class="nav nav-tabs">
        <li><a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a></li>
        <li><a href="nieuws"><span>Voeg nieuws toe</span></a></li>
        <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
        <li><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
        <li><a href="dirigent_admin"><span>Dirigent</span></a></li>
        <li class="active" ><a href="?page=repertoires"><span>Repertoire</span></a></li>
        <li ><a href="jaarprogramma"><span>Agenda</span></a></li>
        <li><a href="fotos"><span>Foto\'s</span></a></li>  
    </ul>

    <h3>Pas het repertoire aan</h3>
    <form method = "post" id="contactform" autocomplete="off">
        <div>
            <label>Naam <span class="required">*</span></label>
            <input name="naam" type="text" />
        </div>
        <div>
            <label>Componist <span class="required">*</span></label>
            <input name="componist" type="text" />
        </div>
        <div>
            <label>Beschrijving <span class="required">*</span></label>
            <textarea name="beschrijving" id="beschrijving" rows="10" cols="50">
            </textarea>
        </div>
        <div>
            <input type="submit" value="Add" name="Add" class="button">
        </div>
    </form>
    <?php
    if (isset($_POST['Add'])) {
        if (($_POST['naam'] == NULL) || ($_POST['componist'] == NULL) || ($_POST['beschrijving'] == NULL)) {
            echo '<div class="alert alert-error">Alle velden moeten ingevuld worden!</div>';
        } else {
            $naam = $_POST['naam'];
            $componist = $_POST['componist'];
            $beschrijving = $_POST['beschrijving'];
            $objRepertoire = new Repertoire($dbh, NULL, $naam, $componist, $beschrijving);
            $objRepertoire->insertRepertoire();
        }
    }
    $objRepertoire = new Repertoire($dbh);
    $repertoireRecords = $objRepertoire->getRepertoireRecords();
    ?>

    <h3>Repertoire</h3>
    <table class="table table-condensed">
        <thead>
            <tr> 
                <th scope="col" ><input type="checkbox" /></th> 
                <th>Naam</th> 
                <th>Componist</th> 
                <th>Beschrijving</th>
                <th>Acties</th>
            </tr> 
        </thead>

        <?php
        foreach ($repertoireRecords as $record) {
            $repertoire = new Repertoire($dbh, $record['id'], $record['naam'], $record['componist'], $record['beschrijving']);
            echo '<tr> 
                <td><input type="checkbox"></td> 
                <td>' . $repertoire->getnaam() . '</td> 
                <td>' . $repertoire->getComponist() . '</td> 
                <td>' . substr($repertoire->getBeschrijving(), 0, 30) . '</td>

                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Bewerk
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <form method="post">
                                <input type="submit" name="edit" class="btn btn-link" value="Wijzig">
                                <input type="hidden" name="' . $repertoire->getRepertoireID() . '" value="' . $repertoire->getRepertoireID() . '"> 
                            </form>

                            <form method="post">
                                <input type="submit" name="delete" class="btn btn-link" value="Verwijder">
                                <input type="hidden" name="' . $repertoire->getRepertoireID() . '" value="' . $repertoire->getRepertoireID() . '">
                            </form>
                        </ul>
                    </div>
                </td> 
            </tr>';

            if (isset($_POST[$repertoire->getRepertoireID()]) && isset($_POST['delete'])) {
                $repertoire->deleteRepertoire();
            }
            if (isset($_POST[$repertoire->getRepertoireID()]) && isset($_POST['edit'])) {
                echo'<form method="post">
                    <tr><td><input name="naam" value="' . $repertoire->getNaam() . '" type="text"></td>
                    <td><input name="componist" value="' . $repertoire->getComponist() . '" type="text"></td>
                    <td><input name="beschrijving" value="' . $repertoire->getBeschrijving() . '" type="text"></td>
                    <td><input type="submit" name="update" value="update"><input type="hidden" name="' . $repertoire->getRepertoireID() . '" value="' . $repertoire->getRepertoireID() . '"> </td>
                </tr></form>';
            }
            if (isset($_POST[$repertoire->getRepertoireID()]) && isset($_POST['update'])) {
                $nummer = $repertoire->getRepertoireID();
                $naam = $_POST['naam'];
                $componist = $_POST['componist'];
                $beschrijving = $_POST['beschrijving'];

                $objRepertoire = new Repertoire($dbh, $repertoire->getRepertoireID(), $naam, $componist, $beschrijving);
                if ($objRepertoire->updateRepertoire()){
                   echo '<META HTTP-EQUIV="Refresh" Content="0; ">'; 
                }
                else{
                    echo '<p><div class="alert alert-error">'
                    . '<button type="button" class="close" data-dismiss="alert">&times;</button>'
                    . '<strong>Fout! </strong>Alle gegevens moeten ingevuld worden.'
                    . '</div></p>';
                }
                
            }
        }
        ?>
        </table>
</div>

