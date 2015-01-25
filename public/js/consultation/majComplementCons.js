var base_url = window.location.toString();
var tabUrl = base_url.split("public");

$(function() {
	
	/**
	 * CACHER TOUTES LES LIGNES DES EXAMENS MORPHOLOGIQUES
	 * CACHER TOUTES LES LIGNES DES EXAMENS MORPHOLOGIQUES
	 */
	 $('.imageRadio').toggle(false);
	  
	/**
	 * RECUPER LE TYPE D'EXAMEN AU SURVOL SUR CELUI CI
	 */
	 $('.imageRadio').hover(function(){
		 document.getElementById('typeExamen_tmp').value = 8;
	 });
	 /**
      * RECUPER LE TYPE D'EXAMEN AU SURVOL SUR CELUI CI
	  */
	 $('.imageEchographie').hover(function(){
		 document.getElementById('typeExamen_tmp').value = 9;
	 });
	 
});

/***
*=======================================================================================================================================
*=======================================================================================================================================
*=======================================================================================================================================
*================ ***************RADIO ======== RADIO ======== RADIO*************** ===============
**======================================================================================================================================
*=======================================================================================================================================
*=======================================================================================================================================
*/
/**
 * Application du plugin PIKACHOOSE
 * Application du plugin PIKACHOOSE
 * Application du plugin PIKACHOOSE
 */
function scriptExamenMorpho() {
   	   var a = function(self){
       	  self.anchor.fancybox();
        };
        $("#pikame").PikaChoose({buildFinished:a,carousel:true,carouselOptions:{wrap:'circular'}});
}
/***
 * PREMIER APPEL POUR LE CHARGEMENT DES IMAGES RADIO (EXAMEN MORPHOLOGIQUES)
 * PREMIER APPEL POUR LE CHARGEMENT DES IMAGES RADIO (EXAMEN MORPHOLOGIQUES)
 * PREMIER APPEL POUR LE CHARGEMENT DES IMAGES RADIO (EXAMEN MORPHOLOGIQUES)
 */
getimagesExamensMorphologiques();
function getimagesExamensMorphologiques()
{
	 var id_cons = $("#id_cons").val();
     $.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/consultation/imagesExamensMorphologiques',
        data: {'id_cons':id_cons, 'ajout':0, 'typeExamen':8},
        success: function(data) {
            var result = jQuery.parseJSON(data);
            $("#pika2").fadeOut(function(){ 
            	$("#pika").html(result);
            	$(function(){ Recupererimage(); });
            	return false;
            }); 
      },
      error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
      dataType: "html"
    });
 }

	/**
	 * AJOUTER DES IMAGES RADIOS
	 * AJOUTER DES IMAGES RADIOS
	 * AJOUTER DES IMAGES RADIOS
	 */
    function Recupererimage(){
    	$(function(){
    	$('#AjoutImage input[type="file"]').change(function() {
    	   var file = $(this);
 		   var reader = new FileReader;
 		   
	       reader.onload = function(event) { 
	    		var img = new Image();
                //Ici on recupere l'image 
			    document.getElementById('fichier_tmp').value = img.src = event.target.result;
			    
			    /**
			     * CODE AJAX POUR L'AJOUT DE L'IMAGE DANS LA BASE DE DONNEES
			     */
			    var typeExamen = $('#typeExamen_tmp').val();
			    var id_cons = $("#id_cons").val();
		    	$.ajax({
		            type: 'POST',
		            url: tabUrl[0]+'public/consultation/imagesExamensMorphologiques',
		            data: {'ajout':1 , 'id_cons':id_cons , 'fichier_tmp': $("#fichier_tmp").val() , 'typeExamen':typeExamen},
		            success: function(data) {
		                var result = jQuery.parseJSON(data); 
		                $("#pika2").fadeOut(function(){ 
		                	$("#pika").html(result);
		                	return false;
		                }); 
		          },
		          error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
		            dataType: "html"
		        });
		    	/**
			     * FIN CODE AJAX POUR L'AJOUT DE L'IMAGE DANS LA BASE DE DONNEES
			     */
    	};
    	reader.readAsDataURL(file[0].files[0]);
    	
      });
    });
    }
    
