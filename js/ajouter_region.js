$(document).ready(function(){
	var $titreAlert=$('#titre-alert'),
		$alertDialog=$('#alert'),
		$nom=$('#nom'),
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
					
	$envoyer.click(function(e){
		var ok=true;
		ok=ok && verificationNom($nom);
		
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
	
	function verificationNom(champ){
		if(champ.val().length>3)
			return true;
		else
			return false;
	}
});