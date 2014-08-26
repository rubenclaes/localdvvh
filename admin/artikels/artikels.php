<?php
require_once 'classes/nieuws.class.php';
require_once 'classes/reacties.class.php';

$objNieuws = new News($dbh);
$objReactie = new Reaction($dbh);
?>

<div class="hero-unit">      
    <ul class="nav nav-tabs">
        <li><a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a></li>
        <li><a href="nieuws"><span>Voeg nieuws toe</span></a></li>
        <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
        <li><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
        <li><a href="dirigent_admin"><span>Dirigent</span></a></li>
        <li><a href="repertoires"><span>Repertoire</span></a></li>
        <li><a href="jaarprogramma"><span>Agenda</span></a></li>
        <li><a href="fotos"><span>Foto\'s</span></a></li>
    </ul>

    <h3>Nieuws</h3>
    <table class="table table-condensed">
        <thead>
            <tr> 
                <th scope="col"><input type="checkbox"/></th> 
                <th scope="col">Gebruiker</th> 
                <th scope="col">Onderwerp</th> 
                <th scope="col">Datum</th>
                <th scope="col">Artikel</th>
                <th scope="col">Acties</th>
            </tr> 
        </thead>
        <?php
        $nieuwsRecords = $objNieuws->getNieuwsRecords();

        foreach ($nieuwsRecords as $nieuws) {
            $nieuws = new News($dbh, $nieuws['nummer'], $nieuws['gebruiker'], $nieuws['email'], $nieuws['onderwerp'], $nieuws['artikel'], $nieuws['datum'], $nieuws['maand'], $nieuws['path']);
            echo '<tr> 
                                    <td><input type="checkbox"/></td> 
                                    <td>' . $nieuws->getGebruiker() . '</td> 
                                    <td>' . $nieuws->getOnderwerp() . '</td> 
                                    <td>' . $nieuws->getDatum() . '</td>
                                    <td>' . substr($nieuws->getArtikel(), 0, 30) . '...</td>    
                                    <td>
                                    <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Bewerk
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                    <form method="post">
                                        <input type="submit" class="btn btn-link" name="edit" value="Wijzig artikel">
                                        <input type="hidden" name="' . $nieuws->getNieuwsID() . '" value="' . $nieuws->getNieuwsID() . '"> 
                                    </form>
                                    <form method="post">
                                        <input type="submit" class="btn btn-link" name="delete" value="Verwijder">
                                        <input type="hidden" name="' . $nieuws->getNieuwsID() . '" value="' . $nieuws->getNieuwsID() . '">
                                    </form>
                                    
                                    </ul>
                                    </td> 
				</tr>';
            if (isset($_POST[$nieuws->getNieuwsID()]) && isset($_POST['delete'])) {
                echo $nieuws->deleteNieuws();
            }
            if (isset($_POST[$nieuws->getNieuwsID()]) && isset($_POST['edit'])) {
                echo'<form method="post" autocomplete= "off">
                     <tr>
                        <td></td>
                        <td><input name="onderwerp" type="text" value="' . $nieuws->getOnderwerp() . '"></td>
                        <td><textarea name="artikel" rows="12">' . $nieuws->getArtikel() . '</textarea></td>
                        <td><input type="submit" name="update" value="update"><input type="hidden" name="' . $nieuws->getNieuwsID() . '" value="' . $nieuws->getNieuwsID() . '"> </td>
                      </tr>
                     </form>';
            }
            if (isset($_POST[$nieuws->getNieuwsID()]) && isset($_POST['update'])) {
                if (!empty($_POST['onderwerp']) && !empty($_POST['artikel'])) {
                    $onderwerp = $_POST['onderwerp'];
                    $artikel = $_POST['artikel'];

                    $objectNieuws = new News($dbh, $nieuws->getNieuwsID(), NULL, NULL, $onderwerp, $artikel, NULL, NULL, NULL);
                    if ($objectNieuws->updateNieuws()) {
                        echo '<META HTTP-EQUIV="Refresh" Content="0; ">';
                    }
                } else {
                    echo '<p><div class="alert alert-error">'
                    . '<button type="button" class="close" data-dismiss="alert">&times;</button>'
                    . '<strong>Fout! </strong>Alle gegevens moeten ingevuld worden.'
                    . '</div></p>';
                }
            }
        }
        echo '</table>';
        
        $reactieRecords = $objReactie->getReactieRecords();
        echo '<h3>Reacties</h3>
                    <table class="table table-condensed">
                            <thead>
                              <tr> 
                                <th scope="col" ><input type="checkbox" /></th> 
    				<th>Gepost Door</th>
    				<th>Datum</th> 
    				<th>Reactie</th> 
                                <th>Acties</th>
                              </tr> 
                             </thead> 
                           <!-- Table body -->';

        foreach ($reactieRecords as $reactie) {
            $reactie = new Reaction($dbh, $reactie['nummer'], $reactie['gebruiker'], $reactie['reactie'], $reactie['itemnumber'], $reactie['datum']);
            echo '<tr> 
   				<td><input type="checkbox"></td> 
                                <td>' . $reactie->getGebruiker() . '</td> 
    				<td>' . $reactie->getDatum() . '</td>
                                <td>' . substr($reactie->getTekst(), 0, 30) . '</td>
    				<td>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Bewerk
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                <form method="post">
                                <input type="submit" class="btn btn-link" name="edit" value="Wijzig reactie">
                                <input type="hidden" name="' . $reactie->getReactieID() . '" value="' . $reactie->getReactieID() . '"> 
                                </form>
                                <form method="post">
                                <input type="submit" class="btn btn-link"  name="delete" value="Verwijder">
                                <input type="hidden" name="' . $reactie->getReactieID() . '" value="' . $reactie->getReactieID() . '">
                                </form>
                                </ul>
                                </td> 
				</tr>';
            if (isset($_POST[$reactie->getReactieID()]) && isset($_POST['delete'])) {
                echo $reactie->deleteReactie();             
            }
            if (isset($_POST[$reactie->getReactieID()]) && isset($_POST['edit'])) {
                echo'<form method="post" autocomplete= "off">';
                echo '<tr>
                        <td><input name="reactie" type="text" value="' . $reactie->getTekst() . '"></td></tr>
                        <td><input type="submit" name="update" value="update"><input type="hidden" name="' . $reactie->getReactieID() . '" value="' . $reactie->getReactieID() . '"> </td>
                      </tr>
                      </form>';
            }
            if (isset($_POST[$reactie->getReactieID()]) && isset($_POST['update'])) {
                 if (!empty($_POST['reactie'])) {
                    $tekst = $_POST['reactie'];
                    
                    $objectReactie = new Reaction($dbh, $reactie->getReactieID(), NULL, $tekst);
                    if ($objectReactie->updateReactie()) {
                        echo '<META HTTP-EQUIV="Refresh" Content="0; ">';
                    }
                } else {
                    echo '<p><div class="alert alert-error">'
                    . '<button type="button" class="close" data-dismiss="alert">&times;</button>'
                    . '<strong>Fout! </strong>Alle gegevens moeten ingevuld worden.'
                    . '</div></p>';
                }
            }
        }
        echo '</table>';
        ?>
</div>
