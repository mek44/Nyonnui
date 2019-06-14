function verificationPhone(champ){
    var $alert=champ.parent().next();
    var parent=champ.parent().parent();
    
    if(/^[0-9][-0-9. ]+$/.test(champ.val())){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');
        champ.next().removeClass('glyphicon-remove');
        champ.next().addClass('glyphicon-ok');
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        champ.next().removeClass('glyphicon-ok');
        champ.next().addClass('glyphicon-remove');
        $alert.slideDown();
        return false;
    }
}

function verificationTaille(champ, taille){
    var $alert=champ.parent().next();
    var parent=champ.parent().parent();
    
    if(champ.val().length>=taille){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');
        champ.next().removeClass('glyphicon-remove');
        champ.next().addClass('glyphicon-ok');
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        champ.next().removeClass('glyphicon-ok');
        champ.next().addClass('glyphicon-remove');
        $alert.slideDown();
        return false;
    }
}



function verificationJour(champ, alert){
    var parent=champ.parent().parent();
    var $alert=$('#'+alert);
    var jour=parseInt(champ.val());

    if(/^[0-9]{1,2}$/.test(champ.val()) && jour>0 && jour<32){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');
        champ.next().removeClass('glyphicon-remove');
        champ.next().addClass('glyphicon-ok');
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        champ.next().removeClass('glyphicon-ok');
        champ.next().addClass('glyphicon-remove');
        $alert.slideDown();
        return false;
    }
}

function verificationMois(champ, alert){
    var parent=champ.parent().parent();
    var $alert=$('#'+alert);
    var mois=parseInt(champ.val());

    if(/^[0-9]{1,2}$/.test(champ.val()) && mois>0 && mois<13){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');
        champ.next().removeClass('glyphicon-remove');
        champ.next().addClass('glyphicon-ok');
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        champ.next().removeClass('glyphicon-ok');
        champ.next().addClass('glyphicon-remove');
        $alert.slideDown();
        return false;
    }
}

function verificationAnnee(champ, alert){
    var parent=champ.parent().parent();
    var $alert=$('#'+alert);
    if(/^[0-9]{4}$/.test(champ.val())){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');
        champ.next().removeClass('glyphicon-remove');
        champ.next().addClass('glyphicon-ok');
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        champ.next().removeClass('glyphicon-ok');
        champ.next().addClass('glyphicon-remove');
        $alert.slideDown();
        return false;
    }
}

function verificationEmail(champ){
    var parent=champ.parent().parent();
    var $alert=champ.parent().next();
    if(champ.val().length>0 && !/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/.test(champ.val())){
        parent.removeClass('has-success');
        parent.addClass('has-error');
        champ.next().removeClass('glyphicon-ok');
        champ.next().addClass('glyphicon-remove');
        $alert.slideDown();
        return false;
    }else{
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');
        champ.next().removeClass('glyphicon-remove');
        champ.next().addClass('glyphicon-ok');
        return true;
    }       
}
        
$(document).ready(function(){
    var $textAlert=$('#texte-alert'),
    $alertDialog=$('#alert'),
    $jourNaissance=$('#jourNaissance'),
    $moisNaissance=$('#moisNaissance'),
    $anneeNaissance=$('#anneeNaissance'),
    $telephone=$('#telephone'),
    $telephoneContact=$('#telephone_contact'),
    $email=$('#email'),
    $texte=$('.texte'),
    $envoyer=$('#envoyer');

    if(/ok/.test($textAlert.text()))
    {
        $('.modal-content').removeClass('echec');
        $('.modal-content').addClass('succes');
        $textAlert.text('Enregistrement effectué avec succès');
        $alertDialog.modal('show');

        setTimeout(function(){
                $alertDialog.modal('hide');
        }, 3000);
    }
    else if(/bad/.test($textAlert.text()))
    {
        $('.modal-content').removeClass('succes');
        $('.modal-content').addClass('echec');
        $textAlert.text('Les données ne sont pas valides');
        $alertDialog.modal('show');

        setTimeout(function(){
                $alertDialog.modal('hide');
        }, 3000);
    }

    $texte.blur(function(){
        verificationTaille($(this), 1);
    });

    $jourNaissance.blur(function(){
        verificationJour($(this), 'dangerDateNais');
    });

    $moisNaissance.blur(function(){
        verificationMois($(this), 'dangerDateNais');
    });

    $anneeNaissance.blur(function(){
        verificationAnnee($(this), 'dangerDateNais');
    });

    $telephone.blur(function(){
        verificationPhone($(this));
    });
    
    $email.blur(function(){
        verificationEmail($(this));
    });

    $envoyer.click(function(e){
        var ok=true;
        $texte.each(function(){
            ok=ok && verificationTaille($(this), 1);
            
        });

        ok=ok && verificationJour($jourNaissance, 'dangerDateNais');
        ok=ok && verificationMois($moisNaissance, 'dangerDateNais');
        ok=ok && verificationAnnee($anneeNaissance, 'dangerDateNais');
        ok=ok && verificationPhone($telephone);
        ok=ok && verificationEmail($email);
        ok=ok && verificationPhone($telephoneContact);
        
        if(!ok){
            e.preventDefault();
            $('.modal-content').removeClass('succes');
            $('.modal-content').addClass('echec');
            $textAlert.text('Les données ne sont pas valides');
            $alertDialog.modal('show');

            setTimeout(function(){
                    $alertDialog.modal('hide');
            }, 3000);
        }
    });		
});