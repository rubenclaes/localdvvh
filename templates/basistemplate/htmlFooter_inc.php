<?php
require_once 'classes/nieuws.class.php';
require_once 'classes/reacties.class.php';
require_once 'classes/gebruikers.class.php';
?>


<!-- Begin Footer -->
<div class="footer">
    <div class="container">

        <div  class="widget-cols">
            <div class="span3">    
                <h3>LAATSTE NIEUWS</h3>
                <?php
                $objNieuws = new News($dbh);
                $nieuwsRecords = $objNieuws->getRecentNieuws();

                foreach ($nieuwsRecords as $nieuws) {
                    $nieuws = new News($dbh, $nieuws['nummer'], $nieuws['gebruiker'], $nieuws['email'], $nieuws['onderwerp'], $nieuws['artikel'], $nieuws['datum'], $nieuws['maand'], $nieuws['path']);
                    echo'<div class="media">';
                    $err= $nieuws->getPath();
                    if (!empty($err)) {
                        echo '<a class="pull-left" href="index.php?page=blogroll&amp;item=' . $nieuws->getNieuwsID() . '">
                        <img class="img-polaroid" height="54" width=54" src="upload/nieuws/' . $nieuws->getPath() . '" alt="niet gevonden">
                      </a>';
                    }
                    echo'<div class="media-body"><h5 class="media-heading"><a href="index.php?page=blogroll&amp;item=' . $nieuws->getNieuwsID() . '">' . $nieuws->getOnderwerp() . '</a></h5>                
                        Gepost op ' . substr($nieuws->getDatum(), 8, 2) . ' ' . $nieuws->getMaand() . '
                     </div>
		 </div>';
                }
                ?> 
            </div>

            <div class="span3">
                <h3>RECENTE REACTIES</h3>
                <?php
                $objReactie = new Reaction($dbh);
                $reactieRecords = $objReactie->getRecenteReacties();

                foreach ($reactieRecords as $record) {
                    $reactie = new Reaction($dbh, NULL, $record['gebruiker'], $record['reactie'], $record['itemnumber'], $record['datum']);
                    $gebruiker = new User($dbh, NULL, NULL, NULL, NULL, $record['imagepath']);
                    echo '<div class="media">';
                    $err=$gebruiker->getImagepath();
                    if (!empty($err)) {
                        echo '<a class="thumbnail pull-left" href="?page=blogroll&amp;item=' . $reactie->getNieuwsID() . '" title="lees reactie"">';
                    }
                    echo' '
                    . '<img class="img-polaroid" width="54" height="54" src="' . $gebruiker->getImagepath() . '" alt="niet gevonden">
                                 </a>
               <div class="media-body">
               <a href="?page=blogroll&amp;item=' . $reactie->getNieuwsID() . '" title="lees reactie"">
                <strong> ' . $reactie->getGebruiker() . '</strong></a><br>
                <p> ' . substr($reactie->getTekst(), 0, 10) . '...</p>
               </div>
              
		</div>';
                }
                ?>
            </div>


            <div class="span2">
                <h3>OUD NIEUWS</h3>
                <ul class="unstyled">
                    <?php
                    foreach ($arrArchivesItems as $strMaand => $strKey) {
                        echo'<li class="cat-item"><a href="maanden&amp;Id=' . $strKey['menuitem'] . '">' . $strKey['menuitem'] . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- ENDS widgets -->	
    </div>

    <!-- bottom -->
    <div class="container">
        <div class="footer-bottom">

            <div class="left"><p>Koninklijke Harmonie De Verenigde Vrienden Heusden 2014</p></div>

            <ul id="social-bar">
                <li><h3> <a href="http://www.facebook.com"  title="Bekijk onze Facebook pagina"><i class="icon-facebook"></i></a></h3></li>
                <li><h3><a href="feeds.php" title="RSS Feed"><i class="icon-rss"></i></a></h3></li>
                <li><h3><a href="http://plus.google.com" title="Bekijk de Google+ pagina"><i class="icon-google-plus"></i> </a></h3></li>
        </div>	
        <!-- ENDS bottom -->
    </div>
</div>
<!-- Einde Footer -->

<script>
    jQuery(document).ready(function() {
        var offset = 220;
        var duration = 500;
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.back-to-top').fadeIn(duration);
            } else {
                jQuery('.back-to-top').fadeOut(duration);
            }
        });

        jQuery('.back-to-top').click(function(event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        })
    });

    $('#email').tooltip({
        animation: 'true',
        placement: 'right',
        trigger: 'focus',
        delay: {show: 200, hide: 100}
    });
    $('#onderwerp').tooltip({
        animation: 'true',
        placement: 'right',
        trigger: 'focus',
        delay: {show: 200, hide: 100}

    });
    $('#artikel').tooltip({
        animation: 'true',
        placement: 'right',
        trigger: 'focus',
        delay: {show: 200, hide: 100}

    });


</script>

</body>
</html>