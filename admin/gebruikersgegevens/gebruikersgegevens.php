<?php

require_once 'classes/gebruikers.class.php';
echo'
<div class="hero-unit">      
    <ul class="nav nav-tabs">
  <li class="active">
    <a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a>';

if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] >= 3)) {
    echo'<li><a href="nieuws"><span>Voeg nieuws toe</span></a></li>';
}
if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] > 3)) {
    echo'  <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
           <li><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
           <li><a href="dirigent_admin"><span>Dirigent</span></a></li>
           <li><a href="repertoires"><span>Repertoire</span></a></li>
           <li><a href="jaarprogramma"><span>Agenda</span></a></li>
           <li><a href="fotos"><span>Foto\'s</span></a></li>
        ';
}
echo '</ul>';

$gebruikersnaam = $_SESSION['username'];
$objGebruiker = new User($dbh, NULL, $gebruikersnaam);

$gebruikerRecord = $objGebruiker->getGebruikerRecord();

$gebruiker= new User($dbh, $gebruikerRecord[0]['id'], $gebruikerRecord[0]['gebruikersnaam'], $gebruikerRecord[0]['paswoord'], $gebruikerRecord[0]['instrument'], $gebruikerRecord[0]['imagepath'], $gebruikerRecord[0]['rol']);


echo '<div class="card hovercard">
                    <img src="images/muziek_instrumenten.jpg" alt=""/>
                    <div class="avatar">
                    <img src="' . $gebruiker->getImagepath() . '" alt="avatar" width="83" height="78" />
                    </div>
                    <div class="info">
                     <div class="title">' . $gebruiker->getGebruikersnaam() . '</div>
                     <div class="desc">Instrument: ' . $gebruiker->getInstrument() . '</div>
                     <div class="desc">Wijzig <a href="wijzig_wachtwoord">hier</a> je wachwoord.</div>
                    </div>
                  </div>';




echo '<header>
      <h3>Afbeelding wijzigen</h3>
      <p>Door onderstaande gegevens intevullen kan u uw persoonlijke
         afbeelding wijzigen.</p>
      </header>
      <form method="post" enctype="multipart/form-data" id="contactform">
      <fieldset>
      <p>Opgelet de afbeelding kan maximaal 50kb groot zijn.</p>
      <label for="file">Afbeelding :</label>
      <input type="file" name="file" id="file" class="btn" /> 
      <br>
      <input type="submit" name="upload" value="Upload" class="btn" />
      </fieldset>
      </form>';

if (isset($_POST['upload']) && $_FILES['file']['size'] > 0) {
    $objGebruiker->uploadAvatar();
}
echo '</div>';