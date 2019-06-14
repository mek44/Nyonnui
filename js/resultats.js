function changeOption()
{
	var classe=$('#classe option:selected').val();
	var trimestre=$('#trimestre option:selected').val();

	$.get(
		'modele/resultats.php',
		'classe='+classe+'&trimestre='+trimestre,
		function(data){
			$('#tableEleve').html(data);
		},
		'text'
	);
}


$(document).ready(function(){
	$('#classe').change(function(){
		changeOption();
	});
	
	$('#trimestre').change(function(){
		changeOption();
	});
	
	
	$('#tableEleve').on('mouseover', '.eleve', function(){
		$(this).css('cursor', 'pointer');
	});
	
	/*$('#tableEleve').on('click', '.eleve', function(){
		var id=$(this).attr('id');
		
		detailEleve(id);
	});*/
});

