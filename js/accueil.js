// JavaScript Document
$(document).ready(function(){
 
    var width = $(window).width(),
       height = $(window).height();
 		 var bgi = $("#img-banniere");
		 var ratio = width / height;
		 if(ratio > 1.7){
			 bgi.attr("src","images/banniere16x9.jpg");
		 }else{
			 bgi.attr("src","images/banniere.jpg");
		 }
});