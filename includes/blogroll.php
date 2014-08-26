<div class="hero-unit">
    <?php
    require_once 'classes/reacties.class.php';
    require_once 'classes/nieuws.class.php';
    require_once 'classes/gebruikers.class.php';

    if (isset($_GET['item'])) {
        $nieuwsID = (int) $_GET['item'];
        $objNieuws = new News($dbh, $nieuwsID);
        $objNieuws->toonNieuwsItem();
    
      ?>
    <a href="index.php?page=index">Terug</a>
</div>
    <?php
        $objReactie = new Reaction($dbh, NULL, NULL, NULL, $nieuwsID);


        
        $reactieRecords = $objReactie->getReactiesEnGebruiker();
        echo '<!-- comments list -->
		<h3 id="comments">REACTIES ' . count($reactieRecords) . '</h3>
                    <ol class="commentlist">';

        foreach ($reactieRecords as $record) {
            $reactie = new Reaction($dbh, $record['nummer'], $record['gebruiker'], $record['reactie'], NULL, $record['datum']);
            $gebruiker = new User($dbh, NULL, NULL, NULL, NULL, $record['imagepath']);
            echo '
                <li class="alt" id="comment-63">
		<cite>
                    <img alt="avatar" src="' . $gebruiker->getImagepath() . '" class="avatar" height="40" width="40" />
                    <strong>' . $reactie->getGebruiker() . '</strong> zegt: <br/>
                    <span class="comment-data">' . $reactie->getDatum() . '</span>
                </cite>     
                    <div class="comment-text">
                    <p>' . $reactie->getTekst() . '</p>
                    </div>
                </li>';
            if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] >= 3)) {
                echo '<form method="post" id="loginform">
                    <input type="submit" value="delete" id="submit" class="button" name="' . $reactie->getReactieID() . '"/>';
                if (isset($_POST[$reactie->getReactieID()])) {
                    $reactie->deleteReactie();
                }
            }
        }
        echo '</ol>
		<!-- ENDS comments list -->';
        echo '</form>';



        if (isset($_POST['submit'])) {
            if (($_POST['message'] != NULL)) {
                $gebruiker = $objReactie->testInput($_SESSION['username']);
                $tekst = $objReactie->testInput($_POST['message']);
                $nieuwsID = $objReactie->testInput($_GET['item']);
                $objReactie = new Reaction($dbh, $objReactie->getReactieID(), $gebruiker, $tekst, $nieuwsID);
                $objReactie->insertReaction();
                $objReactie->lastReaction();
            } else {
                if (empty($_POST['message'])) {
                    echo '<div class="alert alert-error">Geef een bericht in.</div>';
                }
            }
        }

        if (isset($_SESSION['userrole']) && ($_SESSION['userrole'] >= 2)) {
            $objReactie->tabelComment();
        }
    }
  
    