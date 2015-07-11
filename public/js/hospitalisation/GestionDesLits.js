    var base_url = window.location.toString();
    var tabUrl = base_url.split("public");
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    $(function(){
    	initialisation();
    	setTimeout(function() {
    		infoBulle();
    	}, 1000);
    });
    
    function infoBulle(){
    	/***
    	 * INFO BULLE DE LA LISTE
    	 */
    	 var tooltips = $( 'table infoBulleVue' ).tooltip({show: {effect: 'slideDown', delay: 250}});
 	     tooltips.tooltip( 'close' );
    	  $('table infoBulleVue').mouseenter(function(){
    	    var tooltips = $( 'table infoBulleVue' ).tooltip({show: {effect: 'slideDown', delay: 250}});
    	    tooltips.tooltip( 'open' );
    	  });
    }

    function initialisation(){
        var  oTable = $('#patient').dataTable
    	( {
    					"sPaginationType": "full_numbers",
    					"aLengthMenu": [3,5],
    					"iDisplayLength": 3,
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

    					"sAjaxSource": ""+tabUrl[0]+"public/hospitalisation/liste-lits-ajax", 
    					
    	}); 
        
        var asInitVals = new Array();
    
   	//le filtre du select
   	$('#filter_statut').change(function() 
   	{					
   		oTable.fnFilter( this.value );
   	});

   	//le filtre du select du type personnel
	$('#type_personnel').change(function() 
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
    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS </div>");
	    $("#hospitaliser").fadeOut(function(){$("#contenu").fadeIn("fast"); $("#division").val(""); $("#salle,#lit").html("");});
	    return false;
	});
  
    //FILTRE POUR AFFICHER LES PATIENTS LIBERER PAR LE MAJOR  
    //FILTRE POUR AFFICHER LES PATIENTS LIBERER PAR LE MAJOR  
    $('#afficherLitsDisponibles').css({'font-weight':'bold', 'font-size': '17px' });
    oTable.fnFilter( 'Litsdisponibles' );
    $('#afficherLitsDisponibles').click(function(){
    	oTable.fnFilter( 'Litsdisponibles' );
    	$('#afficherLitsOccupes').css({'font-weight':'normal', 'font-size': '14px' });
    	$('#afficherLitsIndisponibles').css({'font-weight':'normal', 'font-size': '14px'});
    	$('#afficherLitsDisponibles').css({'font-weight':'bold', 'font-size': '17px' });
    });

    $('#afficherLitsOccupes').click(function(){
    	oTable.fnFilter( 'Litsoccupes' );
    	$('#afficherLitsIndisponibles').css({'font-weight':'normal', 'font-size': '14px'});
    	$('#afficherLitsDisponibles').css({'font-weight':'normal', 'font-size': '14px'});
    	$('#afficherLitsOccupes').css({'font-weight':'bold', 'font-size': '17px' });
    });
    
    $('#afficherLitsIndisponibles').click(function(){
    	oTable.fnFilter( 'Litsindisponibles' );
    	$('#afficherLitsDisponibles').css({'font-weight':'normal', 'font-size': '14px'});
    	$('#afficherLitsOccupes').css({'font-weight':'normal', 'font-size': '14px'});
    	$('#afficherLitsIndisponibles').css({'font-weight':'bold', 'font-size': '17px'});
    });
    
    
    }
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    
    function vuedetailsLit(id){
    	$('#intitule').html($('#intitule'+id).html());
    	$('#salle').html($('#salle'+id).html());
    	$('#batiment').html($('#batiment'+id).html());
    	
    	$('#date_acquisition').html($('#date_acquisition'+id).html());
    	$('#description').html($('#description'+id).html());
    	
    	$('#date_maintenance').html($('#date_maintenance'+id).html());
    	
    	if($('#etat'+id).val() == "Bon"){
    		$('#etat').html($('#etat'+id).val());
    		$('#iconeEtat').html("<img style='padding-left: 3px;' src='/simens/public/images_icons/oui.png' />");
    	}else
    		if($('#etat'+id).val() == "Assez-bon"){
        		$('#etat').html($('#etat'+id).val());
        		$('#iconeEtat').html("<img style='padding-left: 3px;' src='/simens/public/images_icons/non.png' />");
        	}else
        		if($('#etat'+id).val() == "Mauvais"){
            		$('#etat').html($('#etat'+id).val());
            		$('#iconeEtat').html("<img style='padding-left: 3px;' src='/simens/public/images_icons/non3.png' />");

            	}
    }
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    function rendreLitIndisponible(id){
    	ConfirmationIndindisponibilte(id);
    	$( "#ConfirmationIndisponibilite" ).dialog('open');
    }
    
    function ConfirmationIndindisponibilte(id){
    	$( "#ConfirmationIndisponibilite" ).dialog({
    		resizable: false,
    		height:170,
    	    width:390,
    		autoOpen: false,
    		modal: true,
    		buttons: {
    			"Oui": function() {
    				$( this ).dialog( "close" );

    		    	var chemin = tabUrl[0]+'public/hospitalisation/occuper-lit';
    		        $.ajax({
    		            type: 'POST',
    		            url: chemin ,
    		            data:{'id_lit':id},
    		            success: function() {
    		            	vart=tabUrl[0]+'public/hospitalisation/gestion-des-lits';
    		    		    $(location).attr("href",vart);
    		            },
    		            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
    		            dataType: "html"
    		        });
    		            	
    		        return false;
    			},
    			
    			"Non": function() {
    				$( this ).dialog( "close" );             	     
    				return false;
    			}
    		}
    	});
    }
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    function ConfirmationDisponibilite(id){
    	$( "#ConfirmationDisponibilite" ).dialog({
    		resizable: false,
    		height:170,
    	    width:390,
    		autoOpen: false,
    		modal: true,
    		buttons: {
    			"Oui": function() {
    				$( this ).dialog( "close" );

    		    	var chemin = tabUrl[0]+'public/hospitalisation/liberer-lit';
    		        $.ajax({
    		            type: 'POST',
    		            url: chemin ,
    		            data:{'id_lit':id},
    		            success: function() {
    		            	vart=tabUrl[0]+'public/hospitalisation/gestion-des-lits';
    		    		    $(location).attr("href",vart);
    		            },
    		            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
    		            dataType: "html"
    		        });
    		            	
    		        return false;
    			},
    			
    			"Non": function() {
    				$( this ).dialog( "close" );             	     
    				return false;
    			}
    		}
    	});
    }
    
    function rendreLitDisponible(id){
    	ConfirmationDisponibilite(id);
    	
    	var chemin = tabUrl[0]+'public/hospitalisation/etat-lit';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data:{'id_lit':id},
            success: function(data) {
            	var result = jQuery.parseJSON(data); 
            	if(result == 'Mauvais'){
            		$('#etatLitPopup').html('ce lit est dans un mauvais état');
            		$( "#ConfirmationDisponibilite" ).dialog('open');
            	}else{
            		$('#etatLitPopup').html('');
            		$( "#ConfirmationDisponibilite" ).dialog('open');
            	}
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
        
    }
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    function Informations(id){
    	  $( "#Informations" ).dialog({
    	    resizable: false,
    	    height:375,
    	    width:485,
    	    autoOpen: false,
    	    modal: true,
    	    buttons: {
    	        "Terminer": function() {
    	            $( this ).dialog( "close" );             	     
    	            return false;
    	        }
    	    }
    	  });
    }
    
    function vuePatient(id_patient){
    	Informations(id_patient);
    	var chemin = tabUrl[0]+'public/hospitalisation/information-patient';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data:{'id_patient':id_patient},
            success: function(data) {
            	var result = jQuery.parseJSON(data);
            	$('#info-patient').html(result);
            	$( "#Informations" ).dialog('open');
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
        
    }
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    function attribuerLit(id){
    	$('#contenu').fadeOut(function(){
    		$('#contenuListePatientsAHospitaliser').fadeIn('fast');	
    	});
    }
    
    function listePatientsAHospitaliser(){
        var  oTable = $('#patientAHospitaliser').dataTable
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

    					"sAjaxSource": ""+tabUrl[0]+"public/hospitalisation/liste-patient-ajax", 
    					
    	}); 
        
        var asInitVals = new Array();
    
   	//le filtre du select
   	$('#filter_statut').change(function() 
   	{					
   		oTable.fnFilter( this.value );
   	});

   	//le filtre du select du type personnel
	$('#type_personnel').change(function() 
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

//    $("#annuler").click(function(){
//    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS </div>");
//	    $("#hospitaliser").fadeOut(function(){$("#contenu").fadeIn("fast"); $("#division").val(""); $("#salle,#lit").html("");});
//	    return false;
//	});
    
    }
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
   
//    function vuedetails(id_demande_hospi){
//    	var id_personne = $("#"+id_demande_hospi+"idPers").val();
//    	var id_cons = $("#"+id_demande_hospi+"idCons").val();
//    	var id_hosp = $("#"+id_demande_hospi+"hp").val();
//    	
//    	var chemin = tabUrl[0]+'public/hospitalisation/liberation-patient';
//        $.ajax({
//            type: 'POST',
//            url: chemin ,
//            data:{'id_personne':id_personne, 'id_cons':id_cons, 'id_hosp':id_hosp, 'id_demande_hospi':id_demande_hospi},
//            success: function(data) {
//           	         
//            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> LIB&Eacute;RATION DU PATIENT </div>");
//            	var result = jQuery.parseJSON(data);
//            	$("#contenu").fadeOut(function(){
//            		$("#vue_patient").html(result).fadeIn("fast"); 
//            		$("#annulerLiberer").click(function(){
//                    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> HOSPITALISATION </div>");
//                    	$("#vue_patient").fadeOut(function(){
//                    		$("#contenu").fadeIn("fast");
//                    	});
//                    	return false;
//            		});
//            		
//            		$("#terminerLiberer").click(function(){ 
//            			if(click_info_pat == 1){
//            				$("#titre_info_liste").trigger('click');
//            			}
//            			else{
//            				ConfirmationLiberationPatient();
//                			$("#Confirmation").dialog('open');
//            			}
//            			return false;
//            		});
//            	}); 
//            	     
//            },
//            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//            dataType: "html"
//        });
//    	
//    }
//    
//    function vueDetailsLiberation(id_demande_hospi){
//    	var id_personne = $("#"+id_demande_hospi+"idPers").val();
//    	var id_cons = $("#"+id_demande_hospi+"idCons").val();
//    	var id_hosp = $("#"+id_demande_hospi+"hp").val();
//    	
//    	var chemin = tabUrl[0]+'public/hospitalisation/info-patient-liberer';
//        $.ajax({
//            type: 'POST',
//            url: chemin ,
//            data:{'id_personne':id_personne, 'id_cons':id_cons, 'id_hosp':id_hosp, 'id_demande_hospi':id_demande_hospi},
//            success: function(data) {
//            	$("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS </div>");
//            	var result = jQuery.parseJSON(data);
//            	$("#vue_patient").html('');
//            	$("#contenu").fadeOut(function(){
//            		$("#vue_patient_liberer").html(result).fadeIn("fast"); 
//            		
//            		$("#terminerVisualisationLiberation").click(function(){
//                    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold; padding-left:20px;'><iS style='font-size: 25px;'>&curren;</iS> HOSPITALISATION </div>");
//                    	$("#vue_patient_liberer").fadeOut(function(){
//                    		$("#contenu").fadeIn("fast");
//                    	});
//                    	return false;
//            		});
//            		
//            	});
//            },
//            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//            dataType: "html"
//            
//        });
//        
//    }
//    
//    /************************************************************************************************************************/
//    /************************************************************************************************************************/
//    /************************************************************************************************************************/
//    function ConfirmationLiberationPatient(){
//    	$( "#Confirmation" ).dialog({
//    		resizable: false,
//    		height:180,
//    	    width:390,
//    		autoOpen: false,
//    		modal: true,
//    		buttons: {
//    			"Oui": function() {
//    				$( this ).dialog( "close" );
//    				
//    				setTimeout(function(){
//        				LiberationLit();
//        				$( "#ConfirmationLiberationLit" ).dialog('open');    					
//    				},300);
//
//    				return false;
//    			},
//    			
//    			"Non": function() {
//    				$( this ).dialog( "close" );             	     
//    				return false;
//    			}
//    		}
//    	});
//    }
//    
//    function LiberationLit(){
//    	$( "#ConfirmationLiberationLit" ).dialog({
//    		resizable: false,
//    		height:180,
//    	    width:390,
//    		autoOpen: false,
//    		modal: true,
//    		buttons: {
//    			"Oui": function() {
//    				$( this ).dialog( "close" );
//    				$('#liberer_lit').val(1);
//    				var formulaireLibererPatient = document.getElementById("Formulaire_Liberer_Patient_Major");
//    				formulaireLibererPatient.submit();
//    				
//    				return false;
//    			},
//    			
//    			"Non": function() {
//    				$( this ).dialog( "close" );    
//    				$('#liberer_lit').val(0);
//    				var formulaireLibererPatient = document.getElementById("Formulaire_Liberer_Patient_Major");
//    				formulaireLibererPatient.submit();
//    				
//    				return false;
//    			}
//    		}
//    	});
//    }
//
//    /************************************************************************************************************************/
//    /************************************************************************************************************************/
//    /************************************************************************************************************************/
//    /****** GESTION DES DEPLIANTS DE L'AFFICHAGE DES INFORMATIONS APRES LIBERATION DU PATIENT******/
//    
//    /**INFO HOSPITALISATION**/
//    function depliantPlus2() {
//    	$('#titre_info_hospitalisation').click(function(){
//    		$("#titre_info_hospitalisation").replaceWith(
//    			"<span id='titre_info_hospitalisation' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/plus.png' /> Infos sur l'hospitalisation "+
//    		    "</span>");
//    		animationPliantDepliant2();
//    		$('#info_hospitalisation').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    function animationPliantDepliant2() {
//    	$('#titre_info_hospitalisation').click(function(){
//    		$("#titre_info_hospitalisation").replaceWith(
//    			"<span id='titre_info_hospitalisation' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/minus.png' /> Infos sur l'hospitalisation"+
//    		    "</span>");
//    		depliantPlus2();
//    		$('#info_hospitalisation').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    /**INFO LISTE**/
//    function depliantPlus3() {
//    	$('#titre_info_liste').click(function(){ click_info_pat = 0;
//    		$("#titre_info_liste").replaceWith(
//    			"<span id='titre_info_liste' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/minus.png' /> lib&eacute;ration du patient "+
//    		    "</span>");
//    		animationPliantDepliant3();
//    		$('#info_liste').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    function animationPliantDepliant3() {
//    	$('#titre_info_liste').click(function(){ click_info_pat = 1;
//    		$("#titre_info_liste").replaceWith(
//    			"<span id='titre_info_liste' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/plus.png' /> lib&eacute;ration du patient "+
//    		    "</span>");
//    		depliantPlus3();
//    		$('#info_liste').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    /**INFO DEMANDE**/
//    function depliantPlus4() {
//    	$('#titre_info_demande').click(function(){
//    		$("#titre_info_demande").replaceWith(
//    			"<span id='titre_info_demande' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/plus.png' /> Infos sur la demande d'hospitalisation"+
//    		    "</span>");
//    		animationPliantDepliant4();
//    		$('#info_demande').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    function animationPliantDepliant4() {
//    	$('#titre_info_demande').click(function(){
//    		$("#titre_info_demande").replaceWith(
//    			"<span id='titre_info_demande' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/minus.png' /> Infos sur la demande d'hospitalisation"+
//    		    "</span>");
//    		depliantPlus4();
//    		$('#info_demande').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    /**INFO LISTE**/
//    function depliantPlus5() {
//    	$('#titre_info_liberation_liste').click(function(){
//    		$("#titre_info_liberation_liste").replaceWith(
//    			"<span id='titre_info_liberation_liste' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/minus.png' /> infos sur la lib&eacute;ration du patient "+
//    		    "</span>");
//    		animationPliantDepliant5();
//    		$('#info_liste').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    function animationPliantDepliant5() {
//    	$('#titre_info_liberation_liste').click(function(){
//    		$("#titre_info_liberation_liste").replaceWith(
//    			"<span id='titre_info_liberation_liste' style='margin-left:-10px; cursor:pointer;'>" +
//    			"<img src='"+tabUrl[0]+"public/img/light/plus.png' /> infos sur la lib&eacute;ration du patient "+
//    		    "</span>");
//    		depliantPlus5();
//    		$('#info_liste').animate({
//    			height : 'toggle'
//    		},1000);
//    		return false;
//    	});
//    }
//    
//    function initAnimation() {
//    	$('#info_hospitalisation').toggle(false);
//    	$('#info_demande').toggle(false);
//    }
    
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    /************************************************************************************************************************/
    
    