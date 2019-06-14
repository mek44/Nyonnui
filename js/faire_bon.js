function verificationJour(champ){
    var jour=parseInt(champ.val());
    var $alert=$('#dangerDate');
    var parent=$(this).parent().parent();
    if(/^[0-9]{1,2}$/.test(champ.val()) && jour>0 && jour<32){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');	
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        $alert.slideDown();
        return false;
    }
}
	
function verificationMois(champ){
    var mois=parseInt(champ.val());
    var $alert=$('#dangerDate');
    var parent=$(this).parent().parent();
    if(/^[0-9]{1,2}$/.test(champ.val()) && mois>0 && mois<13){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');	
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        $alert.slideDown();
        return false;
    }
}

function verificationAnnee(champ){
    var $alert=$('#dangerDate');
    var parent=$(this).parent().parent();
    if(/^[0-9]{4}$/.test(champ.val())){
        $alert.slideUp();
        parent.removeClass('has-error');
        parent.addClass('has-success');	
        return true;
    }else{
        parent.removeClass('has-success');
        parent.addClass('has-error');
        $alert.slideDown();
        return false;
    }
}

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
    $nom=$('#nom'),
    $idPersonnel=$('#idPersonnel'),
    $recherche=$('#recherche'),
    $matricule=$('#matricule'),
    $prenom=$('#prenom'),
    $jour=$('#jour'),
    $mois=$('#mois'),
    $annee=$('#annee'),
    $image=$('#image'),
    $telephone=$('#telephone'),
    $montant=$('#montant'),
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
	
    $recherche.click(function(e){
        var valeur=encodeURIComponent($('#rechercheTexte').val());
        $idPersonnel.val('');
        $matricule.val('');
        $nom.val('');
        $prenom.val('');
        $image.attr('src', '');
        $telephone.text('');
        $montant.text('');

        $.get(
            'modele/faire_bon.php',
            'matricule='+valeur,
            function(data){
                $idPersonnel.val(data.id);
                $matricule.val(data.matricule);
                $nom.val(data.nom);
                $prenom.val(data.prenom);
                $image.attr('src', 'imagespersonnel/'+data.photo);
                $telephone.val(data.telephone);
            },
            'json'
        );
    });

				
    $jour.blur(function(){	
        verificationJour($(this));		
    });

    $mois.blur(function(){
        verificationMois($(this));
    });

    $annee.blur(function(){

        verificationAnnee($(this));
    });


    $montant.blur(function(){	
        verificationMontant($(this));
    });
	
					
    $envoyer.click(function(e){
        var ok=true;

        ok=ok && verificationJour($jour);
        ok=ok && verificationMois($mois);
        ok=ok && verificationAnnee($annee);
        ok=ok && verificationMontant($montant);

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