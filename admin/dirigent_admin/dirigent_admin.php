<?php
require_once 'classes/repertoire.class.php';

echo '<div class="hero-unit">      
        <ul class="nav nav-tabs">
        <li><a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a></li>
        <li><a href="nieuws"><span>Voeg nieuws toe</span></a></li>
        <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
        <li><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
        <li class="active"><a href="dirigent_admin"><span>Dirigent</span></a></li>
        <li><a href="repertoires"><span>Repertoire</span></a></li>
        <li ><a href="jaarprogramma"><span>Agenda</span></a></li>
        <li><a href="fotos"><span>Foto\'s</span></a></li>  
        </ul>';

if (isset($_POST['Add'])){  
    if(($_POST['naam']==NULL)||($_POST['componist']==NULL)||($_POST['beschrijving']==NULL)) {
        echo '<div id="alert">Alle velden moeten ingevuld worden!</div>'; 
    }
    else{
       $objRepertoire->addRepertoire();
    }
   }

?>
</div>

