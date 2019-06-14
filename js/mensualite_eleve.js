function rechercherEleve(matricule){
	$.get(
		'modele/mensualite_eleve.php',
		'matricule='+matricule,
		function(data){
			if(data.nombre<1){
				$('#alert').modal('show');
				
				setTimeout(function(){
					$('#alert').modal('hide');
				}, 2000);
			}else{
				$('#matricule').val(data.matricule);
				$('#nom').val(data.nom);
				$('#prenom').val(data.prenom);
				$('#sexe').val(data.sexe);
				$('#image').attr('src', 'imageseleves/'+data.photo);
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
				$('#niveau').val(libelle);
				
				$('#versement').html(data.versement);
				$('#total').text(data.total);
			}
		},
		'json'
	);
}

$(document).ready(function(){
	$('#rechercher').click(function(){
		var matricule=$('#matriculeRecherche').val();
		rechercherEleve(matricule);
		$('#matriculeRecherche').val('');
	});
});