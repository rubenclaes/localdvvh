<?php
/**
 * htmlHeader_inc.php
 *
 * @ author  		Ruben Claes
 * @ copyright  	2011
 * @ license
 * @ version		1.00
 * @ date               24 december 2011
 *
 * Dit bestand genereert de html header van deze basistemplate
 *
 */

echo'
    <!DOCTYPE html>
    <html>
        <head>
            '.$strMetaTags.'
            <title>'.$strPageTitle.'</title>
            '.$styleSheets.'
                    
     
     <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
        </head>
        <body>';
