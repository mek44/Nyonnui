<?php
$mois=date('m');
$annee=date('Y');

if($mois>=9)
    $_SESSION['annee']=$annee.'-'.($annee+1);
else
    $_SESSION['annee']=($annee-1).'-'.$annee;

include_once('vue/entete.php');