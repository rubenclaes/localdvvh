<?php
 
require_once 'classes/agenda.class.php';
echo '<div class="hero-unit">      
        <ul class="nav nav-tabs">
        <li><a href="?page=gebruikersgegevens"><span>Gebruikersgegevens</span></a></li>
        <li><a href="?page=nieuws"><span>Voeg nieuws toe</span></a></li>
        <li><a href="?page=artikels"><span>Nieuws & Reacties</span></a></li>
        <li><a href="?page=gebruiker"><span>Beheer Gebruikers</span></a></li>
        <li><a href="?page=repertoires"><span>Repertoire</span></a></li>
        <li class="active" ><a href="?page=jaarprogramma"><span>Agenda</span></a></li>
        <li><a href="?page=fotos"><span>Foto\'s</span></a></li> 
        </ul>
       ';

$objAgenda = new agenda($dbh);
$objAgenda->tabelAgenda();
$objAgenda->overzichtAgenda();


if (isset($_POST['Add']))
   {  
    if(($_POST['dat']==NULL)||($_POST['ond']==NULL))
                {
                  echo '<div id="alert">Alle velden moeten ingevuld worden!</div>'; 
                }
    else{
       $objAgenda->insertAgenda();
    }
   }

?>
</div>

