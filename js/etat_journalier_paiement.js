$(document).ready(function(){
	
    $('#rechercher').click(function(e){
        if(e.preventDefault())
            e.preventDefault();
        else
            e.returnValue=false;

        var jour=$('#jour').val();
        var mois=$('#mois').val();
        var annee=$('#annee').val();

        $.get(
            'modele/etat_journalier_paiement.php',
            'jour='+jour+'&mois='+mois+'&annee='+annee,
            function(data){
                $('#etats').html(data);
            },
            'html'
        );

    });
});