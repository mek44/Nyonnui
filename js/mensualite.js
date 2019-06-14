function rechercherEleve(matricule){
	$.get(
		'modele/mensualite.php',
		'matricule='+matricule,
		function(data){
			
			if(data.nombre<1){
				$('#alert').modal('show');
				
				setTimeout(function(){
					$('#alert').modal('hide');
				}, 2000);
			}else{
				$('#matricule').val(data.matricule);
				$('#nom').val(data.nom);
				$('#prenom').val(data.prenom);
				$('#sexe').val(data.sexe);
				$('#image').attr('src', 'imageseleves/'+data.photo);
				var libelle=data.niveau+' ';
/*				if(data.niveau!=13)
				{
					libelle+=data.niveau;
					if(data.niveau==1)
						libelle+='ère ';
					else
						libelle+='ème ';
				}
				else
					libelle='Terminal';
*/				
				if(data.niveau>10)
					libelle+=data.option_lycee;
			
				libelle+=data.intitule;
				$('#niveau').val(libelle);
				$('#idEleve').val(data.id);
			}
		},
		'json'
	);
}

/*
 * ajoutée par JPHN le 12/06/2019
 * ajoute une option de libellé, si celui-ci n'existe pas dans la liste
 */
function addLabel(){
    var strLibelle = prompt("Veuillez saisir le libellé à ajouter :");
    if(strLibelle){
        $('#libelle').append(new Option(strLibelle, strLibelle, true, true));

        var url = "ajouterLibelle.php";
        var params = "libelle="+strLibelle;
        var http = new XMLHttpRequest();

        http.open("GET", url+"?"+params, true);
        http.onreadystatechange = function()
            {
                if(http.readyState == 4 && http.status == 200) {
                    alert("Libellé ajouté avec succès");
                }
            }
        http.send(null);    
    }
}

$(document).ready(function(){
	var $jourPaie=$('#jourPaie'),
		$moisPaie=$('#moisPaie'),
		$anneePaie=$('#anneePaie'),
		$montant=$('#montant'),
		$reduction=$('#reduction'),
		$recu=$('#recu'),
		$titreAlert=$('#titre-alert'),
		$alertDialog=$('#alert'),
		$textAlert=$('#texte-alert');
		
	if(/succes/.test($titreAlert.text()))
	{
		$('.modal-content').removeClass('echec');
		$('.modal-content').addClass('succes');
		$textAlert.text('Enregistrement effectué avec succès');
		$titreAlert.text($titreAlert.text().substring(7));
		$alertDialog.modal('show');
		
		setTimeout(function(){
			$alertDialog.modal('hide');
		}, 3000);
	}
	else if(/echec/.test($titreAlert.text()))
	{
		$('.modal-content').removeClass('succes');
		$('.modal-content').addClass('echec');
		$textAlert.text('Les données ne sont pas valides');
		$titreAlert.text($titreAlert.text().substring(6));
		$alertDialog.modal('show');
		
		setTimeout(function(){
			$alertDialog.modal('hide');
		}, 3000);
	}
	
	$jourPaie.blur(function(){
            verificationJour($(this));	
	});
	
	$moisPaie.blur(function(){
            verificationMois($(this));
	});

	$anneePaie.blur(function(){
            verificationAnnee($(this));
	});
	
	$montant.blur(function(){
            verificationMontant($(this));
	});
	
	$reduction.blur(function(){
            if($(this).val().length>0){
                verificationMontant($(this));
            }          
	});
	
	$recu.blur(function(){
            verificationRecu($(this));
	});
	
	$('#rechercher').click(function(e){
            if(e.preventDefault())
                    e.preventDefault();
            else
                    e.returnValue=false;

            var matricule=$('#matriculeRecherche').val();

            rechercherEleve(matricule);
            $('#matriculeRecherche').val('');
	});
	
        $('#addLabel').click(function(e){
            addLabel();
        })
        
	$('#envoyer').click(function(e){
            var ok=true;

            ok=ok && verificationJour($jourPaie);
            ok=ok && verificationMois($moisPaie);
            ok=ok && verificationAnnee($anneePaie);
            ok=ok && verificationMontant($montant);
            ok=ok && verificationRecu($recu);
            if($reduction.val().length>0){
                ok=ok && verificationMontant($reduction);
            }

            ok=ok && $('#idEleve').val().length>0;

            if(!ok){
                e.preventDefault();
                $('.modal-content').removeClass('succes');
                $('.modal-content').addClass('echec');
                $('#texte-alert').text('Les données ne sont pas valides');
                $('#alert').modal('show');

                setTimeout(function(){
                        $('#alert').modal('hide');
                }, 3000);
            }
	});
        
	function verificationRecu(champ){
		var $alert=champ.parent().next();
		var parent=champ.parent().parent();
		if(champ.val().length>0){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
			champ.next().removeClass('glyphicon-remove');
			champ.next().addClass('glyphicon-ok');
			return true;
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			champ.next().removeClass('glyphicon-ok');
			champ.next().addClass('glyphicon-remove');
			$alert.slideDown();
			return false;
		}
	}
	
	function verificationMontant(champ){
		var $alert=champ.parent().next();
		var parent=champ.parent().parent();
		if(/^[0-9]+$/.test(champ.val())){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
			champ.next().removeClass('glyphicon-remove');
			champ.next().addClass('glyphicon-ok');
			return true;
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			champ.next().removeClass('glyphicon-ok');
			champ.next().addClass('glyphicon-remove');
			$alert.slideDown();
			return false;
		}
	}
		
	function verificationJour(champ){
		var jour=parseInt(champ.val());
		var $alert=$('#dangerDate');
		var parent=$(this).parent().parent();
		if(/^[0-9]{1,2}$/.test(champ.val()) && jour>0 && jour<32){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
			return true;
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
			return false;
		}
	}
	
	function verificationMois(champ){
		var mois=parseInt(champ.val());
		var $alert=$('#dangerDate');
		var parent=$(this).parent().parent();
		if(/^[0-9]{1,2}$/.test(champ.val()) && mois>0 && mois<13){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
			return true;
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
			return false;
		}
	}
	
	function verificationAnnee(champ){
		var $alert=$('#dangerDate');
		var parent=$(this).parent().parent();
		if(/^[0-9]{4}$/.test(champ.val())){
			$alert.slideUp();
			parent.removeClass('has-error');
			parent.addClass('has-success');	
			return true;
		}else{
			parent.removeClass('has-success');
			parent.addClass('has-error');
			$alert.slideDown();
			return false;
		}
	}
});