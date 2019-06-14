function verificationPhone(champ){
	if(/^[0-9][-0-9. ]+$/.test(champ.val())){
		return true;
	}else{
		return false;
	}
}

function verificationNom(champ){
	if(champ.val().length>2)
		return true;
	else
		return false;
}

function verificationAdresse(champ){
	if(champ.val().length>=5)
		return true;
	else
		return false;
}

$(document).ready(function(){
	var $titreAlert=$('#titre-alert'),
            $alertDialog=$('#alert'),
            $nom=$('#nom'),
            $adresse=$('#adresse'),
            $telephone=$('#telephone'),
            $envoyer=$('#envoyer');

	if(/succes/.test($titreAlert.text()))
	{
            $('.modal-content').removeClass('echec');
            $('.modal-content').addClass('succes');
            $alertDialog.modal('show');

            setTimeout(function(){
                    $alertDialog.modal('hide');
            }, 3000);
	}
	else if(/echec/.test($titreAlert.text()))
	{
            $('.modal-content').removeClass('succes');
            $('.modal-content').addClass('echec');
            $alertDialog.modal('show');

            setTimeout(function(){
                    $alertDialog.modal('hide');
            }, 3000);
	}
	
						
	$nom.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationNom($(this))){
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
	
	$adresse.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationAdresse($(this))){
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
	
	$('#region').change(function(){
		var region=$('#region option:selected').val();
		$.get(
			'modele/modifier_ecole.php',
			'region='+region,
			function(data){
				$('#prefecture').html(data);
			},
			'text'
		);
	});
					
	$envoyer.click(function(e){
		var ok=true;
		ok=ok && verificationNom($nom);
		ok=ok && verificationAdresse($adresse);
		ok=ok && verificationPhone($telephone);
		
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