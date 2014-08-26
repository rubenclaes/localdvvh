<?php
/**
 * index.php
 *
 * @ author  		Ruben Claes
 * @ copyright  	2014
 * @ license
 * @ version		2.30
 * @ date               14 mei 2014
 *
 * Dit is een template voor de site van Harmonie De Verenigde Vrienden Heusden-Zolder
 */

/**
 * error reporting on
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

session_start(); //werken met sessies voor de authenticatie

/**
 * inladen van de benodigde Config Files
 * -compression_inc dit zal compressie activeren
 * -headConfig bevat alle header variabelen zoals metatags en paginatitel
 * -menuConfig bevat alle variabelen voor het genereren van de menustructuur
 * -htmlHeader_inc deze zal de html Header genereren.
 * -htmlMenu_inc deze zal de html Menu structuur genereren.
 * */
include_once 'config/compression_inc.php';
require_once 'classes/database.class.php';
require_once 'classes/SimpleAuthClass.php';

$dbh = Database::getConnection();
$objAuthentication = new SimpleAuthClass($dbh);

require_once 'config/menuConfig.php';
require_once 'config/headConfig.php';


include 'templates/basistemplate/htmlHeader_inc.php'; 
include 'templates/basistemplate/htmlMenu_inc.php';

echo '<!-- Begin paginacontent -->'
. '<div class="container">';


/*
 * Laadt de paginacontent van de gevraagde pagina in
 */
if (isset($_GET['page'])) {
    $strPage = $_GET['page'];
    if (!array_key_exists($strPage, $arrMenuItems)) {
        $strPage = "404";        
        include $arrMenuItems[$strPage]["page_content"];
    } elseif (($arrMenuItems[$strPage]['page_access'] == 0) ||  $objAuthentication->authenticate($arrMenuItems[$strPage]['page_access'])) {
        include $arrMenuItems[$strPage]["page_content"];
    } else {
        include 'includes/noaccess.php';
    }
} else {
    $strPage = "index";
    include $arrMenuItems[$strPage]["page_content"];
}
echo '<a href="#" class="back-to-top">Terug omhoog</a>';
echo'</div><!-- Einde paginacontent -->';

include 'templates/basistemplate/htmlFooter_inc.php';