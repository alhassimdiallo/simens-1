
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
	$( "#accordionss" ).accordion();
    $( "#accordions" ).accordion();

    /****** CONTROLE LORS DE LA SAISIE ********/ 
    /****** CONTROLE LORS DE LA SAISIE ********/ 
    	
    	/***** Fonction Controle de saisie TENSION *****/
    	 $('body').delegate('input.tension_only_numeric','keyup',function(){ 
    		    
    		    if(!$(this).val().match(/^\-?[0-9]{0,3},?[0-9]{0,2}$/)) // 0-9 et 5 chiffres uniquement avec (,) sur les 3 premiers chiffres
    		      supprimer_dernier_caractere(this);
         });
    	            /**** Annulation du "coller" dans l'input texte auquel on a affect� l'identifiant "no_paste" ***/
    	              /* document.getElementById('no_paste').addEventListener('keydown', function (foo){
    	                 if (foo.keyCode == 86)
    	                 {
    	                  alert('Vous avez copi� du texte');
    	                  foo.preventDefault();
    	                 }
    	                });*/
        /*** FIN ***/
    	    
    	/***** Fonction Controle de saisie TAILLE *****/
    	 $('body').delegate('input.taille_only_numeric','keyup',function(){ 
    		    
    		    if(!$(this).val().match(/^[0-3]{0,1},?[0-9]{0,2}$/)) // 0-3 uniquement et 1 chiffre avant la virgule 2 apr�s
    		      supprimer_dernier_caractere(this); 
    		    
         });
        /*** FIN ***/

    	/***** Fonction Controle de saisie BU *****/
    	 $('body').delegate('input.bu_only_numeric','keyup',function(){
    		    
    		    if(!$(this).val().match(/^[a-zA-Z]*$/)) // alphabetique
    		      supprimer_dernier_caractere(this);
         });
        /*** FIN ***/

    	/***** Fonction Controle de saisie POIDS *****/
    	 $('body').delegate('input.poids_only_numeric','keyup',function(){
    		    
    		    if(!$(this).val().match(/^[0-2]{0,1}?[0-9]{0,2}$/)) // le premier chiffre de 0-2 uniquement et les deux autres de 0-9
    		      supprimer_dernier_caractere(this);
         });
        /*** FIN ***/

    	/***** Fonction Controle de saisie TEMPERATURE *****/
    	 $('body').delegate('input.temperature_only_numeric','keyup',function(){
    		    
    		    if(!$(this).val().match(/^[0-9]{0,2}$/)) // 0-9 avec deux chiffres uniquement
    		      supprimer_dernier_caractere(this);
         });
        /*** FIN ***/

    	/***** Fonction Controle de saisie GLYCEMIE *****/
    	 $('body').delegate('input.glycemie_only_numeric','keyup',function(){
    		    
    		    if(!$(this).val().match(/^[a-zA-Z]*$/)) // donn�es alphabetique
    		      supprimer_dernier_caractere(this);
         });
        /*** FIN ***/ 

    	 /***** Fonction Controle de saisie POULS *****/
    	 $('body').delegate('input.pouls_only_numeric','keyup',function(){ 
    		    
    		    if(!$(this).val().match(/^\-?[0-9]{0,3},?[0-9]{0,2}$/)) // 0-9 les 3 premiers chiffres et 0-9 les 2 chiffres apr�s la virgule
    		      supprimer_dernier_caractere(this);
         });
        /*** FIN ***/

    	/***** Fonction Controle de saisie FREQUENCE RESPIRATOIRE *****/
    	 $('body').delegate('input.frequence_only_numeric','keyup',function(){ 
    		    
    		    if(!$(this).val().match(/^\-?[0-9]{0,1},?[0-9]{0,2}$/)) // 0-9 les 3 premiers chiffres et 0-9 les 2 chiffres apr�s la virgule
    		      supprimer_dernier_caractere(this);
         });
        /*** FIN ***/



    	 /****** CONTROLE APRES VALIDATION ********/ 
    	 /****** CONTROLE APRES VALIDATION ********/ 

    	 	 var valid = true;  // VARIABLE GLOBALE utilis�e dans 'VALIDER LES DONNEES DU TABLEAU DES CONSTANTES'

    	 	     $("#terminer,#bouton_constantes_valider").click(function(){

    	 	     	valid = true;
    	 	         if( $("#taille").val() == ""){
    	 	             $("#taille").css("border-color","#FF0000");
    	 	             $("#erreur_taille").fadeIn().text(".saisir une taille (ex: 3,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	             valid = false;
    	 	         }
    	 	         else{
    	 	         	$("#taille").css("border-color","");
    	 	         	$("#erreur_taille").fadeOut();
    	 	         }
    	 	         if ($("#tension").val() == ""){
    	 	          	$("#tension").css("border-color","#FF0000");
    	 	          	$("#erreur_tension").fadeIn().text(".saisir une valeur (ex: 999,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	          	valid = false;
    	 	         }
    	 	         else{
    	 	             $("#tension").css("border-color", "");
    	 	             $("#erreur_tension").fadeOut();
    	 	         }
    	 	         if( $("#bu").val() == ""){
    	 	        	    $("#bu").css("border-color","#FF0000");
    	 	             $("#erreur_bu").fadeIn().text(".saisir une bu (ex: alphabetique)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	             valid = false;
    	 	         }
    	 	         else{
    	 	         	$("#bu").css("border-color", "");
    	 	             $("#erreur_bu").fadeOut();
    	 	         }
    	 	         if( $("#poids").val() == ""){
    	 	         	$("#poids").css("border-color","#FF0000");
    	 	             $("#erreur_poids").fadeIn().text(".saisir un poids (ex: 299)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	             valid = false;
    	 	         }
    	 	         else{
    	 	         	$("#poids").css("border-color", "");
    	 	             $("#erreur_poids").fadeOut();
    	 	         }
    	 	         if( $('#temperature').val() == ""){
    	 	         	$("#temperature").css("border-color","#FF0000");
    	 	             $("#erreur_temperature").fadeIn().text(".saisir temperature (ex: 99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	             valid = false;
    	 	         }
    	 	         else{
    	 	         	$("#temperature").css("border-color", "");
    	 	             $("#erreur_temperature").fadeOut();
    	 	         }
    	 	         if( $("#glycemie_capillaire").val() == ""){
    	 	         	$("#glycemie_capillaire").css("border-color","#FF0000");
    	 	             $("#erreur_glycemie").fadeIn().text(".saisir glycemie (ex: string)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	             valid = false;
    	 	         }
    	 	         else{
    	 	         	$("#glycemie_capillaire").css("border-color", "");
    	 	             $("#erreur_glycemie").fadeOut();
    	 	         }
    	 	         if( $("#pouls").val() == ""){
    	 	         	$("#pouls").css("border-color","#FF0000");
    	 	             $("#erreur_pouls").fadeIn().text(".saisir le pouls (ex: 999,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	             valid = false;
    	 	         }
    	 	         else{
    	 	         	$("#pouls").css("border-color", "");
    	 	             $("#erreur_pouls").fadeOut();
    	 	         }
    	 	         if( $("#frequence_respiratoire").val() == ""){
    	 	         	$("#frequence_respiratoire").css("border-color","#FF0000");
    	 	             $("#erreur_frequence").fadeIn().text(".saisir la frequence (ex: 9,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
    	 	             valid = false;
    	 	         }
    	 	         else{
    	 	         	$("#frequence_respiratoire").css("border-color", "");
    	 	             $("#erreur_frequence").fadeOut();
    	 	         }
    	 	         
    	 	         return valid;
    	 	 	}); 
      	 	 	
  //******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
  //******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
  
  	var motif1 = $("#motif_admission1");
  	var motif2 = $("#motif_admission2");
  	var motif3 = $("#motif_admission3");
  	var motif4 = $("#motif_admission4");
  	var motif5 = $("#motif_admission5");

  	$( "button" ).button();
  	//$( "bouton_valider_motif" ).button();
  	//$( "bouton_modifier_motif" ).button();

  	//Au debut on cache le bouton modifier et on affiche le bouton valider
  	$( "#bouton_motif_valider" ).toggle(true);
  	$( "#bouton_motif_modifier" ).toggle(false);

  	//Au debut on desactive tous les champs
  	motif1.attr( 'readonly', false );
  	motif2.attr( 'readonly', false );
  	motif3.attr( 'readonly', false );
  	motif4.attr( 'readonly', false );
  	motif5.attr( 'readonly', false );

  	//Valider(cach�) avec le bouton 'valider'
  	$( "#bouton_motif_valider" ).click(function(){
  		motif1.attr( 'readonly', true );     //d�sactiver le motif1
  		motif2.attr( 'readonly', true );     //d�sactiver le motif2
  		motif3.attr( 'readonly', true );   //d�sactiver le motif3
  		motif4.attr( 'readonly', true );
  		motif5.attr( 'readonly', true );
  		$("#bouton_motif_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
  		$("#bouton_motif_valider").toggle(false); //on cache le bouton permettant de valider les champs
  		return false; 
  	});
  	//Activer(d�cach�) avec le bouton 'modifier'
  	$( "#bouton_motif_modifier" ).click(function(){
  		motif1.attr( 'readonly', false );
  		motif2.attr( 'readonly', false );
  		motif3.attr( 'readonly', false );
  		motif4.attr( 'readonly', false );
  		motif5.attr( 'readonly', false );
  	 	$("#bouton_motif_modifier").toggle(false);   //on cache le bouton permettant de modifier les champs
  	 	$("#bouton_motif_valider").toggle(true);    //on affiche le bouton permettant de valider les champs
  	 	return  false;
  	});

  //********************* FIN TABLEAU VALIDATION MOTIFS *****************************
  //********************* FIN TABLEAU VALIDATION MOTIFS *****************************


  	/****** CONTROLE APRES VALIDATION ********/ 
  	/****** CONTROLE APRES VALIDATION ********/ 

  		 var valid = true;  // VARIABLE GLOBALE utilis�e dans 'VALIDER LES DONNEES DU TABLEAU DES CONSTANTES'

  		     $("#terminer,#bouton_constantes_valider").click(function(){

  		     	valid = true;
  		         if( $("#taille").val() == ""){
  		             $("#taille").css("border-color","#FF0000");
  		             $("#erreur_taille").fadeIn().text(".saisir une taille (ex: 3,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		             valid = false;
  		         }
  		         else{
  		         	$("#taille").css("border-color","");
  		         	$("#erreur_taille").fadeOut();
  		         }
  		         if ($("#tension").val() == ""){
  		          	$("#tension").css("border-color","#FF0000");
  		          	$("#erreur_tension").fadeIn().text(".saisir une valeur (ex: 999,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		          	valid = false;
  		         }
  		         else{
  		             $("#tension").css("border-color", "");
  		             $("#erreur_tension").fadeOut();
  		         }
  		         if( $("#bu").val() == ""){
  		        	    $("#bu").css("border-color","#FF0000");
  		             $("#erreur_bu").fadeIn().text(".saisir une bu (ex: alphabetique)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		             valid = false;
  		         }
  		         else{
  		         	$("#bu").css("border-color", "");
  		             $("#erreur_bu").fadeOut();
  		         }
  		         if( $("#poids").val() == ""){
  		         	$("#poids").css("border-color","#FF0000");
  		             $("#erreur_poids").fadeIn().text(".saisir un poids (ex: 299)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		             valid = false;
  		         }
  		         else{
  		         	$("#poids").css("border-color", "");
  		             $("#erreur_poids").fadeOut();
  		         }
  		         if( $('#temperature').val() == ""){
  		         	$("#temperature").css("border-color","#FF0000");
  		             $("#erreur_temperature").fadeIn().text(".saisir temperature (ex: 99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		             valid = false;
  		         }
  		         else{
  		         	$("#temperature").css("border-color", "");
  		             $("#erreur_temperature").fadeOut();
  		         }
  		         if( $("#glycemie_capillaire").val() == ""){
  		         	$("#glycemie_capillaire").css("border-color","#FF0000");
  		             $("#erreur_glycemie").fadeIn().text(".saisir glycemie (ex: string)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		             valid = false;
  		         }
  		         else{
  		         	$("#glycemie_capillaire").css("border-color", "");
  		             $("#erreur_glycemie").fadeOut();
  		         }
  		         if( $("#pouls").val() == ""){
  		         	$("#pouls").css("border-color","#FF0000");
  		             $("#erreur_pouls").fadeIn().text(".saisir le pouls (ex: 999,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		             valid = false;
  		         }
  		         else{
  		         	$("#pouls").css("border-color", "");
  		             $("#erreur_pouls").fadeOut();
  		         }
  		         if( $("#frequence_respiratoire").val() == ""){
  		         	$("#frequence_respiratoire").css("border-color","#FF0000");
  		             $("#erreur_frequence").fadeIn().text(".saisir la frequence (ex: 9,99)").css({"color":"#ff5b5b","padding":" 0 10px 0 10px","margin-top":"-18px","font-size":"13px","font-style":"italic"});
  		             valid = false;
  		         }
  		         else{
  		         	$("#frequence_respiratoire").css("border-color", "");
  		             $("#erreur_frequence").fadeOut();
  		         }
  		         
  		         return valid;
  		 	}); 

  			   //******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
  			   //******************* VALIDER LES DONNEES DU TABLEAU DES MOTIFS ******************************** 
  			   


  	
 //******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 
 //******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 

   //Au debut on d�sactive le code cons et la date de consultation qui sont non modifiables
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
  	
	  //Au debut on cache le bouton modifier et on affiche le bouton valider
  	$( "#bouton_constantes_valider" ).toggle(true);
  	$( "#bouton_constantes_modifier" ).toggle(false);

  	//Au debut on active tous les champs
  	poids.attr( 'readonly', false );
  	taille.attr( 'readonly', false );
  	tension.attr( 'readonly', false); 
  	bu.attr( 'readonly', false);  
  	temperature.attr( 'readonly', false); 
  	glycemie_capillaire.attr( 'readonly', false);
  	pouls.attr( 'readonly', false);
  	frequence_respiratoire.attr( 'readonly', false);

  	//Valider(cach�) avec le bouton 'valider'
  	$( "#bouton_constantes_valider" ).click(function(){
  		if(valid == true){
	   		poids.attr( 'readonly', true );     //d�sactiver le poids
	   		taille.attr( 'readonly', true );     //d�sactiver la taille
	   		tension.attr( 'readonly', true);
	   		bu.attr( 'readonly', true);
	   		temperature.attr( 'readonly', true);
	   		glycemie_capillaire.attr( 'readonly', true);
	   		pouls.attr( 'readonly', true);
	   		frequence_respiratoire.attr( 'readonly', true);
  		    $("#bouton_constantes_modifier").toggle(true);  //on affiche le bouton permettant de modifier les champs
  		    $("#bouton_constantes_valider").toggle(false); //on cache le bouton permettant de valider les champs
  		}
  		return false; 
  	});
  	//Activer(d�cach�) avec le bouton 'modifier'
  	$( "#bouton_constantes_modifier" ).click(function(){
  		poids.attr( 'readonly', false );
  		taille.attr( 'readonly', false ); 
  		tension.attr( 'readonly', false); 
  		bu.attr( 'readonly', false);
  		temperature.attr( 'readonly', false);
  		glycemie_capillaire.attr( 'readonly', false);
  		pouls.attr( 'readonly', false);
  		frequence_respiratoire.attr( 'readonly', false);
  	 	$("#bouton_constantes_modifier").toggle(false);   //on cache le bouton permettant de modifier les champs
  	 	$("#bouton_constantes_valider").toggle(true);    //on affiche le bouton permettant de valider les champs
  	 	return  false;
  	});


 //******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 
//******************* VALIDER LES DONNEES DU TABLEAU DES CONSTANTES ******************************** 
});
//Boite de dialogue de confirmation d'annulation
//Boite de dialogue de confirmation d'annulation
//Boite de dialogue de confirmation d'annulation

/***BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION**/
$(document).ready(function() {
	var base_url = window.location.toString();
	var tabUrl = base_url.split("public");
	
	var theHREF = tabUrl[0]+"public/consultation/recherche";
	function confirmation(){
		
  		$( "#confirmation" ).dialog({
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
	
	$("#annuler").click(function() {
        event.preventDefault(); 
        confirmation(); 
        $("#confirmation").dialog('open');
    }); 

});


//******************* AUTO AJOUT DES CHAMPS MOTIFS ADMISSION ******************************** 
//******************* AUTO AJOUT DES CHAMPS MOTIFS ADMISSION ******************************** 


	//AJOUT DE CHAMPS MOTIFS
	//AJOUT DE CHAMPS MOTIFS
	//AJOUT DE CHAMPS MOTIFS
	function champ2(){
	   $( "#leschamps_2" ).click(function(){
		  $( "#motif2" ).toggle(true);
		  $('#plus').children().remove();
		  $('<span id="moins_3" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/moins-vert.PNG" alt="Constantes" title="Supprimer" /></a></span>').appendTo("#plus");
		  $('<span id="leschamps_3" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/add.PNG" alt="Constantes" title="Ajouter" /></a></span>').appendTo("#moins_3");
		  
		  champ3();
		  supChamp2();
	   });
	   
	}

	function champ3(){
		  $( "#leschamps_3" ).click(function(){
			  $( "#motif3" ).toggle(true);
			  $('#plus').children().remove();
			  $('<span id="moins_4" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/moins-vert.PNG" alt="Constantes" title="Supprimer" /></a></span>').appendTo("#plus");
			  $('<span id="leschamps_4" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/add.PNG" alt="Constantes" title="Ajouter" /></a></span>').appendTo("#moins_4");

			  champ4();
			  supChamp3();
		  });
	}

	function champ4(){
			$( "#leschamps_4" ).click(function(){
				$( "#motif4" ).toggle(true);
				$('#plus').children().remove();
				$('<span id="moins_5" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/moins-vert.PNG" alt="Constantes" title="Supprimer" /></a></span>').appendTo("#plus");
				$('<span id="leschamps_5" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/add.PNG" alt="Constantes" title="Ajouter" /></a></span>').appendTo("#moins_5");

				champ5();
				supChamp4();
		    });
			 
	}
	
	function champ5(){ 
			 $( "#leschamps_5" ).click(function(){
				 $( "#motif5" ).toggle(true);
				 $('#plus').children().remove();
				 $('<span id="moins_6" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/moins-vert.PNG" alt="Constantes" title="Supprimer" /></a></span>').prependTo("#plus");
				 supChamp5();
			 });
	}   
			     
	champ2();

	//SUPPRESSION DU CHAMP MOTIF
	//SUPPRESSION DU CHAMP MOTIF
	//SUPPRESSION DU CHAMP MOTIF
	function supChamp2(){
	     $( "#moins_3" ).click(function(){
		     $( "#motif2" ).toggle(false);
		     $( "#motif_admission2" ).val("");
		     $('#plus').children().remove();
		     $('<span id="moins_2" ></span>').appendTo("#plus");
		     $('<span id="leschamps_2" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/add.PNG" alt="Constantes" title="Ajouter" /></a></span>').appendTo("#moins_2");
		     champ2();
		     //supChamp2();
	     }); 
	}

	function supChamp3(){
	     $( "#moins_4" ).click(function(){
		     $( "#motif3" ).toggle(false);
		     $( "#motif_admission3" ).val("");
		     $('#plus').children().remove();
		     $('<span id="moins_3" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/moins-vert.PNG" alt="Constantes" title="Supprimer" /></a></span>').appendTo("#plus");
		     $('<span id="leschamps_3" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/add.PNG" alt="Constantes" title="Ajouter" /></a></span>').appendTo("#moins_3");
		     champ3();
		     supChamp2();
	     });
	}

	function supChamp4(){
	     $( "#moins_5" ).click(function(){
		     $( "#motif4" ).toggle(false);
		     $( "#motif_admission4" ).val("");
		     $('#plus').children().remove();
		     $('<span id="moins_4" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/moins-vert.PNG" alt="Constantes" title="Supprimer" /></a></span>').appendTo("#plus");
		     $('<span id="leschamps_4" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/add.PNG" alt="Constantes" title="Ajouter" /></a></span>').appendTo("#moins_4");
		     champ4();
		     supChamp3();
	     });
	}

	function supChamp5(){
	     $( "#moins_6" ).click(function(){
		     $( "#motif5" ).toggle(false);
		     $( "#motif_admission5" ).val("");
		     $('#plus').children().remove();
		     $('<span id="moins_5" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/moins-vert.PNG" alt="Constantes" title="Supprimer" /></a></span>').appendTo("#plus");
		     $('<span id="leschamps_5" > <a><img style="display: inline; float:left; border:transparent; padding-left:10px;" src="/simens/public/images_icons/add.PNG" alt="Constantes" title="Ajouter" /></a></span>').appendTo("#moins_5");
		     champ5();
		     supChamp4();
	     });
	}

$(document).ready(function() {
		$( "#motif2" ).toggle(false);
		$( "#motif3" ).toggle(false);
		$( "#motif4" ).toggle(false);
		$( "#motif5" ).toggle(false);
		
		champ2();champ3();champ4();champ5();
		supChamp2();supChamp3();supChamp4();supChamp5();

});

