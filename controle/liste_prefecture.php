<?php
include_once('modele/connexion_base.php');
include_once('modele/liste_prefecture.php');

$observation='';

$listeRegion=getRegion();
$listePrefecture=getPrefecture();

include_once('vue/liste_prefecture.php');