<?php

require_once 'reacties.class.php';

/**
 * News Class
 * 
 */
class News {

    private $sql;
    private $dbh;
    private $nieuwsID;
    private $gebruiker;
    private $email;
    private $onderwerp;
    private $artikel;
    private $datum;
    private $maand;
    private $nieuwsRecords;
    private $path;

    /**
     * 
     * @param type $dbh databaseverbinding 
     * @param integer $nieuwsID unieke nieuwsID
     * @param string $gebruiker gebruiker die het nieuws heeft upgeload
     * @param string $email email van de gebruik
     * @param string $onderwerp onderwerp waarover dit nieuws gaat
     * @param string $artikel artikel van het nieuws
     * @parem string $datum datum van het nieuws
     * @param string $maand de maand wanneer dit nieuws is gepost
     * @param string $path het path naar de afbeelding voor het nieuws
     */
    public function __construct($dbh, $nieuwsID = NULL, $gebruiker = NULL, $email = NULL, $onderwerp = NULL, $artikel = NULL, $datum = NULL, $maand = NULL, $path = NULL) {
        $this->dbh = $dbh;
        $this->nieuwsRecords = NULL;
        $this->nieuwsID = $nieuwsID === NULL ? $this->nieuwsID : $nieuwsID;
        $this->gebruiker = $gebruiker === NULL ? $this->gebruiker : $gebruiker;
        $this->email = $email === NULL ? $this->email : $email;
        $this->onderwerp = $onderwerp === NULL ? $this->onderwerp : $onderwerp;
        $this->artikel = $artikel === NULL ? $this->artikel : $artikel;
        $this->datum = $datum === NULL ? $this->datum : $datum;
        $this->maand = $maand === NULL ? $this->maand : $maand;
        $this->path = $path === NULL ? $this->path : $path;
    }

    public function getNieuwsRecords() {
        if ($this->nieuwsRecords == NULL) { // caching
            $this->sql = "SELECT * FROM nieuws ORDER BY datum DESC";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->nieuwsRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->nieuwsRecords;
        } else {
            return $this->nieuwsRecords;
        }
    }

    public function getNieuwsID() {
        return $this->nieuwsID;
    }

