function verificationJour(champ){
        var jour=parseInt(champ.val());

        if(/^[0-9]{1,2}/.test(champ.val()) && jour>0 && jour<32){
                return true;
        }else{
                return false;
        }
}

function verificationMois(champ){
        var mois=parseInt(champ.val());

        if(/^[0-9]{1,2}/.test(champ.val()) && mois>0 && mois<13){
                return true;
        }else{
                return false;
        }
}

function verificationAnnee(champ){
        if(/^[0-9]{4}/.test(champ.val())){
                return true;
        }else{
                return false;
        }
}

function verificationMontant(champ){
        var valeur=parseInt(champ.val());

        if(/^[0-9]+/.test(champ.val())){
                return true;
        }else{
                return false;
        }
}

function verificationTaux(champ){
        var taux=parseInt(champ.val());

        if(taux>0){
                return true;
        }else{
                return false;
        }
}


function calculNet()
{
    var salaire= parseInt($('#salaire').val()),
    taux=parseInt($('#taux').val()),
    volume=parseInt($('#volume').val()),
    net=0,
    $net=$('#net');
    
    if(salaire>0)
    {
        net=salaire;
        
        if(taux>0 && volume>0)
            net+=taux*volume;
    }
    
    $net.val(net);
}


$(document).ready(function(){
	var $titreAlert=$('#titre-alert'),
		$alertDialog=$('#alert'),
		$form=$('#form-inscription'),
		$nom=$('#nom'),
		$idPersonnel=$('#idPersonnel'),
		$recherche=$('#recherche'),
		$matricule=$('#matricule'),
		$prenom=$('#prenom'),
		$jour=$('#jour'),
		$mois=$('#mois'),
		$annee=$('#annee'),
		$image=$('#image'),
		$fonction=$('#fonction'),
		$salaire=$('#salaire'),
                $taux=$('#taux'),
                $volume=$('#volume'),
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
		$fonction.text('');
		$salaire.text('');
		$taux.text('');
		
		$.get(
			'modele/salaire.php',
			'matricule='+valeur,
			function(data){
				$idPersonnel.val(data.id);
				$matricule.val(data.matricule);
				$nom.val(data.nom);
				$prenom.val(data.prenom);
				$image.attr('src', 'imagespersonnel/'+data.photo);
				$salaire.val(data.salaire);
				$taux.val(data.taux);
				$fonction.val(data.fonction);
			},
			'json'
		);
		
	});
	
				
	$jour.blur(function(){
		var $alert=$('#dangerDate');
		var parent=$(this).parent().parent();
		if(verificationJour($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});
	
	$mois.blur(function(){
		var $alert=$('#dangerDate');
		var parent=$(this).parent().parent();
		if(verificationMois($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});

	$annee.blur(function(){
		var $alert=$('#dangerDate');
		var parent=$(this).parent().parent();
		if(verificationAnnee($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});

	
	/*$salaire.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationMontant($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
			$(this).next().removeClass('glyphicon-remove');
			$(this).next().addClass('glyphicon-ok');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$(this).next().removeClass('glyphicon-ok');
			$(this).next().addClass('glyphicon-remove');
			$alert.slideDown();
		}
	});
	*/
	$volume.blur(function(){
            var $alert=$(this).parent().next();
            var parent=$(this).parent().parent();
            if(verificationTaux($(this))){
                $alert.slideUp();
                parent.removeClass('has-error');
                parent.addClass('has-success');
                $(this).next().removeClass('glyphicon-remove');
                $(this).next().addClass('glyphicon-ok');
            }else{
                parent.removeClass('has-success');
                parent.addClass('has-error');
                $(this).next().removeClass('glyphicon-ok');
                $(this).next().addClass('glyphicon-remove');
                $alert.slideDown();
            }
	});
	
        $volume.keyup(function(){
            calculNet();
        });
	
					
	$envoyer.click(function(e){
		var ok=true;
		
		ok=ok && verificationJour($jour);
		ok=ok && verificationMois($mois);
		ok=ok && verificationAnnee($annee);
		ok=ok && verificationMontant($salaire);
		ok=ok && verificationMontant($taux);
		
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