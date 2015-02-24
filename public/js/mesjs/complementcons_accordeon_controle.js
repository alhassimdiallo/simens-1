
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
		radio.attr( 'readonly', true).css({'background':'#f8f8f8'});
		ecographie.attr( 'readonly', true).css({'background':'#f8f8f8'});
		fibrocospie.attr( 'readonly', true).css({'background':'#f8f8f8'});
		scanner.attr( 'readonly', true).css({'background':'#f8f8f8'});
		irm.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_morpho_modifier").toggle(true);
		$("#bouton_morpho_valider").toggle(false);
		return false;
	});
	
	$("#bouton_morpho_modifier").click(function(){
		radio.attr( 'readonly', false).css({'background':'#fff'});
		ecographie.attr( 'readonly', false).css({'background':'#fff'});
		fibrocospie.attr( 'readonly', false).css({'background':'#fff'});
		scanner.attr( 'readonly', false).css({'background':'#fff'});
		irm.attr( 'readonly', false).css({'background':'#fff'});
		
		$("#bouton_morpho_modifier").toggle(false);
		$("#bouton_morpho_valider").toggle(true);
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
		diagnostic_traitement_chirurgical.attr( 'readonly', true).css({'background':'#f8f8f8'});
		intervention_prevue.attr( 'readonly', true).css({'background':'#f8f8f8'});
		type_anesthesie_demande.attr( 'readonly', true).css({'background':'#f8f8f8'});
		numero_vpa.attr( 'readonly', true).css({'background':'#f8f8f8'});
		observation.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_chirurgical_modifier").toggle(true);
		$("#bouton_chirurgical_valider").toggle(false);	
	});
	
	//Au debut on affiche pas le bouton modifier, on l'affiche seulement apres impression
	$("#bouton_chirurgical_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_chirurgical_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	diagnostic_traitement_chirurgical.attr( 'readonly', false).css({'background':'#fff'});
	intervention_prevue.attr( 'readonly', false).css({'background':'#fff'});
	type_anesthesie_demande.attr( 'readonly', false).css({'background':'#fff'});
	numero_vpa.attr( 'readonly', false).css({'background':'#fff'});
	observation.attr( 'readonly', false).css({'background':'#fff'});
	
	$("#bouton_chirurgical_valider").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', true).css({'background':'#f8f8f8'});
		intervention_prevue.attr( 'readonly', true).css({'background':'#f8f8f8'});
		type_anesthesie_demande.attr( 'readonly', true).css({'background':'#f8f8f8'});
		numero_vpa.attr( 'readonly', true).css({'background':'#f8f8f8'});
		observation.attr( 'readonly', true).css({'background':'#f8f8f8'});
		
		$("#bouton_chirurgical_modifier").toggle(true);
		$("#bouton_chirurgical_valider").toggle(false);
		return false;
	});
	
	$("#bouton_chirurgical_modifier").click(function(){
		diagnostic_traitement_chirurgical.attr( 'readonly', false).css({'background':'#fff'});
		intervention_prevue.attr( 'readonly', false).css({'background':'#fff'});
		type_anesthesie_demande.attr( 'readonly', false).css({'background':'#fff'});
		numero_vpa.attr( 'readonly', false).css({'background':'#fff'});
		observation.attr( 'readonly', false).css({'background':'#fff'});
		
		$("#bouton_chirurgical_modifier").toggle(false);
		$("#bouton_chirurgical_valider").toggle(true);
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
		motif_transfert.attr( 'readonly', true).css({'background':'#f8f8f8'});
		$("#hopital_accueil_tampon").val(hopital_accueil.val());
		hopital_accueil.attr( 'disabled', true).css({'background':'#f8f8f8'});
		$("#service_accueil_tampon").val(service_accueil.val());
		service_accueil.attr( 'disabled', true).css({'background':'#f8f8f8'});
		$("#bouton_transfert_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
	    $("#bouton_transfert_valider").toggle(false); //on cache le bouton permettant de valider les champs
	});

	$( "bouton_valider_transfert" ).button();
	$( "bouton_modifier_transfert" ).button();

	//Au debut on cache le bouton modifier et on affiche le bouton valider
	$( "#bouton_transfert_valider" ).toggle(true);
	$( "#bouton_transfert_modifier" ).toggle(false);

	//Au debut on desactive tous les champs
	motif_transfert.attr( 'readonly', false ).css({'background':'#fff'});;
	hopital_accueil.attr( 'disabled', false ).css({'background':'#fff'});;
	service_accueil.attr( 'disabled', false ).css({'background':'#fff'});;

	//Valider(cachï¿½) avec le bouton 'valider'
	$( "#bouton_transfert_valider" ).click(function(){
		motif_transfert.attr( 'readonly', true ).css({'background':'#f8f8f8'});     //dï¿½sactiver le motif transfert
		$("#hopital_accueil_tampon").val(hopital_accueil.val());
		hopital_accueil.attr( 'disabled', true ).css({'background':'#f8f8f8'});     //dï¿½sactiver hopital accueil
		$("#service_accueil_tampon").val(service_accueil.val());
		service_accueil.attr( 'disabled', true ).css({'background':'#f8f8f8'});   //dï¿½sactiver service accueil
		$("#bouton_transfert_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
		$("#bouton_transfert_valider").toggle(false); //on cache le bouton permettant de valider les champs
		return false; 
	});
	//Activer(dï¿½cachï¿½) avec le bouton 'modifier'
	$( "#bouton_transfert_modifier" ).click(function(){
		motif_transfert.attr( 'readonly', false ).css({'background':'#fff'});
		hopital_accueil.attr( 'disabled', false ).css({'background':'#fff'});
		service_accueil.attr( 'disabled', false ).css({'background':'#fff'});
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
		motif_hospitalisation.attr( 'readonly', true).css({'background':'#f8f8f8'});
		$("#bouton_hospi_modifier").toggle(true);
		$("#bouton_hospi_valider").toggle(false);	
	});
	
	//Au debut on affiche pas le bouton modifier
	$("#bouton_hospi_modifier").toggle(false);
	//Au debut on affiche le bouton valider
	$("#bouton_hospi_valider").toggle(true);
	
	//Au debut on desactive tous les champs
	motif_hospitalisation.attr( 'readonly', false).css({'background':'#fff'});
	
	$("#bouton_hospi_valider").click(function(){
		motif_hospitalisation.attr( 'readonly', true).css({'background':'#f8f8f8'});
		$("#bouton_hospi_modifier").toggle(true);
		$("#bouton_hospi_valider").toggle(false);
		return false;
	});
	
	$("#bouton_hospi_modifier").click(function(){
		motif_hospitalisation.attr( 'readonly', false).css({'background':'#fff'});
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
   date_rv.attr('autocomplete', 'off');
   $( "#disable" ).click(function(){
	  motif_rv.attr( 'readonly', true ).css({'background':'#f8f8f8'});     //dï¿½sactiver le motif
	  $("#date_rv_tampon").val(date_rv.val()); //Placer la date dans date_rv_tampon avant la desacivation
      date_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});     //dï¿½sactiver la date
      $("#heure_rv_tampon").val(heure_rv.val()); //Placer l'heure dans heure_rv_tampon avant la desacivation
      heure_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});   //dï¿½sactiver l'heure
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
   motif_rv.attr( 'readonly', false ).css({'background':'#fff'});
   date_rv.attr( 'disabled', false ).css({'background':'#fff'});
   heure_rv.attr( 'disabled', false ).css({'background':'#fff'});

   //Valider(cachï¿½) avec le bouton 'valider'
   $( "#enable_bouton" ).click(function(){
	  motif_rv.attr( 'readonly', true ).css({'background':'#f8f8f8'});     //dï¿½sactiver le motif
	  $("#date_rv_tampon").val(date_rv.val()); //Placer la date dans date_rv_tampon avant la desacivation
      date_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});     //dï¿½sactiver la date
      $("#heure_rv_tampon").val(heure_rv.val()); //Placer l'heure dans heure_rv_tampon avant la desacivation
	  heure_rv.attr( 'disabled', true ).css({'background':'#f8f8f8'});   //dï¿½sactiver l'heure
	  $("#disable_bouton").toggle(true);  //on affiche le bouton permettant de modifier les champs
	  $("#enable_bouton").toggle(false); //on cache le bouton permettant de valider les champs
	  return false; 
   });
   //Activer(dï¿½cachï¿½) avec le bouton 'modifier'
   $( "#disable_bouton" ).click(function(){
	  motif_rv.attr( 'readonly', false ).css({'background':'#fff'});      //activer le motif
	  date_rv.attr( 'disabled', false ).css({'background':'#fff'});      //activer la date
	  heure_rv.attr( 'disabled', false ).css({'background':'#fff'});    //activer l'heure
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

	var theHREF = "/simens/public/consultation/consultation-medecin";
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
//	function executerRequetePost(donnees) {
//		// Le formulaire ï¿½ monFormulaire ï¿½ existe dï¿½jï¿½ dans la page
//	    var formulaire = document.createElement("form");
//	 
//	    formulaire.setAttribute("action","/simens/public/consultation/update-complement-consultation"); 
//	    formulaire.setAttribute("method","POST"); 
//	    for( donnee in donnees){
//	     // Ajout dynamique de champs dans le formulaire
//	        var champ = document.createElement("input");
//	        champ.setAttribute("type", "hidden");
//	        champ.setAttribute("name", donnee);
//	        champ.setAttribute("value", donnees[donnee]);
//	        formulaire.appendChild(champ);
//	    }
//	    // Envoi de la requï¿½te
//	    formulaire.submit();
//	    // Suppression du formulaire
//	    document.body.removeChild(formulaire);
//	}
	
    /***LORS DU CLICK SUR 'Terminer' ****/
	/***LORS DU CLICK SUR 'Terminer' ****/
//	$("#terminer2").click(function() {
//		event.preventDefault(); 
//	    var donnees = new Array();
//	    
//	    // **********-- Pour la validation de la consultation par le médecin --*********
//	    donnees['terminer'] = 'save';
//	    donnees['id_cons']    = $("#id_cons").val();
//	    
//	    // **********-- Donnees de l'examen physique --*******
//        // **********-- Donnees de l'examen physique --*******
//	    donnees['examen_donnee1'] = $("#examen_donnee1").val();
//	    donnees['examen_donnee2'] = $("#examen_donnee2").val();
//	    donnees['examen_donnee3'] = $("#examen_donnee3").val();
//	    donnees['examen_donnee4'] = $("#examen_donnee4").val();
//	    donnees['examen_donnee5'] = $("#examen_donnee5").val();
//	    
//	    //**********-- ANALYSE BIOLOGIQUE --************
//        //**********-- ANALYSE BIOLOGIQUE --************
//	    donnees['groupe_sanguin']      = $("#groupe_sanguin").val();
//	    donnees['hemogramme_sanguin']  = $("#hemogramme_sanguin").val();
//	    donnees['bilan_hemolyse']      = $("#bilan_hemolyse").val();
//	    donnees['bilan_hepatique']     = $("#bilan_hepatique").val();
//	    donnees['bilan_renal']         = $("#bilan_renal").val();
//	    donnees['bilan_inflammatoire'] = $("#bilan_inflammatoire").val();
//	    
//	    //**********-- ANALYSE MORPHOLOGIQUE --************
//        //**********-- ANALYSE MORPHOLOGIQUE --************
//	    donnees['radio_']        = $("#radio").val();
//	    donnees['ecographie_']   = $("#ecographie").val();
//	    donnees['fibroscopie_']  = $("#fibrocospie").val();
//	    donnees['scanner_']      = $("#scanner").val();
//	    donnees['irm_']          = $("#irm").val();
//	    
//	    //*********** DIAGNOSTICS ************
//	    //*********** DIAGNOSTICS ************
//	    donnees['diagnostic1'] = $("#diagnostic1").val();
//	    donnees['diagnostic2'] = $("#diagnostic2").val();
//	    donnees['diagnostic3'] = $("#diagnostic3").val();
//	    donnees['diagnostic4'] = $("#diagnostic4").val();
//	    
//	    //*********** ORDONNACE (Mï¿½dical) ************
//	    //*********** ORDONNACE (Mï¿½dical) ************
//	    donnees['duree_traitement_ord'] = $("#duree_traitement_ord").val();
//	     
//	    for(var i = 1 ; i < 10 ; i++ ){
//	     	if($("#medicament_0"+i).val()){
//	     		donnees['medicament_0'+i] = $("#medicament_0"+i).val();
//	     		donnees['medicament_1'+i] = $("#medicament_1"+i).val();
//	     		donnees['medicament_2'+i] = $("#medicament_2"+i).val();
//	     		donnees['medicament_3'+i] = $("#medicament_3"+i).val();
//	     	}
//	     }
//	    
//	    //*********** TRAITEMENTS CHIRURGICAUX ************
//		//*********** TRAITEMENTS CHIRURGICAUX ************
//	    donnees['diagnostic_traitement_chirurgical'] = $("#diagnostic_traitement_chirurgical").val();
//	    donnees['intervention_prevue'] = $("#intervention_prevue").val();
//	    donnees['type_anesthesie_demande'] = $("#type_anesthesie_demande").val();
//	    donnees['numero_vpa'] = $("#numero_vpa").val();
//	    donnees['observation'] = $("#observation").val();
//	    
//	    // **********-- Rendez Vous --*******
//        // **********-- Rendez Vous --*******
//		donnees['id_patient'] = $("#id_patient").val();
//		   //Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas dï¿½sactiver
//		   if($("#date_rv").val()){$("#date_rv_tampon").val($("#date_rv").val());}
//		donnees['date_rv']    = $("#date_rv_tampon").val();
//		donnees['motif_rv']   = $("#motif_rv").val();
//		   //Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas dï¿½sactiver
//		   if($("#heure_rv").val()){$("#heure_rv_tampon").val($("#heure_rv").val());}
//		donnees['heure_rv']   = $("#heure_rv_tampon").val();
//		
//		// **********-- Hospitalisation --*******
//        // **********-- Hospitalisation --*******
//		donnees['motif_hospitalisation'] = $("#motif_hospitalisation").val();
//		
//		// **********-- Transfert --*******
//        // **********-- Transfert --*******
//		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas dï¿½sactiver
//		   if($("#service_accueil").val()){$("#service_accueil_tampon").val($("#service_accueil").val());};
//		
//		donnees['id_service']      = $("#service_accueil_tampon").val();
//		donnees['med_id_personne'] = $("#id_medecin").val();
//		donnees['date']            = $("#date_cons").val();
//		donnees['motif_transfert'] = $("#motif_transfert").val();
//	    
//		
//		//**********-- Demande Examens (Biologique et Morphologique) --********
//		//**********-- Demande Examens (Biologique et Morphologique) --********
////	    var checkbox = [];
////	    $('input[name="cdemande"]:checked').each(function(i){
////	      checkbox[$(this).attr('value')] = $(this).attr('value');
////	    });
////	    
////	    if(!checkbox[1]){ checkbox[1] = null;}
////	    if(!checkbox[2]){ checkbox[2] = null;}
////	    if(!checkbox[3]){ checkbox[3] = null;}
////	    if(!checkbox[4]){ checkbox[4] = null;}
////	    if(!checkbox[5]){ checkbox[5] = null;}
////	    if(!checkbox[6]){ checkbox[6] = null;}
////	    if(!checkbox[7]){ checkbox[7] = null;}
////	    if(!checkbox[8]){ checkbox[8] = null;}
////	    if(!checkbox[9]){ checkbox[9] = null;}
////	    if(!checkbox[10]){ checkbox[10] = null;}
////	    if(!checkbox[11]){ checkbox[11] = null;}
////	    if(!checkbox[12]){ checkbox[12] = null;}
////	    if(!checkbox[13]){ checkbox[13] = null;}
////	    
////		donnees['groupe']        = checkbox[1];
////		donnees['hemmogramme']   = checkbox[2];
////		donnees['hepatique']     = checkbox[3];
////		donnees['renal']         = checkbox[4];
////		donnees['hemostase']     = checkbox[5];
////		donnees['inflammatoire'] = checkbox[6];
////		donnees['autreb']        = checkbox[7];
////		donnees['radio']         = checkbox[8];
////		donnees['ecographie']    = checkbox[9];
////		donnees['irm']           = checkbox[10];
////		donnees['scanner']       = checkbox[11];
////		donnees['fibroscopie']   = checkbox[12];
////		donnees['autrem']        = checkbox[13];
////		
////		
////		//note sur les examens
////		donnees['ngroupe']       = $("#note1").val();
////		donnees['nhemmogramme']  = $("#note2").val();
////		donnees['nhepatique']    = $("#note3").val();
////		donnees['nrenal']        = $("#note4").val();
////		donnees['nhemostase']    = $("#note5").val();
////		donnees['ninflammatoire']= $("#note6").val();
////		donnees['nautreb']       = $("#note7").val();
////		donnees['nradio']        = $("#note8").val();
////		donnees['necographie']   = $("#note9").val();
////		donnees['nirm']          = $("#note10").val();
////		donnees['nscanner']      = $("#note11").val();
////		donnees['nfibroscopie']  = $("#note12").val();
////		donnees['nautrem']       = $("#note13").val();
//		
//		executerRequetePost(donnees);
//	});
	var valid = true;  // VARIABLE GLOBALE utilisï¿½e dans 'VALIDER LES DONNEES DU TABLEAU DES CONSTANTES'
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	/****** MASK DE SAISIE ********/ 
   	/****** MASK DE SAISIE ********/ 
 	/****** MASK DE SAISIE ********/
	function maskSaisie() {
		$(function(){
	    	$("#poids").mask("299");
	    	$("#taille").mask("299");
	    	$("#temperature").mask("49");
	    	$("#pressionarterielle").mask("299/299");
	    	$("#glycemie_capillaire").mask("9,99");
	    	$("#pouls").mask("299");
	    	$("#frequence_respiratoire").mask("299");
	    });
	    
	    $("#taille").blur(function(){
	    	if($("#taille").val() > 250 || $("#taille").val() == "___"){
	    		$("#taille").val('');
	    		$("#taille").mask("299");
	    		$("#taille").css("border-color","#FF0000");
	    		$("#erreur_taille").fadeIn().text("Max: 250cm").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
	    	} else 
	    		if($("#taille").val() <= 250){
	    			$("#taille").css("border-color","");
	    			$("#erreur_taille").fadeOut();
	    		}
	    	return false;
	    });
	    	
	    $("#temperature").blur(function(){ 
	    	if($("#temperature").val() > 45 || $("#temperature").val() < 34 || $("#temperature").val() == "__"){
	    		$("#temperature").val('');
	    		$("#temperature").mask("49");
	    		$("#temperature").css("border-color","#FF0000");
	    		$("#erreur_temperature").fadeIn().text("Min: 34Â°C, Max: 45Â°C").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
	    	} else 
	    		if($("#temperature").val() <= 45 && $("#temperature").val() >= 34){
	    			$("#temperature").css("border-color","");
	    			$("#erreur_temperature").fadeOut();
	    		}
	    	return false;
	    });
	    
	    $("#poids").blur(function(){
	    	if($("#poids").val() > 300 || $("#poids").val() == "___"){
	    		$("#poids").val('');
	    		$("#poids").mask("299");
	    		$("#poids").css("border-color","#FF0000");
	    		$("#erreur_poids").fadeIn().text("Max: 300kg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
	    	} else 
	    		if($("#poids").val() <= 300){
	    			$("#poids").css("border-color","");
	    			$("#erreur_poids").fadeOut();
	    		}
	    	return false;
	    });
	    
	    $("#pressionarterielle").blur(function(){
	    	if($("#pressionarterielle").val() > 300 || $("#pressionarterielle").val() == "___/___"){
	    		$("#pressionarterielle").val('');
	    		$("#pressionarterielle").mask("299/299");
	    		$("#pressionarterielle").css("border-color","#FF0000");
	    		$("#erreur_pressionarterielle").fadeIn().text("Max: 300mmHg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
	    	} else
	    		if($("#pressionarterielle").val() != "___/___"){
	    			$("#pressionarterielle").css("border-color","");
	    			$("#erreur_pressionarterielle").fadeOut();
	    		}
	    	return false;
	    });
	    
	    $("#pouls").blur(function(){
	    	if($("#pouls").val() > 150 || $("#pouls").val() == "___"){
	    		$("#pouls").val('');
	    		$("#pouls").mask("199");
	    		$("#pouls").css("border-color","#FF0000");
	    		$("#erreur_pouls").fadeIn().text("Max: 150battements").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
	    	} else 
	    		if($("#pouls").val() <= 150){
	    			$("#pouls").css("border-color","");
	    			$("#erreur_pouls").fadeOut();
	    		}
	    	return false;
	    });
	    
	    $("#frequence_respiratoire").blur(function(){
	    	if($("#frequence_respiratoire").val() > 300 || $("#frequence_respiratoire").val() == "___"){
	    		$("#frequence_respiratoire").val('');
	    		$("#frequence_respiratoire").mask("299");
	    		$("#frequence_respiratoire").css("border-color","#FF0000");
	    		$("#erreur_frequence").fadeIn().text("Ce champs est requis").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
	    	} else 
	    		if($("#frequence_respiratoire").val() <= 300){
	    			$("#frequence_respiratoire").css("border-color","");
	    			$("#erreur_frequence").fadeOut();
	    		}
	    	return false;
	    });
	
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	}
	
	
	/****** CONTROLE APRES VALIDATION ********/ 
	/****** CONTROLE APRES VALIDATION ********/ 

     $("#terminer,#bouton_constantes_valider, #terminer2, #terminer3").click(function(){

     	 valid = true;
         if( $("#taille").val() == ""){
             $("#taille").css("border-color","#FF0000");
             $("#erreur_taille").fadeIn().text("Max: 250cm").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
             valid = false;
         }
         else{
         	$("#taille").css("border-color","");
         	$("#erreur_taille").fadeOut();
         }

         if( $("#poids").val() == ""){
         	$("#poids").css("border-color","#FF0000");
             $("#erreur_poids").fadeIn().text("Max: 300kg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
             valid = false;
         }
         else{
         	$("#poids").css("border-color", "");
             $("#erreur_poids").fadeOut();
         }
         if( $('#temperature').val() == ""){
         	$("#temperature").css("border-color","#FF0000");
             $("#erreur_temperature").fadeIn().text("Min: 34Â°C, Max: 45Â°C").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
             valid = false;
         }
         else{
         	$("#temperature").css("border-color", "");
             $("#erreur_temperature").fadeOut();
         }
         
         if( $("#pouls").val() == ""){
         	 $("#pouls").css("border-color","#FF0000");
             $("#erreur_pouls").fadeIn().text("Max: 150battements").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
             valid = false;
         }
         else{
         	 $("#pouls").css("border-color", "");
             $("#erreur_pouls").fadeOut();
         }
         
         
         if( $("#frequence_respiratoire").val() == ""){
         	 $("#frequence_respiratoire").css("border-color","#FF0000");
             $("#erreur_frequence").fadeIn().text("Ce champs est requis").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
             valid = false;
         }
         else{
        	 $("#frequence_respiratoire").css("border-color", "");
             $("#erreur_frequence").fadeOut();
         }
         
         
         if( $("#pressionarterielle").val() == ""){
        	 $("#pressionarterielle").css("border-color","#FF0000");
        	 $("#erreur_pressionarterielle").fadeIn().text("Max: 300mmHg").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
        	 valid = false;
         }
         else{
        	 $("#pressionarterielle").css("border-color", "");
        	 $("#erreur_pressionarterielle").fadeOut();
         }
         return valid;
 	}); 
//-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--*-*-*-*-*-*-*-*-*--*-*-*-*--*-*-*-*-*-**--*-**-*--**-*-*-*-*-*-*-*-*-*-*-*-*-*--**-*-*-*-*-	
	//Method envoi POST pour updatecomplementconsultation
	//Method envoi POST pour updatecomplementconsultation
	//Method envoi POST pour updatecomplementconsultation
	function updateexecuterRequetePost(donnees) {
		// Le formulaire ï¿½ monFormulaire ï¿½ existe dï¿½jï¿½ dans la page
	    var formulaire = document.createElement("form");
	 
	    formulaire.setAttribute("action","/simens/public/consultation/update-complement-consultation"); 
	    formulaire.setAttribute("method","POST"); 
	    for( donnee in donnees){
	     // Ajout dynamique de champs dans le formulaire
	        var champ = document.createElement("input");
	        champ.setAttribute("type", "hidden");
	        champ.setAttribute("name", donnee);
	        champ.setAttribute("value", donnees[donnee]);
	        formulaire.appendChild(champ);
	    }
        
	    // Envoi de la requï¿½te
	    formulaire.submit();
	    // Suppression du formulaire
	    document.body.removeChild(formulaire);
	}
	
    /***LORS DU CLICK SUR 'Terminer' ****/
	/***LORS DU CLICK SUR 'Terminer' ****/
	$("#terminer2, #terminer3").click(function() {
		if (valid == false){return false;}
		
		event.preventDefault(); 
	    var donnees = new Array();
	    donnees['id_cons']    = $("#id_cons").val();
	    donnees['terminer'] = 'save';
	    
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
	    
	    //*********** ORDONNACE (Mï¿½dical) ************
	    //*********** ORDONNACE (Mï¿½dical) ************
	    donnees['duree_traitement_ord'] = $("#duree_traitement_ord").val();
	     
	    for(var i = 1 ; i < 10 ; i++ ){
	     	if($("#medicament_0"+i).val()){
	     		donnees['medicament_0'+i] = $("#medicament_0"+i).val();
	     		donnees['forme_'+i] = $("#forme_"+i).val();
	     		donnees['nb_medicament_'+i] = $("#nb_medicament_"+i).val();
	     		donnees['quantite_'+i] = $("#quantite_"+i).val();
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
		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas dï¿½sactiver
		   if($("#date_rv").val()){$("#date_rv_tampon").val($("#date_rv").val());}
		donnees['date_rv']    = $("#date_rv_tampon").val();
		donnees['motif_rv']   = $("#motif_rv").val();
		donnees['heure_rv']   = $("#heure_rv").val();
		
		// **********-- Hospitalisation --*******
        // **********-- Hospitalisation --*******
		donnees['motif_hospitalisation'] = $("#motif_hospitalisation").val();
		
		// **********-- Transfert --*******
        // **********-- Transfert --*******
		//Au cas ou l'utilisateur ne valide pas ou n'imprime pas cela veut dire que le champ n'est pas dï¿½sactiver
		   if($("#service_accueil").val()){$("#service_accueil_tampon").val($("#service_accueil").val());};
		
		donnees['id_service']      = $("#service_accueil_tampon").val();
		donnees['med_id_personne'] = $("#id_medecin").val();
		donnees['date']            = $("#date_cons").val();
		donnees['motif_transfert'] = $("#motif_transfert").val();
	    
		//**********-- LES MOTIFS D'ADMISSION --********
		//**********-- LES MOTIFS D'ADMISSION --********
		//**********-- LES MOTIFS D'ADMISSION --********
		donnees['motif_admission1'] = $("#motif_admission1").val();
		donnees['motif_admission2'] = $("#motif_admission2").val();
		donnees['motif_admission3'] = $("#motif_admission3").val();
		donnees['motif_admission4'] = $("#motif_admission4").val();
		donnees['motif_admission5'] = $("#motif_admission5").val();
		
		//**********-- LES CONSTANTES CONSTANTES CONSTANTES --********
		//**********-- LES CONSTANTES CONSTANTES CONSTANTES --********
		//**********-- LES CONSTANTES CONSTANTES CONSTANTES --********
		//Recuperer les valeurs des champs
		//Recuperer les valeurs des champs
		donnees['poids'] = $("#poids").val();
		donnees['taille'] = $("#taille").val();
		donnees['temperature'] = $("#temperature").val();
		donnees['pressionarterielle'] = $("#pressionarterielle").val();
		donnees['pouls'] = $("#pouls").val();
		donnees['frequence_respiratoire'] = $("#frequence_respiratoire").val();
		donnees['glycemie_capillaire'] = $("#glycemie_capillaire").val();
		
		//Recuperer les donnees sur les bandelettes urinaires
		//Recuperer les donnees sur les bandelettes urinaires
		donnees['albumine'] = $('#BUcheckbox input[name=albumine]:checked').val();
		if(!donnees['albumine']){ donnees['albumine'] = 0;}
		donnees['croixalbumine'] = $('#BUcheckbox input[name=croixalbumine]:checked').val();
		if(!donnees['croixalbumine']){ donnees['croixalbumine'] = 0;}

		donnees['sucre'] = $('#BUcheckbox input[name=sucre]:checked').val();
		if(!donnees['sucre']){ donnees['sucre'] = 0;}
		donnees['croixsucre'] = $('#BUcheckbox input[name=croixsucre]:checked').val();
		if(!donnees['croixsucre']){ donnees['croixsucre'] = 0;}
		
		donnees['corpscetonique'] = $('#BUcheckbox input[name=corpscetonique]:checked').val();
		if(!donnees['corpscetonique']){ donnees['corpscetonique'] = 0;}
		donnees['croixcorpscetonique'] = $('#BUcheckbox input[name=croixcorpscetonique]:checked').val();
		if(!donnees['croixcorpscetonique']){ donnees['croixcorpscetonique'] = 0;}
		
		
		updateexecuterRequetePost(donnees);
	});
	
	
	
	//Annuler le transfert au clic
	$("#annulertransfert").click(function() {
		$("#motif_transfert").val("");
		//document.getElementById('hopital_accueil').value="";
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

 /**************************************************************************************************************/
 
 /*======================================== MENU ANTECEDENTS MEDICAUX =========================================*/
 
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

	 /*************************************************************************************************************/
	 
	 /*=================================== MENU ANTECEDENTS TERRAIN PARTICULIER ==================================*/
	 
	 /*************************************************************************************************************/
		 
	 $(function(){
		    //ANTECEDENTS PERSONNELS
			//ANTECEDENTS PERSONNELS
			$("#antecedentsPersonnels").toggle(false);
			$("#AntecedentsFamiliaux").toggle(false);
			$("#MenuAntecedentPersonnel").toggle(false);
			$("#HabitudesDeVie").toggle(false);
			$("#AntecedentMedicaux").toggle(false);
			$("#AntecedentChirurgicaux").toggle(false);
			$("#GynecoObstetrique").toggle(false);
			
	//*****************************************************************
    //*****************************************************************
			//ANTECEDENTS PERSONNELS
			//ANTECEDENTS PERSONNELS
			$(".image1_TP").click(function(){
				 $("#MenuTerrainParticulier").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			$(".image_fleche").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#MenuTerrainParticulier").fadeIn("fast");
				 });
			});
			
			//HABITUDES DE VIE
			//HABITUDES DE VIE
			$(".image1_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#HabitudesDeVie").fadeIn("fast");
				 });
			});
			
			$("#TerminerHabitudeDeVie").click(function(){
				$("#HabitudesDeVie").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			//ANTECEDENTS MEDICAUX
			//ANTECEDENTS MEDICAUX
			$(".image2_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#AntecedentMedicaux").fadeIn("fast");
				 });
			});
			
			$("#TerminerAntecedentMedicaux").click(function(){
				$("#AntecedentMedicaux").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			//ANTECEDENTS CHIRURGICAUX
			//ANTECEDENTS CHIRURGICAUX
			$(".image3_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#AntecedentChirurgicaux").fadeIn("fast");
				 });
			});
			
			$("#TerminerAntecedentChirurgicaux").click(function(){
				$("#AntecedentChirurgicaux").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			//ANTECEDENTS CHIRURGICAUX
			//ANTECEDENTS CHIRURGICAUX
			$(".image4_AP").click(function(){
				 $("#MenuAntecedentPersonnel").fadeOut(function(){ 
					 $("#GynecoObstetrique").fadeIn("fast");
				 });
			});
			
			$("#TerminerGynecoObstetrique").click(function(){
				$("#GynecoObstetrique").fadeOut(function(){ 
					 $("#MenuAntecedentPersonnel").fadeIn("fast");
				 });
			});
			
			
			//HABITUDES DE VIE TESTER SI UNE HABITUDE EST COCHEE OU PAS
			//HABITUDES DE VIE TESTER SI UNE HABITUDE EST COCHEE OU PAS
			//$("#HabitudesDeVie input[name=testHV]").attr('checked', true);
			$("#dateDebAlcoolique, #dateFinAlcoolique").toggle(false);
			$("#dateDebFumeur, #dateFinFumeur, #nbPaquetJour").toggle(false);
			$("#dateDebDroguer, #dateFinDroguer").toggle(false);
			
			$('#HabitudesDeVie input[name=AlcooliqueHV]').click(function(){
				var boutons = $('#HabitudesDeVie input[name=AlcooliqueHV]');
				if( boutons[0].checked){ $("#dateDebAlcoolique, #dateFinAlcoolique").toggle(true); }
				if(!boutons[0].checked){ $("#dateDebAlcoolique, #dateFinAlcoolique").toggle(false); }
			});
			
			$('#HabitudesDeVie input[name=FumeurHV]').click(function(){
				var boutons = $('#HabitudesDeVie input[name=FumeurHV]');
				if( boutons[0].checked){ $("#dateDebFumeur, #dateFinFumeur, #nbPaquetJour").toggle(true); }
				if(!boutons[0].checked){ $("#dateDebFumeur, #dateFinFumeur, #nbPaquetJour").toggle(false); }
			});
			
			$('#HabitudesDeVie input[name=DroguerHV]').click(function(){
				var boutons = $('#HabitudesDeVie input[name=DroguerHV]');
				if( boutons[0].checked){ $("#dateDebDroguer, #dateFinDroguer").toggle(true); }
				if(!boutons[0].checked){ $("#dateDebDroguer, #dateFinDroguer").toggle(false); }
			});
			
			
			//GYNECO-OBSTETRIQUE TESTER SI C'EST COCHE
			//GYNECO-OBSTETRIQUE TESTER SI C'EST COCHE
			$("#NoteMonarche").toggle(false);
			$("#NoteGestite").toggle(false);
			$("#NoteParite").toggle(false);
			$("#RegulariteON, #DysmenorrheeON, #DureeGO").toggle(false);
			
			$('#GynecoObstetrique input[name=MonarcheGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=MonarcheGO]');
				if( boutons[0].checked){ $("#NoteMonarche").toggle(true); }
				if(!boutons[0].checked){ $("#NoteMonarche").toggle(false); }
			});
			
			$('#GynecoObstetrique input[name=GestiteGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=GestiteGO]');
				if( boutons[0].checked){ $("#NoteGestite").toggle(true); }
				if(!boutons[0].checked){ $("#NoteGestite").toggle(false); }
			});
			
			$('#GynecoObstetrique input[name=PariteGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=PariteGO]');
				if( boutons[0].checked){ $("#NoteParite").toggle(true); }
				if(!boutons[0].checked){ $("#NoteParite").toggle(false); }
			});
			
			$('#GynecoObstetrique input[name=CycleGO]').click(function(){
				var boutons = $('#GynecoObstetrique input[name=CycleGO]');
				if( boutons[0].checked){ $("#RegulariteON, #DysmenorrheeON, #DureeGO").toggle(true); }
				if(!boutons[0].checked){ $("#RegulariteON, #DysmenorrheeON, #DureeGO").toggle(false); }
			});
			
			
    //******************************************************************************
	//******************************************************************************
			$(".image2_TP").click(function(){
				$("#MenuTerrainParticulier").fadeOut(function(){ 
					 $("#AntecedentsFamiliaux").fadeIn("fast");
				 });
			}); 
			
			$("#TerminerAntecedentsFamiliaux").click(function(){
				$("#AntecedentsFamiliaux").fadeOut(function(){ 
					 $("#MenuTerrainParticulier").fadeIn("fast");
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
 
/***************************************************************************************/
 
 /**========================== CONSTANTES CONSTANTES  ================================**/
 
 /***************************************************************************************/
		
    $('table input').attr('autocomplete', 'off');
	//*********************************************************************
	//*********************************************************************
	//*********************************************************************
		function dep1(){
			$('#depliantBandelette').click(function(){
				$("#depliantBandelette").replaceWith("<img id='depliantBandelette' style='cursor: pointer; position: absolute; padding-right: 120px; margin-left: -5px;' src='../img/light/plus.png' />");
				dep();
			    $('#BUcheckbox').animate({
			        height : 'toggle'
			    },1000);
			 return false;
			});
		}
		
		function dep(){ 
			$('#depliantBandelette').click(function(){
				$("#depliantBandelette").replaceWith("<img id='depliantBandelette' style='cursor: pointer; position: absolute; padding-right: 120px; margin-left: -5px;' src='../img/light/minus.png' />");
				dep1();
			    $('#BUcheckbox').animate({
			        height : 'toggle'
			    },1000);
			 return false;
			});
		}
			
 
    //TESTER LEQUEL DES CHECKBOX est coché
	//TESTER LEQUEL DES CHECKBOX est coché
	//maskDeSaisie();
	OptionCochee();
	function OptionCochee() {
	$("#labelAlbumine").toggle(false);
	$("#labelSucre").toggle(false);
	$("#labelCorpscetonique").toggle(false);

	//AFFICHER SI C'EST COCHE
	//AFFICHER SI C'EST COCHE
	var boutonsAlbumine = $('#BUcheckbox input[name=albumine]');
	if(boutonsAlbumine[1].checked){ $("#labelAlbumine").toggle(true); }
	
	var boutonsSucre = $('#BUcheckbox input[name=sucre]');
	if(boutonsSucre[1].checked){ $("#labelSucre").toggle(true); }

	var boutonsCorps = $('#BUcheckbox input[name=corpscetonique]');
	if(boutonsCorps[1].checked){ $("#labelCorpscetonique").toggle(true); }

	//AFFICHER AU CLICK SI C'EST COCHE
	//AFFICHER AU CLICK SI C'EST COCHE
	$('#BUcheckbox input[name=albumine]').click(function(){
		$("#ChoixPlus").toggle(false);
		var boutons = $('#BUcheckbox input[name=albumine]');
		if(boutons[0].checked){	$("#labelAlbumine").toggle(false); $("#BUcheckbox input[name=croixalbumine]").attr('checked', false); }
		if(boutons[1].checked){ $("#labelAlbumine").toggle(true); $("#labelCroixAlbumine").toggle(true);}
	});

	$('#BUcheckbox input[name=sucre]').click(function(){
		$("#ChoixPlus2").toggle(false);
		var boutons = $('#BUcheckbox input[name=sucre]');
		if(boutons[0].checked){	$("#labelSucre").toggle(false); $("#BUcheckbox input[name=croixsucre]").attr('checked', false); }
		if(boutons[1].checked){ $("#labelSucre").toggle(true); $("#labelCroixSucre").toggle(true);}
	});

	$('#BUcheckbox input[name=corpscetonique]').click(function(){
		$("#ChoixPlus3").toggle(false);
		var boutons = $('#BUcheckbox input[name=corpscetonique]');
		if(boutons[0].checked){	$("#labelCorpscetonique").toggle(false); $("#BUcheckbox input[name=croixcorpscetonique]").attr('checked', false); }
		if(boutons[1].checked){ $("#labelCorpscetonique").toggle(true); $("#labelCroixCorpscetonique").toggle(true);}
	});
	
	}
	
	//CHOIX DU CROIX
	//========================================================
	$("#ChoixPlus").toggle(false);
	albumineOption();
	function albumineOption(){
		var boutons = $('#BUcheckbox input[name=croixalbumine]');
		if(boutons[0].checked){
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("1+");

		}
		if(boutons[1].checked){ 
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("2+");

		}
		if(boutons[2].checked){ 
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("3+");
			
		}
		if(boutons[3].checked){ 
			$("#labelCroixAlbumine").toggle(false); 
			$("#ChoixPlus").toggle(true); 
			$("#ChoixPlus label").html("4+");

		}
	}
	
	$('#BUcheckbox input[name=croixalbumine]').click(function(){
		albumineOption();
	});

	//========================================================
	$("#ChoixPlus2").toggle(false);
	sucreOption();
	function sucreOption(){
		var boutons = $('#BUcheckbox input[name=croixsucre]');
		if(boutons[0].checked){
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("1+");

		}
		if(boutons[1].checked){ 
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("2+");

		}
		if(boutons[2].checked){ 
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("3+");
			
		}
		if(boutons[3].checked){ 
			$("#labelCroixSucre").toggle(false); 
			$("#ChoixPlus2").toggle(true); 
			$("#ChoixPlus2 label").html("4+");

		}
	}
	$('#BUcheckbox input[name=croixsucre]').click(function(){
		sucreOption();
	});

	//========================================================
	$("#ChoixPlus3").toggle(false);
	corpscetoniqueOption();
	function corpscetoniqueOption(){
		var boutons = $('#BUcheckbox input[name=croixcorpscetonique]');
		if(boutons[0].checked){
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("1+");

		}
		if(boutons[1].checked){ 
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("2+");

		}
		if(boutons[2].checked){ 
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("3+");
			
		}
		if(boutons[3].checked){ 
			$("#labelCroixCorpscetonique").toggle(false); 
			$("#ChoixPlus3").toggle(true); 
			$("#ChoixPlus3 label").html("4+");

		}
	}
	$('#BUcheckbox input[name=croixcorpscetonique]').click(function(){
		corpscetoniqueOption();
	});
	
	
	//******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
	//******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
	 	     
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	/****** ======================================================================= *******/
	//******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 
	 //******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 

	   //Au debut on dï¿½sactive le code cons et la date de consultation qui sont non modifiables
	  	var id_cons = $("#id_cons");
	  	var date_cons = $("#date_cons");
	  	id_cons.attr('readonly',true);
	  	date_cons.attr('readonly',true);

	  	var poids = $('#poids');
	  	var taille = $('#taille');
	  	var tension = $('#tension');
	  	var bu = $('#bu');
	  	var temperature = $('#temperature');
	  	var glycemie_capillaire = $('#glycemie_capillaire');
	  	var pouls = $('#pouls');
	  	var frequence_respiratoire = $('#frequence_respiratoire');
	  	var pressionarterielle = $("#pressionarterielle");
	  	
		  //Au debut on cache le bouton modifier et on affiche le bouton valider
	  	$( "#bouton_constantes_valider" ).toggle(true);
	  	$( "#bouton_constantes_modifier" ).toggle(false);

	  	//Au debut on active tous les champs
	  	poids.attr( 'readonly', false ).css({'background':'#fff'});
	  	taille.attr( 'readonly', false ).css({'background':'#fff'});
	  	tension.attr( 'readonly', false).css({'background':'#fff'}); 
	  	bu.attr( 'readonly', false).css({'background':'#fff'});  
	  	temperature.attr( 'readonly', false).css({'background':'#fff'}); 
	  	glycemie_capillaire.attr( 'readonly', false).css({'background':'#fff'});
	  	pouls.attr( 'readonly', false).css({'background':'#fff'});
	  	frequence_respiratoire.attr( 'readonly', false).css({'background':'#fff'});
	  	pressionarterielle.attr( 'readonly', false ).css({'background':'#fff'});

	  	$( "#bouton_constantes_valider" ).click(function(){
	  		if(valid == true){
		   		poids.attr( 'readonly', true ).css({'background':'#f8f8f8'});    
		   		taille.attr( 'readonly', true ).css({'background':'#f8f8f8'});
		   		tension.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		bu.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		temperature.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		glycemie_capillaire.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		pouls.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		frequence_respiratoire.attr( 'readonly', true).css({'background':'#f8f8f8'});
		   		pressionarterielle.attr( 'readonly', true ).css({'background':'#f8f8f8'});
		   		
	  		    $("#bouton_constantes_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
	  		    $("#bouton_constantes_valider").toggle(false); //on cache le bouton permettant de valider les champs
	  		}
	  		return false; 
	  	});
	  	
	  	$( "#bouton_constantes_modifier" ).click(function(){
	  		poids.attr( 'readonly', false ).css({'background':'#fff'});
	  		taille.attr( 'readonly', false ).css({'background':'#fff'}); 
	  		tension.attr( 'readonly', false).css({'background':'#fff'}); 
	  		bu.attr( 'readonly', false).css({'background':'#fff'});
	  		temperature.attr( 'readonly', false).css({'background':'#fff'});
	  		glycemie_capillaire.attr( 'readonly', false).css({'background':'#fff'});
	  		pouls.attr( 'readonly', false).css({'background':'#fff'});
	  		frequence_respiratoire.attr( 'readonly', false).css({'background':'#fff'});
	  		pressionarterielle.attr( 'readonly', false ).css({'background':'#fff'});
	  		
	  	 	$("#bouton_constantes_modifier").toggle(false);   //on cache le bouton permettant de modifier les champs
	  	 	$("#bouton_constantes_valider").toggle(true);    //on affiche le bouton permettant de valider les champs
	  	 	return  false;
	  	});

	  	$('#dateDebAlcoolique input, #dateFinAlcoolique input, #dateDebFumeur input, #dateFinFumeur input, #dateDebDroguer input, #dateFinDroguer input').datepicker(
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