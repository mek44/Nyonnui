$(document).ready(function(){
	var $editionCategorie=$('.edit-categorie');
	
	$editionCategorie.mouseenter(function(){
		$(this).css('cursor', 'pointer');
	});
	
	$editionCategorie.click(function(){
		var id=$(this).attr('id').split('-')[1];
		var $modal=$('#edition');
		$('#idEdit').val(id);
		$('#editLibelle').val($(this).parent().prev().text());
		
		$modal.modal('show');
	});
});