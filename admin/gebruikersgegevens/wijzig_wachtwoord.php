<?php
require_once 'classes/gebruikers.class.php';
$objGebruiker = new User($dbh);
?>

<div class="hero-unit">      
    <ul class="nav nav-tabs">
  <li class="active">
    <a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a>

<?php if(isset($_SESSION['userrole'])&&($_SESSION['userrole'] >= 3)){ ?>
       <li><a href="nieuws"><span>Voeg nieuws toe</span></a></li>
<?php } 
 if(isset($_SESSION['userrole'])&&($_SESSION['userrole'] > 3)){ ?>
           <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
           <li><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
           <li><a href="repertoires"><span>Repertoire</span></a></li>
           <li><a href="jaarprogramma"><span>Agenda</span></a></li>
           <li><a href="fotos"><span>Foto\'s</span></a></li>
        
<?php }     ?>        
</ul>
      <h3>Wachtwoord wijzigen</h3>
      <p>Door onderstaande gegevens intevullen kan u uw wachtwoord wijzigen.</p>
       <p><span class="label label-info">Opgelet!</span> Gegevens met een <span class="required">*</span> zijn verplicht!</p>
          <form method="post" class="form-horizontal" name="registratieform"> 
          
          
      <div id="div3" class="control-group">
                 <label class="control-label" for="password">Wachtwoord <span class="required">*</span></label>
                 <div class="controls"> 
		 <input name="password" id="password" type="password">
                  <span id="password-result" class="help-inline"></span>
                 </div>
		</div>
                
                <div id="div4" class="control-group">
                 <label class="control-label" for="password2">Herhaling Wachtwoord <span class="required">*</span></label>
                 <div class="controls">
		 <input name="password2" id="password2" type="password" >
                  <span id="password-result" class="help-inline"></span>
                 </div>
		</div>
   
                <div class="control-group">
                 <div class="controls">   
                 <input type="submit" class="btn" name="wijzigpaswoord" value="wijzig">
                 </div>
                </div>
      
      </form>
<?php
if (isset($_POST['wijzigpaswoord']))
 {  
   $paswoord = $objGebruiker->testInput($_POST['password']);
   $paswoord2 = $objGebruiker->testInput($_POST['password2']);
   $objGebruiker->wijzigPaswoord($paswoord, $paswoord2); 
 } 
?>
</div>   
<script type="text/javascript">

   $("#password").keyup(check_password_existence);
   $("#password2").keyup(check_password_existence);
   
   function check_password_existence(){
        
        var password2 = $("#password2").val(); //get the string typed by user
        var password1 = $("#password").val();
        if(password1 !== "" && password2 !== ""){
        if (password2 !== password1)
        {   
            document.getElementById("div3").className = "control-group warning";
            document.getElementById("div4").className = "control-group warning";
            document.getElementById("password-result").innerHTML = "Beide wachtwoorden moeten hetzelfde zijn";        
        }
        else{
            document.getElementById("div3").className = "control-group";
            document.getElementById("div4").className = "control-group";
            document.getElementById("password-result").innerHTML = "";  
        }
    }            

   }
</script>
