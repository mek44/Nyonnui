$(document).ready(function(){
	
    $('#classe').click(function(e){
        if(e.preventDefault())
            e.preventDefault();
        else
            e.returnValue=false;

        var classe=$(this).val();
        $.get(
            'modele/controle_paiement.php',
            'classe='+classe,
            function(data){
                $('#controle').html(data);
            },
            'html'
        );
    });
});