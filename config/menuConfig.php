<?php
/**
 * menuConfig.php
 *
 * @ author  		Ruben Claes
 * @ copyright  	2014
 * @ license
 * @ version		2.00
 * @ date               21 maart 2014
 *
 * Dit bestand bevat de variabelen over de pagina's die in de navigatiebar 
 * van deze basistemplate moeten komen.
 *
 */
$arrMenuItems = array(
    "artikels" => array(
               'menuitem'=>'Artikels',
               'page_id' =>'artikels',
               'page_name'=>'Artikels',
               'page_content'=> 'admin/artikels/artikels.php',
               'page_access'=> 4,//admin
               'state'=> 0, //hidden
               ),
    "nieuws" => array(
               'menuitem'=>'Nieuws',
               'page_id' =>'nieuws',
               'page_name'=>'Nieuws',
               'page_content'=> 'admin/nieuws/nieuws.php',
               'page_access'=> 3,//bestuurlid+admin
               'state'=> 0, //hidden
               ),
     "gebruiker" => array(
               'menuitem'=>'gebruiker',
               'page_id' =>'gebruiker',
               'page_name'=>'gebruiker',
               'page_content'=> 'admin/gebruiker/gebruiker.php',
               'page_access'=> 4,
               'state'=> 0, //hidden
               ),
    "check_username" => array(
               'menuitem'=>'check_username',
               'page_id' =>'check_username',
               'page_name'=>'check_username',
               'page_content'=> 'admin/gebruiker/check_username.php',
               'page_access'=> 4,
               'state'=> 0, //hidden
               ),
    "wijzig_wachtwoord" => array(
               'menuitem'=>'wijzig_wachtwoord',
               'page_id' =>'wijzig_wachtwoord',
               'page_name'=>'wijzig_wachtwoord',
               'page_content'=> 'admin/gebruikersgegevens/wijzig_wachtwoord.php',
               'page_access'=> 1,
               'state'=> 0, //hidden
               ),
    "repertoires" => array(
               'menuitem'=>'repertoires',
               'page_id' =>'repertoires',
               'page_name'=>'repertoires',
               'page_content'=> 'admin/repertoires/repertoires.php',
               'page_access'=> 4,
               'state'=> 0, //hidden
               ),
     "jaarprogramma" => array(
               'menuitem'=>'jaarprogramma',
               'page_id' =>'jaarprogramma',
               'page_name'=>'jaarprogramma',
               'page_content'=> 'admin/jaarprogramma/jaarprogramma.php',
               'page_access'=> 4,
               'state'=> 0, //hidden
               ),
    "fotos" => array(
               'menuitem'=>'fotos',
               'page_id' =>'fotos',
               'page_name'=>'fotos',
               'page_content'=> 'admin/fotos/fotos.php',
               'page_access'=> 4,//admin
               'state'=> 0, //hidden
               ),
     "index" => array(
               'menuitem'=>'Home',
               'page_id' =>'index',
               'page_name'=>'Home',
               'page_content'=> 'includes/index.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
    "verifeer" => array(
               'menuitem'=>'Verifeer',
               'page_id' =>'verifeer',
               'page_name'=>'Verifeer',
               'page_content'=> 'includes/verifeer.php',
               'page_access'=> 0,//iedereen
               'state'=> 0,
               ),
    "geschiedenis" => array(
               'menuitem'=>'Geschiedenis',
               'page_id' =>'geschiedenis',
               'page_name'=>'Geschiedenis',
               'page_content'=>'includes/geschiedenis.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
    "agenda" => array(
               'menuitem'=>'Agenda',
               'page_id' =>'agenda',
               'page_name'=>'Agenda',
               'page_content'=>'includes/agenda.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
    "harmonie" => array(
               'menuitem'=>'Harmonie',
               'page_id' =>'dirigent',
               'page_name'=>'Harmonie',
               'page_content'=>'includes/dirigent.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
    "dirigent" => array(
               'menuitem'=>'Dirigent',
               'page_id' =>'dirigent',
               'page_name'=>'Dirigent',
               'page_content'=>'includes/dirigent.php',
               'page_access'=> 0,//iedereen
               'state'=> 0,
               ),
    "drumband" => array(
               'menuitem'=>'Drumband',
               'page_id' =>'drumband',
               'page_name'=>'Drumband',
               'page_content'=>'includes/drumband.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
    "leden" => array(
               'menuitem'=>'Leden',
               'page_id' =>'leden',
               'page_name'=>'Leden',
               'page_content'=>'includes/leden.php',
               'page_access'=> 0,//iedereen
               'state'=> 0,
               ),
   "repertoire" => array(
               'menuitem'=>'Repertoire',
               'page_id' =>'repertoire',
               'page_name'=>'Repertoire',
               'page_content'=>'includes/repertoire.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
    "registratie" => array(
               'menuitem'=>'Registratie',
               'page_id' =>'registratie',
               'page_name'=>'Registratie',
               'page_content'=>'includes/registratie.php',
               'page_access'=> 0,//iedereen
               'state'=> 0,//hidden
               ),
    "login" => array(
               'menuitem'=>'Login',
               'page_id' =>'login',
               'page_name'=>'Login',
               'page_content'=>'includes/login.php',
               'page_access'=> 0,//iedereen
               'state'=> 0,//hidden
               ),
    "fotoalbum" => array(
               'menuitem'=>'Fotoalbum',
               'page_id' =>'fotoalbum',
               'page_name'=>'Fotoalbum',
               'page_content'=>'includes/fotoalbum.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
    "contact" => array(
               'menuitem'=>'Over ons',
               'page_id' =>'contact',
               'page_name'=>'Contact',
               'page_content'=>'includes/contact.php',
               'page_access'=> 0,//iedereen
               'state'=> 1,
               ),
      "blogroll" => array(
               'menuitem'=>'Blogroll',
               'page_id' =>'blogroll',
               'page_name'=>'Home',
               'page_content'=>'includes/blogroll.php',
               'page_access'=> 0,//iedereen
               'state'=> 0,//hidden   
               ),
      "gebruikersgegevens" => array(
               'menuitem'=>'gebruikersgevens',
               'page_id' =>'gebruikersgegevens',
               'page_name'=>'gebruiksgegevens',
               'page_content'=> 'admin/gebruikersgegevens/gebruikersgegevens.php',
               'page_access'=> 1,
               'state'=> 0, 
               ),
      "maanden" => array(
               'menuitem'=>'Maanden',
               'page_id' =>'maanden',
               'page_name'=>'Maanden',
               'page_content'=>'includes/maanden.php',
               'page_access'=> 0,//iedereen
               'state'=> 0,//hidden   
               ),
      "404" => array(
               'menuitem'=>'404' ,
               'page_id' => '404',
               'page_name' =>'error 404',
               'page_content'=> 'includes/404.xhtml',
               'page_access'=> 0,//iedereen
               'state'=> 0,   //hidden
               ),
    );   
$arrArchivesItems=array(
    "January" => array(
                'menuitem'=>'januari',
                'page_id' => 'maanden&Id=januari',
                'page_name'=>'januari',
                'page_content'=>'includes/maanden.php',
                'page_access'=> '',
                'dagen'=>31,
                'nummer'=>1,
                ),
    "February" => array(
                'menuitem'=>'februari',
                'page_id' => 'maanden&Id=februari',
                'page_name'=>'februari',
                'page_content'=>'includes/maanden.php', 
                'dagen'=>28,
                'nummer'=>2,
                ),
    "March" => array(
                'menuitem'=>'maart',
                'page_id' => 'maanden&Id=maart',
                'page_name'=>'maart',
                'page_content'=>'includes/maanden.php',
                'dagen'=>31,
                'nummer'=>3,
                ),
    "April" => array(
                'menuitem'=>'april',
                'page_id' => 'maanden&Id=april',
                'page_name'=>'april',
                'page_content'=>'',  
                'dagen'=>30,
                'nummer'=>4,
                ),
     "May" => array(
                'menuitem'=>'mei',
                'page_id' => 'maanden&Id=mei',
                'page_name'=>'mei',
                'page_content'=>'', 
                'dagen'=>31,
                'nummer'=>5,
                ),
    "June" => array(
                'menuitem'=>'juni',
                'page_id' => 'maanden&Id=juni',
                'page_name'=>'juni',
                'page_content'=>'', 
                'dagen'=>30,
                'nummer'=>6,
                ),
    "July" => array(
                'menuitem'=>'juli',
                'page_id' => 'maanden&Id=juli',
                'page_name'=>'juli',
                'page_content'=>'',  
                'dagen'=>31,
                'nummer'=>7,
                ),
    "August" => array(
                'menuitem'=>'augustus',
                'page_id' => 'maanden&Id=augustus',
                'page_name'=>'augustus',
                'page_content'=>'', 
                'dagen'=>31,
                'nummer'=>8,
                ),
    "September" => array(
                'menuitem'=>'september',
                'page_id' => 'maanden&Id=september',
                'page_name'=>'september',
                'page_content'=>'', 
                'dagen'=>30,
                'nummer'=>9,
                ),
   
    "October" => array(
                'menuitem'=>'oktober',
                'page_id' => 'maanden&Id=oktober',
                'page_name'=>'oktober',
                'page_content'=>'',
                'dagen'=>31,
                'nummer'=>10,
                ),
    "November" => array(
                'menuitem'=>'november',
                'page_id' => 'maanden&Id=november',
                'page_name'=>'november',
                'page_content'=>'', 
                'dagen'=>30,
                'nummer'=>11,
                ),
    "December" => array(
                'menuitem'=>'december',
                'page_id' => 'maanden&Id=december',
                'page_name'=>'december',
                'page_content'=>'', 
                'dagen'=>31,
                'nummer'=>12,
                ),    
);
?>