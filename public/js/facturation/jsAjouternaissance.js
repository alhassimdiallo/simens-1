var base_url = window.location.toString();
var tabUrl = base_url.split("public");

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
     var chemin = tabUrl[0]+'public/facturation/ajouter-naissance';
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
					"aaSorting": "", //pour trier la liste affich�e
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
					   "iDisplayLength": "5",
					   "aLengthMenu": [1,3,5],
					   
					   
						
	} );

	$("thead input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable.fnFilter( this.value, $("thead input").index(this) );
	} );

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
	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 30px;'><iS style='font-size: 25px; '>&curren;</iS> RECHERCHER LA MAMAN </div>");	
    
	$('#contenu').animate({
        height : 'toggle'
     },1000);
     $('#ajouter_naissance').animate({
        height : 'toggle'
     },1000);
	
     $("#terminer").replaceWith("<button id='terminer' style='height:35px;'>Terminer</button>");
     
     return false;
});
}

function ajouternaiss(id){
	
	$("#terminer").replaceWith("<button id='terminer' style='height:35px;'>Terminer</button>");
	$('#date_naissance').datepicker(
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
	
	
    $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold; padding-left: 30px;'><iS style='font-size: 25px;'>&curren;</iS> ETAT CIVIL DE L'ENFANT </div>");	

    //R�cup�ration des donn�es de la maman
    var cle = id;
    var chemin = tabUrl[0]+'public/facturation/lepatient';
    $.ajax({
        type: 'POST',
        url: chemin ,
        data:'id='+cle,
        success: function(data) {    
        	    var result = jQuery.parseJSON(data);  
        	     $("#info_maman").html(result);
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
    //Fin R�cup�ration des donn�es de la maman
    
    //Annuler l'enregistrement d'une naissance
    $("#annuler").click(function(){
    	$("#annuler").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
    	vart=tabUrl[0]+'public/facturation/ajouter-naissance';
        $(location).attr("href",vart);
        return false;
    });
    
    //Insertion des donn�es dans la base de donn�es
//    $('#terminer').click(function(){
//    	$("#terminer").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
//    	var taille = $("#taille").val();
//    	var poids  = $("#poids").val();
//    	var groupe_sanguin = $("#groupe_sanguin").val();
//    	var heure_naissance = $("#heure_naissance").val();
//    	var date_naissance = $("#date_naissance").val();
//    	var nom = $("#nom").val();
//    	var prenom = $("#prenom").val();
//    	var lieu_naissance = $("#lieu_naissance").val();
//    	var sexe = $("#sexe").val(); if(!sexe){sexe="";}
//    
//    	$.ajax({
//            type: 'POST',
//            url: tabUrl[0]+'public/facturation/enregistrer-bebe' ,  
//            data: {'id':cle , 'nom':nom , 'prenom':prenom , 'date_naissance':date_naissance , 'lieu_naissance':lieu_naissance , 'heure_naissance':heure_naissance , 'poids':poids , 'groupe_sanguin':groupe_sanguin , 'taille':taille , 'sexe':sexe},
//    	    success: function(data) {    
//    	    	//var result = jQuery.parseJSON(data); 
//    	    	vart=tabUrl[0]+'public/facturation/liste-naissance';
//    	    	$(location).attr("href",vart);
//            },
//            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
//            dataType: "html"
//    	});
//    });
    //Fin insertion des donn�es
    
    //Ajouter l'id pour savoir de quelle maman il s'agit
    $("#id_personne").val(id);
    
    //MENU GAUCHE
  	//MENU GAUCHE
  	$("#vider").click(function(){
  		document.getElementById('nom').value="";
  		document.getElementById('prenom').value="";
  		document.getElementById('date_naissance').value="";
  		document.getElementById('heure_naissance').value="";
  		document.getElementById('lieu_naissance').value="";
  		document.getElementById('poids').value="";
  		document.getElementById('sexe').value="";
  		document.getElementById('taille').value="";
  		document.getElementById('groupe_sanguin').value="";
  		return false;
  	});
  	
  	function activer(){
  	  $("#div_modifier_donnees").click(function(){	
  		$("#nom").attr('disabled',false);
	    $("#prenom").attr('disabled', false);
	    $("#date_naissance").attr('disabled', false);
  	    $("#heure_naissance").attr('disabled', false);
  	    $("#poids").attr('disabled', false);
  	    $("#sexe").attr('disabled', false);
  	    $("#taille").attr('disabled', false);
  	    $("#groupe_sanguin").attr('disabled', false);
  	    $("#lieu_naissance").attr('disabled', false);
  	    desactiver();
  	  });
  	}
  	
  	function desactiver(){
  	  $("#div_modifier_donnees").click(function(){
  		$("#nom").attr('disabled',true);
	    $("#prenom").attr('disabled', true);
	    $("#date_naissance").attr('disabled', true);
	    $("#heure_naissance").attr('disabled', true);
	    $("#poids").attr('disabled', true);
	    $("#sexe").attr('disabled', true);
	    $("#taille").attr('disabled', true);
	    $("#groupe_sanguin").attr('disabled', true);
	    $("#lieu_naissance").attr('disabled', true);
	    activer();
  	  });
  	}
  	    
        //ON PREPARE LA DESACTIVATION 
  	    desactiver();  	
  
  		$('#vider_champ').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/annuler2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/annuler1.png") no-repeat right top');
  	    });

  		$('#div_supprimer_photo').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/mod2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/mod.png") no-repeat right top');
  	    });

  		$('#div_ajouter_photo').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/ajouterphoto2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/ajouterphoto.png") no-repeat right top');
  	    });

  		$('#div_modifier_donnees').hover(function(){
  			
  			 $(this).css('background','url("'+tabUrl[0]+'public/images_icons/modifier2.png") no-repeat right top');
  		},function(){
  			  $(this).css('background','url("'+tabUrl[0]+'public/images_icons/modifier.png") no-repeat right top');
  	   });
  
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  
}