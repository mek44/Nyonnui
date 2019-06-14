$(document).ready(function(){
	var $titreAlert=$('#titre-alert'),
		$alertDialog=$('#alert'),
		$matiere=$('#matiere'),
		$classee=$('#classe'),
		$listeClasse=$('#listeClasse'),
		$coefficient=$('#coefficient'),
		$envoyer=$('#envoyer'),
		$formAddMatiere=$('#formAddMatiere'),
		$supprimerMatiere=$('.remove-matiere'),
		$validerSuppression=$('#validerSuppression'),
		$annulerSuppression=$('#annulerSuppression'),
		$validerModification=$('#validerModification'),
		$annulerModification=$('#annulerModification'),
		$form=$('#ormAddMatiere');
	
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
	
	
	$listeClasse.change(function(){
		var selection=$('#listeClasse option:selected').val();
		
		$('#classe').val(selection);
		$('#classeASupprimer').val(selection);
		$('#classeAModifier').val(selection);
		
		$.get(
			'modele/get_matiere_classe.php',
			'id='+selection,
			function(data){
				$matiere.empty();
				
				$matiere.html(data.matiere);
				$('#tableMatiere').replaceWith(data.matiereClasse);
			},
			'json'
		);
	});
	
	$('.coefficient').blur(function(){
		var $alert=$(this).parent().next();;
		var parent=$(this).parent().parent();
		if(verificationCoefficient($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
		}
	});

	
	$('.table-responsive').on('click', '.remove-matiere', function(){
		$('#matiereASupprimer').val($(this).attr('id').split('-')[1]);
		$('#modalSuppression').modal('show');
	});
	
	
	$('.table-responsive').on('click', '.edit-matiere', function(){
		$('#matiereAModifier').val($(this).attr('id').split('-')[1]);
		$('#coefficientAModifier').val($(this).parent().prev().text());
		$('#modalModification').modal('show');
	});
	
	$envoyer.click(function(e){
		e.preventDefault();
		e.returnValue=false;
		$.post(
			$formAddMatiere.attr('action'), 
			$formAddMatiere.serialize(),
			function(data){
				if(data=='ok'){
					var nombre=$('#tableMatiere tr').length;
					var ligne='<tr><td>'+nombre+'</td>'
					ligne+='<td>'+$('#matiere option:selected').text()+'</td>';
					ligne+='<td>'+$coefficient.val()+'</td>';
					ligne+='<td style="text-align:center;"><span class="glyphicon glyphicon-edit edit-matiere" id="editMatiere-'+$('#matiere option:selected').val()+'"></span></td>';
					ligne+='<td style="text-align:center;"><span class="glyphicon glyphicon-remove remove-matiere" id="removeMatiere-'+$('#matiere option:selected').val()+'"></span></td>';
					ligne+='</tr>';
					
					$('#tableMatiere').append(ligne);
					$('#matiere option:selected').remove();
				}else{
					$('.modal-content').addClass('echec');
					$('#alert').modal('show');
					
					setTimeout(function(){
						$('#alert').modal('hide');
					}, 3000);
				}
			},
			'text'
		);
	});
		
	
	$validerSuppression.click(function(e){
		e.preventDefault();
		e.returnValue=false;
		
		$formSuppression=$('#suppression');
		
		$.post(
			$formSuppression.attr('action'), 
			$formSuppression.serialize(),
			function(data){
				if(data=='supprimer'){
					var $cellSup=$('#removeMatiere-'+$('#matiereASupprimer').val()).parent();
					var nomMatiereSupprime=$cellSup.prev().prev().prev().text();
					$cellSup.parent().remove();
					
					var option='<option value="'+$('#matiereASupprimer').val()+'">'+nomMatiereSupprime+'</option>';
					$('#matiere').append(option);
					$('#modalSuppression').modal('hide');
				}
			},
			'text'
		);
	});
	
	
	$annulerSuppression.click(function(){
		$('#modalSuppression').modal('hide');
	});
	
	
	$validerModification.click(function(e){
		e.preventDefault();
		e.returnValue=false;
		
		$formModification=$('#modification');
		
		$.post(
			$formModification.attr('action'), 
			$formModification.serialize(),
			function(data){
				if(data=='modifier'){
					var $cellMod=$('#editMatiere-'+$('#matiereAModifier').val()).parent();
					$cellMod.prev().text($('#coefficientAModifier').val());
					
					$('#modalModification').modal('hide');
				}
			},
			'text'
		);
	});
	
	
	$annulerModification.click(function(){
		$('#modalModification').modal('hide');
	});
	
	function verificationCoefficient(champ){
		if(/^[1-4]$/.test(champ.val())){
			return true;
		}else{
			return false;
		}
	}
});