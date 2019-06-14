$(document).ready(function(){
	$('#listeUser').on('mouseover', '.utilisateur', function(){
		$(this).css('cursor', 'pointer');
	});
	
	$('#listeUser').on('click', '.utilisateur', function(){
		var id=$(this).attr('id');
		
		$('#id_user').val(id);
		$('#nom').val($(this).children('td:eq(0)').text());
		$('#adresse').val($(this).children('td:eq(1)').text());
		$('#telephone').val($(this).children('td:eq(2)').text());
		$('#login').val($(this).children('td:eq(3)').text());
		//$('#fonction').val($(this).children('td:eq(4)').text());
		//$('#region').val($(this).children('td:eq(5)').text());
		//$('#prefecture').val($(this).children('td:eq(6)').text());
		//$('#ecole').val($(this).children('td:eq(7)').text());
		
		for(var i=0; i<$('#fonction option').length; i++){
			if($('#fonction option:eq('+i+')').text()==$(this).children('td:eq(4)').text()){
				$('#fonction option:eq('+i+')').prop('selected', true);
				break;
			}
		}
		
		for(var i=0; i<$('#region option').length; i++){
			if($('#region option:eq('+i+')').text()==$(this).children('td:eq(5)').text()){
				$('#region option:eq('+i+')').prop('selected', true);
				break;
			}
		}
		
		getPrefecture($(this).children('td:eq(6)').text());
		
		getEcole($(this).children('td:eq(7)').text());
		
		if($('#fonction option:selected').text()!='Directeur général' && $('#fonction option:selected').text()!='Proviseur' &&
			$('#fonction option:selected').text()!='Principal' && $('#fonction option:selected').text()!='Directeur' && $('#fonction option:selected').text()!='Comptable')
			$('#divEcole').slideUp('slow');
		else
			$('#divEcole').slideDown('slow');
		
		$('#edition').modal('show');
	});
	
	
	$('#fonction').change(function(){
		if($('#fonction option:selected').text()=='Directeur général' || $('#fonction option:selected').text()=='Proviseur' ||
			$('#fonction option:selected').text()=='Principal' || $('#fonction option:selected').text()=='Directeur' || $('#fonction option:selected').text()=='Comptable')
			$('#divEcole').slideDown('slow');
		else
			$('#divEcole').slideUp('slow');
	});
	
	$('#region').change(function(){
		getPrefecture('');
	});
	
	$('#prefecture').change(function(){
		getEcole('');
	});
	
	
	$('#envoyer').click(function(e){
		e.preventDefault();
		$.post(
			'modele/modifier_utilisateur.php',
			$('#formModifier').serialize(),
			function(data){
				$('#listeUser').html(data);
			},
			'text'
		);
		
		$('#edition').modal('hide');
	});

});


function getPrefecture(prefecture){
	var region=$('#region option:selected').val();
	$.get(
		'modele/ajouter_utilisateur.php',
		'region='+region,
		function(data){
			$('#prefecture').html(data.prefecture);
			$('#ecole').html(data.ecole);
		},
		'json'
	);
	
	if(prefecture!=''){
		for(var i=0; i<$('#prefecture option').length; i++){
			if($('#prefecture option:eq('+i+')').text()==prefecture){
				$('#prefecture option:eq('+i+')').prop('selected', true);
				break;
			}
		}
	}
}


function getEcole(ecole){
	var prefecture=$('#prefecture option:selected').val();
	$.get(
		'modele/ajouter_utilisateur.php',
		'prefecture='+prefecture,
		function(data){
			$('#ecole').html(data);
		},
		'text'
	);
	
	if(ecole!=''){
		for(var i=0; i<$('#ecole option').length; i++){
			if($('#ecole option:eq('+i+')').text()==ecole){
				$('#ecole option:eq('+i+')').prop('selected', true);
				break;
			}
		}
	}
}