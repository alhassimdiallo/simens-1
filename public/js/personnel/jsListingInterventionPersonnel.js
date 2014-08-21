
	//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(idIntervention,idAgent){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:405,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );
	            
	            var cle = idIntervention;
	            var chemin = '/simens_derniereversion/public/personnel/personnel/supprimerintervention';
	            $.ajax({
	                type: 'POST',
	                url: chemin ,
	                data: $(this).serialize(),  
	                data:({'id':cle , 'idAgent':idAgent}),
	                success: function(data) { 
	                	     var result = jQuery.parseJSON(data);  
	                	     $("#"+cle+"inter").fadeOut(function(){
	                	    	 $("#listeinterventionbis").html(result);
	                	     });
	                	     
	                	     
	                },
	                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
	                dataType: "html"
	            });
	    	     return false;
	    	     
	        },
	        "Annuler": function() {
                $( this ).dialog( "close" );
            }
	   }
	  });
    }
    
    /**********************************************************************************/
    
    function affichervue(id){
    	
    	var cle = id;
        var chemin = '/simens_derniereversion/public/personnel/personnel/vueintervention';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:{'id':cle},
            success: function(data) {
            	
            	     $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS </div>");
            	     var result = jQuery.parseJSON(data);  
            	     $("#contenu").fadeOut(function(){ $("#vue_patient").html(result).fadeIn("fast"); });
            	     
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
	    return false;
    }
    
    function listepatient(){
    	//Lorsqu'on clique sur terminer ça ramène la liste des patients décédés 
	    $("#terminer").click(function(){
	    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2;  color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> LE PERSONNEL </div>");
  	    	$("#vue_patient").fadeOut(function(){$("#contenu").fadeIn("fast"); });
  	    });
    }
    
    function terminerRechercheAvancee(){
    	
    	
    	$('#terminer_intervention_recherhce_avancee').click(function(){
    		$("#titre2").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS </div>");
   	    	$("#recherche_avancee").fadeOut(function(){$("#vue_patient").fadeIn("fast"); });
    	});
   

    }
    /************************************************************************************************************************/
    
    /**=========================================== PARTIE MENU INERVENTION ================================================**/
    
    /************************************************************************************************************************/
  
    function vueinterventionAgent(){
    	$( "#informations" ).dialog({
    	    resizable: false,
    	    height:305,
    	    width:600,
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
    
    function vueintervention(idIntervention){
    	vueinterventionAgent();
        var chemin = '/simens_derniereversion/public/personnel/personnel/vueinterventionagent';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:({'idIntervention':idIntervention}),
            success: function(data) {    
            	    var result = jQuery.parseJSON(data);   
            	     $("#info").html(result);
            	     
            	     $("#informations").dialog('open'); //Appel du POPUP
            	       
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
    }
    
    /***************************************************************************************/
    
    /**======================== SUPPRESSION INTERVENTION =================================**/
    
    /***************************************************************************************/
 
    function supprimerintervention(idIntervention,idAgent){
    	confirmation(idIntervention,idAgent);
        $("#confirmation").dialog('open');
    }
    
    /***************************************************************************************/
    
    /**======================== MODIFICATION INTERVENTION ================================**/
    
    /***************************************************************************************/
    function Modifierinterventions(id, idAgent){
    	$( "#modifications" ).dialog({
    	    resizable: false,
    	    height:445,
    	    width:1100,
    	    autoOpen: false,
    	    modal: true,
    	    buttons: {
    	        "Enregistrer": function() {
    	            $( this ).dialog( "close" );  
    	            var type_intervention = $('#type_intervention').val();
    	            
    	            var service_origine = $('#service_origine').val();
    	            var service_accueil = $('#service_accueil').val();
    	            var date_debut = $('#date_debut').val();
    	            var date_fin = $('#date_fin').val();
    	            var motif_intervention = $('#motif_intervention').val();
    	            var note = $('#note').val();
    	            
    	            var service_origine_externe = $('#service_origine_externe').val();
    	            var hopital_accueil  = $('#hopital_accueil').val();
    	            var service_accueil_externe = $('#service_accueil_externe').val();
    	            var date_debut_externe = $('#date_debut_externe').val();
    	            var date_fin_externe = $('#date_fin_externe').val();
    	            var motif_intervention_externe = $('#motif_intervention_externe').val();
    	            var note_externe = $('#note_externe').val();
    	            
    	            $.ajax({
    	                type: 'GET',  
    	                url: '/simens_derniereversion/public/personnel/personnel/saveintervention' ,  
    	                data: ({'id':id , 'type_intervention':type_intervention , 
    	                	'service_origine':service_origine , 'service_accueil':service_accueil, 'date_debut':date_debut, 
    	                	'date_fin':date_fin, 'motif_intervention':motif_intervention, 'note':note, 
    	                	'service_origine_externe':service_origine_externe, 'hopital_accueil':hopital_accueil, 
    	                	'service_accueil_externe':service_accueil_externe, 'date_debut_externe':date_debut_externe, 
    	                	'date_fin_externe':date_fin_externe, 'motif_intervention_externe':motif_intervention_externe,
    	                	'note_externe':note_externe
    	                	}),
    	        	    success: function() {   /*MAIS ICI ON NE SUPPRIME PAS C JUSTE POUR RAFFRAICHIR*/ 
    	        	    	
    	        	    	 $.ajax({
    	     	                type: 'GET',  
    	     	                url: '/simens_derniereversion/public/personnel/personnel/enregistrermodificationintervention' ,  
    	     	                data: {'idAgent':idAgent},
    	     	                success: function(data) {
    	     	                	     var result = jQuery.parseJSON(data); 
    			                	     $("#listeinterventionbis").html(result);
    	     	                },
    	        	    	
    	     	                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
    	    	                dataType: "html"
    	        	    	 });
    	        	    	
    	               },
    	                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
    	                dataType: "html"
    	        	});
    	        },
    	        "Annuler": function() {
                    $( this ).dialog( "close" );             	     
                    return false;
                }
    	   }
    	  });
      }
    
    function modifierintervention(idIntervention, idAgent){
    	Modifierinterventions(idIntervention,idAgent);
        var chemin = '/simens_derniereversion/public/personnel/personnel/modifierinterventionagent';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:({'idIntervention':idIntervention , 'idAgent':idAgent}),
            success: function(data) {    
            	     var result = jQuery.parseJSON(data);   
            	     $("#info_modif").html(result);
            	     
            	     $("#modifications").dialog('open'); //Appel du POPUP
            	       
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
    }
    
    /***************************************************************************************/
    
    /**========================== PAGINATION INTERVENTION ================================**/
    
    /***************************************************************************************/
 
    function pagination(){
    	
    	$(document).ready(function() {
    		//CODE POUR INITIALISER LA LISTE 
    		$('#listeintervention').each(function() {
                var currentPage = 0;
                var numPerPage = 3;
                var $table = $(this);
                  $table.find('tbody tr').hide()
                    .slice(currentPage * numPerPage, (currentPage + 1) * numPerPage)
                    .show();
    		});
    		//CODE POUR LA PAGINATION
            $('#listeintervention').each(function() {
                var currentPage = 0;
                var numPerPage = 3;
                var $table = $(this);
                var repaginate = function() {
                  $table.find('tbody tr').hide()
                    .slice(currentPage * numPerPage, (currentPage + 1) * numPerPage)
                    .show();
                };
                var numRows = $table.find('tbody tr').length;
                var numPages = Math.ceil(numRows / numPerPage);
                var $pager = $('<div class="pager"></div>');
                
                //**********************
                //POUR ALLER AU DEBUT
                //**********************
            /*    $('<button class="page-number" title="premier" style="margin-right: 5px; background: #efefef;"></button>').text('|<')
                .bind('click', {newPage: 0}, function(event) {
                  currentPage = event.data['newPage'];
                  repaginate();
                  $(this).addClass('active').css({'background': '#8e908d', 'color':'white'}).siblings().removeClass('active').css({'background': '#efefef', 'color':'black'});
                }).appendTo($pager).addClass('clickable');*/
                //***********************
                //FIN POUR ALLER AU DEBUT
                //***********************
                
                for (var page = 0; page < numPages; page++) {
                  $('<button class="page-number" style="margin-right: 5px; background: #efefef;"></button>').text(page + 1)
                    .bind('click', {newPage: page}, function(event) {
                      currentPage = event.data['newPage'];
                      repaginate();
                      $(this).addClass('active').css({'background': '#8e908d', 'color':'white'}).siblings().removeClass('active').css({'background': '#efefef', 'color':'black'});
                    }).appendTo($pager).addClass('clickable');
                }
                
                //**********************
                //POUR ALLER A LA FIN
                //**********************
             /*   $('<button class="page-number" title="premier" style="margin-right: 5px; background: #efefef;"></button>').text('>|')
                .bind('click', {newPage: page-1}, function(event) {
                  currentPage = event.data['newPage'];
                  repaginate();
                  $(this).addClass('active').css({'background': '#8e908d', 'color':'white'}).siblings().removeClass('active').css({'background': '#efefef', 'color':'black'});
                }).appendTo($pager).addClass('clickable');*/
                //***********************
                //FIN POUR ALLER A LA FIN
                //***********************
                
                $pager.insertAfter($table)
                  .find('button.page-number:first').addClass('active').css({'background': '#8e908d', 'color':'white'});
              });

            
            
            
            
            
            
  //*******************************************************************************************************************
           
  //========================================= CODE POUR FILTRER =======================================================
            
  //*******************************************************************************************************************

          
    	});
    	
    	  //*******************************************************************************************************************
        
    	  //========================================= AJOUTER UNE INTERVENTION =======================================================
    	            
    	  //*******************************************************************************************************************
    	
    	//AU CLIC SUR NOUVELLE INTERVENTION
    	$('#ajouternouvelleintervention').click(function(){
            	vart='/simens_derniereversion/public/personnel/personnel/intervention';
                $(location).attr("href",vart);
                return false;
         });
    	
    }
    
  //AU CLIC SUR RECHERCHER INTERVENTION AVANCEE
	function rechercherintervention(id){
		
        var chemin = '/simens_derniereversion/public/personnel/personnel/rechercheravanceeintervention';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:({'id':id}),
            success: function(data) {    
          	         $("#titre2").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><span style=' padding-right:10px;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS</span> <span style='text-decoration:none; font-style:italic;'>(Recherche avanc&eacute;e)</span></div>");
            	     var result = jQuery.parseJSON(data);   
            	     $("#vue_patient").fadeOut(function(){ $("#recherche_avancee").html(result).fadeIn("fast"); });
            	       
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
        
		return false;
	}
    
    function tabledata(){
    
    	    $('#listeintervention').pagination({
    	        items: 7,
    	        itemsOnPage: 3,
    	        cssStyle: 'light-theme'
    	    });

    }
    
    function initialisation(){	
    	
     var asInitVals = new Array();
	 var  oTable = $('#patientdeces').dataTable
	  ( {    
					"aaSorting": "", //pour trier la liste affichée
					"oLanguage": { 
						"sProcessing":   "Traitement en cours...",
						//"sLengthMenu":   "Afficher _MENU_ &eacute;l&eacute;ments",
						"sZeroRecords":  "Aucun &eacute;l&eacute;ment &agrave; afficher",
						"sInfo": "_TOTAL_ &eacute;l&eacute;ments",
						//"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
						"sInfoFiltered": "",
						"sInfoPostFix":  "",
						"sSearch": "",
						"sUrl": "",
						"sWidth": "30px",
						"oPaginate": {
							"sFirst":    "|<",
							"sPrevious": "",
							"sNext":     "",
							"sLast":     ">|",
						}
					   },
					   "iDisplayLength": "3",
					   				
	  } );

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
	
	$("tfoot input").keyup( function () { //Permet de rechercher par l'element saisi
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
	
	$("tfoot input").focus( function () { //reinitialise
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );
	
	$("tfoot input").blur( function (i) { //ne reinitialise pas
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("tfoot input").index(this)];
		}
	} );

	
	$('#date_debut').datepicker(
			$.datepicker.regional['fr'] = {
					closeText: 'Fermer',
					changeYear: true,
					yearRange: 'c-80:c',
					prevText: '&#x3c;PrÃ©c',
					nextText: 'Suiv&#x3e;',
					currentText: 'Courant',
					monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
					'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
					monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
					'Jul','Aout','Sep','Oct','Nov','Dec'],
					dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
					dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
					dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
					weekHeader: 'Sm',
					dateFormat: 'yy-mm-dd',
					firstDay: 1,
					isRTL: false,
					showMonthAfterYear: false,
					yearRange: '1990:2015',
					showAnim : 'bounce',
					changeMonth: true,
					changeYear: true,
					yearSuffix: ''
			}
	);
	
    }
    
    /********************************************************************************************/
    
    /*==========================================================================================*/
    
    /********************************************************************************************/
    
    
    
    
    
    
    
    
    
    
    
    
    
    /****************************************************************************************************************************************/
    function modifiertransfert(id){
    	var cle = id;
        var chemin = '/simens_derniereversion/public/personnel/personnel/modifiertransfert';
        $.ajax({
            type: 'GET',
            url: chemin ,
            data: $(this).serialize(),  
            data:'id='+cle,
            success: function(data) {
       	  
            	     $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> MODIFICATIONS </div>");
            	     var result = jQuery.parseJSON(data);  

            	     /****EFFACER LE CONTENU ET DEPLIER L'INTERFACE DE MODIFICATION****/
            	    $("#contenu").fadeOut(function(){
            	    	 $("#modifier_transfert").html(result); 
            	     
            	    	 /********************ON PREPARE LA TOUCHE 'Pécédent' *******************/
            	    	 $('#precedent').click(function(){
            	    		
            	 	    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> LE PERSONNEL </div>");	
            	 	    
            	 	         $('#modifier_transfert').animate({
            	 	            height : 'toggle'
            	 	         },1000).queue(function(){
            	 	        	$('#contenu').fadeIn(1000);
            	 	            $(this).dequeue();
            	 	         });//.queue(function(){$("#modifier_donnees_deces").stop(true); $(this).dequeue();});
	
            	 	         $("#terminer_transfert").replaceWith("<button id='terminer_modif_deces' style='height:35px;'>Terminer</button>");

            	 	         return false;
            	 	     });
            	    	 /****************************************************************/
            	    	 
            	    	 
            	    	 /****************ON PREPARE LA TOUCHE 'Terminer'*****************/
       	 	            // modifierDonnees(id);
       	 	             /****************************************************************/
            	    	 
            	    	 
            	    	 /****DEPLIER L'INTERFACE****/
            	         $('#modifier_transfert').animate({
            	            height : 'toggle'
            	         },1000).queue(function(){$("#modifier_transfert").stop(true); $(this).dequeue();}); //POUR EVITER L'EFFET SUR LE DOUBLE CLICK DE L'ICONE 'Modifier' 
            	         });
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
	    return false;
    }
    
    function getListePersonnel(id){
    	var cle = id;
    	
    	if(id==1){
          var chemin = '/simens_derniereversion/public/personnel/personnel/lalistepersonnel';
          $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:'id='+cle,
            success: function(data) {
       	    
            	     //$("#titre").replaceWith("<div id='titre2' style='font-family: police2; text-decoration:underline; color: green; font-size: 20px; font-weight: bold;'>Informations sur le patient </div>");
            	     var result = jQuery.parseJSON(data);  
            	     $("#donnees").fadeOut(function(){$(this).html(result).fadeIn("fast"); }); 
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
           });
    	 }
    }
    
    function getChamps(id){
    	
    	if(id=="Interne"){
    		$("#vider_champ_externe").toggle(false);
    		$("#vider_champ_interne").toggle(true);
    		
    		$(".transfert_externe").toggle(false);
    		$(".transfert_interne").toggle(true);
    	}
    	else
    		if(id=="Externe"){
    			$("#vider_champ_interne").toggle(false);
    			$("#vider_champ_externe").toggle(true);
    			
    			$(".transfert_interne").toggle(false);
    			$(".transfert_externe").toggle(true);
    		}
    	
    	$("#vider_champ_interne").click(function(){
    		document.getElementById('service_accueil').value="";
    		document.getElementById('motif_intervention').value="";
    		document.getElementById('date_debut').value="";
    		document.getElementById('date_fin').value="";
    		document.getElementById('note').value="";
    	});
    	
    	$("#vider_champ_externe").click(function(){
    		document.getElementById('hopital_accueil').value="";
    		document.getElementById('service_accueil_externe').value="";
    		document.getElementById('motif_intervention_externe').value="";
    		document.getElementById('date_debut_externe').value="";
    		document.getElementById('date_fin_externe').value="";
    		document.getElementById('note_externe').value="";

    	});
    	
    }
    
    function calendrier(){
    	$('#date_debut,#date_fin,#date_debut_externe,#date_fin_externe').datepicker(
    			$.datepicker.regional['fr'] = {
    					closeText: 'Fermer',
    					changeYear: true,
    					yearRange: 'c-80:c',
    					prevText: '&#x3c;PrÃ©c',
    					nextText: 'Suiv&#x3e;',
    					currentText: 'Courant',
    					monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
    					'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
    					monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
    					'Jul','Aout','Sep','Oct','Nov','Dec'],
    					dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
    					dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
    					dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
    					weekHeader: 'Sm',
    					dateFormat: 'dd/mm/yy',
    					firstDay: 1,
    					isRTL: false,
    					showMonthAfterYear: false,
    					yearRange: '1990:2015',
    					showAnim : 'bounce',
    					changeMonth: true,
    					changeYear: true,
    					yearSuffix: ''}
    	);
    }
    
    function enregistrermodificiation(id){ //cliquer sur 'terminer' apres mis à jour
    	$('#terminer').click(function(){
    	  
    		$("#terminer").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
        	var type_transfert = $("#type_transfert").val();
        	var service_origine  =$("#service_origine").val();
        	var service_accueil  = $("#service_accueil").val();
        	var motif_transfert = $("#motif_transfert").val();
        	var note = $('#note').val(); 
        	
        	var hopital_accueil  = $("#hopital_accueil").val();
        	var service_origine_externe  = $("#service_origine_externe").val();
        	var service_accueil_externe  = $("#service_accueil_externe").val();
        	var motif_transfert_externe  = $("#motif_transfert_externe").val();
        	
      
        	$.ajax({
                type: 'POST',  
                url: '/simens_derniereversion/public/personnel/personnel/modifiertransfert' ,  
                data: {'id':id , 'type_transfert':type_transfert , 'service_origine':service_origine , 'service_accueil':service_accueil , 
                	'motif_transfert':motif_transfert , 'service_origine_externe':service_origine_externe , 'note':note,
                	'hopital_accueil':hopital_accueil,'service_origine_externe':service_origine_externe, 'service_accueil_externe':service_accueil_externe,
                	'motif_transfert_externe':motif_transfert_externe},
        	    success: function(data) {    
        	    	
                  vart='/simens_derniereversion/public/personnel/personnel/listing';
                  $(location).attr("href",vart);
                  
               },
                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
                dataType: "html"
        	});
    	});
    	
    	$('#annuler').click(function(){
    		vart='/simens_derniereversion/public/personnel/personnel/listing';
            $(location).attr("href",vart);
    	});
    }