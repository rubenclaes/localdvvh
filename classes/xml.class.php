<?php

/**
 * Description of xml
 *
 * @author Ruben
 */
class Xml {
    private $sql;
    private $dbh;
    
     public function __construct($dbh) {
           $this->dbh = $dbh;
    }
    
    public function genereerRSS()
    {           
            $this->sql = "SELECT * FROM nieuws ORDER BY datum DESC";
            $stmt = $this->dbh->prepare($this->sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute();

            $arr_gegevens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $aantalGegevens = count($arr_gegevens);
            
             for ($i=0;$i<$aantalGegevens;$i++) {
                  echo '<item>  
                           <title> '. $arr_gegevens[$i]['onderwerp'] . '</title>
                           <description>' . $arr_gegevens[$i]['artikel'] . '</description>
                           <link>http://deverenigdevriendenheusden.be/index.php?page=blogroll&#38;item='.$arr_gegevens[$i]['nummer'].'</link>     
                           <pubDate>' .  date("D, d M Y H:i:s O", strtotime($arr_gegevens[$i]['datum'])) . '</pubDate> 
                           <guid>http://deverenigdevriendenheusden.be/index.php?page=blogroll&#38;item='.$arr_gegevens[$i]['nummer'].'</guid>    
                         </item>
                         ';
            }
        }
}
