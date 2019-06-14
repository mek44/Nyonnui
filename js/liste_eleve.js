function changeOption()
{
	var classe=$('#classe option:selected').val();
	var annee=$('#annee option:selected').val();

	$.get(
		'modele/liste_eleve.php',
		'classe='+classe+'&annee='+annee,
		function(data){
			$('#tableEleve').html(data);
		},
		'text'
	);
}


function detailEleve(matricule){
	$.get(
		'modele/liste_eleve.php',
		'matricule='+matricule,
		function(data){
			if(data.nombre<1){
				$('#modalMatricule').modal('show');
				
				setTimeout(function(){
					$('#modalMatricule').modal('hide');
				}, 2000);
			}else{
				$('#matricule').text(data.matricule);
				$('#nom').text(data.nom);
				$('#prenom').text(data.prenom);
				$('#sexe').text(data.sexe);
				$('#lieuNaissance').text(data.lieu_naissance);
				$('#dateNaissance').text(data.date_naissance);
				$('#pere').text(data.pere);
				$('#mere').text(data.mere);
				$('#photo').attr('src', 'imageseleves/'+data.photo);
				$('#nomTuteur').text(data.nomTuteur);
				$('#telephone').text(data.telephone);
				$('#adresse').text(data.adresse);
				$('#dateInscription').text(data.dateInscription);
				
				var libelle=data.niveau+' ';
/*				if(data.niveau!=13)
				{
					libelle+=data.niveau;
					if(data.niveau==1)
						libelle+='ère ';
					else
						libelle+='ème ';
				}
				else
					libelle='Terminal';
*/				
				if(data.niveau>10)
					libelle+=data.option_lycee;
			
				libelle+=data.intitule;
				$('#coursDemande').text(libelle);
				$('#ecoleOrigine').text(data.ecole_origine);
				$('#pv').text(data.pv==0?'':data.pv);
				$('#rang').text(data.rang==0?'':data.rang);
				$('#session').text(data.session==0?'':data.session);
				
				$('#detailEleve').modal('show');
			}
		},
		'json'
	);
}

$(document).ready(function(){
	var $eleve=$('.eleve');
	
	$('.modal').modal({
		keyboard: false,
		show: false,
		backdrop: false
	});
	
	$('#classe').change(function(){
		changeOption();
	});
	
	$('#annee').change(function(){
		changeOption();
	});
	
	$('#afficherTous').click(function(){
		if($(this).is(':checked')){
			$('#annee').attr('disabled', true);
			$('#classe').attr('disabled', true);
			
			$.get(
				'modele/liste_eleve.php',
				'afficherTous=ok',
				function(data){
					$('#tableEleve').html(data);
				},
				'text'
			);
		}else{
			$('#annee').attr('disabled', false);
			$('#classe').attr('disabled', false);
			changeOption();
		}	
	});
	
	$('#rechercher').click(function(){
		var matricule=$('#matriculeRecherche').val();
		detailEleve(matricule);
		$('#matriculeRecherche').val('');
	});
	
	$('#tableEleve').on('mouseover', '.eleve', function(){
		$(this).css('cursor', 'pointer');
	});
	
	$('#tableEleve').on('click', '.eleve', function(){
		var id=$(this).attr('id');
		
		detailEleve(id);
	});
});