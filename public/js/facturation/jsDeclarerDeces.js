
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
     var chemin = '/simens_derniereversion/public/facturation/facturation/DeclarerDeces';
     $.ajax({
         type: 'POST',
         url: chemin ,
         data: $(this).serialize(),  
         data:'id='+cle,
         success: function(data) {    
         	    var result = jQuery.parseJSON(data);   
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
	
$('#declarer_deces').toggle(false);

$('#precedent').click(function(){
	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> RECHERCHER LE PATIENT </div>");	
    
	$('#contenu').animate({
        height : 'toggle'
     },1000);
     $('#declarer_deces').animate({
        height : 'toggle'
     },1000);
	
     
     $("#terminerdeces").replaceWith("<button id='terminerdeces' style='height:35px;'>Terminer</button>");
     
     return false;
});
}

function declarer(id){
	
	$("#terminerdeces").replaceWith("<button id='terminerdeces' style='height:35px;'>Terminer</button>");
	$('#date_deces').datepicker({
	    dateFormat: 'yy-mm-dd',
	    showAnim : 'bounce',
	    yearRange : '2013:2015',
	    
	});
	
    $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> D&Eacute;CLARER LE D&Eacute;C&Egrave;S </div>");	

    //Récupération des données du patient
    var cle = id;
    var chemin = '/simens_derniereversion/public/facturation/facturation/lepatient';
    $.ajax({
        type: 'POST',
        url: chemin ,
       /* data: $(this).serialize(),*/  
        data:'id='+cle,
        success: function(data) {    
        	    var result = jQuery.parseJSON(data);  
        	     $("#info_patient").html(result);
        	     //PASSER A SUIVANT
        	     $('#declarer_deces').animate({
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
    	vart='/simens_derniereversion/public/facturation/facturation/declarerdeces';
        $(location).attr("href",vart);
    });
    
    //Insertion des données dans la base de données
    $('#terminerdeces').click(function(){
    	$("#terminerdeces").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
    	//$("#terminerdeces").attr( 'disabled', true );
    	//$("#annuler").attr( 'disabled', true );
    	var date_deces = $("#date_deces").val();
    	var heure_deces = $("#heure_deces").val();
    	var age_deces = $("#age_deces").val();
    	var lieu_deces = $("#lieu_deces").val();
    	var circonstances_deces = $("#circonstances_deces").val();
    	var note = $("#note").val();
    	
    	$.ajax({
            type: 'POST',
            url: '/simens_derniereversion/public/facturation/facturation/enregisterdeces' ,  
            data: {'id':cle , 'lieu_deces':lieu_deces , 'circonstances_deces':circonstances_deces , 'age_deces':age_deces , 'heure_deces':heure_deces , 'date_deces':date_deces, 'note':note, },
    	    success: function(data) {    
    	    	
              vart='/simens_derniereversion/public/facturation/facturation/listepatientdecedes';
              $(location).attr("href",vart);
                
            }
    	});
    });
    //Fin insertion des données
    
    
    //MENU GAUCHE
  	//MENU GAUCHE
  	$("#vider").click(function(){
  		document.getElementById('date_deces').value="";
  		document.getElementById('heure_deces').value="";
  		//document.getElementById('age_deces').value="";
  		document.getElementById('lieu_deces').value="";
  		document.getElementById('circonstances_deces').value="";
  		document.getElementById('note').value="";
  		return false;
  	});
  	
  	
 
  		$('#vider_champ').hover(function(){
  			
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
  	   });
  
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  
  		
  		
  		
}