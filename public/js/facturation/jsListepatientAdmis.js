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
	            var chemin = '/simens_derniereversion/public/facturation/facturation/supprimeradmission';
	            $.ajax({
	                type: 'POST',
	                url: chemin ,
	                data: $(this).serialize(),  
	                data:'id='+cle,
	                success: function(data) {
	                	     //vart='/simens_derniereversion/public/facturation/facturation/listepatient';
	                         //$(location).attr("href",vart);
	                	    
	                	     var result = jQuery.parseJSON(data);  
	                	     //$("#foot").fadeOut(function(){$(this).html(result).fadeIn("fast"); });  
	                	     $("#"+cle).fadeOut(function(){$("#"+cle).empty();});
	                	     $("#compteur").html(result);
	                	     
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
    
    function affichervue(id, idFacturation){

        var chemin = '/simens_derniereversion/public/facturation/facturation/vuepatientadmis';
        $.ajax({
            type: 'POST',
            url: chemin ,
            data: $(this).serialize(),  
            data:{'id':id, 'idFacturation':idFacturation},
            success: function(data) {
       	    
            	     //vart='/simens_derniereversion/public/facturation/facturation/listepatient';
                     //$(location).attr("href",vart);
            	     $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> INFORMATIONS SUR LE PATIENT </div>");
            	     var result = jQuery.parseJSON(data);  
            	     $("#contenu").fadeOut(function(){$("#vue_patient").html(result).fadeIn("fast"); }); 
            	     
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
	    return false;
    }
    
    function listepatient(){
    	//Lorsqu'on clique sur terminer ça ramène la liste des aptients admis 
	    $("#terminer").click(function(){
	    	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> LISTE DES PATIENTS ADMIS </div>");
  	    	$("#vue_patient").fadeOut(function(){$("#contenu").fadeIn("fast"); });
  	    });
    }
    
    /**********************************************************************************/
    function initialisation(){	
    	
     var asInitVals = new Array();
	 var  oTable = $('#patientdeces').dataTable
	  ( {
		        
					//"bJQueryUI": true,
					//"sPaginationType": "full_numbers",
					"aaSorting": "", //pour trier la liste affichée
					"oLanguage": { 
						"sProcessing":   "Traitement en cours...",
						//"sLengthMenu":   "Afficher _MENU_ &eacute;l&eacute;ments",
						"sZeroRecords":  "Aucun &eacute;l&eacute;ment &agrave; afficher",
						//"sInfo": "Total: "+nb+" &eacute;l&eacute;ments",
						//"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
						"sInfoFiltered": "",
						"sInfoPostFix":  "",
						"sSearch": "",
						"sUrl": "",
						"sWidth": "30px",
						"oPaginate": {
							"sFirst":    "|<",
							"sPrevious": "<",
							"sNext":     ">",
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
	
	$('#liste_service').change(function()
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
	

    }