
//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
function confirmation(id){
  $( "#confirmation" ).dialog({
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

function visualiser(id){
	 confirmation(id);
	 var cle = id;
     var chemin = '/simens_derniereversion/public/personnel/Personnel/recherche';
     $.ajax({
         type: 'POST',
         url: chemin ,
         data: $(this).serialize(),  
         data:'id='+cle,
         success: function(data) {    
         	    var result = jQuery.parseJSON(data);  
         	     //$("#foot").fadeOut(function(){$(this).html(result).fadeIn("fast"); }); 
         	     $("#info").html(result);
         	     
         	     $("#confirmation").dialog('open'); //Appel du POPUP
         	       
         },
         error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
         dataType: "html"
     });
}


function initialisation(){
	
	var asInitVals = new Array();
	var  oTable = $('#patient').dataTable
	( {
					"aaSorting": "", //pour trier la liste affichée
					"oLanguage": { 
						"sProcessing":   "Traitement en cours...",
						"sZeroRecords":  "Aucun &eacute;l&eacute;ment &agrave; afficher",
						"sInfo": "_END_ sur _TOTAL_ ",
						"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
						"sInfoFiltered": "",
						"sInfoPostFix":  "",
						"sSearch": "",
						"sUrl": "",
						"sWidth": "30px",
						"oPaginate": {
							"sFirst":    "",
							"sPrevious": "",
							"sNext":     "",
							"sLast":     ""
							}
					   },
					   "iDisplayLength": "3",
					   "aLengthMenu": [1,3,5],
					   
					   
						
	} );

	$("thead input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable.fnFilter( this.value, $("thead input").index(this) );
	} );
	
	//le filtre du select du type personnel
	$('#type_personnel').change(function() 
	{					
		oTable.fnFilter( this.value );
	});

	/*
	* Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
	* the footer
	*/
	$("thead input").each( function (i) {
		asInitVals[i] = this.value;
	} );

	$("thead input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );

	$("thead input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("thead input").index(this)];
		}
	} );
	
	
   }

function animation(){
//ANIMATION
//ANIMATION
//ANIMATION

$('#ajouter_naissance').toggle(false);

$('#precedent').click(function(){
	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> LE PERSONNEL</div>");	
    
	$('#ajouter_naissance').animate({
        height : 'toggle'
     },1000);
	$('#contenu').animate({
        height : 'toggle'
    },1000);
    
     
     $("#terminer").replaceWith("<button id='terminer' style='height:35px;'>Terminer</button>");
     
     return false;
});
}

function transferer(id){
	
	$("#terminer").replaceWith("<button id='terminer' style='height:35px;'>Terminer</button>");
	/*$('#date_naissance').datepicker(
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
	);*/
	
	
    $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 20px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> TRANSF&Eacute;RER L'AGENT </div>");	

    //Récupération des données de la maman
    var cle = id;
    var chemin = '/simens_derniereversion/public/personnel/personnel/lepersonnel';
    $.ajax({
        type: 'POST',
        url: chemin ,
        data:'id='+cle,
        success: function(data) {    
        	    var result = jQuery.parseJSON(data);  
        	     $("#info_personnel").html(result);
        	     //PASSER A SUIVANT
        	     $('#ajouter_naissance').animate({
        	         height : 'toggle'
        	      },1000);
        	     $('#contenu').animate({
        	         height : 'toggle'
        	     },1000);
        },
        error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        dataType: "html"
    });
    //Fin Récupération des données de la maman
    
    //Annuler l'enregistrement d'une naissance
    $("#annuler").click(function(){
    	$("#annuler").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
    	vart='/simens_derniereversion/public/personnel/Personnel/recherche';
        $(location).attr("href",vart);
    });
    
    //Insertion des données dans la base de données
    $('#terminer').click(function(){
    	$("#terminer").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
    	var type_transfert = $("#type_transfert").val();
    	
    	var service_origine  = $("#service_origine").val();
    	var service_accueil = $("#service_accueil").val();
    	var motif_transfert = $("#motif_transfert").val();
    	var note = $("#note").val();
    	
    	var service_origine_externe = $("#service_origine_externe").val();
    	var hopital_accueil = $("#hopital_accueil").val();
    	var service_accueil_externe = $("#service_accueil_externe").val();
    	var motif_transfert_externe = $("#motif_transfert_externe").val(); 
    
    	$.ajax({
            type: 'POST',
            url: '/simens_derniereversion/public/personnel/personnel/savetransfert' ,  
            data: {'id':cle , 'type_transfert':type_transfert , 'service_origine':service_origine , 'service_accueil':service_accueil ,
            	   'motif_transfert':motif_transfert , 'note':note , 'service_origine_externe':service_origine_externe ,
            	   'hopital_accueil':hopital_accueil , 'service_accueil_externe':service_accueil_externe , 
            	   'motif_transfert_externe':motif_transfert_externe},
    	    success: function(data) {    
    	      var result = jQuery.parseJSON(data);  
              vart='/simens_derniereversion/public/personnel/Personnel/listing/'+result;
              $(location).attr("href",vart);            
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
    	});
    });
    //Fin insertion des données
    
  	    
        //ON PREPARE LA DESACTIVATION 
  	    desactiver();  	
  
  		/*$('#vider_champ').hover(function(){
  			
  			 $(this).css('background','url("/simens_derniereversion/public/images_icons/annuler2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("/simens_derniereversion/public/images_icons/annuler1.png") no-repeat right top');
  	    });

  		$('#div_supprimer_photo').hover(function(){
  			
  			 $(this).css('background','url("/simens_derniereversion/public/images_icons/mod2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("/simens_derniereversion/public/images_icons/mod.png") no-repeat right top');
  	    });

  		$('#div_ajouter_photo').hover(function(){
  			
  			 $(this).css('background','url("/simens_derniereversion/public/images_icons/ajouterphoto2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("/simens_derniereversion/public/images_icons/ajouterphoto.png") no-repeat right top');
  	    });

  		$('#div_modifier_donnees').hover(function(){
  			
  			 $(this).css('background','url("/simens_derniereversion/public/images_icons/modifier2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("/simens_derniereversion/public/images_icons/modifier.png") no-repeat right top');
  	   });*/
  
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  
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
		document.getElementById('motif_transfert').value="";
		document.getElementById('note').value="";
	});
	
	$("#vider_champ_externe").click(function(){
		document.getElementById('hopital_accueil').value="";
		document.getElementById('service_accueil_externe').value="";
		document.getElementById('motif_transfert_externe').value="";
	});
	
}