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
     var chemin = tabUrl[0]+'public/facturation/declarer-deces';
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

$('#declarer_deces').toggle(false);

$('#precedent').click(function(){
	$("#titre2").replaceWith("<div id='titre' style='font-family: police2; color: green; font-size: 18px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> RECHERCHER LE PATIENT </div>");	
    
	$('#contenu').animate({
        height : 'toggle'
     },1000);
     $('#declarer_deces').animate({
        height : 'toggle'
     },1000);
	 
     //IL FAUT LE RECREER POUR L'ENLEVER DU DOM A CHAQUE FOIS QU'ON CLIQUE SUR PRECEDENT
     $("#termineradmission").replaceWith("<button id='termineradmission' style='height:35px;'>Terminer</button>");
     
     return false;
});
}

function declarer(id){
	
	$("#termineradmission").replaceWith("<button id='termineradmission' style='height:35px;'>Terminer</button>");
    $("#titre").replaceWith("<div id='titre2' style='font-family: police2; color: green; font-size: 18px; font-weight: bold;'><iS style='font-size: 25px;'>&curren;</iS> ADMISSION </div>");	

    //R�cup�ration des donn�es du patient
    var cle = id;
    var chemin = tabUrl[0]+'public/facturation/admission';
    $.ajax({
        type: 'POST',
        url: chemin ,
        data: $(this).serialize(),  
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
    //Fin R�cup�ration des donn�es de la maman
    
    //Annuler l'enregistrement d'une naissance
    $("#annuler").click(function(){
    	$("#annuler").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
    	vart=tabUrl[0]+'public/facturation/admission';
        $(location).attr("href",vart);
    	//ANNULER
	    /*  $('#contenu').animate({
	         height : 'toggle'
	      },1000);
	      $('#declarer_deces').animate({
	         height : 'toggle'
	      },1000);
	     
	     return true;*/
    });
    
    //Insertion des donn�es dans la base de donn�es
    $('#termineradmission').click(function(){
    	//alert('test');
    	$("#termineradmission").css({"border-color":"#ccc", "background":"-webkit-linear-gradient( #555, #CCC)", "box-shadow":"1px 1px 10px black inset,0 1px 0 rgba( 255, 255, 255, 0.4)"});
    	$("#termineradmission").attr( 'disabled', true );
    	$("#annuler").attr( 'disabled', true );
    	var numero = $("#numero").val();
    	var service = $("#service").val();
    	var montant = $("#montant").val();
    	
    	$.ajax({
            type: 'POST',
            url: tabUrl[0]+'public/facturation/enregistrer-admission' ,  
            data: {'id':cle , 'numero':numero , 'service':service , 'montant':montant },
    	    success: function(data) {    
    	    	
              vart=tabUrl[0]+'public/facturation/liste-patients-admis';
              $(location).attr("href",vart);
                
            }
    	});
    });
    //Fin insertion des donn�es
  
}


function getmontant(id){
	//R�cup�ration des donn�es du patient
    var cle = id;
    var chemin = tabUrl[0]+'public/facturation/montant';
    $.ajax({
        type: 'POST',
        url: chemin ,
        data:'id='+cle,
        success: function(data) {    
        	    var result = jQuery.parseJSON(data);  
        	     $("#montant").val(result);
        },
        error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        dataType: "html"
    });
	
}