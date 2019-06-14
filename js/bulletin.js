function changeOption()
{
	var annee=$('#annee option:selected').val();
	var trimestre=$('#trimestre option:selected').val();

	$.get(
		'modele/bulletin.php',
		'annee='+annee+'&trimestre='+trimestre,
		function(data){
			$('.panel-title').text(data.title);
			$('#tableNote').html(data.note);
			$('#rang').text(data.rang);
			$('#moyenne').text(data.moyenne);
		},
		'json'
	);
}

$(document).ready(function(){
	$('#annee').change(function(){
		changeOption();
	});
	
	$('#trimestre').change(function(){
		changeOption();
	});
});