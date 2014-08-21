$(function(){
	$("#accordions").accordion();
	//$( "button" ).button(); // APPLICATION DU STYLE POUR LES BOUTONS
	
	/*********************************/
	/***FACTURATION***/
	/*********************************/
	$("#bouton_donnees_valider_affectation").click(function(){
	     $("#numero_os").attr( 'readonly', true );
         $("#service_accueil").attr( 'readonly', true );
         $("#date_fin").attr( 'readonly', true );
         $("#date_debut").attr( 'readonly', true );
         
         $('#bouton_valider_donnees_facturation').toggle(false);
         $("#modifier_champ_affectation").toggle(true);
	});
	
	$("#modifier_champ_affectation").click(function(){
		$("#numero_os").attr( 'readonly', false );
        $("#service_accueil").attr( 'readonly', false );
        $("#date_fin").attr( 'readonly', false );
        $("#date_debut").attr( 'readonly', false );
        
        $('#bouton_valider_donnees_facturation').toggle(true);
        $("#modifier_champ_affectation").toggle(false);
	});
	
	$("#vider_champ_affectation").click(function(){
		document.getElementById('numero_os').value="";
		document.getElementById('service_accueil').value="";
		document.getElementById('date_fin').value="";
		document.getElementById('date_debut').value="";
	 });
	
});

function dialogue(){ 
//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:375,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );

	             $('#photo').children().remove(); 
	             $('<input type="file" />').appendTo($('#photo')); 
	             $("#div_supprimer_photo").children().remove();
	             Recupererimage();          	       
	    	     return false;
	    	     
	        },
	        "Annuler": function() {
                $( this ).dialog( "close" );
            }
	   }
	  });
    }
  //FONCTION QUI RECUPERE LA PHOTO ET LA PLACE SUR L'EMPLACEMENT SOUHAITE
    function Recupererimage(){
    	$('#photo input[type="file"]').change(function() {
    	  
    	   var file = $(this);
 		   var reader = new FileReader;
 		   
	       reader.onload = function(event) {
	    		var img = new Image();
                 
        		img.onload = function() {
				   var width  = 100;
				   var height = 105;
				
				   var canvas = $('<canvas></canvas>').attr({ width: width, height: height });
				   file.replaceWith(canvas);
				   var context = canvas[0].getContext('2d');
	        	    	context.drawImage(img, 0, 0, width, height);
			    };
			    document.getElementById('fichier_tmp').value = img.src = event.target.result;
			   
    	};
    	 $("#modifier_photo").remove(); //POUR LA MODIFICATION
    	reader.readAsDataURL(file[0].files[0]);
    	//Création de l'onglet de suppression de la photo
    	$("#div_supprimer_photo").children().remove();
    	$('<input alt="supprimer_photo" title="Supprimer la photo" name="supprimer_photo" id="supprimer_photo">').appendTo($("#div_supprimer_photo"));
      
    	//SUPPRESSION DE LA PHOTO
        //SUPPRESSION DE LA PHOTO
          $("#supprimer_photo").click(function(e){
        	 e.preventDefault();
        	 confirmation();
             $("#confirmation").dialog('open');
          });
      });
    }
    //AJOUTER LA PHOTO DU PATIENT
    //AJOUTER LA PHOTO DU PATIENT
    Recupererimage();
}

