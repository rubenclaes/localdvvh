<?php
echo'
<div class="hero-unit">
    <h1>Leden</h1>
';
require_once 'classes/gebruikers.class.php';

$objGebruiker = new User($dbh);
if(isset($_GET['show'])){
  $instrument =$_GET['show'];
  $objGebruiker->toonLeden($instrument);
}

$objGebruiker->leden();



echo "</div>";
?>
