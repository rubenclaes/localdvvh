<?php
 //Controleren of de extensie 'zlib' is geladen
        if(extension_loaded('zlib')){
           //Controleren of de client 'gzip' of 'deflate' accepteert
           if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){
            $sAcceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
            $sAcceptEncoding = strtolower($sAcceptEncoding);
            if(strpos($sAcceptEncoding, 'gzip') 
            || strpos($sAcceptEncoding, 'deflate')){
                ob_start('ob_gzhandler');
            }
            unset($sAcceptEncoding);
        }
        }
        