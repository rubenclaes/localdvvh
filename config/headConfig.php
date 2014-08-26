<?php
/**
 * headConfig_inc.php
 *
 * @ author  		Ruben Claes
 * @ copyright  	2011
 * @ license
 * @ version		1.00
 * @ date               24 december 2011
 *
 * Dit bestand bevat de variabelen die in de document head van het
 * htmlHeader_inc.php van de basis template worden weergegeven
 *
 */
$strMetaTags = '
            <meta charset="utf-8"> 
            <link rel="shortcut icon" type="image/ico" href="http://deverenigdevriendenheusden.be/favicon.ico" />
            <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="application-name" content="Home"/> 
            <meta name="msapplication-TileColor" content="#13712A" />
            <meta name="msapplication-TileImage" content="http://deverenigdevriendenheusden.be/images/logo2.png" />
            <meta name="description" content="De site van Koninklijke Harmonie De Verenigde Vrienden Heusden-Zolder." />
            <meta name="keywords" content="de verenigde vrienden,Heusden-Zolder,Koninklijke Harmonie,Harmonie Heusden,Harmonie Verenigde Vrienden,harmonie,verenigde vrienden" />
            <meta name="author" content="Ruben Claes" />
            ';
 
 $styleSheets='     
                    <!-- Le styles -->
                    <link href=\'http://fonts.googleapis.com/css?family=Roboto:400,300,700\' rel=\'stylesheet\' type=\'text/css\'>
                    
                    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
                    <link href="assets/css/bootplus.css" rel="stylesheet">
                 
                    <link href="assets/css/bootplus-responsive.css" rel="stylesheet">
                    <link href="assets/css/font-awesome-ie7.min.css" rel="stylesheet">
      
                    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
                    <!--[if lt IE 9]>
                    <script src="assets/js/html5shiv.js"></script>
                    <![endif]-->

                    <!-- Fav and touch icons -->
                    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">';

 if(isset($_GET['page']) && isset($arrMenuItems[$_GET['page']]['menuitem'])){ 
    $strPageTitle = $arrMenuItems[$_GET['page']]['menuitem'];
    $strActiveMenu =$_GET['page'];
}
else{
    $strPageTitle = "Home";
    $strActiveMenu ="index";
}
