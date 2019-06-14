$(document).ready(function(){
	var $personnel=$('.personnel'),
		$ajouterMatiere=$('#ajouterMatiere'),
		$validationAjoutMatiere=$('#validationAjoutMatiere'),
		$valider=$('#envoyer'),
		$modalAjoutMatiere=$('#modalAjoutMatiere'),
		$listeMatiere=$('#listeMatiere'),
		$primaire=$('#primaire'),
		$secondaire=$('#secondaire'),
		$classe=$('#classe'),
                $classeSecondaire=$('#classeSecondaire'),
                $matiere=$('#matiere');
		
	$personnel.mouseover(function(){
            $(this).css('cursor', 'pointer');
	});
	
	
	$primaire.click(function(){
            $classe.attr('disabled', false);
            $ajouterMatiere.attr('disabled', true);
	});
	
	$secondaire.click(function(){
            $classe.attr('disabled', true);
            $ajouterMatiere.attr('disabled', false);
	});
	
	$ajouterMatiere.click(function(e){
            if(e.preventDefault())
                    e.preventDefault();
            else
                    e.returnValue=false;

            $modalAjoutMatiere.modal('show');
		
	});
        
        $classeSecondaire.change(function(){
            var classe=$classeSecondaire.children('option:selected').val();
            
            $.get(
                    'modele/liste_personnel.php',
                    'classe='+classe,
                    function(data){
                        $matiere.html(data);
                    },
                    'html'
            );
        });
	
	
	$valider.click(function(e){
		if(e.preventDefault())
			e.preventDefault();
		else
			e.returnValue=false;
		
		var matricule=$('#personnel').val();
		
		if($primaire.is(':checked')){
			var classe=$classe.children('option:selected').val();
                        $.post(
                                'modele/liste_personnel.php',
                                'matricule='+matricule+'&classe='+classe+'&cycle=Primaire',
                                function(data){
                                   alert(data); 
                                },
                                'text'
                        );
		}else{
			var $matiereClasse=$('.matiereClasse');
			$matiereClasse.each(function(){
				var classe=$(this).children('td:first').attr('id');
				var matiere=$(this).children('td:eq(1)').attr('id');
                                $.post(
                                    'modele/liste_personnel.php',
                                    'matricule='+matricule+'&classe='+classe+'&matiere='+matiere+'&cycle=Secondaire',
                                    function(data){
                                       alert(data); 
                                    },
                                    'text'
                                );
			});
		}
	});
	
	
	$validationAjoutMatiere.click(function(e){
		if(e.preventDefault())
			e.preventDefault();
		else
			e.returnValue=false;
		
		var $matiere=$('.matiere');
                
                //$('#table').;
		$matiere.each(function(){
			if($(this).find('input').is(':checked')){
                            var classeId=parseInt($('#classeSecondaire').val());
                            var classeLabel=$('#classeSecondaire option:selected').text();
                            var matiereId=parseInt($(this).attr('id'));
                            var matiereLabel=$(this).children('td:first').text();

                            if(!estAjouterMatiereClasse(classeId, matiereId)){
                                var tr='<tr class="matiereClasse"><td id="'+classeId+'">'+classeLabel+'</td><td id="'+matiereId+'">'+matiereLabel+'</td></tr>';
                                $('#table').append(tr);
                            }
                                
			}
		});
		
		$modalAjoutMatiere.modal('hide');
	});
	
	
	
	$personnel.click(function(){
		var matricule=$(this).attr('id');
                var niveau=$(this).children('td:eq(6)').text();
		
		$.get(
			'modele/liste_personnel.php',
			'matricule='+matricule+'&niveau='+niveau,
			function(data){
                            $("#matricule").text(data.matricule);
                            $('#nom').text(data.nom);
                            $('#prenom').text(data.prenom);
                            $('#sexe').text(data.sexe);
                            $('#dateNaissance').text(data.date_naissance);
                            $('#lieuNaissance').text(data.lieu_naissance);
                            $('#telephone').text(data.telephone);
                            $('#quartier').text(data.quartier);
                            $('#dateEngagement').text(data.date_engagement);
                            $('#fonction').text(data.fonction);
                            $('#salaire').text(data.salaire_base);
                            $('#taux').text(data.taux_horaire);
                            $('#photo').attr('src', 'imagespersonnel/'+data.photo);
                            $('#personnel').val(data.matricule);

                            if(niveau==='Primaire'){
                                $primaire.prop('checked', true);
                                $classe.children('option[value='+data.classe+']').prop('selected', true);
                                $classe.attr('disabled', false);
                                $listeMatiere.html('<table class="table table-bordered table-striped table-condensed" id="table"><tr><th>Classe</th><th>Matière</th></tr></table>');
                                $ajouterMatiere.attr('disabled', true);
                            }else{
                                $secondaire.attr('checked', true);
                                $classe.attr('disabled', true);
                                $ajouterMatiere.attr('disabled', false);
                                $listeMatiere.html('<table class="table table-bordered table-striped table-condensed" id="table"><tr><th>Classe</th><th>Matière</th></tr>'+data.classe+'</table>');
                            }
                                
			},
			'json'
		);
	});
});



function estAjouterMatiereClasse(idClasse, idMatiere){
    var $matiereClasse=$('.matiereClasse');
    var existe=false;
    $matiereClasse.each(function(){
        
        var matiereAjoutee=parseInt($(this).children('td:eq(1)').attr('id'));
        var classeAjoutee=parseInt($(this).children('td:eq(0)').attr('id'));
        
        if(matiereAjoutee===idMatiere && classeAjoutee===idClasse){
            existe=true;
        }
    });
    
    return existe;
}