<?php

class Guestbook
{
    private $sql;
    private $dbh;
    private $name;
    private $email;
    private $message;
    
    public function __construct($dbh) {
           $this->dbh = $dbh;
    }
    
    
    public function insertMessage()
    {
        $this->sql = "INSERT INTO gastenboek (naam, email, bericht, datum) VALUES (:naam, :email, :bericht, NOW())";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':naam', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':bericht', $this->message);
        $stmt->execute();  
    }
    
    public function showMessages()
    {
        $this->sql = "SELECT naam, email, bericht, datum FROM gastenboek ORDER BY datum DESC";
        $result = $this->dbh->query($this->sql);
        $result->setFetchMode(PDO::FETCH_OBJ);
                
        
        while ($row = $result->fetch(PDO::FETCH_NUM))
        {
                echo '
                      <table>
                      <tr>
                        <th class="first">Datum: </th>
                        <td>'.$row[3].'</td>
                      </tr> 
                      <tr>
                        <td class="first">Naam: </td>
                        <td>'.$row[0].'</td>
                      </tr>
                      <tr>
                        <td class="first">Email: </td>
                        <td><a href="mailto:'.$row[1].'">'.$row[1].'</a></td>
                      </tr>
                      <tr>
                        <td class="first">Bericht: </td>
                        <td>'.$row[2].'</td>
                      </tr>
                      </table>
                      <hr/>';
        }
        
    }
    public function showMessages2()
    {   
        $sql = "SELECT * FROM gastenboek";
        $stmt = $this->dbh->prepare($sql,array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        
        $arr_gegevens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        for ($i=0;$i<count($arr_gegevens);$i++){
                echo '<form id="loginform" method="post">
                        <p>Naam: '.$arr_gegevens[$i]['naam'].'</p>
                        <p>Email: '.$arr_gegevens[$i]['email'].'</p>
                        <p>Bericht: '.$arr_gegevens[$i]['bericht'].'</p>
                        <p>Datum: '.$arr_gegevens[$i]['datum'].'</p>
                        <input type="submit" value="delete" name="'.$arr_gegevens[$i]['nummer'].'" class="button" id="submit"/>     
                        </form>';
                if (isset($_POST[$arr_gegevens[$i]['nummer']]))
                {
                $nummer =$arr_gegevens[$i]['nummer'];
                $sql5 = "DELETE FROM gastenboek WHERE nummer = '$nummer'";
                $stmt = $this->dbh->prepare($sql5,array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute();
                }      
        }
    }
    public function lastMessage()
    {
        $this->sql = "SELECT naam, email, bericht, datum FROM gastenboek WHERE datum = (SELECT MAX(datum) FROM gastenboek)";
      
        $result = $this->dbh->query($this->sql);
        $result->setFetchMode(PDO::FETCH_OBJ);
        if($result){echo '<p><div class="success">Onderstaand bericht werd succesvol gepost!</div></p>';};
        while ($row = $result->fetch(PDO::FETCH_NUM))
        {
            
            echo '<table>
                      <tr>
                        <th class="first">Datum: </th>
                        <td>'.$row[3].'</td>
                      </tr> 
                      <tr>
                        <td class="first">Naam: </td>
                        <td>'.$row[0].'</td>
                      </tr>
                      <tr>
                        <td class="first">Email: </td>
                        <td><a href="mailto:'.$row[1].'">'.$row[1].'</a></td>
                      </tr>
                      <tr>
                        <td class="first">Bericht: </td>
                        <td>'.$row[2].'</td>
                      </tr>
                      </table>
                      <hr/>';
        }
    }
    
    public function showForm()
    {
        
 echo '
    <h3>Laat een bericht achter!</h3>
    <form method = "post" id="contactform">
    
    <div>
    <label>Naam <span class="required">*</span></label>
    <input type ="text" name= "naam" id="name" />
    </div>
    
    <div>
    <label>E-mail <span class="required">*</span></label>
    <input type="text" name= "email" id="email" />
    </div>
    
    <div>
    <label>Bericht <span class="required">*</span></label>
    <textarea rows="10" cols= "50" name= "message" id="message"></textarea>
    </div>
    
    <div>
    <input type="submit" name="submit" value="Plaats Bericht" class="button" />
    </div>
    </form>';
    }
            
}
?>