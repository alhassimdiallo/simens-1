    var nb="_TOTAL_";
    var asInitVals = new Array();
	//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(id){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:485,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );
	            
	            var cle = id;
	            var chemin = '/simens_derniereversion/public/facturation/facturation/supprimer';
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
	                	     
	                	     nb= result;
	                	     $("#"+cle).fadeOut(function(){$("#"+cle).empty();});
	                	     
	                	       
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
     //e.preventDefault();
   	 confirmation(id);
     $("#confirmation").dialog('open');
   	}
    
   
    /**********************************************************************************/
    
    function initialisation(){
    	
     var asInitVals = new Array();
	/* var  oTable = $('#patient').dataTable
	  ( {
		        
					"bJQueryUI": false,
					"sPaginationType": "full_numbers",
					"aaSorting": "", //pour trier la liste affichée
					"oLanguage": { 
						"sProcessing":   "Traitement en cours...",
						//"sLengthMenu":   "Afficher _MENU_ &eacute;l&eacute;ments",
						//"sZeroRecords":  "Aucun &eacute;l&eacute;ment &agrave; afficher",
						"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ patients",
						"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
						"sInfoFiltered": "",
						"sInfoPostFix":  "",
						"sSearch": "",
						"sUrl": "",
						"sWidth": "30px",
						"oPaginate": {
							"sFirst":    "|<",
							"sPrevious": "<",
							"sNext":     ">",
							"sLast":     ">|"
							}
					   },
					   
					   "iDisplayLength": "10",
					   "aLengthMenu": [5,7,10,15],
					   
					   "sAjaxSource":  "<?php echo $this->url(array('controller' => 'Facturation', 'action' => 'listepatientajax', 'module' => 'facturation', 'format' => 'json')); ?>",
						
	} );*/

	//le filtre du select
	$('#filter_statut').change(function() 
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