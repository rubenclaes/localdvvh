<?php

/**
 * Description of repertoire
 *
 * @author Ruben
 */
class repertoire {
    private $sql;
    private $dbh;
    
    public function __construct($dbh) {
           $this->dbh = $dbh;
    }
    
    public function repertoire() {
        $this->sql = "SELECT naam FROM repertoire ORDER BY naam ASC";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $arr_gegevens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<ul class="unstyled">';
        for ($i=0;$i<count($arr_gegevens);$i++) {
            echo '<li><a href="index.php?page=repertoire&amp;show='.$arr_gegevens[$i]['naam'].'"><i class="icon-music"></i> '.$arr_gegevens[$i]['naam'].'</a></li>';
        }
        echo'</ul>';
    }
    
    public function toonRepertoire()
    {
        $this->sql = "SELECT * FROM repertoire WHERE naam='$this->item'";;
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $arr_gegevens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<ul class="unstyled">';
        for ($i=0;$i<count($arr_gegevens);$i++) {
            echo '<hr/>
                  <h2>'.$arr_gegevens[$i]['naam'].'</h2>';
            echo '<p>'.$arr_gegevens[$i]['componist'].'</p>';
            echo '<p>'.$arr_gegevens[$i]['beschrijving'].'</p>';
        }
        echo'</ul>';
    }
    
    public function overzichtRepertoires()
    {
            $this->sql = "SELECT * FROM repertoire";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $arr_gegevens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo '        
                      <h3>Repertoire</h3>
                       <table class="table table-condensed">
                            <thead>
                              <tr> 
                                <th scope="col" ><input type="checkbox" /></th> 
    				<th>Naam</th> 
    				<th>Componist</th> 
    				<th>Beschrijving</th>
                                <th>Acties</th>
                              </tr> 
                             </thead>';
				
            for ($i=0;$i<count($arr_gegevens);$i++) {
                  echo '<tr> 
                            <td><input type="checkbox"></td> 
                            <td>' . $arr_gegevens[$i]['naam'] . '</td> 
                            <td>' . $arr_gegevens[$i]['componist'] . '</td> 
                            <td>' . substr($arr_gegevens[$i]['beschrijving'], 0,30) . '</td>
                            
                            <td>
                            <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Bewerk
                                    <span class="caret"></span>
                                    </a>
                                 <ul class="dropdown-menu">
                                <form method="post">
                                <input type="submit" name="edit" class="btn btn-link" value="Wijzig">
                                <input type="hidden" name="'.$arr_gegevens[$i]['id'].'" value="'.$arr_gegevens[$i]['id'].'"> 
                                </form>
                                
                                <form method="post">
                                <input type="submit" name="delete" class="btn btn-link" value="Verwijder">
                                <input type="hidden" name="'.$arr_gegevens[$i]['id'].'" value="'.$arr_gegevens[$i]['id'].'">
                                </form>
                                </ul>
                             </div>
                            </td> 
                        </tr>';
                  
                  if (isset($_POST[$arr_gegevens[$i]['id']]) && isset($_POST['delete'])) {
                    $nummer = $arr_gegevens[$i]['id'];
                    $this->sql = "DELETE FROM repertoire WHERE id = '$nummer'";
                    $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $stmt->execute();
                    echo '<META HTTP-EQUIV="Refresh" Content="0; ">';  
                    }
                 if (isset($_POST[$arr_gegevens[$i]['id']]) && isset($_POST['edit'])) {
                    echo'<form method="post">
                         <tr><td><input name="naam" value="' . $arr_gegevens[$i]['naam'] . '" type="text"></td>
                            <td><input name="componist" value="' . $arr_gegevens[$i]['componist'] . '" type="text"></td>
                            <td><input name="beschrijving" value="' . $arr_gegevens[$i]['beschrijving'] . '" type="text"></td>
                            <td><input type="submit" name="update" value="update"><input type="hidden" name="'.$arr_gegevens[$i]['id'].'" value="'.$arr_gegevens[$i]['id'].'"> </td>
                        </tr></form>';
                    }
                  if(isset($_POST[$arr_gegevens[$i]['id']]) && isset($_POST['update']))
                    {
                     $nummer = $arr_gegevens[$i]['id'];
                     $naam = $_POST['naam'];
                     $componist =  $_POST['componist'];
                     $beschrijving =$_POST['beschrijving'] ;
                  
                     $this->sql = "UPDATE repertoire SET naam = '$naam',componist='$componist', beschrijving='$beschrijving' WHERE id='$nummer'";
                     $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                     $stmt->execute();
                     echo '<META HTTP-EQUIV="Refresh" Content="0; ">'; 
                    }
            }
        echo '</table>';
    }
    public function addRepertoire()
    {
        $naam = $_POST['naam'];
        $componist = $_POST['componist'];
        $beschrijving = $_POST['beschrijving'];
        
        $this->sql = "INSERT INTO repertoire (naam, componist, beschrijving) VALUES (:naam, :componist, :beschrijving)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':componist', $componist);
        $stmt->bindParam(':beschrijving', $beschrijving);
        $stmt->execute();

        if ($stmt) {
            echo '<p><div class="success">Repertoire aangepast!</div></p>';
        }
    }
    public function repertoireTabel()
    {
        echo '<h3>Pas het repertoire aan</h3>
                      <form method = "post" id="contactform">
						<div>
                                                        <label>Naam <span class="required">*</span></label>
							<input name="naam" type="text" />
                                                </div>
						<div>
                                                        <label>Componist <span class="required">*</span></label>
							<input name="componist" type="text" />
						</div>
						<div>
                                                        <label>Beschrijving <span class="required">*</span></label>
							<textarea name="beschrijving" id="beschrijving" rows="10" cols="50">
                                                        </textarea>
						</div>
                                                <div>
                                                        <input type="submit" value="Add" name="Add" class="button">
                                                </div>
                                    </form>';
    }
    public function setItem($item) {
        return $this->item = $item;
    }
}
?>