/**
 * Appel du pop-up de confirmation de la suppression
 * Appel du pop-up de confirmation de la suppression
 * Appel du pop-up de confirmation de la suppression
 */
function raffraichirimagesExamensMorphologiques(typeExamen)
{
	 var id_cons = $("#id_cons").val();
     $.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/consultation/imagesExamensMorphologiques',
        data: {'id_cons':id_cons, 'ajout':0, 'typeExamen':typeExamen},
        success: function(data) {
            var result = jQuery.parseJSON(data);
            if(typeExamen == 8){
            	$("#pika2").fadeOut(function(){ 
                	$("#pika").html(result);
                	return false;
                });
            } else
            	if(typeExamen ==9){
            		$("#pika4").fadeOut(function(){ 
                    	$("#pika3").html(result);
                    	return false;
                    }); 
            	}
             
      },
      error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
      dataType: "html"
    });
 }

function confirmerSuppression(id, typeExamen){
 $( "#confirmation" ).dialog({
  resizable: false,
  height:170,
  width:420,
  autoOpen: false,
  modal: true,
  buttons: {
      "Oui": function() {
          $( this ).dialog( "close" );

          var id_cons = $("#id_cons").val();
          var chemin = tabUrl[0]+'public/consultation/supprimerImage';
          $.ajax({
              type: 'POST',
              url: chemin ,
              data: {'id_cons':id_cons, 'id':id , 'typeExamen':typeExamen},
              success: function() {
            	  raffraichirimagesExamensMorphologiques(typeExamen);
            	  return false;
              },
              error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
              dataType: "html"
          });
          
      },
      "Annuler": function() {
          $( this ).dialog( "close" );
      }
 }
 });
}

/**
 * Appel de la suppression
 * Appel de la suppression
 * Appel de la suppression
 */

function supprimerImage(id){
	var typeExamen = $('#typeExamen_tmp').val();
	confirmerSuppression(id, typeExamen);
	$("#confirmation").dialog('open');
}

/***
*=======================================================================================================================================
*=======================================================================================================================================
*=======================================================================================================================================
*================ ***************ECHOGRAPHIE ======== ECHOGRAPHIE ======== ECHOGRAPHIE*************** ===============
**======================================================================================================================================
*=======================================================================================================================================
*=======================================================================================================================================
*/
/**
 * Application du plugin PIKACHOOSE
 * Application du plugin PIKACHOOSE
 * Application du plugin PIKACHOOSE
 */
function scriptEchographieExamenMorpho() {
   	   var a = function(self){
       	  self.anchor.fancybox();
        };
        $("#pikameEchographie").PikaChoose({buildFinished:a,carousel:true,carouselOptions:{wrap:'circular'}});
}
/***
 * PREMIER APPEL POUR LE CHARGEMENT DES IMAGES ECHOGRAPHIE (EXAMEN MORPHOLOGIQUES)
 * PREMIER APPEL POUR LE CHARGEMENT DES IMAGES ECHOGRAPHIE (EXAMEN MORPHOLOGIQUES)
 * PREMIER APPEL POUR LE CHARGEMENT DES IMAGES ECHOGRAPHIE (EXAMEN MORPHOLOGIQUES)
 */
getimagesEchographieExamensMorphologiques();
function getimagesEchographieExamensMorphologiques()
{
	 var id_cons = $("#id_cons").val();
     $.ajax({
        type: 'POST',
        url: tabUrl[0]+'public/consultation/imagesExamensMorphologiques',
        data: {'id_cons':id_cons, 'ajout':0, 'typeExamen':9},
        success: function(data) {
            var result = jQuery.parseJSON(data);
            $("#pika4").fadeOut(function(){ 
            	$("#pika3").html(result);
            	//$(function(){ //Recupererimage(); 
            	//});
            	return false;
            }); 
      },
      error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
      dataType: "html"
    });
 }