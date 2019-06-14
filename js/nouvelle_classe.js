$(document).ready(function(){
	var $textAlert=$('#texte-alert'),
		$alert=$('#alert');
	
	if(/ok/.test($textAlert.text()))
	{
		$('.modal-content').removeClass('echec');
		$('.modal-content').addClass('succes');
		$textAlert.text('Enregistrement effectué avec succès');
		$alert.modal('show');
		
		setTimeout(function(){
			$alert.modal('hide');
		}, 3000);
	}
	else if(/bad/.test($textAlert.text()))
	{
		$('.modal-content').removeClass('succes');
		$('.modal-content').addClass('echec');
		$textAlert.text('Les données ne sont pas valides');
		$alert.modal('show');
		
		setTimeout(function(){
			$alert.modal('hide');
		}, 3000);
	}
});