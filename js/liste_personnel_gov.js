$(document).ready(function(){	
    $('#prefecture').change(function(){
       
        changeOption();
    });

    $('#categorie').change(function(){
        changeOption();
    });
    
    
});


function changeOption()
{
    var prefecture=$('#prefecture option:selected').val();
    var categorie=$('#categorie option:selected').val();

    $.get(
        'modele/liste_personnel_gov.php',
        'prefecture='+prefecture+'&categorie='+categorie,
        function(data){
            $('#listePersonnel').html(data.personnel);
            $('#statistique').html(data.statistique);
        },
        'json'
    );
}