<?php
require_once 'classes/nieuws.class.php';
require_once 'config/facebookConfig.php';


echo' <div class="hero-unit">      
       <ul class="nav nav-tabs">
        <li>
         <a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a>
        </li>';
if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] >= 3)) {
    echo'<li class="active"><a href="?page=nieuws"><span>Voeg nieuws toe</span></a></li>';
}
if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] > 3)) {
    echo'  <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
           <li><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
           <li><a href="dirigent_admin"><span>Dirigent</span></a></li>
           <li><a href="repertoires"><span>Repertoire</span></a></li>
           <li><a href="jaarprogramma"><span>Agenda</span></a></li>
           <li><a href="fotos"><span>Foto\'s</span></a></li>';
}
echo'</ul>';


if ($fbuser) {
  try {
        //Get user pages details using Facebook Query Language (FQL)
        $fql_query = 'SELECT page_id, name, page_url FROM page WHERE page_id IN (SELECT page_id FROM page_admin WHERE uid='.$fbuser.')';
        $postResults = $facebook->api(array( 'method' => 'fql.query', 'query' => $fql_query ));
    } catch (FacebookApiException $e) {
        echo $e->getMessage();
  }
}else{
        //Show login button for guest users
        $loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
        echo '<a href="'.$loginUrl.'"><img src="images/facebook-login.png" border="0"></a>';
}
if($fbuser && empty($postResults))
{
        /*
        if user is logged in but FQL is not returning any pages, we need to make sure user does have a page
        OR "manage_pages" permissions isn't granted yet by the user.
        Let's give user an option to grant application permission again.
        */
        $loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
        echo 'Could not get your page details, make sure you have created one!';
        echo '<a href="'.$loginUrl.'">Click here to try again!</a>';
}elseif($fbuser && !empty($postResults)){

//Everything looks good, show message form.
?>



<div class="fbpagewrapper">
<div id="fbpageform" class="pageform">
<form id="form" name="form" method="post" action="process.php">
<h1>Post to Facebook Page Wall</h1>
<p>Choose a page to post!</p>
<label>Pages
<span class="small">Select a Page</span>
</label>
<select name="userpages" id="upages">
    <?php
    foreach ($postResults as $postResult) {
            echo '<option value="'.$postResult["page_id"].'">'.$postResult["name"].'</option>';
        }
    ?>
</select>
<label>Message
<span class="small">Write something to post!</span>
</label>
<textarea name="message"></textarea>
<button type="submit" class="button" id="submit_button">Send Message</button>
<div class="spacer"></div>
</form>
</div>
</div>


<?php
}

 
  if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] >= 2)) {
    if (isset($_POST['adnieuws'])) {
        if (!empty($_POST['onderwerp']) && !empty($_POST['email']) && !empty($_POST['artikel'])) {
            $gebruiker = $_SESSION['username'];
            $onderwerp = $_POST['onderwerp'];
            $artikel = $_POST['artikel'];
            $email = $_POST['email'];
            $bestandsnaam= "";
            $Month = date('F');
            $maand = $arrArchivesItems[$Month]['menuitem'];
      
            if (isset($_FILES["file"]) && !empty($_POST['onderwerp']) && !empty($_POST['email']) && !empty($_POST['artikel']) && !empty($_FILES["file"]["name"])) {
                $bestand = $_FILES["file"];
                $bestandsnaam = $_FILES["file"]["name"];
                $objNieuws = new News($dbh, NULL, $gebruiker, $email, $onderwerp, $artikel, NULL, $maand, $bestandsnaam);
                $objNieuws->upload($bestand);
            }
            else{
                $objNieuws = new News($dbh, NULL, $gebruiker, $email, $onderwerp, $artikel, NULL, $maand, $bestandsnaam);
            }
            if (isset($_POST['verzendmail'])) {
                $objNieuws->sendMail();
            }
            $objNieuws->insertNieuws();
            $objNieuws->lastMessage();
        } else {
            echo '<p><div class="alert alert-error">'
            . '<button type="button" class="close" data-dismiss="alert">&times;</button>'
                    . '<strong>Fout! </strong>Alle gegevens moeten ingevuld worden.'
                    . '</div></p>';
        }
    }
}
?>
<h3>Vul onderstaande gegevens in om nieuws toe te voegen.</h3>
              <p><span class="label label-info">Opgelet!</span> Gegevens met een <span class="required">*</span> zijn verplicht!</p>
              
               <form name="form2" method="post" id="contactform" class="form-horizontal" enctype="multipart/form-data">
                        <div class="control-group">                       
                        <label class="control-label" for="email">E-mail <span class="required">*</span></label>
                        <div class="controls">
                        <input type="email" name="email" id="email" title="Geef je e-mail in">
                        </div>
                        </div>
                       
                        <div class="control-group">   
                        <label class="control-label" for="onderwerp">Onderwerp <span class="required">*</span></label>
                        <div class="controls">
                        <input autocomplete="off" type="text" name="onderwerp" id="onderwerp" title="Geef de titel van dit nieuws">
                        </div>
                        </div>
                        
                        <div class="control-group">   
                        <label class="control-label" for="artikel">Artikel <span class="required">*</span></label>
                        <div class="controls">
                        <textarea class="input-xxlarge" name="artikel" id="artikel" rows="20" title="Geef het artikel in"></textarea>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label" for="file">Afbeelding </label>
                        <div class="controls">
                        <input type="file" name="file" id="file" class="btn"> 
                        </div>
                        </div>
                        
                        <div class="control-group">   
                        <label class="control-label" for="verzendmail" class="checkbox">Verzend mail naar gebruikers </label>                     
                        <div class="controls">
                        <input type="checkbox" name="verzendmail" value="newsletter">
                        </div>
                        </div>
                       
                       <div class="control-group">
                        <div class="controls">
                        <input type="submit" value="Voeg Toe" name="adnieuws" id="submit" class="btn">
                        </div>
                       </div>
                 </form>
</div>  
