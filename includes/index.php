<?php
require_once 'classes/agenda.class.php';
require_once 'classes/nieuws.class.php';
require_once 'classes/gebruikers.class.php';
$objAgenda = new Agenda($dbh);
?>


<div id="this-carousel-id" class="carousel slide">
    <div class="carousel-inner">
        <div class="item active">
            <img src="images/slides/image1.jpg" alt="" />
            <div class="carousel-caption">
                <p>Koninklijke Harmonie De Verengide Vrienden Heusden</p>
            </div>
        </div>
        <div class="item">
            <img src="images/slides/image2.jpg" alt="" />
            <div class="carousel-caption">
                <p>Caption text here</p>
            </div>
        </div>
        <div class="item">
            <img src="images/slides/image3.jpg" alt="" />
            <div class="carousel-caption">
                <p>Caption text here</p>
            </div>
        </div>
        <div class="item">
            <img src="images/slides/image4.jpg" alt="" />
            <div class="carousel-caption">
                <p>Caption text here</p>
            </div>
        </div>
        <div class="item">
            <img src="images/slides/image5.jpg" alt="" />
            <div class="carousel-caption">
                <p>Caption text here</p>
            </div>
        </div>
        <div class="item">
            <img src="images/slides/image6.jpg" alt="" />
            <div class="carousel-caption">
                <p>Caption text here</p>
            </div>
        </div>
    </div>
    <a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
</div>

