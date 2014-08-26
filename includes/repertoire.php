<?php
require_once 'classes/repertoire.class.php';
?>
<div class="hero-unit">
    <h1>Repertoire </h1>
    <hr>
    <?php
    if (isset($_GET['show'])) {
        $naam = $_GET['show'];
        $objRepertoire = new Repertoire($dbh, NULL, $naam);
        $repertoireOpNaam = $objRepertoire->getRepertoireOpNaam();

        echo '<ul class="unstyled">';
        foreach ($repertoireOpNaam as $record) {
            $repertoire = new Repertoire($dbh, $record['id'], $record['naam'], $record['componist'], $record['beschrijving']);
            echo '<h2>' . $repertoire->getNaam() . '</h2>';
            echo '<p>' . $repertoire->getComponist() . '</p>';
            echo '<p>' . $repertoire->getBeschrijving() . '</p>';
            echo '<hr>';
        }
        echo'</ul>';
    } else {
        $objRepertoire = new Repertoire($dbh);
    }
    $repertoireRecords = $objRepertoire->getRepertoireRecords();

    echo '<ul class="unstyled">';
    foreach ($repertoireRecords as $record) {
        $repertoire = new Repertoire($dbh, $record['id'], $record['naam'], $record['componist'], $record['beschrijving']);
        echo '<li><a href="index.php?page=repertoire&amp;show=' . $repertoire->getNaam() . '"><i class="icon-music"></i> ' . $repertoire->getNaam() . '</a></li>';
    }
    echo'</ul>';
    echo '          
      </div>';
    