$(document).ready(function(){
	$('#enregistrer').click(function(){
		var $listeEleve=$('.eleve');
		
		$('#alert').modal('show');
		var i=0;
		$listeEleve.each(function(){
			var id=$(this).attr('id');
			var motif=$(this).children('td:last').children('input:first').val();
			var present=$(this).children('td:eq(2)').children('input:first').prop('checked')?1:0;
			var jour=$('#jour').val();
			var mois=$('#mois').val();
			var annee=$('#annee').val();
			var periode=$('#periode option:selected').text();
                        
			$.post(
				'modele/controle_presence.php',
				'id='+id+'&motif='+motif+'&jour='+jour+'&mois='+mois+'&annee='+annee+'&present='+present+'&periode='+periode,
				function(data){
			
				},
				'text'
			);
			
			i++;
			if(i===$listeEleve.length){
				setTimeout(function(){
					$('#texte-alert').text('enregistrement terminé');
					
					setTimeout(function(){
						$('#alert').modal('hide');
					}, 1000);
				}, 1000);
			}
				
		});
	
	});
	
	
	$('#classe').change(function(){
            changementOption();
	});
        
        
        
        $('#jour').keyup(function(){
            changementOption();
        });
        
        
        $('#periode').change(function(){
            var classe=$('#classe option:selected').val();
            var periode=$('#periode option:selected').text();
            var jour=$('#jour').val();
            var mois=$('#mois').val();
            var annee=$('#annee').val();
            $.get(
                    'modele/controle_presence.php',
                    'classe='+classe+'&jour='+jour+'&mois='+mois+'&annee='+annee+'&periode='+periode,
                    function(data){
                            
                         $('#listeEleve').html(data);   
                    },
                    'html'
            );
        });
});



function changementOption()
{
    var classe=$('#classe option:selected').val();
    var jour=$('#jour').val();
    var mois=$('#mois').val();
    var annee=$('#annee').val();
    $.get(
            'modele/controle_presence.php',
            'classe='+classe+'&jour='+jour+'&mois='+mois+'&annee='+annee,
            function(data){
                    $('#listeEleve').html(data.eleves);
                    $('#periode').html(data.periode);
            },
            'json'
    );
}