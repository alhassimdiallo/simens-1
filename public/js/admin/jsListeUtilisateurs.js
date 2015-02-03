    var base_url = window.location.toString();
    var tabUrl = base_url.split("public");
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    $(function(){
    	initialisation();
    	});
    function initialisation(){
        var  oTable = $('#utilisateurs').dataTable
    	( {
    					"sPaginationType": "full_numbers",
    					"aLengthMenu": [5,7,10,15],
    					"aaSorting": [], //On ne trie pas la liste automatiquement
    					"oLanguage": {
    						"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    						"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
    						"sInfoFiltered": "",
    						"sUrl": "",
    						"oPaginate": {
    							"sFirst":    "|<",
    							"sPrevious": "<",
    							"sNext":     ">",
    							"sLast":     ">|"
    							}
    					   },

    					"sAjaxSource": ""+tabUrl[0]+"public/admin/liste-utilisateurs-ajax", 
    					
    	}); 
        
        var asInitVals = new Array();
    
   	//le filtre du select
   	$('#filter_statut').change(function() 
   	{					
   		oTable.fnFilter( this.value );
   	});
   	
   	$("tfoot input").keyup( function () {
   		/* Filter on the column (the index) of this element */
   		oTable.fnFilter( this.value, $("tfoot input").index(this) );
   	} );
   	
   	/*
   	 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
   	 * the footer
   	 */
   	$("tfoot input").each( function (i) {
   		asInitVals[i] = this.value;
   	} );
   	
   	$("tfoot input").focus( function () {
   		if ( this.className == "search_init" )
   		{
   			this.className = "";
   			this.value = "";
   		}
   		
   	} );
   	
   	$("tfoot input").blur( function (i) {
   		if ( this.value == "" )
   		{
   			this.className = "search_init";
   			this.value = asInitVals[$("tfoot input").index(this)];
   		}
   	} );

    $("#annuler").click(function(){
    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES UTILISATEURS </div>");
	    $("#FormUtilisateur").fadeOut(function(){
	    	$("#contenu").fadeIn("fast"); 
	    });
	    return false;
	});
  
    }
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    function modifier(id){

         $.ajax({
            type: 'POST',
            url: tabUrl[0]+'public/admin/modifier-utilisateur' ,
            data:{'id':id},
            success: function(data) {
           	         
            	var result = jQuery.parseJSON(data);  
            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> MODIFICATION DES DONNEES </div>");
            	$("#scriptFormUtilisation").html(result);
            	$("#contenu").fadeOut(function(){$("#FormUtilisateur").fadeIn("fast"); }); 
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
         
         
   	}
    
    function viderChamp(){
    	$("#nomUtilisateur").val('');
    	$("#prenomUtilisateur").val('');
    	$("#username").val('');
    	$("#password").val('');
    	$("#fonction").val('');
    	$("#service").val('');
    }
    
    function ajouterUtilisateur(){
    	viderChamp();
    	$('#id').val("");
    	var role = $('#RoleSelect').val();
    	$('input[type=radio][name=role][value='+role+']').attr('checked', false);
    	$("#contenu").fadeOut(function(){
    		$("#FormUtilisateur").fadeIn("fast"); 
    		$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> AJOUT D'UN NOUVEL UTILISATEUR </div>");
    		
    	});
    }
    //    function affichervue(id_personne){
//    	var id_cons = $("#"+id_personne).val();
//    	var chemin = tabUrl[0]+'public/hospitalisation/info-patient';
//        $.ajax({
//            type: 'POST',
//            url: chemin ,
//            data:{'id_personne':id_personne, 'id_cons':id_cons},
//            success: function(data) {
//           	         
//            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS </div>");
//            	var result = jQuery.parseJSON(data);
//            	$("#contenu").fadeOut(function(){$("#vue_patient").html(result).fadeIn("fast"); }); 
//            	     
//            },
//            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//            dataType: "html"
//        });
//     }
//    
//    function listepatient(){
//	    $("#terminer").click(function(){
//	    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS </div>");
//  	    	$("#vue_patient").fadeOut(function(){$("#contenu").fadeIn("fast"); });
//  	    });
//    }
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
//    function hospitaliser(id_personne){
//    	
//    	var chemin = tabUrl[0]+'public/hospitalisation/info-patient-hospi';
//        $.ajax({
//            type: 'POST',
//            url: chemin ,
//            data:{'id_personne':id_personne},
//            success: function(data) {
//           	         
//            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> HOSPITALISER </div>");
//            	var result = jQuery.parseJSON(data);
//            	$("#vue_patient_hospi").html(result);
//            	$("#division,#salle,#lit").val("");
//            	$("#code_demande").val($("#"+id_personne+"dh").val());
//            	$("#contenu").fadeOut(function(){$("#hospitaliser").fadeIn("fast"); }); 
//            	     
//            },
//            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//            dataType: "html"
//        });
//        
//    }
 
    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
    /*************************************************************************************************************************/
//    function getsalle(id_batiment){
//      var chemin = tabUrl[0]+'public/hospitalisation/salles';
//      $.ajax({
//        type: 'POST',
//        url: chemin ,
//        data:'id_batiment='+id_batiment,
//        success: function(data) {
//        	     var result = jQuery.parseJSON(data);  
//        	     $("#salle").html(result); 
//        },
//        error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//        dataType: "html"
//      });
//    }
//    
//    function getlit(id_salle){ 
//    	var chemin = tabUrl[0]+'public/hospitalisation/lits';
//    	$.ajax({
//            type: 'POST',
//            url: chemin ,
//            data:'id_salle='+id_salle,
//            success: function(data) {
//            	     var result = jQuery.parseJSON(data);  
//            	     $("#lit").html(result); 
//            },
//            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//            dataType: "html"
//        });
//    }

    