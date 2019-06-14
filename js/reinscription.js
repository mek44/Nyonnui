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
		$dernierCours=$('#dernierCours');
		$pv=$('#pv'),
		$rang=$('#rang'),
		$session=$('#session'),
		$ecoleOrigine=$('#ecoleOrigine')
		$input=$('#form-inscription input'),
		$texte=$('.texte');
		$envoyer=$('#envoyer');
	
	if(/ok/.test($textAlert.text()))
	{
		$('.modal-content').removeClass('echec');
		$('.modal-content').addClass('succes');
		$textAlert.text('Enregistrement effectu� avec succ�s');
		$alertDialog.modal('show');
		
		setTimeout(function(){
			$alertDialog.modal('hide');
		}, 3000);
	}
	else if(/bad/.test($textAlert.text()))
	{
		$('.modal-content').removeClass('succes');
		$('.modal-content').addClass('echec');
		$textAlert.text('Les donn�es ne sont pas valides');
		$alertDialog.modal('show');
		
		setTimeout(function(){
			$alertDialog.modal('hide');
		}, 3000);
	}
	
						
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
		if(verificationAnnee($(this))){
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
		ok=ok && verificationTexte($texte);
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
			$textAlert.text('Les donn�es ne sont pas valides');
			$alertDialog.modal('show');
			
			setTimeout(function(){
				$alertDialog.modal('hide');
			}, 3000);
			}
	});
	
	$matricule.keyup(function(e){
		var valeur=encodeURIComponent($(this).val());
		
		$.get(
			'modele/get_infos_eleve.php',
			'matricule='+valeur,
			function(data){
				
				$nom.val(data.nom);
				$prenom.val(data.prenom);
				$('#sexe option[value="'+data.sexe+'"').prop('selected', true);
				$jourNaissance.val(data.jour);
				$moisNaissance.val(data.mois);
				$anneeNaissance.val(data.annee);
				$lieuNaissance.val(data.lieu_naissance);
				$pere.val(data.pere);
				$mere.val(data.mere);
				$nomTuteur.val(data.nomTuteur);
				$adresse.val(data.adresse);
				$telephone.val(data.telephone);
				$ecoleOrigine.val(data.ecole_origine);
				$pv.val(data.pv);
				$rang.val(data.rang);
				$session.val(data.session);
				var classe=data.niveau+' ';
/*				if(data.niveau!=13){
					classe=data.niveau;
					if(data.niveau==1)
						classe+='�re';
					else
						classe+='�me';
				}
				else
					classe='Terminal';
*/					
				$dernierCours.val(classe+' '+data.option_lycee+' '+data.intitule);
			},
			'json'
		);
	});
		
	function verificationTexte(champ){
		if(champ.val().length>1)
			return true;
		else
			return false;
	}
	
	
	function verificationPhone(champ){
		if(/^[0-9][-0-9. ]+$/.test(champ.val())){
			return true;
		}else{
			return false;
		}
	}
	
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
	
	function verificationPVRang(champ){
		var valeur=parseInt(champ.val());
		
		if(champ.val().length>0 && (!/^[0-9]+/.test(champ.val()) && valeur<=0)){
			return false;
		}else{
			return true;
		}
	}
	
	function verificationSession(champ){
		if(champ.val().length>0 && !/^[0-9]{4}/.test(champ.val())){
			return false;
		}else{
			return true;
		}
	}
});