    public function getGebruiker() {
        return $this->gebruiker;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getOnderwerp() {
        return $this->onderwerp;
    }

    public function getArtikel() {
        return $this->artikel;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function getMaand() {
        return $this->maand;
    }

    public function getPath() {
        return $this->path;
    }

    public function deleteNieuws() {
        $this->sql = "DELETE FROM nieuws WHERE nummer = '$this->nieuwsID'";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        return '<META HTTP-EQUIV="Refresh" Content="0;">';
    }

    public function updateNieuws() {
        try {
            $this->sql = "UPDATE nieuws SET onderwerp =:onderwerp, artikel=:artikel WHERE nummer=:nieuwsID";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->bindParam(':onderwerp', $this->onderwerp, PDO::PARAM_STR);
            $stmt->bindParam(':artikel', $this->artikel, PDO::PARAM_STR);
            $stmt->bindParam(':nieuwsID', $this->nieuwsID, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'Regel: ' . $e->getLine() . '<br>';
            echo 'Bestand: ' . $e->getFile() . '<br>';
            echo 'Foutmelding: ' . $e->getMessage();
            echo '</pre>';
        }
    }

    public function insertNieuws() {
        $this->sql = "INSERT INTO nieuws (datum, gebruiker, email, onderwerp, artikel, maand, path) "
                . "VALUES (NOW(), :gebruiker, :email, :onderwerp, :artikel, :maand, :path)";
        $stmt = $this->dbh->prepare($this->sql);
        $stmt->bindParam(':gebruiker', $this->gebruiker);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':onderwerp', $this->onderwerp);
        $stmt->bindParam(':artikel', $this->artikel);
        $stmt->bindParam(':maand', $this->maand);
        $stmt->bindParam(':path', $this->path);
        $stmt->execute();
        if ($stmt) {
            echo '<p><div class="alert alert-success">Onderstaand bericht werd succesvol gepost.</div></p>';
        }
    }

    public function upload($bestand) {
        if (isset($_FILES["file"])) {
            $allowedExts = array("jpg", "jpeg", "gif", "png", "pdf");
            $bestandsnaam = $bestand["name"];
            $extension = end(explode(".", $bestandsnaam));
            $bestandtype = $bestand["type"];
            $bestandgrootte = $bestand["size"];
            $bestanderror = $bestand["error"];
            $bestand_temp = $bestand["tmp_name"];

            if (( ($bestandtype == "image/gif") || ($bestandtype == "image/jpeg") || ($bestandtype == "image/png") || ($bestandtype == "application/pdf") && ($bestandgrootte < 10000000) && in_array($extension, $allowedExts))) {
                if ($bestanderror > 0) {
                    echo "Return Code: " . $bestanderror . "<br>";
                } else {
                    if (file_exists("upload/nieuws/" . $bestandsnaam)) {
                        move_uploaded_file($bestand_temp, "upload/nieuws/" . $bestandsnaam);
                        echo '<p><div class="alert alert-success">Bestand is upgeload!</div></p>';
                    } else {
                        move_uploaded_file($bestand_temp, "upload/nieuws/" . $bestandsnaam);
                        echo '<p><div class="alert alert-success">Bestand is upgeload!</div></p>';
                    }
                }
            } else {
                echo '<p><div class="alert alert-error">Bestandsformaat wordt niet ondersteund. Enkel jpeg, png & pdf</div></p>';
            }
        }
    }

    public function getRecentNieuws() {
         if ($this->nieuwsRecords == NULL) { // caching
            $this->sql = "SELECT * FROM (
                        SELECT * FROM nieuws ORDER BY datum DESC LIMIT 5
                        ) sub
                       ORDER BY nummer ASC";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->nieuwsRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->nieuwsRecords;
        } else {
            return $this->nieuwsRecords;
        }  
    }

    public function selecteerNieuws($start, $limit) {
        $this->sql = "SELECT * FROM nieuws ORDER BY datum DESC LIMIT $start,$limit";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function sendMail() {
        $this->sql = "SELECT email FROM nieuwsbrief";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        $Cc = array();
//        foreach ($row as $value) {
//            array_push($Cc, $value['email']);
//        }
        $Cc = "rubenclaes@outlook.com";
        $to = "info@deverenigdevriendenheusden.be";
        $subject = $this->onderwerp;
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>Nieuwsbrief Harmonie De Verenigde Vrienden Heusden-Zolder</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </head>
                <body>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 0 0 30px 0;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                                    <tr>
                                        <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                            <img src="http://www.deverenigdevriendenheusden.be/images/logo2.png" alt="Creating Email Magic" width="300" height="230" style="display: block;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b>' . $this->onderwerp . '</b>
									</td>
								</tr>
                                                                <tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
										' . $this->artikel . '
									</td>
								</tr>
                                            </table>
                                        </td>
                                    </tr>
                                   <tr>
						<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
										&reg; ' . $this->gebruiker . ', Heusden-Zolder 2014<br/>
										<a href="#" style="color: #ffffff;"><font color="#ffffff">Uitschrijven</font></a> voor deze nieuwsbrief.
									</td>
									<td align="right">
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="http://www.twitter.com/" style="color: #ffffff;">
														<img src="http://www.nightjar.com.au/tests/magic/images/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="http://www.twitter.com/" style="color: #ffffff;">
														<img src="http://www.nightjar.com.au/tests/magic/images/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
													</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Nieuwsbrief De Verenigde Vrienden HZ  <info@deverenigdevriendenheusden.be>" . "\r\n";
//        $headers .= "Bcc:" . implode(",", $Cc) . "\r\n";
        $headers .= "Bcc:" . $Cc . "\r\n";

        mail($to, $subject, $message, $headers);
        if (mail($to, $subject, $message, $headers)) {
            echo "Mail Sent Successfully";
        } else {
            echo "Mail Not Sent";
        }
    }

    public function lastMessage() {
        $this->sql = "SELECT * FROM nieuws WHERE datum = (SELECT MAX(datum) FROM nieuws)";
        $result = $this->dbh->query($this->sql);
        $result->setFetchMode(PDO::FETCH_OBJ);
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            echo '    <p><strong>Datum: </strong>' . $row[0] . '</p>
                      <p><strong>Gebruiker: </strong>' . $row[1] . '</p>
                      <p><strong>Email: </strong>' . $row[2] . '</p>
                      <p><strong>Onderwerp: </strong>' . $row[3] . '</p>
                      <p><strong>Artikel: </strong>' . $row[4] . '</p>
                <hr/>';
        }
    }

    public function showUploads() {
        $this->sql = "SELECT * FROM upload ";
        $result = $this->dbh->query($this->sql);
        $result->setFetchMode(PDO::FETCH_OBJ);
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            echo '<p>Nummer: ' . $row[0] . '</p>
                  <p>Naam: ' . $row[1] . '</p>           
                ';
        }
    }

    public function getNieuwsOpMaand() {
        if ($this->nieuwsRecords == NULL) { // caching
            $this->sql = "SELECT * FROM nieuws WHERE maand = '$this->maand'";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();
            $this->nieuwsRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->nieuwsRecords;
        } else {
            return $this->nieuwsRecords;
        }

    }

    public function toonNieuwsItem() {
        $this->sql = "SELECT * FROM nieuws WHERE nummer = '$this->nieuwsID'";
        $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $this->nieuwsRecords = $stmt->fetch(PDO::FETCH_ASSOC);

        $objReactie = new Reaction($this->dbh, NULL, NULL, NULL, $this->nieuwsID);
        $aantalreacties = $objReactie->getAantalReacties();

        echo '
            <h1>' . $this->nieuwsRecords['onderwerp'] . '</h1>
            <hr>
            <p>Door <a class="mail" href="mailto:' . $this->nieuwsRecords['email'] . '">' . $this->nieuwsRecords['gebruiker'] . '</a>, ' . $this->nieuwsRecords['datum'] . ', reacties ' . $aantalreacties . ' </p>';
        $err= $this->nieuwsRecords['path'];
        if (!empty($err)) {
            echo '
            <div class="row-fluid">  
             <div class="span4">
            <a href="upload/nieuws/' . $this->nieuwsRecords['path'] . '">'
            . '<img class="img-polaroid" src="upload/nieuws/' . $this->nieuwsRecords['path'] . '" alt="niet gevonden" >
            </a>
            </div>
            </div>';
        }
        echo '
            <p>' . nl2br(html_entity_decode(htmlspecialchars($this->nieuwsRecords['artikel']))) . '</p>';
    }

}
