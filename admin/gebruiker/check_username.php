<?php
require_once '../../classes/gebruikers.class.php';
require_once '../../classes/database.class.php';


if(isset($_GET["username"]))
{
   $dbh = Database::getConnection();
   $username = $_GET["username"];
   $objGebruiker = new User($dbh, NULL, $username);
 
  //received username value from registration page
  $username_exist = $objGebruiker->controleerGebruiker();
  echo $username_exist;
  
}

