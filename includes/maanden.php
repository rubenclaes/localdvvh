<?php

require_once 'classes/nieuws.class.php';
?>
<div class="hero-unit">

    
<?php
if (isset($_GET['Id'])) {
    $maand = $_GET['Id'];
    $objNieuws = new News($dbh, NULL, NULL, NULL, NULL, NULL, NULL, $maand);
    $nieuwsRecords = $objNieuws->getNieuwsOpMaand();


    foreach ($nieuwsRecords as $nieuws) {
        $nieuws = new News($dbh, $nieuws['nummer'], $nieuws['gebruiker'], $nieuws['email'], $nieuws['onderwerp'], $nieuws['artikel'], $nieuws['datum'], $nieuws['maand'], $nieuws['path']);
        echo '  <header>
                    <h2>' . $nieuws->getOnderwerp() . '</h2>
                </header>
                    <p>Gepost op <time datetime="2012-02-15T13:10:40+01:00">' . $nieuws->getDatum() . '</time> door <a href="mailto:' . $nieuws->getEmail() . '">' . $nieuws->getGebruiker() . '</a></p>    
                    <p>
                        ' . $nieuws->getArtikel() . '
                    </p>';
    }
}
?>
<a href="index.php?page=index">Terug</a>
</div>
