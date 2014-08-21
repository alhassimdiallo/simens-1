
  $(function(){
	$( "#accordionsssss").accordion();
  });
  
  $(function(){
    $( "#accordionssss").accordion();
  });

  $(function() {
	$( "#accordions_resultat" ).accordion();
	$( "#accordions_demande" ).accordion();
	$( "#accordionsss" ).accordion();
  });

  $(function() {
	$( "#accordionss" ).accordion();
  });

  $(function() {
    $( "#accordions" ).accordion();
  });
  
  
  function supprimer_dernier_caractere(elm) {
	  var val = $(elm).val();
	var cursorPos = elm.selectionStart;
	$(elm).val(
	   val.substr(0,cursorPos-1) + // before cursor - 1
	  val.substr(cursorPos,val.length) // after cursor
	);
	elm.selectionStart = cursorPos-1; // replace the cursor at the right place
	elm.selectionEnd = cursorPos-1;
 }

  $(function() {
  /***** Fonction Controle de saisie TEMPERATURE *****/
	 $('body').delegate('input.duree_traitement_ord','keyup',function(){
		    
		    if(!$(this).val().match(/^[0-9]{0,3}$/)) // 0-9 avec deux chiffres uniquement
		      supprimer_dernier_caractere(this);
    });
  });
  /*** FIN ***/

