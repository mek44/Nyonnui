function changeOption()
{
	var classe=$('#classe option:selected').val();
	var mois=$('#mois option:selected').val();

	$.get(
		'modele/rapport_payement.php',
		'classe='+classe+'&mois='+mois,
		function(data){
			$('#payement').html(data.liste);
			$('#total').html(data.total);
			$('#mensualite').html(data.mensualite);
			$('#cfip').html(data.cfip);
			$('#partEcole').html(data.partEcole);
			$('#partOng').html(data.partOng);
		},
		'json'
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