<?php
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
require_once 'classes/xml.class.php';
require_once 'classes/database.class.php';
$dbh = database::getConnection();
$objXML = new xml($dbh);
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:link href="http://deverenigdevriendenheusden.be/feeds.php" rel="self" type="application/rss+xml" />
<title>Koninklijjke Harmonie De Verenigde Vrienden Heusden-Zolder</title>
<link>http://www.deverenigdevriendenheusden.be</link>
<description>Rss Feed van onze harmonie.</description>
<language>nl-be</language>
<webMaster>ruben.claes@hotmail.be (Ruben Claes)</webMaster>
<?php
$objXML->genereerRSS();
?>
</channel>
</rss>