//********************* ANALYSE BIOLOGIQUE *****************************
//********************* ANALYSE BIOLOGIQUE *****************************
$(function(){
/*	var groupe_sanguin = $("#groupe_sanguin");
	var hemogramme_sanguin = $("#hemogramme_sanguin");
	var bilan_hemolyse = $("#bilan_hemolyse");
	var bilan_hepatique = $("#bilan_hepatique");
	var bilan_renal = $("#bilan_renal");
	var bilan_inflammatoire = $("#bilan_inflammatoire");
	
	//Au debut on affiche pas le bouton modifier
	$("#bouton_bio_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_bio_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	groupe_sanguin.attr( 'readonly', false);
	hemogramme_sanguin.attr( 'readonly', false);
	bilan_hemolyse.attr( 'readonly', false);
	bilan_hepatique.attr( 'readonly', false);
	bilan_renal.attr( 'readonly', false);
	bilan_inflammatoire.attr( 'readonly', false);
	
	$("#bouton_bio_valider").click(function(){
		groupe_sanguin.attr( 'readonly', true);
		hemogramme_sanguin.attr( 'readonly', true);
		bilan_hemolyse.attr( 'readonly', true);
		bilan_hepatique.attr( 'readonly', true);
		bilan_renal.attr( 'readonly', true);
		bilan_inflammatoire.attr( 'readonly', true);
		
		$("#bouton_bio_modifier").toggle(true);
		$("#bouton_bio_valider").toggle(false);
		return false;
	});
	
	$("#bouton_bio_modifier").click(function(){
		groupe_sanguin.attr( 'readonly', false);
		hemogramme_sanguin.attr( 'readonly', false);
		bilan_hemolyse.attr( 'readonly', false);
		bilan_hepatique.attr( 'readonly', false);
		bilan_renal.attr( 'readonly', false);
		bilan_inflammatoire.attr( 'readonly', false);
		
		$("#bouton_bio_modifier").toggle(false);
		$("#bouton_bio_valider").toggle(true);
		return false;
	});
	*/
});
  
  
//********************* ANALYSE MORPHOLOGIQUE *****************************
//********************* ANALYSE MORPHOLOGIQUE *****************************
$(function(){
	var radio = $("#radio");
	var ecographie = $("#ecographie");
	var fibrocospie = $("#fibrocospie");
	var scanner = $("#scanner");
	var irm = $("#irm");
	
	//Au debut on affiche pas le bouton modifier
	$("#bouton_morpho_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_morpho_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	radio.attr( 'readonly', false);
	ecographie.attr( 'readonly', false);
	fibrocospie.attr( 'readonly', false);
	scanner.attr( 'readonly', false);
	irm.attr( 'readonly', false);
	
	$("#bouton_morpho_valider").click(function(){
		radio.attr( 'readonly', true);
		ecographie.attr( 'readonly', true);
		fibrocospie.attr( 'readonly', true);
		scanner.attr( 'readonly', true);
		irm.attr( 'readonly', true);
		
		$("#bouton_morpho_modifier").toggle(true);
		$("#bouton_morpho_valider").toggle(false);
		return false;
	});
	
	$("#bouton_morpho_modifier").click(function(){
		radio.attr( 'readonly', false);
		ecographie.attr( 'readonly', false);
		fibrocospie.attr( 'readonly', false);
		scanner.attr( 'readonly', false);
		irm.attr( 'readonly', false);
		
		$("#bouton_morpho_modifier").toggle(false);
		$("#bouton_morpho_valider").toggle(true);
		return false;
	});
	
});
  
  
//********************* DIAGNOSTIC *****************************
//********************* DIAGNOSTIC *****************************
$(function(){
	var diagnostic1 = $("#diagnostic1");
	var diagnostic2 = $("#diagnostic2");
	var diagnostic3 = $("#diagnostic3");
	var diagnostic4 = $("#diagnostic4");
	
	//Au debut on affiche pas le bouton modifier
	$("#bouton_diagnostic_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_diagnostic_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	diagnostic1.attr( 'readonly', false);
	diagnostic2.attr( 'readonly', false);
	diagnostic3.attr( 'readonly', false);
	diagnostic4.attr( 'readonly', false);
	
	$("#bouton_diagnostic_valider").click(function(){
		diagnostic1.attr( 'readonly', true);
		diagnostic2.attr( 'readonly', true);
		diagnostic3.attr( 'readonly', true);
		diagnostic4.attr( 'readonly', true);
		$("#bouton_diagnostic_modifier").toggle(true);
		$("#bouton_diagnostic_valider").toggle(false);
		return false;
	});
	
	$("#bouton_diagnostic_modifier").click(function(){
		diagnostic1.attr( 'readonly', false);
		diagnostic2.attr( 'readonly', false);
		diagnostic3.attr( 'readonly', false);
		diagnostic4.attr( 'readonly', false);
		$("#bouton_diagnostic_modifier").toggle(false);
		$("#bouton_diagnostic_valider").toggle(true);
		return false;
	});
	
});
  
//********************* TRAITEMENTS CHIRURGICAUX *****************************
//********************* TRAITEMENTS CHIRURGICAUX ***************************** 
//********************* TRAITEMENTS CHIRURGICAUX ***************************** 
$(function(){
	var diagnostic_traitement_chirurgical = $("#diagnostic_traitement_chirurgical");
	var intervention_prevue = $("#intervention_prevue");
	var type_anesthesie_demande = $("#type_anesthesie_demande");
	var numero_vpa = $("#numero_vpa");
	var observation = $("#observation");
	
	$("#chirurgicalImpression").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', true);
		intervention_prevue.attr( 'readonly', true);
		type_anesthesie_demande.attr( 'readonly', true);
		numero_vpa.attr( 'readonly', true);
		observation.attr( 'readonly', true);
		
		$("#bouton_chirurgical_modifier").toggle(true);
		$("#bouton_chirurgical_valider").toggle(false);	
	});
	
	//Au debut on affiche pas le bouton modifier, on l'affiche seulement apres impression
	$("#bouton_chirurgical_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_chirurgical_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	diagnostic_traitement_chirurgical.attr( 'readonly', false);
	intervention_prevue.attr( 'readonly', false);
	type_anesthesie_demande.attr( 'readonly', false);
	numero_vpa.attr( 'readonly', false);
	observation.attr( 'readonly', false);
	
	$("#bouton_chirurgical_valider").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', true);
		intervention_prevue.attr( 'readonly', true);
		type_anesthesie_demande.attr( 'readonly', true);
		numero_vpa.attr( 'readonly', true);
		observation.attr( 'readonly', true);
		
		$("#bouton_chirurgical_modifier").toggle(true);
		$("#bouton_chirurgical_valider").toggle(false);
		return false;
	});
	
	$("#bouton_chirurgical_modifier").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', false);
		intervention_prevue.attr( 'readonly', false);
		type_anesthesie_demande.attr( 'readonly', false);
		numero_vpa.attr( 'readonly', false);
		observation.attr( 'readonly', false);
		
		$("#bouton_chirurgical_modifier").toggle(false);
		$("#bouton_chirurgical_valider").toggle(true);
		return false;
	});
	
});

