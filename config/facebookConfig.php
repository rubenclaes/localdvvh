<?php
include 'Facebook/facebook.php';

$appId = '647042625369176'; //Facebook App ID
$appSecret = '55eadcc81a7a1657e59a0abc5440ae80'; // Facebook App Secret
$return_url = 'http://localhost/localdvvh/nieuws?page=nieuws';  //return url (url to script)
$homeurl = 'http://localhost/localdvvh/nieuws?page=nieuws';  //return to home
$fbPermissions = 'publish_stream,manage_pages';  //Required facebook permissions


//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));

$fbuser = $facebook->getUser();

