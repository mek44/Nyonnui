function changeOption(){
	var $listeEleve=$('.eleve');
	$listeEleve.each(function(){
		var matricule=$(this).children('td:first').text();
		var matiere=$('#matiere option:selected').val();
		var mois=$('#mois option:selected').val();
		
		$.get(
			'modele/get_note_eleve.php',
			'matricule='+matricule+'&matiere='+matiere+'&mois='+mois,
			function(data){
				$('#'+matricule).parent().find('input').val(data);
			},
			'text'
		);
	});		
}

$(document).ready(function(){
	var $enregistrer=$('#enregistrer'),
		$annuler=$('#annuler'),
		$mois=$('#mois'),
		$matiere=$('#matiere'),
		$classe=$('#classe');
		
		
	$mois.change(function(){
		changeOption();
	});
	
	
	$matiere.change(function(){
		changeOption();
	});
	
	
	$enregistrer.click(function(){
		var $listeEleve=$('.eleve');
		var $note=$('.eleve input');
		
		var ok=true;
		$note.each(function(){
			if(!/^[0-9]{1,2}([,.][0-9]{1,2})?$/.test($(this).val())){
				ok=false
			}
		});
		
		if(ok){
			$('.modal-content').removeClass('echec');
			$('.modal-content').removeClass('succes');
			$('#texte-alert').text('Enregistrement en cours...');
			$('#alert').modal('show');
			var i=0;
			$listeEleve.each(function(){
				var matricule=$(this).children('td:first').text();
				var note=$(this).children('td:last').children('input:first').val();
				var matiere=$('#matiere option:selected').val();
				var mois=$('#mois option:selected').val();
				
				$.get(
					'modele/saisie_note.php',
					'matricule='+matricule+'&note='+note+'&matiere='+matiere+'&mois='+mois,
					function(data){
					
					},
					'text'
				);
				
				i++;
				if(i==$listeEleve.length){
					setTimeout(function(){
						$('.modal-content').addClass('succes');
						$('#texte-alert').text('enregistrement terminé');
						
						setTimeout(function(){
							$('#alert').modal('hide');
						}, 1000);
					}, 1000);
				}
					
			});
		}else{
			$('#texte-alert').text('Les notes ne sont pas valides');
			$('.modal-content').removeClass('succes');
			$('.modal-content').addClass('echec');
			$('#alert').modal('show');
			setTimeout(function(){
				$('#alert').modal('hide');
			}, 2000);
		}
	});
	
	$classe.change(function(){
		var classe=$('#classe option:selected').val();
		$.get(
			'modele/saisie_note.php',
			'classe='+classe,
			function(data){
				$('#listeEleve').html(data.eleve);
				$('#matiere').html(data.matiere);
				changeOption();
			},
			'json'
		);
	});
	
});