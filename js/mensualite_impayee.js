function changeOption()
{
	var classe=$('#classe option:selected').val();
	var mois=$('#mois option:selected').val();

	$.get(
		'modele/mensualite_impaye.php',
		'classe='+classe+'&mois='+mois,
		function(data){
			$('#versement').html(data);
		},
		'text'
	);
}

$(document).ready(function(){
	
	$('#classe').change(function(){
		changeOption();
	});
	
	$('#mois').change(function(){
		changeOption();
	});
});