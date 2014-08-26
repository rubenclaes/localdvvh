<?php

require_once 'classes/gebruikers.class.php';

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    $objGebruiker = new User($dbh);
    $email = $objGebruiker->test_input($_GET['email']);
    $hash = $objGebruiker->test_input($_GET['hash']);
    $gebruiker = new User($dbh, NULL, NULL, NULL, NULL, NULL, NULL, $hash, $email);
    $gebruikersOpEmailHash = $gebruiker->getGebruikersOpEmailHash();
    
    if(count($gebruikersOpEmailHash)>0){
        $gebruiker->activateGebruiker();
    }else{
        echo '<div class="alert alert-error">De url is ofwel onjuist ofwel is deze account al geactiveerd.</div>';
    }
    
}else{
    echo '<div class="alert alert-error">Geen toegang, gebruik alstublieft de gegeven link die is verzonden naar uw e-mailadres.</div>';
}