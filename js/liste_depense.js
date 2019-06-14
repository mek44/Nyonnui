$(document).ready(function(){
	
	$('#rechercher').click(function(e){
		if(e.preventDefault())
			e.preventDefault();
		else
			e.returnValue=false;
		
		var categorie=$('#categorie option:selected').val();
		var jourDebut=$('#jourDebut').val();
		var moisDebut=$('#moisDebut').val();
		var anneeDebut=$('#anneeDebut').val();
		
		var jourFin=$('#jourFin').val();
		var moisFin=$('#moisFin').val();
		var anneeFin=$('#anneeFin').val();
		
		$.get(
			'modele/liste_depense.php',
			'jourDebut='+jourDebut+'&moisDebut='+moisDebut+'&anneeDebut='+anneeDebut+'&jourFin='+jourFin+'&moisFin='+moisFin+'&anneeFin='+anneeFin+'&categorie='+categorie,
			function(data){
				$('#listeDepense').html(data);
			},
			'text'
		);
		
	});
});