$(document).ready(function(){
	
	$('#region').change(function(){
		var region=$('#region option:selected').val();
		var cycle=$('#cycle option:selected').val();
		$.get(
			'modele/partenaires.php',
			'region='+region+'&cycle='+cycle,
			function(data){
				
				$('#listeEcole').html(data.ecole);
				$('#prefecture').html(data.prefecture);
				$('#statistique').html(data.statistique);
			},
			'json'
		);
	});
	
	
	$('#prefecture').change(function(){
		var prefecture=$('#prefecture option:selected').val();
		var cycle=$('#cycle option:selected').val();

		$.get(
			'modele/partenaires.php',
			'prefecture='+prefecture+'&cycle='+cycle,
			function(data){
				$('#listeEcole').html(data.ecoles);
				$('#statistique').html(data.statistique);
			},
			'json'
		);
	});

	$('#cycle').change(function(){
		var prefecture=$('#prefecture option:selected').val();
		var cycle=$('#cycle option:selected').val();

		$.get(
			'modele/partenaires.php',
			'prefecture='+prefecture+'&cycle='+cycle,
			function(data){
				
				$('#listeEcole').html(data.ecoles);
				$('#statistique').html(data.statistique);
			},
			'json'
		);
	});
});