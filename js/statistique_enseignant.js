$(document).ready(function(){
	$('#actualiser').click(function(e){
		e.preventDefault();
		var jour=$('#jour').val();
		var mois=$('#mois').val();
		var annee=$('#annee').val();
		var prefecture=$('#prefecture option:selected').val();
		
		$.get(
			'modele/statistique_enseignant.php',
			'jour='+jour+'&mois='+mois+'&annee='+annee+'&prefecture='+prefecture,
			function(data){
				$('#statistique').html(data);
			},
			'text'
		);
	});
	
	
	$('#region').change(function(){
		var region=$('#region option:selected').val();
		
		$.get(
			'modele/statistique_enseignant.php',
			'region='+region,
			function(data){
				$('#prefecture').html(data);
			},
			'text'
		);
	});
	
	
	$('#statistique').on('click', '.afficherAbsent', function(){
		var id=$(this).attr('id');
		var jour=$('#jour').val();
		var mois=$('#mois').val();
		var annee=$('#annee').val();
		var ecole=$(this).parent().parent().prev().children('h1:first').text();
		
		$.get(
			'modele/statistique_enseignant.php',
			'id='+id+'&jour='+jour+'&mois='+mois+'&annee='+annee,
			function(data){
				$('#titreAbsent').text(ecole);
				$('#listeAbsent').html(data);
				$('#alertAbsent').modal('show');
			},
			'text'
		);
	});
});