//********************* DONNEES DE L EXAMEN PHYSIQUE *****************************
//********************* DONNEES DE L EXAMEN PHYSIQUE *****************************
$(function(){
	var donnee1 = $("#examen_donnee1");
	var donnee2 = $("#examen_donnee2");
	var donnee3 = $("#examen_donnee3");
	var donnee4 = $("#examen_donnee4");
	var donnee5 = $("#examen_donnee5");
	
	//Au debut on affiche pas le bouton modifier
	$("#bouton_donnee_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_donnee_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	donnee1.attr( 'readonly', false);
	donnee2.attr( 'readonly', false);
	donnee3.attr( 'readonly', false);
	donnee4.attr( 'readonly', false);
	donnee5.attr( 'readonly', false);
	
	$("#bouton_donnee_valider").click(function(){
		donnee1.attr( 'readonly', true);
		donnee2.attr( 'readonly', true);
		donnee3.attr( 'readonly', true);
		donnee4.attr( 'readonly', true);
		donnee5.attr( 'readonly', true);
		$("#bouton_donnee_modifier").toggle(true);
		$("#bouton_donnee_valider").toggle(false);
		return false;
	});
	
	$("#bouton_donnee_modifier").click(function(){
		donnee1.attr( 'readonly', false);
		donnee2.attr( 'readonly', false);
		donnee3.attr( 'readonly', false);
		donnee4.attr( 'readonly', false);
		donnee5.attr( 'readonly', false);
		$("#bouton_donnee_modifier").toggle(false);
		$("#bouton_donnee_valider").toggle(true);
		return false;
	});
	
});


// *************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************
// *************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************
// *************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************

// ******************* Tranfert ******************************** 
// ******************* Tranfert ******************************** 
$(function(){
	var motif_transfert = $("#motif_transfert");
	var hopital_accueil = $("#hopital_accueil");
	var service_accueil = $("#service_accueil");
	$("#transfert").click(function(){
		motif_transfert.attr( 'readonly', true);
		$("#hopital_accueil_tampon").val(hopital_accueil.val());
		hopital_accueil.attr( 'disabled', true);
		$("#service_accueil_tampon").val(service_accueil.val());
		service_accueil.attr( 'disabled', true);
		$("#bouton_transfert_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
	    $("#bouton_transfert_valider").toggle(false); //on cache le bouton permettant de valider les champs
	});

	$( "bouton_valider_transfert" ).button();
	$( "bouton_modifier_transfert" ).button();

	//Au debut on cache le bouton modifier et on affiche le bouton valider
	$( "#bouton_transfert_valider" ).toggle(true);
	$( "#bouton_transfert_modifier" ).toggle(false);

	//Au debut on desactive tous les champs
	motif_transfert.attr( 'readonly', false );
	hopital_accueil.attr( 'disabled', false );
	service_accueil.attr( 'disabled', false );

	//Valider(caché) avec le bouton 'valider'
	$( "#bouton_transfert_valider" ).click(function(){
		motif_transfert.attr( 'readonly', true );     //désactiver le motif transfert
		$("#hopital_accueil_tampon").val(hopital_accueil.val());
		hopital_accueil.attr( 'disabled', true );     //désactiver hopital accueil
		$("#service_accueil_tampon").val(service_accueil.val());
		service_accueil.attr( 'disabled', true );   //désactiver service accueil
		$("#bouton_transfert_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
		$("#bouton_transfert_valider").toggle(false); //on cache le bouton permettant de valider les champs
		return false; 
	});
	//Activer(décaché) avec le bouton 'modifier'
	$( "#bouton_transfert_modifier" ).click(function(){
		motif_transfert.attr( 'readonly', false );
		hopital_accueil.attr( 'disabled', false );
		service_accueil.attr( 'disabled', false );
	 	$("#bouton_transfert_modifier").toggle(false);   //on cache le bouton permettant de modifier les champs
	 	$("#bouton_transfert_valider").toggle(true);    //on affiche le bouton permettant de valider les champs
	 	return  false;
	});
});

//********************* HOSPITALISATION *****************************
//********************* HOSPITALISATION *****************************
$(function(){
	var motif_hospitalisation = $("#motif_hospitalisation");
	$("#hospitalisation").click(function(){
		motif_hospitalisation.attr( 'readonly', true);
		$("#bouton_hospi_modifier").toggle(true);
		$("#bouton_hospi_valider").toggle(false);	
	});
	
	//Au debut on affiche pas le bouton modifier
	$("#bouton_hospi_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_hospi_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	motif_hospitalisation.attr( 'readonly', false);
	
	$("#bouton_hospi_valider").click(function(){
		motif_hospitalisation.attr( 'readonly', true);
		$("#bouton_hospi_modifier").toggle(true);
		$("#bouton_hospi_valider").toggle(false);
		return false;
	});
	
	$("#bouton_hospi_modifier").click(function(){
		motif_hospitalisation.attr( 'readonly', false);
		$("#bouton_hospi_modifier").toggle(false);
		$("#bouton_hospi_valider").toggle(true);
		return false;
	});
	
});

//********************* RENDEZ VOUS *****************************
//********************* RENDEZ VOUS *****************************
 $(function() {
 var motif_rv = $('#motif_rv');
 var date_rv = $( "#date_rv" );
 var heure_rv = $("#heure_rv");
   $( "#disable" ).click(function(){
	  motif_rv.attr( 'readonly', true );     //désactiver le motif
	  $("#date_rv_tampon").val(date_rv.val()); //Placer la date dans date_rv_tampon avant la desacivation
      date_rv.attr( 'disabled', true );     //désactiver la date
      $("#heure_rv_tampon").val(heure_rv.val()); //Placer l'heure dans heure_rv_tampon avant la desacivation
      heure_rv.attr( 'disabled', true );   //désactiver l'heure
      $("#disable_bouton").toggle(true);  //on affiche le bouton permettant de modifier les champs
      $("#enable_bouton").toggle(false); //on cache le bouton permettant de valider les champs
 
      date_rv.val(date);
   });
   
   $( "button" ).button();
   //$( "bouton_valider" ).button();

   //Au debut on affiche pas le bouton modifier, on l'affiche seulement apres impression
   $("#disable_bouton").toggle(false);
   //Au debut on affiche le bouton valider
   $("#enable_bouton").toggle(true);
   
   //Au debut on desactive tous les champs
   motif_rv.attr( 'readonly', false );
   date_rv.attr( 'disabled', false );
   heure_rv.attr( 'disabled', false );

   //Valider(caché) avec le bouton 'valider'
   $( "#enable_bouton" ).click(function(){
	  motif_rv.attr( 'readonly', true );     //désactiver le motif
	  $("#date_rv_tampon").val(date_rv.val()); //Placer la date dans date_rv_tampon avant la desacivation
      date_rv.attr( 'disabled', true );     //désactiver la date
      $("#heure_rv_tampon").val(heure_rv.val()); //Placer l'heure dans heure_rv_tampon avant la desacivation
	  heure_rv.attr( 'disabled', true );   //désactiver l'heure
	  $("#disable_bouton").toggle(true);  //on affiche le bouton permettant de modifier les champs
	  $("#enable_bouton").toggle(false); //on cache le bouton permettant de valider les champs
	  return false; 
   });
   //Activer(décaché) avec le bouton 'modifier'
   $( "#disable_bouton" ).click(function(){
	  motif_rv.attr( 'readonly', false );      //activer le motif
	  date_rv.attr( 'disabled', false );      //activer la date
	  heure_rv.attr( 'disabled', false );    //activer l'heure
 	  $("#disable_bouton").toggle(false);   //on cache le bouton permettant de modifier les champs
 	  $("#enable_bouton").toggle(true);    //on affiche le bouton permettant de valider les champs
 	  return  false;
   });
   
 });
 
//Boite de dialogue de confirmation d'annulation
//Boite de dialogue de confirmation d'annulation
//Boite de dialogue de confirmation d'annulation

/***BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION**/
/***BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION**/

 $(document).ready(function() {
	var theHREF = "/simens_derniereversion/public/consultation/Consultation/consultationmedecin";
	function confirmation(){
		
 		$( "#confirmation2" ).dialog({
 		    resizable: false,
 		    height:170,
 		    width:505,
 		    autoOpen: false,
 		    modal: true,
 		    buttons: {
 		        "Oui": function() {
 		            $( this ).dialog( "close" );
 		            window.location.href = theHREF;   
 		        },
 		        "Non": function() {
 		            $( this ).dialog( "close" );
 		        }
 		    }
 		});
    }
	
	$("#annuler2").click(function() {
       event.preventDefault(); 
       confirmation(); 
       $("#confirmation2").dialog('open');
    }); 
	
		
/***ON CREE UN FORMULAIRE OU ON MET LES DONNEES POUR POUVOIR LES RECUPERER AVEC LA METHOD POST**/
/***ON CREE UN FORMULAIRE OU ON MET LES DONNEES POUR POUVOIR LES RECUPERER AVEC LA METHOD POST**/
	//Method POST pour consultationmedecin
	//Method POST pour consultationmedecin
	//Method POST pour consultationmedecin
	function executerRequetePost(donnees) {
		// Le formulaire « monFormulaire » existe déjà dans la page
	    var formulaire = document.createElement("form");
	 
	    formulaire.setAttribute("action","/simens_derniereversion/public/consultation/Consultation/consultationmedecin/terminer/save"); 
	    formulaire.setAttribute("method","POST"); 
	    for( donnee in donnees){
	     // Ajout dynamique de champs dans le formulaire
	        var champ = document.createElement("input");
	        champ.setAttribute("type", "hidden");
	        champ.setAttribute("name", donnee);
	        champ.setAttribute("value", donnees[donnee]);
	        formulaire.appendChild(champ);
	    }
	    // Envoi de la requête
	    formulaire.submit();
	    // Suppression du formulaire
	    document.body.removeChild(formulaire);
	}
	
    /***LORS DU CLICK SUR 'Terminer' ****/
	/***LORS DU CLICK SUR 'Terminer' ****/
	$("#terminer2").click(function() {
		event.preventDefault(); 
	    var donnees = new Array();
	    donnees['id_cons']    = $("#id_cons").val();
	    
	    // **********-- Donnees de l'examen physique --*******
        // **********-- Donnees de l'examen physique --*******
	    donnees['examen_donnee1'] = $("#examen_donnee1").val();
	    donnees['examen_donnee2'] = $("#examen_donnee2").val();
	    donnees['examen_donnee3'] = $("#examen_donnee3").val();
	    donnees['examen_donnee4'] = $("#examen_donnee4").val();
	    donnees['examen_donnee5'] = $("#examen_donnee5").val();
	    
	    //**********-- ANALYSE BIOLOGIQUE --************
        //**********-- ANALYSE BIOLOGIQUE --************
	    donnees['groupe_sanguin']      = $("#groupe_sanguin").val();
	    donnees['hemogramme_sanguin']  = $("#hemogramme_sanguin").val();
	    donnees['bilan_hemolyse']      = $("#bilan_hemolyse").val();
	    donnees['bilan_hepatique']     = $("#bilan_hepatique").val();
	    donnees['bilan_renal']         = $("#bilan_renal").val();
	    donnees['bilan_inflammatoire'] = $("#bilan_inflammatoire").val();
	    
	    //**********-- ANALYSE MORPHOLOGIQUE --************
        //**********-- ANALYSE MORPHOLOGIQUE --************
	    donnees['radio_']        = $("#radio").val();
	    donnees['ecographie_']   = $("#ecographie").val();
	    donnees['fibroscopie_']  = $("#fibrocospie").val();
	    donnees['scanner_']      = $("#scanner").val();
	    donnees['irm_']          = $("#irm").val();
	    
	    //*********** DIAGNOSTICS ************
	    //*********** DIAGNOSTICS ************
	    donnees['diagnostic1'] = $("#diagnostic1").val();
	    donnees['diagnostic2'] = $("#diagnostic2").val();
	    donnees['diagnostic3'] = $("#diagnostic3").val();
	    donnees['diagnostic4'] = $("#diagnostic4").val();
	    
	    //*********** ORDONNACE (Médical) ************
	    //*********** ORDONNACE (Médical) ************
	    donnees['duree_traitement_ord'] = $("#duree_traitement_ord").val();
	     
	    for(var i = 1 ; i < 10 ; i++ ){
	     	if($("#medicament_0"+i).val()){
	     		donnees['medicament_0'+i] = $("#medicament_0"+i).val();
	     		donnees['medicament_1'+i] = $("#medicament_1"+i).val();
	     		donnees['medicament_2'+i] = $("#medicament_2"+i).val();
	     		donnees['medicament_3'+i] = $("#medicament_3"+i).val();
	     	}
	     }
	    
	    //*********** TRAITEMENTS CHIRURGICAUX ************
		//*********** TRAITEMENTS CHIRURGICAUX ************
	    donnees['diagnostic_traitement_chirurgical'] = $("#diagnostic_traitement_chirurgical").val();
	    donnees['intervention_prevue'] = $("#intervention_prevue").val();
	    donnees['type_anesthesie_demande'] = $("#type_anesthesie_demande").val();
	    donnees['numero_vpa'] = $("#numero_vpa").val();
	    donnees['observation'] = $("#observation").val();
	    
	    // **********-- Rendez Vous --*******
        // **********-- Rendez Vous --*******
		donnees['id_patient'] = $("#id_patient").val();
		   //Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas désactiver
		   if($("#date_rv").val()){$("#date_rv_tampon").val($("#date_rv").val());}
		donnees['date_rv']    = $("#date_rv_tampon").val();
		donnees['motif_rv']   = $("#motif_rv").val();
		   //Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas désactiver
		   if($("#heure_rv").val()){$("#heure_rv_tampon").val($("#heure_rv").val());}
		donnees['heure_rv']   = $("#heure_rv_tampon").val();
		
		// **********-- Hospitalisation --*******
        // **********-- Hospitalisation --*******
		donnees['motif_hospitalisation'] = $("#motif_hospitalisation").val();
		
		// **********-- Transfert --*******
        // **********-- Transfert --*******
		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas désactiver
		   if($("#service_accueil").val()){$("#service_accueil_tampon").val($("#service_accueil").val());};
		
		donnees['id_service']      = $("#service_accueil_tampon").val();
		donnees['med_id_personne'] = $("#id_medecin").val();
		donnees['date']            = $("#date_cons").val();
		donnees['motif_transfert'] = $("#motif_transfert").val();
	    
		
		//**********-- Demande Examens (Biologique et Morphologique) --********
		//**********-- Demande Examens (Biologique et Morphologique) --********
	    var checkbox = [];
	    $('input[name="cdemande"]:checked').each(function(i){
	      checkbox[$(this).attr('value')] = $(this).attr('value');
	    });
	    
	    if(!checkbox[1]){ checkbox[1] = null;}
	    if(!checkbox[2]){ checkbox[2] = null;}
	    if(!checkbox[3]){ checkbox[3] = null;}
	    if(!checkbox[4]){ checkbox[4] = null;}
	    if(!checkbox[5]){ checkbox[5] = null;}
	    if(!checkbox[6]){ checkbox[6] = null;}
	    if(!checkbox[7]){ checkbox[7] = null;}
	    if(!checkbox[8]){ checkbox[8] = null;}
	    if(!checkbox[9]){ checkbox[9] = null;}
	    if(!checkbox[10]){ checkbox[10] = null;}
	    if(!checkbox[11]){ checkbox[11] = null;}
	    if(!checkbox[12]){ checkbox[12] = null;}
	    if(!checkbox[13]){ checkbox[13] = null;}
	    
		donnees['groupe']        = checkbox[1];
		donnees['hemmogramme']   = checkbox[2];
		donnees['hepatique']     = checkbox[3];
		donnees['renal']         = checkbox[4];
		donnees['hemostase']     = checkbox[5];
		donnees['inflammatoire'] = checkbox[6];
		donnees['autreb']        = checkbox[7];
		donnees['radio']         = checkbox[8];
		donnees['ecographie']    = checkbox[9];
		donnees['irm']           = checkbox[10];
		donnees['scanner']       = checkbox[11];
		donnees['fibroscopie']   = checkbox[12];
		donnees['autrem']        = checkbox[13];
		
		
		//note sur les examens
		donnees['ngroupe']       = $("#note1").val();
		donnees['nhemmogramme']  = $("#note2").val();
		donnees['nhepatique']    = $("#note3").val();
		donnees['nrenal']        = $("#note4").val();
		donnees['nhemostase']    = $("#note5").val();
		donnees['ninflammatoire']= $("#note6").val();
		donnees['nautreb']       = $("#note7").val();
		donnees['nradio']        = $("#note8").val();
		donnees['necographie']   = $("#note9").val();
		donnees['nirm']          = $("#note10").val();
		donnees['nscanner']      = $("#note11").val();
		donnees['nfibroscopie']  = $("#note12").val();
		donnees['nautrem']       = $("#note13").val();
		
		executerRequetePost(donnees);
	});
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--*-*-*-*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-**--*-**-*--**-*-*-*-*-*-*-*-*-*-*-*-*-*--**-*-*-*-*-	
	//Method envoi POST pour updatecomplementconsultation
	//Method envoi POST pour updatecomplementconsultation
	//Method envoi POST pour updatecomplementconsultation
	function updateexecuterRequetePost(donnees) {
		// Le formulaire « monFormulaire » existe déjà dans la page
	    var formulaire = document.createElement("form");
	 
	    formulaire.setAttribute("action","/simens_derniereversion/public/consultation/Consultation/updatecomplementconsultation"); 
	    formulaire.setAttribute("method","POST"); 
	    for( donnee in donnees){
	     // Ajout dynamique de champs dans le formulaire
	        var champ = document.createElement("input");
	        champ.setAttribute("type", "hidden");
	        champ.setAttribute("name", donnee);
	        champ.setAttribute("value", donnees[donnee]);
	        formulaire.appendChild(champ);
	    }
        
	    // Envoi de la requête
	    formulaire.submit();
	    // Suppression du formulaire
	    document.body.removeChild(formulaire);
	}
	
    /***LORS DU CLICK SUR 'Terminer' ****/
	/***LORS DU CLICK SUR 'Terminer' ****/
	$("#terminer3").click(function() {
		event.preventDefault(); 
	    var donnees = new Array();
	    donnees['id_cons']    = $("#id_cons").val();
	    
	    // **********-- Donnees de l'examen physique --*******
        // **********-- Donnees de l'examen physique --*******
	    donnees['examen_donnee1'] = $("#examen_donnee1").val();
	    donnees['examen_donnee2'] = $("#examen_donnee2").val();
	    donnees['examen_donnee3'] = $("#examen_donnee3").val();
	    donnees['examen_donnee4'] = $("#examen_donnee4").val();
	    donnees['examen_donnee5'] = $("#examen_donnee5").val();
	    
	    //**********-- ANALYSE BIOLOGIQUE --************
        //**********-- ANALYSE BIOLOGIQUE --************
	    donnees['groupe_sanguin']      = $("#groupe_sanguin").val();
	    donnees['hemogramme_sanguin']  = $("#hemogramme_sanguin").val();
	    donnees['bilan_hemolyse']      = $("#bilan_hemolyse").val();
	    donnees['bilan_hepatique']     = $("#bilan_hepatique").val();
	    donnees['bilan_renal']         = $("#bilan_renal").val();
	    donnees['bilan_inflammatoire'] = $("#bilan_inflammatoire").val();
	    
	    //**********-- ANALYSE MORPHOLOGIQUE --************
        //**********-- ANALYSE MORPHOLOGIQUE --************
	    donnees['radio_']        = $("#radio").val();
	    donnees['ecographie_']   = $("#ecographie").val();
	    donnees['fibroscopie_']  = $("#fibrocospie").val();
	    donnees['scanner_']      = $("#scanner").val();
	    donnees['irm_']          = $("#irm").val();
	    
	    //*********** DIAGNOSTICS ************
	    //*********** DIAGNOSTICS ************
	    donnees['diagnostic1'] = $("#diagnostic1").val();
	    donnees['diagnostic2'] = $("#diagnostic2").val();
	    donnees['diagnostic3'] = $("#diagnostic3").val();
	    donnees['diagnostic4'] = $("#diagnostic4").val();
	    
	    //*********** ORDONNACE (Médical) ************
	    //*********** ORDONNACE (Médical) ************
	    donnees['duree_traitement_ord'] = $("#duree_traitement_ord").val();
	     
	    for(var i = 1 ; i < 10 ; i++ ){
	     	if($("#medicament_0"+i).val()){
	     		donnees['medicament_0'+i] = $("#medicament_0"+i).val();
	     		donnees['medicament_1'+i] = $("#medicament_1"+i).val();
	     		donnees['medicament_2'+i] = $("#medicament_2"+i).val();
	     		donnees['medicament_3'+i] = $("#medicament_3"+i).val();
	     	}
	     }
	    
	    //*********** TRAITEMENTS CHIRURGICAUX ************
		//*********** TRAITEMENTS CHIRURGICAUX ************
	    donnees['diagnostic_traitement_chirurgical'] = $("#diagnostic_traitement_chirurgical").val();
	    donnees['intervention_prevue'] = $("#intervention_prevue").val();
	    donnees['type_anesthesie_demande'] = $("#type_anesthesie_demande").val();
	    donnees['numero_vpa'] = $("#numero_vpa").val();
	    donnees['observation'] = $("#observation").val();
	    
	    // **********-- Rendez Vous --*******
        // **********-- Rendez Vous --*******
		donnees['id_patient'] = $("#id_patient").val();
		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas désactiver
		   if($("#date_rv").val()){$("#date_rv_tampon").val($("#date_rv").val());}
		donnees['date_rv']    = $("#date_rv_tampon").val();
		donnees['motif_rv']   = $("#motif_rv").val();
		donnees['heure_rv']   = $("#heure_rv").val();
		
		// **********-- Hospitalisation --*******
        // **********-- Hospitalisation --*******
		donnees['motif_hospitalisation'] = $("#motif_hospitalisation").val();
		
		// **********-- Transfert --*******
        // **********-- Transfert --*******
		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas désactiver
		   if($("#service_accueil").val()){$("#service_accueil_tampon").val($("#service_accueil").val());};
		
		donnees['id_service']      = $("#service_accueil_tampon").val();
		donnees['med_id_personne'] = $("#id_medecin").val();
		donnees['date']            = $("#date_cons").val();
		donnees['motif_transfert'] = $("#motif_transfert").val();
	    
	   
		//**********-- Demande Examens (Biologique et Morphologique) --********
		//**********-- Demande Examens (Biologique et Morphologique) --********
		//var j=1;
	    var checkbox = [];
	    $('input[name="cdemande"]:checked').each(function(i){
	      checkbox[$(this).attr('value')] = $(this).attr('value');
	    });
	    
	    if(!checkbox[1]){ checkbox[1] = null;}
	    if(!checkbox[2]){ checkbox[2] = null;}
	    if(!checkbox[3]){ checkbox[3] = null;}
	    if(!checkbox[4]){ checkbox[4] = null;}
	    if(!checkbox[5]){ checkbox[5] = null;}
	    if(!checkbox[6]){ checkbox[6] = null;}
	    if(!checkbox[7]){ checkbox[7] = null;}
	    if(!checkbox[8]){ checkbox[8] = null;}
	    if(!checkbox[9]){ checkbox[9] = null;}
	    if(!checkbox[10]){ checkbox[10] = null;}
	    if(!checkbox[11]){ checkbox[11] = null;}
	    if(!checkbox[12]){ checkbox[12] = null;}
	    if(!checkbox[13]){ checkbox[13] = null;}
	    
		donnees['groupe']        = checkbox[1];
		donnees['hemmogramme']   = checkbox[2];
		donnees['hepatique']     = checkbox[3];
		donnees['renal']         = checkbox[4];
		donnees['hemostase']     = checkbox[5];
		donnees['inflammatoire'] = checkbox[6];
		donnees['autreb']        = checkbox[7];
		donnees['radio']         = checkbox[8];
		donnees['ecographie']    = checkbox[9];
		donnees['irm']           = checkbox[10];
		donnees['scanner']       = checkbox[11];
		donnees['fibroscopie']   = checkbox[12];
		donnees['autrem']        = checkbox[13];
		
		
		//note sur les examens
		donnees['ngroupe']       = $("#note1").val();
		donnees['nhemmogramme']  = $("#note2").val();
		donnees['nhepatique']    = $("#note3").val();
		donnees['nrenal']        = $("#note4").val();
		donnees['nhemostase']    = $("#note5").val();
		donnees['ninflammatoire']= $("#note6").val();
		donnees['nautreb']       = $("#note7").val();
		donnees['nradio']        = $("#note8").val();
		donnees['necographie']   = $("#note9").val();
		donnees['nirm']          = $("#note10").val();
		donnees['nscanner']      = $("#note11").val();
		donnees['nfibroscopie']  = $("#note12").val();
		donnees['nautrem']       = $("#note13").val();
		
		updateexecuterRequetePost(donnees);
	});
	
	
	
	//Annuler le transfert au clic
	$("#annulertransfert").click(function() {
		$("#motif_transfert").val("");
		document.getElementById('hopital_accueil').value="";
		document.getElementById('service_accueil').value="";
		return false;
	});
	
	//Annuler le rendez-vous au clic
	$("#annulerrendezvous").click(function() {
		$("#motif_rv").val("");
		$("#date_rv").val("");
		document.getElementById('heure_rv').value="";
		return false;
	});
	
	//Annuler le traitement chirurgical au clic
	$("#annuler_traitement_chirurgical").click(function() {
		$("#diagnostic_traitement_chirurgical").val("");
		$("#intervention_prevue").val("");
		document.getElementById('type_anesthesie_demande').value="";
		$("#numero_vpa").val("");
		$("#observation").val("");
		return false;
	});

});

 /**************************************************************************************************************/
 
 /*============================================== MENU ANTECEDENTS ============================================*/
 
 /**************************************************************************************************************/
 function AntecedentScript(){
	 $(function(){
		//CONSULTATION
		//CONSULTATION
		$("#titreTableauConsultation").toggle(false);
		$("#ListeConsultationPatient").toggle(false);
		$("#boutonTerminerConsultation").toggle(false);
		$(".pager").toggle(false);
		//HOSPITALISATION
		//HOSPITALISATION
		$("#titreTableauHospitalisation").toggle(false);
		$("#boutonTerminerHospitalisation").toggle(false);
		$("#ListeHospitalisation").toggle(false);
		
		
		//CONSULTATION
		//CONSULTATION
		$(".image1").click(function(){
			
			 $("#MenuAntecedent").fadeOut(function(){ 
				 $("#titreTableauConsultation").fadeIn("fast");
				 $("#ListeConsultationPatient").fadeIn("fast"); 
			     $("#boutonTerminerConsultation").toggle(true);
			     $(".pager").toggle(true);
			 });
		});
		
		$("#TerminerConsultation").click(function(){
			$("#boutonTerminerConsultation").fadeOut();
			$(".pager").fadeOut();
			$("#titreTableauConsultation").fadeOut();
			$("#ListeConsultationPatient").fadeOut(function(){ 
			    $("#MenuAntecedent").fadeIn("fast");
			});
		});
		
		//HOSPITALISATION
		//HOSPITALISATION
		$(".image2").click(function(){
			 $("#MenuAntecedent").fadeOut(function(){ 
				 $("#titreTableauHospitalisation").fadeIn("fast");
			     $("#boutonTerminerHospitalisation").toggle(true);
			     $("#ListeHospitalisation").fadeIn("fast");
			 });
		});
		
		$("#TerminerHospitalisation").click(function(){
			$("#boutonTerminerHospitalisation").fadeOut();
			$("#ListeHospitalisation").fadeOut();
			$("#titreTableauHospitalisation").fadeOut(function(){ 
			    $("#MenuAntecedent").fadeIn("fast");
			});
		});
		
		
	 });
	 
}
 
 
 /***************************************************************************************/
 
 /**========================== PAGINATION INTERVENTION ================================**/
 
 /***************************************************************************************/

 function pagination(){
	  $(function(){
 		//CODE POUR INITIALISER LA LISTE 
 		$('#ListeConsultationPatient').each(function() {
             var currentPage = 0;
             var numPerPage = 3;
             var $table = $(this);
               $table.find('tbody tr').hide()
                 .slice(currentPage * numPerPage, (currentPage + 1) * numPerPage)
                 .show();
 		});
 		//CODE POUR LA PAGINATION
         $('#ListeConsultationPatient').each(function() {
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
             
             
             for (var page = 0; page < numPages; page++) {
               $('<a class="page-number" id="page_number" style="cursor:pointer; margin-right: 5px; background: #efefef; width:80px; height:80px; padding-left: 10px; padding-right: 10px; padding-top: 2px; padding-bottom: 2px; border: 1px solid gray;"></a>').text(page + 1)
                 .bind('click', {newPage: page}, function(event) {
                   currentPage = event.data['newPage'];
                   repaginate();
                   $(this).addClass('active').css({'background': '#8e908d', 'color':'white'}).siblings().removeClass('active').css({'background': '#efefef', 'color':'black'});
                 }).appendTo($pager).addClass('clickable');
             }
           
             
             $pager.insertAfter($table)
               .find('a.page-number:first').addClass('active').css({'background': '#8e908d', 'color':'white'});
           });
	  });
 }
 