function debuter(){
	/***********************************************************************************************                              

	========================== LES BOUTONS "TERMINER" et "ANNULER" =================================                              
	                          
	***********************************************************************************************/
	 $("#terminer").click(function(){
		   $("#terminer").attr( 'disabled', true );
	       $("#annuler").attr( 'disabled', true );
		 //RECUPERER LES DONNEES DE ETAT CIVIL
	        var civilite       = $("#civilite").val();
	    	var nom            = $("#nom").val();
	    	var prenom         = $("#prenom").val();
	    	var lieu_naissance = $("#lieu_naissance").val();
	    	var telephone      = $("#telephone").val();
	    	var profession     = $("#profession").val();
	    	var email          = $("#email").val();
	    	var nationalite    = $("#nationalite").val();
	    	var situation_matrimoniale = $("#situation_matrimoniale").val();
	    	var date_naissance = $("#date_naissance").val();
	    	var adresse        = $("#adresse").val();
	    	var sexe           = $("#sexe").val();
	    	var fichier_tmp    = $("#fichier_tmp").val();
	    	
	     //RECUPERER LES DONNEES DES COMPLEMENTS
	    	var type_personnel = $("#type_personnel").val();
	    	
	    	//========== TABLEAU COMPLEMENT INFO MEDECIN ========
	    	var matricule  = $("#matricule").val();
	    	var grade      = $("#grade").val();
	    	var specialite = $("#specialite").val();
	    	var fonction   = $("#fonction").val();
	    	
	    	//========== TABLEAU COMPLEMENT INFO MEDICO-TECHNIQUE ========
	    	var matricule_medico = $("#matricule_medico").val();
	    	var grade_medico     = $("#grade_medico").val();
	    	var domaine_medico   = $("#domaine_medico").val();
	    	
	    	//========== TABLEAU COMPLEMENT INFO LOGISTIQUE ========
	    	var matricule_logistique = $("#matricule_logistique").val();
	    	var grade_logistique     = $("#grade_logistique").val();
	    	var domaine_logistique   = $("#domaine_logistique").val(); 
	    	var autres_logistique    = $("#autres_logistique").val();
	    	
	     //TABLEAU FACTURATION
	    	var service_accueil = $("#service_accueil").val();
	    	var date_debut      = $("#date_debut").val();
	    	var date_fin        = $("#date_fin").val();
	    	var numero_os       = $("#numero_os").val();
	    	
	    	
	    	$.ajax({
	            type: 'POST',
	            url: '/simens_derniereversion/public/personnel/Personnel/dossierpersonnel' ,  
	            data: ({'civilite':civilite , 'nom':nom , 'prenom':prenom , 'lieu_naissance':lieu_naissance , 'telephone':telephone,
	            	    'profession':profession , 'email':email , 'nationalite':nationalite , 'situation_matrimoniale':situation_matrimoniale,
	            	    'date_naissance':date_naissance , 'adresse':adresse , 'sexe':sexe , 'fichier_tmp':fichier_tmp , 'type_personnel': type_personnel, 
	            	    'matricule':matricule , 'grade':grade , 'specialite':specialite, 'fonction':fonction,
	            	    'matricule_medico':matricule_medico , 'grade_medico':grade_medico , 'domaine_medico':domaine_medico,
	            	    'matricule_logistique':matricule_logistique , 'grade_logistique':grade_logistique , 'domaine_logistique':domaine_logistique , 'autres_logistique':autres_logistique , 
	            	    'service_accueil':service_accueil , 'date_debut':date_debut , 'date_fin':date_fin , 'numero_os':numero_os
	                   }),
	    	    success: function() {    
	    	    	
	    	    	vart='/simens_derniereversion/public/personnel/Personnel/listepersonnel';
	    	        $(location).attr("href",vart);
	                
	            },
	            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
	            dataType: "html"
	    	});
	    	
	    });
/********************************************************************************************/
/********************************************************************************************/ 
    
    //AJOUT LA PHOTO DU PATIENT EN CLIQUANT SUR L'ICONE AJOUTER
    //AJOUT LA PHOTO DU PATIENT EN CLIQUANT SUR L'ICONE AJOUTER
    $("#ajouter_photo").click(function(e){
    	e.preventDefault();
    });
    
    //VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
    //VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
    //VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
    
            var civilite = $("#civilite");
            var      nom = $("#nom");
            var   prenom = $("#prenom");
            var     sexe = $("#sexe");
            var date_naissance = $("#date_naissance");
            var lieu_naissance = $("#lieu_naissance");
            var nationalite = $("#nationalite");
            var situation_matrimoniale = $("#situation_matrimoniale");
            var     adresse = $("#adresse");
            var   telephone = $("#telephone");
            var       email = $("#email");
            var  profession = $("#profession");
    	
    $( "button" ).button(); // APPLICATION DU STYLE POUR LES BOUTONS
    
    /*******************************************************/
    //En cliquant sur l'icone modifier
    
    $( "#div_modifier_donnees" ).click(function(){
	       civilite.attr( 'readonly', true );     
	            nom.attr( 'readonly', true );    
	         prenom.attr( 'readonly', true );  
	           sexe.attr( 'readonly', true );
     date_naissance.attr( 'readonly', true );
     lieu_naissance.attr( 'readonly', true );
     nationalite.attr( 'readonly', true );
     situation_matrimoniale.attr( 'readonly', true );
         adresse.attr( 'readonly', true );
       telephone.attr( 'readonly', true );
           email.attr( 'readonly', true );
      profession.attr( 'readonly', true );
      desativer();
    });

    function desativer(){
    	$( "#div_modifier_donnees" ).click(function(){
		       civilite.attr( 'readonly', false );     
                    nom.attr( 'readonly', false );    
                 prenom.attr( 'readonly', false );  
                   sexe.attr( 'readonly', false );
         date_naissance.attr( 'readonly', false );
         lieu_naissance.attr( 'readonly', false );
            nationalite.attr( 'readonly', false );
 situation_matrimoniale.attr( 'readonly', false );
             adresse.attr( 'readonly', false );
           telephone.attr( 'readonly', false );
               email.attr( 'readonly', false );
          profession.attr( 'readonly', false );
          activer();
	    });
    }
    
    function activer(){
     $( "#div_modifier_donnees" ).click(function(){
	       civilite.attr( 'readonly', true );     
	            nom.attr( 'readonly', true );    
	         prenom.attr( 'readonly', true );  
	           sexe.attr( 'readonly', true );
     date_naissance.attr( 'readonly', true );
     lieu_naissance.attr( 'readonly', true );
      nationalite.attr( 'readonly', true );
      situation_matrimoniale.attr( 'readonly', true );
          adresse.attr( 'readonly', true );
        telephone.attr( 'readonly', true );
            email.attr( 'readonly', true );
       profession.attr( 'readonly', true );
       desativer();
       return false; 
      });
    }
    
    /*******************************************************/
    
    //Au debut on cache le bouton modifier et on affiche le bouton valider
  	//$( "#bouton_donnees_valider" ).toggle(true);
  	//$( "#bouton_donnees_modifier" ).toggle(false);
  	
  	/*$( "#bouton_donnees_valider" ).click(function(){
  		       civilite.attr( 'readonly', true );     
  		            nom.attr( 'readonly', true );    
  		         prenom.attr( 'readonly', true );  
  		           sexe.attr( 'readonly', true );
         date_naissance.attr( 'readonly', true );
         lieu_naissance.attr( 'readonly', true );
    nationalite_origine.attr( 'readonly', true );
   nationalite_actuelle.attr( 'readonly', true );
                adresse.attr( 'readonly', true );
              telephone.attr( 'readonly', true );
                  email.attr( 'readonly', true );
             profession.attr( 'readonly', true );
             
  		$("#bouton_donnees_valider").toggle(false);  
  		$("#bouton_donnees_modifier").toggle(true); 
  		return false; 
  	});
  	
  	$( "#bouton_donnees_modifier" ).click(function(){
  		      civilite.attr( 'readonly', false );     
                   nom.attr( 'readonly', false );    
                prenom.attr( 'readonly', false );  
                  sexe.attr( 'readonly', false );
        date_naissance.attr( 'readonly', false );
        lieu_naissance.attr( 'readonly', false );
   nationalite_origine.attr( 'readonly', false );
  nationalite_actuelle.attr( 'readonly', false );
               adresse.attr( 'readonly', false );
             telephone.attr( 'readonly', false );
                 email.attr( 'readonly', false );
            profession.attr( 'readonly', false );
  		
        $("#bouton_donnees_valider").toggle(true);  
  		$("#bouton_donnees_modifier").toggle(false); 
  		return false; 
  	});
  	*/
  	//MENU GAUCHE
  	//MENU GAUCHE
  	$("#vider").click(function(){
  		document.getElementById('civilite').value="";
  		document.getElementById('lieu_naissance').value="";
  		document.getElementById('email').value="";
  		document.getElementById('nom').value="";
  		document.getElementById('telephone').value="";
  		document.getElementById('nationalite').value="";
  		document.getElementById('prenom').value="";
  		document.getElementById('situation_matrimoniale').value="";
  		document.getElementById('date_naissance').value="";
  		document.getElementById('adresse').value="";
  		document.getElementById('sexe').value="";
  		document.getElementById('profession').value="";
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
  
  		$('#date_naissance, #date_debut, #date_fin').datepicker( 
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
  						yearSuffix: ''
  				}
  		);
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT
  //FIN VALIDATION OU MODIFICATION DU FORMULAIRE ETAT CIVIL DU PATIENT 
}

function vider_medecin(){
	document.getElementById('matricule').value="";
	document.getElementById('grade').value="";
	document.getElementById('specialite').value="";
	document.getElementById('fonction').value="";
}

function vider_medicoTechnique(){
	document.getElementById('matricule_medico').value="";
	document.getElementById('grade_medico').value="";
	document.getElementById('domaine_medico').value="";
}

function vider_logistique(){
	document.getElementById('matricule_logistique').value="";
	document.getElementById('grade_logistique').value="";
	document.getElementById('domaine_logistique').value="";
	document.getElementById('autres_logistique').value="";
}

function getChamps(id){
   
	/***COMPLEMENT MEDECIN***/
	if(id==1){ $('.complement_medico-technique').toggle(false);
	           $('#modifier_champ_medico').toggle(false);
	           $("#vider_champ_medico").toggle(false);
               $("#bouton_valider_donnees_medico").toggle(false);
               
               $(".complement_logistique").toggle(false);
               $('#modifier_champ_logistique').toggle(false);
               $("#vider_champ_logistique").toggle(false);
               $("#bouton_valider_donnees_logistique").toggle(false);
               
               
             
               $('.complement_medecin').toggle(true); 
	           $('#vider_champ2').toggle(true);
               $("#bouton_valider_donnees").toggle(true);
                  $("#matricule").attr( 'readonly', false );
                  $("#grade").attr( 'readonly', false );
                  $("#specialite").attr( 'readonly', false );
                  $("#fonction").attr( 'readonly', false );
                  vider_medecin();
             }
	
	/***COMPLEMENT MEDICO-TECHNIQUE***/
	if(id==2){ $('.complement_medecin').toggle(false);
	           $('#modifier_champ2').toggle(false);
	           $('#vider_champ2').toggle(false);
               $("#bouton_valider_donnees").toggle(false);
               
               $(".complement_logistique").toggle(false);
               $('#modifier_champ_logistique').toggle(false);
               $("#vider_champ_logistique").toggle(false);
               $("#bouton_valider_donnees_logistique").toggle(false); 
               
               
               
               $('.complement_medico-technique').toggle(true);
               $("#vider_champ_medico").toggle(true);
               $("#bouton_valider_donnees_medico").toggle(true);
                  $("#matricule_medico").attr( 'readonly', false );
                  $("#grade_medico").attr( 'readonly', false );
                  $("#domaine_medico").attr( 'readonly', false );
                  vider_medicoTechnique();
	         }
	
	/***COMPLEMENT LOGISTIQUE***/
	if(id==3){
		       $('.complement_medecin').toggle(false);
		       $('#modifier_champ2').toggle(false);
		       $('#vider_champ2').toggle(false);
		       $("#bouton_valider_donnees").toggle(false);
		       
		       $('.complement_medico-technique').toggle(false);
		       $('#modifier_champ_medico').toggle(false);
		       $("#vider_champ_medico").toggle(false);
               $("#bouton_valider_donnees_medico").toggle(false);
               
               
               
               $(".complement_logistique").toggle(true);
               $("#vider_champ_logistique").toggle(true);
               $("#bouton_valider_donnees_logistique").toggle(true);
                  $("#matricule_logistique").attr( 'readonly', false );
                  $("#grade_logistique").attr( 'readonly', false );
                  $("#domaine_logistique").attr( 'readonly', false );
                  $("#autres_logistique").attr( 'readonly', false );
                  vider_logistique();
             }
	
	/***COMPLEMENT MEDICAL***/
	if(id==4){
		       $('.complement_medecin').toggle(false);
		       $('#modifier_champ2').toggle(false);
		       $('#vider_champ2').toggle(false);
               $("#bouton_valider_donnees").toggle(false);
               
		       $('.complement_medico-technique').toggle(false);
		       $("#vider_champ_medico").toggle(false);
		       $("#vider_champ_medico").toggle(false);
		       $("#bouton_valider_donnees_medico").toggle(false);
		       
		       $(".complement_logistique").toggle(false);
		       $('#modifier_champ_logistique').toggle(false);
		       $("#vider_champ_logistique").toggle(false);
               $("#bouton_valider_donnees_logistique").toggle(false);
		     
             }
	
	/************************/
	/***COMPLEMENT MEDECIN***/
	/************************/
	$("#bouton_donnees_valider").click(function(){
		   $("#matricule").attr( 'readonly', true );
               $("#grade").attr( 'readonly', true );
          $("#specialite").attr( 'readonly', true );
            $("#fonction").attr( 'readonly', true );
 	   $("#bouton_valider_donnees").toggle(false);
 		 $('#modifier_champ2').toggle(true);
 	   });
	
	$("#modifier_champ2").click(function(){
		 $("#matricule").attr( 'readonly', false );
             $("#grade").attr( 'readonly', false );
        $("#specialite").attr( 'readonly', false );
          $("#fonction").attr( 'readonly', false );
		$("#bouton_valider_donnees").toggle(true);
   		  $('#modifier_champ2').toggle(false);
	});
	
	$("#vider2").click(function(){
		vider_medecin();
	 });
	
	/*********************************/
	/***COMPLEMENT MEDICO-TECHNIQUE***/
	/*********************************/
	$("#bouton_donnees_valider_medico").click(function(){
	    $("#matricule_medico").attr( 'readonly', true );
            $("#grade_medico").attr( 'readonly', true );
          $("#domaine_medico").attr( 'readonly', true );
	   $("#bouton_valider_donnees_medico").toggle(false);
		 $('#modifier_champ_medico').toggle(true);
	   });
	
	$("#modifier_champ_medico").click(function(){
		$("#matricule_medico").attr( 'readonly', false );
            $("#grade_medico").attr( 'readonly', false );
          $("#domaine_medico").attr( 'readonly', false );
		$("#bouton_valider_donnees_medico").toggle(true);
		  $('#modifier_champ_medico').toggle(false);
	});
	
	$("#vider_champ_medico").click(function(){
		vider_medicoTechnique();
	 });
	
	/*********************************/
	/***COMPLEMENT LOGISTIQUE***/
	/*********************************/
	$("#bouton_donnees_valider_logistique").click(function(){
	    $("#matricule_logistique").attr( 'readonly', true );
            $("#grade_logistique").attr( 'readonly', true );
          $("#domaine_logistique").attr( 'readonly', true );
           $("#autres_logistique").attr( 'readonly', true );
	   $("#bouton_valider_donnees_logistique").toggle(false);
		 $('#modifier_champ_logistique').toggle(true);
	   });
	
	$("#modifier_champ_logistique").click(function(){
		$("#matricule_logistique").attr( 'readonly', false );
            $("#grade_logistique").attr( 'readonly', false );
          $("#domaine_logistique").attr( 'readonly', false );
           $("#autres_logistique").attr( 'readonly', false );
		$("#bouton_valider_donnees_logistique").toggle(true);
		  $('#modifier_champ_logistique').toggle(false);
	});
	
	$("#vider_champ_logistique").click(function(){
		vider_logistique();
	 });

}
