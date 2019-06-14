$(document).ready(function(){
	var $classe=$('.classe');
	var $donneesOK=false;
	
	$classe.mouseover(function(){
		$(this).css('cursor', 'pointer');
	});
	
	$classe.click(function(){
		var id=$(this).attr('id');
		var libelle=$(this).children('td:first').text();
		
		$.get(
			'modele/liste_classe.php',
			'classe='+id,
			function(data){
				$("#tableEleve").html(data.eleve);
				$('#tableMatiere').html(data.matiere);
				$('#titreTableEleve').text('Liste des élèves '+libelle);
				$('#classe').val(id);
				$('#matiere').html(data.optionMatiere);
				$('#tableEmploie').html(data.tableEmploie);
				$('#titreTableEmploie').text('Emploie du temps '+libelle);
			},
			'json'
		);
	});
	
	$('#professeur').keyup(function(){
		var matricule=$(this).val();
		$.get(
			'modele/liste_classe.php',
			'matricule='+matricule,
			function(data){
				$('#nomProfesseur').text(data);
			},
			'text'
		);
	});
	
	$('#etablirEmploie').click(function(){
		$('#modalEmploie').modal('show');
	});
	
	$('#envoyer').click(function(e){
		e.preventDefault();
		var $form=$('#formEmploie');
		
		if($('#nomProfesseur').text()!=''){
			$.post(
				'modele/liste_classe.php',
				$form.serialize(),
				function(data){
					$('#tableEmploie').html(data);
					$('#modalEmploie').modal('hide');
				},
				'text'
			);
		}
	});
});