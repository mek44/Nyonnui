$(document).ready(function(){
	$('#actualiser').click(function(e){
		e.preventDefault();
		var jour=$('#jour').val();
		var mois=$('#mois').val();
		var annee=$('#annee').val();
		var idEcole=$('#idEcole').val();
		
		$.get(
			'modele/statistique_presence.php',
			'jour='+jour+'&mois='+mois+'&annee='+annee+'&id_ecole='+idEcole,
			function(data){
				$('#statistique').html(data);
			},
			'text'
		);
	});
	
	
	$('#statistique').on('click', '.afficherAbsent', function(){
		var id=$(this).attr('id');
		var jour=$('#jour').val();
		var mois=$('#mois').val();
		var annee=$('#annee').val();
		
		$.get(
			'modele/statistique_presence.php',
			'id='+id+'&jour='+jour+'&mois='+mois+'&annee='+annee,
			function(data){
				$('#titreAbsent').text(data.titre);
				$('#listeAbsent').html(data.liste);
				$('#alertAbsent').modal('show');
			},
			'json'
		);
	});
});