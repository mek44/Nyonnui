$(document).ready(function(){
	var $textAlert=$('#texte-alert'),
		$alertDialog=$('#alert'),
		$form=$('#form-inscription'),
		$nom=$('#nom'),
		$matricule=$('#matricule'),
		$prenom=$('#prenom'),
		$jourNaissance=$('#jourNaissance'),
		$moisNaissance=$('#moisNaissance'),
		$anneeNaissance=$('#anneeNaissance'),
		$lieuNaissance=$('#lieuNaissance'),
		$pere=$('#pere'),
		$mere=$('#mere'),
		$nomTuteur=$('#nomTuteur'),
		$adresse=$('#adresse'),
		$telephone=$('#telephone'),
		$jourInscription=$('#jourInscription'),
		$moisInscription=$('#moisInscription'),
		$anneeInscription=$('#anneeInscription'),
		$pv=$('#pv'),
		$rang=$('#rang'),
		$session=$('#session'),
		$input=$('#form-inscription input'),
		$texte=$('.texte'),
		$passe=$('#passe'),
		$passeTuteur=$('#passeTuteur'),
		$choixTuteur=$('#choixTuteur'),
		$recherche=$('#recherche'),
		$validationRecherche=$('#validationRecherche'),
		$tuteur=$('#tuteur'),
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
	
	
	$choixTuteur.click(function(){
		if($(this).is(':checked')){
			$('.tuteur').attr('disabled', false);
			$recherche.attr('disabled', true);
			$validationRecherche.attr('disabled', true);
		}else{
			$('.tuteur').attr('disabled', true);
			$recherche.attr('disabled', false);
			$validationRecherche.attr('disabled', false);
		}
	});
			

	$validationRecherche.click(function(e){
		if(e.preventDefault())
			e.preventDefault();
		else
			e.returnValue=false;
		
		var telephone=$recherche.val();
		
		$.get(
			'controle/recherche_tuteur.php',
			'telephone='+telephone,
			function(data){
				if(data.nombre>0){
					$tuteur.val(data.id);
					$nomTuteur.val(data.nom);
					$adresse.val(data.adresse);
					$telephone.val(data.telephone);
					$passeTuteur.val(data.passe);
				}
			},
			'json'
		);
	});
	
	
	$texte.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationTexte($(this))){
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
				
	$jourNaissance.blur(function(){
		var $alert=$('#dangerDateNais');
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
	
	$passe.blur(function(){
		var $alert=$('#dangerPasse');
		var parent=$(this).parent().parent();
		if(verificationTexte($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});
	
	$moisNaissance.blur(function(){
		var $alert=$('#dangerDateNais');
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

	$anneeNaissance.blur(function(){
		var $alert=$('#dangerDateNais');
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

	$telephone.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationPhone($(this))){
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
	
	$jourInscription.blur(function(){
		var $alert=$('#dangerDateIns');
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
	
	$moisInscription.blur(function(){
		var $alert=$('#dangerDateIns');
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

	$anneeInscription.blur(function(){
		var $alert=$('#dangerDateIns');
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
	
	$pv.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationPVRang($(this))){
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
	
	$rang.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationPVRang($(this))){
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
	
	$session.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationSession($(this))){
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

					
	$envoyer.click(function(e){
		var ok=true;
		$texte.each(function(){
			ok=ok && verificationTexte($texte);
		});
		ok=ok && verificationJour($jourNaissance);
		ok=ok && verificationMois($moisNaissance);
		ok=ok && verificationAnnee($anneeNaissance);
		ok=ok && verificationPhone($telephone);
		ok=ok && verificationJour($jourInscription);
		ok=ok && verificationMois($moisInscription);
		ok=ok && verificationAnnee($anneeInscription);
		ok=ok && verificationPVRang($pv);
		ok=ok && verificationPVRang($rang);
		ok=ok && verificationSession($session);
		
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
		
	function verificationTexte(champ){
		if(champ.val().length>=0)
			return true;
		else
			return false;
	}
	
	
	function verificationPhone(champ){
		if(champ.val()>0 && !/^[0-9][-0-9. ]+$/.test(champ.val())){
			return false;
		}else{
			return true;
		}
	}
	
	function verificationJour(champ){
		var jour=parseInt(champ.val());
		
		if(champ.val().length>0 && (!/^[0-9]{1,2}$/.test(champ.val()) || jour<=0 || jour>=32)){
			return false;
		}else{
			return true;
		}
	}
	
	function verificationMois(champ){
		var mois=parseInt(champ.val());
		
		if(champ.val().length>0 && (!/^[0-9]{1,2}$/.test(champ.val()) || mois<=0 || mois>=13)){
			return false;
		}else{
			return true;
		}
	}
	
	function verificationAnnee(champ){
		if(champ.val().length>0 && (!/^[0-9]{4}$/.test(champ.val()))){
			return false;
		}else{
			return true;
		}
	}
	
	function verificationPVRang(champ){
		var valeur=parseInt(champ.val());
		
		if(champ.val().length>0 && (!/^[0-9]+$/.test(champ.val()) && valeur<=0)){
			return false;
		}else{
			return true;
		}
	}
	
	function verificationSession(champ){
		if(champ.val().length>0 && !/^[0-9]{4}$/.test(champ.val())){
			return false;
		}else{
			return true;
		}
	}
});