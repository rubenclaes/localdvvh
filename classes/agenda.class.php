<?php

class agenda {

    private $sql;
    private $dbh;
    private $maandNr;
    private $jaar;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function toonActiviteiten($maandNr, $jaar) {
        $this->maandNr = $maandNr;
        $this->jaar = $jaar;
        $this->sql = "SELECT * FROM `agenda` "
                . "WHERE (SUBSTRING(datum, 6 ,2) = '$this->maandNr') AND"
                . "(SUBSTRING(datum, 3 ,2) = '$this->jaar')"
                . "ORDER BY datum DESC";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '<ul class="unstyled">';
        if (!empty($row)) {
            $i = 0;
            while ($i < 5 && isset($row[$i]['onderwerp'])) {
                echo '<li><strong>' . substr($row[$i]['datum'], 8, 2) . '-' . $this->maandNr . '</strong> ' . $row[$i]['onderwerp'] . '</li>';
                $i++;
            }
        } else {
            echo '<li>Er zijn geen aankomende activiteiten voor deze maand.</li>';
        }
        echo '</ul>';
    }

    public function toonAgenda($maandNr) {
        $this->maandNr = $maandNr;
        $this->sql = "SELECT * FROM agenda WHERE"
                . " MONTH(datum) = $this->maandNr;";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($row)) {
            echo'<table width="100%">
                    <th></th>';
            foreach ($row as $value) {
                if (date("Y", strtotime($value['datum'])) >= date('Y')) {
                    $x = explode("-", $value['datum']);
                    $dagen = array("zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag");
                    $w = date("w", mktime(0, 0, 0, $x[1], $x[2], $x[0]));

                    echo '<tr><td><strong>' . $dagen[$w] . ' ' . date("j/n", strtotime($value['datum'])) . '</strong> : ' . $value['onderwerp'] . '</td></tr>';
                }
            }
        } else {
            echo'<table width="100%">
                    <th></th>';
            echo '<tr><td>Er zijn nog geen activiteiten voor deze maand.</td></tr>';
            echo'</table>';
        }
        echo'</table>';
    }

    public function insertAgenda() {
        $dat = $_POST['dat'];
        $ond = $_POST['ond'];

        $this->sql = "INSERT INTO agenda (datum, onderwerp) VALUES (:datum, :onderwerp)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':datum', $dat);
        $stmt->bindParam(':onderwerp', $ond);
        $stmt->execute();
        echo '<META HTTP-EQUIV="Refresh" Content="0;">';
        if ($stmt) {
            echo '<p><div class="alert alert-success>Succes agendaitem toegevoegd!</div></p>';
        }
    }

    public function overzichtAgenda() {
        $this->sql = "SELECT * FROM agenda";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $arr_gegevens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '      <h3>Agendaitems</h3>
                       <table class="table table-condensed">
                            <thead>
                              <tr> 
                                <th scope="col" ><input type="checkbox" /></th> 
    				<th>Datum</th> 
    				<th>Onderwerp</th>
                                <th>Acties</th> 
                              </tr> 
                             </thead> ';

        foreach ($arr_gegevens as $value) {
            echo '         <tr> 
                                <td><input type="checkbox"></td> 
                                <td>' . $value['datum'] . '</td> 
                                <td>' . $value['onderwerp'] . '</td>
                                <td>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Bewerk
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                <form method="post">
                                <input type="submit" class="btn btn-link" name="edit" value="Wijzig">
                                <input type="hidden" name="' . $value['id'] . '" value="' . $value['id'] . '"> 
                                </form>
                                <form method="post">
                                <input type="submit" class="btn btn-link" name="delete" value="Verwijder">
                                <input type="hidden" name="' . $value['id'] . '" value="' . $value['id'] . '">
                                </form>
                                </ul>
                                </div>
                                </td> 
				</tr>';
            if (isset($_POST[$value['id']]) && isset($_POST['delete'])) {
                $nummer = $value['id'];
                $this->sql = "DELETE FROM agenda WHERE id = '$nummer'";
                $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute();
                echo '<META HTTP-EQUIV="Refresh" Content="0;">';
            }
            if (isset($_POST[$value['id']]) && isset($_POST['edit'])) {
                echo'<form method="post">
                    <tr>
                    <td></td>
                    <td>Datum:<input name="datum" value="' . $value['datum'] . '" type="text"></td>
                    <td>Onderwerp:<input name="onderwerp" value="' . $value['onderwerp'] . '" type="text"></td>
                    <td><input type="submit" name="update" value="update"><input type="hidden" name="' . $value['id'] . '" value="' . $value['id'] . '"> </td>
                    </tr></form>';
            }
            if (isset($_POST[$value['id']]) && isset($_POST['update'])) {
                $nummer = $value['id'];
                $datum = $_POST['datum'];
                $onderwerp = $_POST['onderwerp'];
                try {
                    $this->sql = "UPDATE agenda SET datum = '$datum', onderwerp='$onderwerp' WHERE id='$nummer'";
                    $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo '<pre>';
                    echo 'Regel: ' . $e->getLine() . '<br>';
                    echo 'Bestand: ' . $e->getFile() . '<br>';
                    echo 'Foutmelding: ' . $e->getMessage();
                    echo '</pre>';
                }
                echo '<META HTTP-EQUIV="Refresh" Content="0;">';
            }
        }
        echo '</table>';
    }

    public function tabelAgenda() {
        echo '<header>
                    <h3>Voeg agenda-items toe</h3>
                  </header>
                 <form  method="post" id="contactform">   
                            <div>
                            <label>Datum <span class="required">*</span></label>
                            <input type="date" name="dat"  id="name"/>
                            </div>
                            <div>
                            <label>Onderwerp <span class="required">*</span></label>
                            <input type="text" name="ond"  id="subject"/>
                            </div>
                            <div>
                            <input type="submit" value="Voeg Toe" name="Add" id="submit" class="btn"/>
                            </div>
                 </form>';
    }

}