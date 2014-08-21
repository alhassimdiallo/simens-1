    var nb="_TOTAL_";
    var asInitVals = new Array();
	//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(id){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:405,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );
	            
	            var cle = id;
	            var chemin = '/simens_derniereversion/public/personnel/personnel/supprimer';
	            $.ajax({
	                type: 'POST',
	                url: chemin ,
	                data: $(this).serialize(),  
	                data:'id='+cle,
	                success: function(data) { 
	                	     $("#"+cle).fadeOut(function(){$("#"+cle).empty();});
	                	     //$("#compteur").html(result);
	                	     
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
    
    function envoyer(id){
   	   confirmation(id);
       $("#confirmation").dialog('open');
   	}
    
    /**********************************************************************************/
    
    function modifierpersonnel(id){
        var vart='/simens_derniereversion/public/personnel/personnel/modifierdossier/code/'+id;
        $(location).attr("href",vart);
    }
    
    
    /**********************************************************************************/
    
    function affichervue(id){
    	
    	var cle = id;
        var chemin = '/simens_derniereversion/public/personnel/personnel/vuepersonnel';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:'id='+cle,
            success: function(data) {
       	    
            	     $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS </div>");
            	     var result = jQuery.parseJSON(data);  
            	     $("#contenu").fadeOut(function(){$("#vue_patient").html(result).fadeIn("fast"); }); 
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
	    return false;
    }
    
    function listepatient(){
    	//Lorsqu'on clique sur terminer �a ram�ne la liste des aptients d�c�d�s 
	    $("#terminer").click(function(){
  	   	    //alert('ok');
	    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> LE PERSONNEL </div>");
  	    	$("#vue_patient").fadeOut(function(){$("#contenu").fadeIn("fast"); });
  	    });
    }
    
    /**********************************************************************************/
    function initialisation(){	
    	
     var asInitVals = new Array();
	 var  oTable = $('#patientdeces').dataTable
	  ( {
		        
					"aaSorting": "", //pour trier la liste affich�e
					"oLanguage": { 
						"sProcessing":   "Traitement en cours...",
						//"sLengthMenu":   "Afficher _MENU_ &eacute;l&eacute;ments",
						"sZeroRecords":  "Aucun &eacute;l&eacute;ment &agrave; afficher",
						"sInfo": nb+" &eacute;l&eacute;ments",
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
					   "iDisplayLength": "10",
					   
					   
						
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

    }
    
    
    /****************************************************************************************************************************************/
    function modifierdeces(id){/*
    	var cle = id;
        var chemin = '/simens_derniereversion/public/facturation/facturation/modifierdeces';
        $.ajax({
            type: 'GET',
            url: chemin ,
            data: $(this).serialize(),  
            data:'id='+cle,
            success: function(data) {
       	  
            	     $("#titre").replaceWith("<div id='titre2' style='font-family: police2; text-decoration:underline; color: green; font-size: 20px; font-weight: bold;'>Modifier les infos sur le d&eacute;c&egrave;s </div>");
            	     var result = jQuery.parseJSON(data);  

            	     *//****EFFACER LE CONTENU ET DEPLIER L'INTERFACE DE MODIFICATION****//*
            	     $("#contenu").fadeOut(function(){
            	    	 $("#modifier_donnees_deces").html(result); 
            	     
            	    	 *//********************ON PREPARE LA TOUCHE 'P�c�dent' *******************//*
            	    	 $('#precedent').click(function(){
            	    		
            	 	    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; text-decoration:underline; color: green; font-size: 20px; font-weight: bold;'>Liste des naissances </div>");	
            	 	    
            	 	         $('#modifier_donnees_deces').animate({
            	 	            height : 'toggle'
            	 	         },1000).queue(function(){
            	 	        	$('#contenu').fadeIn(1000);
            	 	            $(this).dequeue();
            	 	         });//.queue(function(){$("#modifier_donnees_deces").stop(true); $(this).dequeue();});
	
            	 	         $("#terminer_modif_deces").replaceWith("<button id='terminer_modif_deces' style='height:35px;'>Terminer</button>");

            	 	         return false;
            	 	     });
            	    	 *//****************************************************************//*
            	    	 
            	    	 
            	    	 *//****************ON PREPARE LA TOUCHE 'Terminer'*****************//*
       	 	             modifierDonnees(id);
       	 	             *//****************************************************************//*
            	    	 
            	    	 
            	    	 *//****DEPLIER L'INTERFACE****//*
            	         $('#modifier_donnees_deces').animate({
            	            height : 'toggle'
            	         },1000).queue(function(){$("#modifier_donnees_deces").stop(true); $(this).dequeue();}); //POUR EVITER L'EFFET SUR LE DOUBLE CLICK DE L'ICONE 'Modifier' 
            	     });
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
	    return false;
    */}
    
    
    function modifierDonnees(id){
    	
    	/*$("#terminer_modif_deces").click(function(){ 
    		$("#terminer_modif_deces").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
        	var date_deces = $("#date_deces").val();
        	var heure_deces  =$("#heure_deces").val();
        	var age_deces  = $("#age_deces").val();
        	var lieu_deces = $("#lieu_deces").val();
        	var circonstances_deces  = $("#circonstances_deces").val();
        	var note = $('#note').val();
      
        	$.ajax({
                type: 'POST',  
                url: '/simens_derniereversion/public/facturation/facturation/modifierdeces' ,  
                data: {'id':id , 'date_deces':date_deces , 'heure_deces':heure_deces , 'age_deces':age_deces , 'lieu_deces':lieu_deces , 'circonstances_deces':circonstances_deces , 'note':note},
        	    success: function(data) {    
        	    	
                  vart='/simens_derniereversion/public/facturation/facturation/listepatientdecedes';
                  $(location).attr("href",vart);
                  
                },
                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
                dataType: "html"
        	});
    	});
    	
    	//Annuler l'enregistrement d'un deces
        $("#annuler_modif_deces").click(function(){
        	$("#annuler_modif_deces").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
        	//vart='/simens_derniereversion/public/facturation/facturation/listepatientdecedes';
            //$(location).attr("href",vart);
        	
        	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; text-decoration:underline; color: green; font-size: 20px; font-weight: bold;'>Liste des patients d&eacute;c&eacute;d&eacute;s </div>");
  	    	//$("#modifier_donnees_deces").fadeOut(function(){$("#contenu").fadeIn("fast"); });

        	$('#modifier_donnees_deces').animate({
 	            height : 'toggle'
 	         },100).queue(function(){
	 	        	$('#contenu').fadeIn(1000);
	 	            $(this).dequeue();
	 	         });
        });
        
        
        $('#date_deces').datepicker(
    			$.datepicker.regional['fr'] = {
    					closeText: 'Fermer',
    					changeYear: true,
    					yearRange: 'c-80:c',
    					prevText: '&#x3c;Préc',
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
    	);*/
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