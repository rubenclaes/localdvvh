<?php
/**
 * htmlMenu_inc.php
 *
 * @ author  		Ruben
 * @ copyright  	2011
 * @ license
 * @ version		1.00
 * @ date               24 december 2011
 *
 * Dit bestand zorgt voor de navigatie op de site. De menupunten worden
 * ingesteld via het bestand menuConfig.php
 *
 */
?> 
<!-- HEADER -->
		
		<!-- ENDS HEADER -->
<div class="container">
    
			
                   
				<div class="logo">
                                   
                                    <h3>Koninklijke Harmonie De Verenigde Vrienden Heusden</h3>
				</div>
                
<div class="navbar">
  <div class="navbar-inner">
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
     </a>
<div class="nav-collapse collapse">

 <?php      

echo '<ul class="nav">';
        
foreach($arrMenuItems as $strMenuItem => $strKey) {
 if ($strKey['state']== 1) {
  if (($strKey['page_access'] == 0 || $objAuthentication->authenticate($strKey['page_access']))) {         
    if($strMenuItem == $strActiveMenu) {
       if($strMenuItem == 'harmonie') {
         echo'<li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Harmonie <b class="caret"></b></a>
              <ul class="drodown-menu">
                 <li><a href="'.$arrMenuItems['dirigent']['page_id'].'">'.$arrMenuItems['dirigent']['menuitem'].'</a></li>
                 <li><a href="'.$arrMenuItems['leden']['page_id'].'">'.$arrMenuItems['leden']['menuitem'].'</a></li>
                 <li><a href="'.$arrMenuItems['bestuur']['page_id'].'">'.$arrMenuItems['bestuur']['menuitem'].'</a></li>
              </ul>
              </li>';
         }
        else {  
            if(isset($strKey["menuitem"])) {
            echo'<li class = "active"><a href="'.$strKey["page_id"].'">'.$strKey["menuitem"].'</a></li>';
            }
         }
        }
    else {
        if($strMenuItem == 'harmonie') {
            echo'<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Harmonie <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="'.$arrMenuItems['dirigent']['page_id'].'">'.$arrMenuItems['dirigent']['menuitem'].'</a></li>
                    <li><a href="'.$arrMenuItems['leden']['page_id'].'">'.$arrMenuItems['leden']['menuitem'].'</a></li>
                  </ul>
                </li>';
         }
        else {
            if(isset($strKey["menuitem"])) {
            echo'<li><a href="'.$strKey["page_id"].'">'.$strKey["menuitem"].'</a></li>';
            }
        }
       }                
      }
     }
    }
?>
              </ul>
              <?php 
           if(isset($_SESSION['username'])) { 
           echo'
              
              <ul class="nav pull-right">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION['username'].' <b class="caret"></b></a>
                    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdown"> 
                    <li><a tabindex="-1" href="gebruikersgegevens"><i class="icon-user"></i> Gebruikersgegevens </a></li>
                    <li><a tabindex="-1" href="login"><i class="icon-power-off"></i> Afmelden </a> </li>
                    </ul>
                </li>
              </ul><p class="navbar-text pull-right">
              Ingelogd als</p>
              '; 
        }
        else {
            echo'
              <p class="navbar-text pull-right">
              <a href="login" class="navbar-link">Inloggen</a>
              </p>
              ';
        }
              ?>
              
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar inverse -->
      </div> <!-- /.container -->