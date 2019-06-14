function changeDate()
{
	var jour=$('#jour').val();
	var mois=$('#mois').val();
	var annee=$('#annee').val();
	
	$.get(
		'modele/controle_enseignant.php',
		'jour='+jour+'&mois='+mois+'&annee='+annee,
		function(data){
			$('#listeEnseignant').html(data);
		},
		'text'
	);
}

$(document).ready(function(){
	
	$('.date').keyup(function(){
		changeDate();
	});
	
	$('#enregistrer').click(function(){
		var $liste=$('.enseignant');
		
		$('#alert').modal('show');
		var i=0;
		$liste.each(function(){
			var id=$(this).attr('id');
			var motif=$(this).children('td:last').children('input:first').val();
			var present=$(this).children('td:eq(5)').children('input:first').prop('checked')?1:0;
			var classe=$(this).children('td:eq(1)').attr('id');
			var matiere=$(this).children('td:eq(2)').attr('id');
			var debut=$(this).children('td:eq(3)').text();
			var fin=$(this).children('td:eq(4)').text();
			var jour=$('#jour').val();
			var mois=$('#mois').val();
			var annee=$('#annee').val();
			
			$.post(
				'modele/controle_enseignant.php',
				'id='+id+'&motif='+motif+'&jour='+jour+'&mois='+mois+'&annee='+annee+'&classe='+classe+'&matiere='+matiere+'&debut='+debut+'&fin='+fin+'&present='+present,
				function(data){
			
				},
				'text'
			);
			
			i++;
			if(i==$liste.length){
				setTimeout(function(){
					$('#texte-alert').text('enregistrement terminé');
					
					setTimeout(function(){
						$('#alert').modal('hide');
					}, 1000);
				}, 1000);
			}
				
		});
	
	});
	
});