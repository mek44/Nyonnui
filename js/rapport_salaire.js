$(document).ready(function(){
	
	$('#mois').change(function(){
		var mois=$('#mois option:selected').val();
		$.get(
			'modele/rapport_salaire.php',
			'mois='+mois,
			function(data){
				$('#salaire').html(data.liste);
				$('#total').html(data.total);
			},
			'json'
		);
	});
});