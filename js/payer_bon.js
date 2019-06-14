function verificationMontant(champ){
    var $alert=champ.parent().next();
    var parent=champ.parent().parent();
    if(/^[0-9]+$/.test(champ.val())){
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

$(document).ready(function(){
    var $titreAlert=$('#titre-alert'),
    $alertDialog=$('#alert'),
    $verser=$('#verser'),
    $envoyer=$('#envoyer');

    if(/succes/.test($titreAlert.text()))
    {
        $('.modal-content').removeClass('echec');
        $('.modal-content').addClass('succes');
        $('#texte-alert').text('Paiement effectué avec succès');
        $alertDialog.modal('show');

        setTimeout(function(){
                $alertDialog.modal('hide');
        }, 3000);
    }
    else if(/echec/.test($titreAlert.text()))
    {
        $('.modal-content').removeClass('succes');
        $('.modal-content').addClass('echec');
        $('#texte-alert').text('Les donées ne sont pas valides');
        $alertDialog.modal('show');

        setTimeout(function(){
                $alertDialog.modal('hide');
        }, 3000);
    }

    $verser.blur(function(){	
        verificationMontant($(this));
    });
	
					
    $envoyer.click(function(e){
        var ok=true;
        ok=ok && verificationMontant($verser);

        if(!ok){
            e.preventDefault();

            $('.modal-content').removeClass('succes');
            $('.modal-content').addClass('echec');
            $alertDialog.modal('show');

            setTimeout(function(){
                    $alertDialog.modal('hide');
            }, 3000);
        }
    });	
});