<div class="row">
    <div class="span7">
        <?php
        $objNieuws = new News($dbh);
        $total_pages = count($objNieuws->getNieuwsRecords());
        $limit = 4;
        $stages = 1;
        $page = 0;

        if (isset($_GET['ID'])) {
            $page = $_GET['ID'];
            $start = ($page - 1) * $limit;
        } else {
            $start = 0;
        }

        $nieuwsRecords = $objNieuws->selecteerNieuws($start, $limit);

        foreach ($nieuwsRecords as $nieuws) {
            $nieuws = new News($dbh, $nieuws['nummer'], $nieuws['gebruiker'], $nieuws['email'], $nieuws['onderwerp'], $nieuws['artikel'], $nieuws['datum'], $nieuws['maand'], $nieuws['path']);
            $nummer = $nieuws->getNieuwsID();
            $objReactie = new Reaction($dbh, NULL, NULL, NULL, $nummer);
            $aantalreacties = $objReactie->getAantalReacties();

            echo '
               <div class="card">
                     <h2 class="card-heading">  ' . $nieuws->getOnderwerp() . '</h2>
                       <div class="underline">
                       <p class="muted">
                       Gepost op ' . substr($nieuws->getDatum(), 8, 2) . ' ' . substr($nieuws->getMaand(), 0, 3) . '
                        </p>
                        </div>';
            $err = $nieuws->getPath();
            if (!empty($err)) {
                echo'
                   <div class=".card-heading.image">
                    <a class="thumbnail" href="blogroll&amp;item=' . $nieuws->getNieuwsID() . '">
                    <img src="upload/nieuws/' . $nieuws->getPath() . '" alt="niet gevonden">
                    </a>
                   </div>';
            }
            echo'
                  <div class="card-actions">
                    <p><a class="btn btn-success"" href="blogroll&amp;item=' . $nieuws->getNieuwsID() . '">Lees meer &raquo;</a></p>
                  </div>
                  <div class="card-comments">
                    <div class="comments-collapse-toggle">
                        <a data-toggle="collapse" data-target="#' . $nieuws->getNieuwsID() . '">' . $aantalreacties . ' reacties <i class="icon-angle-down"></i></a>
                    </div>';
            if ($aantalreacties > 0) {
                $reactieRecords = $objReactie->getReactiesEnGebruiker();
                echo '<div id="' . $nieuws->getNieuwsID() . '" class="comments collapse">';
                foreach ($reactieRecords as $record) {
                    $reactie = new Reaction($dbh, $record['nummer'], $record['gebruiker'], $record['reactie'], NULL, $record['datum']);
                    $gebruiker = new User($dbh, NULL, NULL, NULL, NULL, $record['imagepath']);
                    echo' <div class="media">
                            <a class="pull-left" href="#">
                                <img style="height:42px;max-width:42px;" class="img-circle" height="42" width="42" src="' . $gebruiker->getImagepath() . '" alt="avatar"/>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">' . $reactie->getGebruiker() . '</h4>
                                <p>' . $reactie->getTekst(). '</p>
                            </div>
                        </div>';
                }
                echo '</div>';
            }
            echo'</div>
                </div>';
        }

        if ($page == 0) {
            $page = 1;
        }
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total_pages / $limit);
        $LastPagem1 = $lastpage - 1;
        $paginate = '';
        if ($lastpage > 1) {
            $paginate .= "<div class=\"pagination\"><ul> ";
            //Previous
            if ($page > 1) {
                $paginate.= "<li><a href='index&ID=$prev'>&lt;&lt;</a></li>";
            }

            //Pages
            if ($lastpage < 7 + ($stages * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $paginate.= "<li><a href='#'> $counter</a></li>";
                    } else {
                        $paginate.= "<li><a href='index&ID=$counter'>$counter</a></li>";
                    }
                }
            } elseif ($lastpage > 5 + ($stages * 2)) {
                //Beginning only hide later pages
                if ($page < 1 + ($stages * 2)) {
                    for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                        if ($counter == $page) {
                            $paginate.="<li>$counter</li>";
                        } else {
                            $paginate.= "<li><a href='index&ID=$counter'>$counter</a></li>";
                        }
                    }
                    $paginate.= "...";
                    $paginate.= "<li><a href='index&ID=$LastPagem1'>$LastPagem1</a></li>";
                    $paginate.= "<li><a href='index&ID=$lastpage'>$lastpage</a></li>";
                }
                // Middle hide some front and some back
                elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
                    $paginate.= "<li><a href='index&ID=1'>1</a></li>";
                    $paginate.= "<li><a href='index&ID=2'>2</a></li>";
                    $paginate.="...";
                    for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                        if ($counter == $page) {
                            $paginate.="<li>$counter</li>";
                        } else {
                            $paginate.= "<li><a href='index&ID=$counter'>$counter</a></li>";
                        }
                    }
                    $paginate.= "...";
                    $paginate.= "<li><a href='index&ID=$LastPagem1'>$LastPagem1</a></li>";
                    $paginate.= "<li><a href='index&ID=$lastpage'>$lastpage</a></li>";
                }
                // End only hide early pages
                else {
                    $paginate.= "<li><a href='index&ID=1'>1</a></li>";
                    $paginate.= "<li><a href='index&ID=2'>2</a></li>";
                    $paginate.="...";
                    for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                            $paginate.="<li>$counter</li>";
                        } else {
                            $paginate.= "<li><a href='index&ID=$counter'>$counter</a></li>";
                        }
                    }
                }
            }
            // Next
            if ($page < $counter - 1) {
                $paginate.= "<li><a href='index&ID=$next'>&gt;&gt;</a></li>";
            } else {
                $paginate.= "<li>>></li>";
            }
            $paginate.="</ul></div>";
        }
        echo $paginate;
        ?>      
    </div>

    <!--Sidebar content-->
    <div class="span3">

        <div class="card">
            <h2 class="card-heading"><i class="icon-info-sign"></i> Info</h2>
            <div class="card-body">
                <p>De wekelijkse repetities vinden plaats op maandag van 19u45 tot 21u45.</p>
                <p>Voor meer informatie klik <a href="contact">hier</a>.</p>
            </div>
        </div>
        <div class="card">    
            <h2 class="card-heading"><i class="icon-calendar"></i> Activiteiten</h2>
            <div class="card-body">
                <?php
                $maandNr = date('m');
                $jaar = date('y');

                $objAgenda->toonActiviteiten($maandNr, $jaar);
                ?>
            </div>
        </div>
        <div class="card">    
            <h2 class="card-heading"><i class="icon-envelope-alt"></i> Nieuwsbrief</h2>
            <div class="card-body">
                <p>Wilt u onze nieuwsmail ontvangen zodat u op de hoogte kan blijven 
                    van onze laatste activiteiten? Schrijf u dan in via onderstaande link.
                </p>
                <p>
                    <a class="btn" href="registratie">Inschrijven</a>
                <p>
            </div>
        </div>
        <div class="card">       
            <h2 class="card-heading"><i class="icon-tags"></i> Tags</h2>
            <div class="card-body">
                <p>Wilt u onze nieuwsmail ontvangen zodat u op de hoogte kan blijven 
                    van onze laatste activiteiten? Schrijf u dan in via onderstaande link.
                </p>
            </div>
        </div>
    </div>  
</div>
