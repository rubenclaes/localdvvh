<?php
require_once 'classes/agenda.class.php';
$objAgenda = new Agenda($dbh);
?>
    <div class="hero-unit">
         <h1>Jaarprogramma <?php echo date('Y'); ?> </h1>
         <hr>
	
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
        <td width="15%">
                   <ul class="nav nav-list">
            <?php 
            foreach ($arrArchivesItems as $strMaand =>$strKey){
                if(isset($_GET['show']) && $_GET['show']== $strKey['nummer']){   
                  echo' <li class="active"><a href="agenda&amp;show='.$strKey['nummer'].'">'.$strKey['menuitem'].'</a></li>';    
                }
                else{
                echo'<li><a href="agenda&amp;show='.$strKey['nummer'].'">'.$strKey['menuitem'].'</a></li>';  
                }
            }
            ?>
                </ul>

        </td>
        <td width="85%">

            <?php 
            if(isset($_GET['show'])){
             $maandNr= $_GET['show'];
             $objAgenda->toonAgenda($maandNr);
            }
            ?>
            
        </td>
        </tr>
        </table>
</div>
