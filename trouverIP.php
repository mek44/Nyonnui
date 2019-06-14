<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$to="22961202022@mtn.bj";
$message="essai d'envoi de sms via l'application nyonnui. Armand, si tu reçois ce sms, préviens moi sur whatsapp. merci togbo jipé.";
if(mail($to,'',$message)){
    echo "envoi supposé réussi chez armand";
}

$to="33658079572@mms.bouyguestelecom.fr";
$message="essai d'envoi de sms via l'application nyonnui. Armand, si tu reçois ce sms, préviens moi sur whatsapp. merci togbo jipé.";
if(mail($to,'',$message)){
    echo "envoi supposé réussi chez jp";
}

?>
