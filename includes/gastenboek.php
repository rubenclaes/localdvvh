<div class="hero-unit">
    <h1>Gastenboek</h1>
    
<?php

require_once 'classes/gastenboek.class.php';
$objGastenboek = new Guestbook($dbh);

if (isset($_POST['submit']))
{
  if (($_POST['naam']!=NULL)&&($_POST['email']!=NULL)&&($_POST['message']!=NULL)){
  $name = $_POST['naam'];
  $name= str_replace(array("&lt;i&gt;", "&lt;b&gt;", "&lt;/i&gt;", "&lt;/b&gt;"), array("<i>", "<b>", "</i>", "</b>"), $message);
  $email = $_POST['email'];
  $email = str_replace(array("&lt;i&gt;", "&lt;b&gt;", "&lt;/i&gt;", "&lt;/b&gt;"), array("<i>", "<b>", "</i>", "</b>"), $message);
  $message = htmlentities($_POST['message']);
  $message = str_replace(array("&lt;i&gt;", "&lt;b&gt;", "&lt;/i&gt;", "&lt;/b&gt;"), array("<i>", "<b>", "</i>", "</b>"), $message);
  
  $objGastenboek->setName($name);
  $objGastenboek->setEmail($email);
  $objGastenboek->setMessage($message);

  $objGastenboek->insertMessage();
  $objGastenboek->lastMessage();
  }
  else{
      if(($_POST['naam']==NULL)&&($_POST['email']==NULL)&&($_POST['message']==NULL))
                {
                  echo '<div id="alert">geef een naam, e-mail en bericht in!</div>'; 
                }
      else{
                if($_POST['naam']==NULL)
                {
                  echo '<div id="alert">geef een naam in!</div>';  
                }
                if($_POST['email']==NULL)
                {
                  echo '<div id="alert">geef een email in!</div>';  
                }
                if($_POST['message']==NULL)
                {
                  echo '<div id="alert">geef een bericht in!</div>';  
                }
            }
        }
}
if (isset($_SESSION['userrole'])&&($_SESSION['userrole'] >= 3))
     {   
     $objGastenboek->showMessages2();
     }
 else   
     {      
     $objGastenboek->showMessages();
     }
          
 if (isset($_SESSION['userrole'])&&($_SESSION['userrole'] >= 1))
     {
     $objGastenboek->showForm();
     }
 else
     {
        echo "<p>Om iets te plaatsen in het gastenboek moet u zich registreren of aanmelden. U kan zich aanmelden door rechtsboven op \"Log in\" te klikken.<a href='?page=registratie'>Klik hier</a> voor registratie.</p>";
     }
?>   
</div>