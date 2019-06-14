$(document).ready(function(){
	var $region=$('#region');
	var $liste=$('#listePrefecture');
	var $nom=$('#nom');
	var $idPrefecture=$('#id_prefecture');
	var $listeRegion=$('#id_region option');
	var $valider=$('#valider');
	var $formPrefecture=$('#form-prefecture');
	var $listePrefecture=$('.prefecture');
	
	$region.change(function(){
		var id=$('#region option:selected').val();
		$.get(
			'modele/liste_prefecture.php',
			'id='+id,
			function(data){
				$liste.html(data);
			}, 
			'text'
		);
	});
	
	$liste.on('mouseenter', '.prefecture', function(){
		$(this).css('cursor', 'pointer');
	});
	
	$liste.on('click', '.prefecture', function(){
		var id=$(this).attr('id');
		var nom=$(this).children('td:first').text();
		var region=$(this).children('td:last').text();
		
		$idPrefecture.val(id);
		$nom.val(nom);
		$listeRegion.each(function(){
			if($(this).text()==region){
				$(this).prop('selected', true);
			}
		});
	});
	
	
	$nom.blur(function(){
		var $alert=$(this).parent().next();
		var parent=$(this).parent().parent();
		if(verificationNom($(this))){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');
			$(this).next().removeClass('glyphicon-remove');
			$(this).next().addClass('glyphicon-ok');
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$(this).next().removeClass('glyphicon-ok');
			$(this).next().addClass('glyphicon-remove');
			$alert.slideDown();
		}
	});
					
	$valider.click(function(e){
		e.preventDefault();
		var ok=true;
		ok=ok && verificationNom($nom);
		
		if(ok){
			$.post(
				$formPrefecture.attr('action'),
				$formPrefecture.serialize(),
				function(data){
					
				},
				'text'
			);
			
			var id=$('#region option:selected').val();
			$.get(
				'modele/liste_prefecture.php',
				'id='+id,
				function(data){
					$liste.html(data);
				}, 
				'text'
			);
		}
	});
});

function verificationNom(champ){
	if(champ.val().length>3)
		return true;
	else
		return false;
}