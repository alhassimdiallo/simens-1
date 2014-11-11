<?php

namespace Consultation\Form;

use Zend\Form\Form;
use Zend\Stdlib\DateTime;

class ConsultationForm extends Form {
	public $decor = array (
			'ViewHelper'
	);
	public function __construct($name = null) {
		parent::__construct ();
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'dmy-His' );
		$heure = $today->format ( "H:i" );
		//$this->seta
		$this->add ( array (
				'name' => 'id_cons',
				'type' => 'Text',
				'options' => array (
						'label' => 'Code consultation'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'value' => 's-c-' . $date,
						'id' => 'id_cons'
				)
		) );
		$this->add ( array (
				'name' => 'heure_cons',
				'type' => 'Hidden',
				'attributes' => array (
						'value' => $heure
				)
		) );
		$this->add ( array (
				'name' => 'id_medecin',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor
				)
		) );
		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor
				)
		) );
		$this->add ( array (
				'name' => 'dateonly',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor
				)
		) );
		$this->add ( array (
				'name' => 'motif_admission',
				'type' => 'Text',
				'options' => array (
						'label' => 'Motif_admission'
				)
		) );
		/**
		 * ********* LES MOTIFS D ADMISSION *************
		 */
		/**
		 * ********* LES MOTIFS D ADMISSION *************
		 */
		$this->add ( array (
				'name' => 'motif_admission1',
				'type' => 'Text',
				'options' => array (
						'label' => 'motif 1'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_admission1'
				)
		) );
		$this->add ( array (
				'name' => 'motif_admission2',
				'type' => 'Text',
				'options' => array (
						'label' => 'motif 2'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_admission2'
				)
		) );
		$this->add ( array (
				'name' => 'motif_admission3',
				'type' => 'Text',
				'options' => array (
						'label' => 'motif 3'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_admission3'
				)
		) );
		$this->add ( array (
				'name' => 'motif_admission4',
				'type' => 'Text',
				'options' => array (
						'label' => 'motif 4'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_admission4'
				)
		) );
		$this->add ( array (
				'name' => 'motif_admission5',
				'type' => 'Text',
				'options' => array (
						'label' => 'motif 5'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_admission5'
				)
		) );
		/**
		 * ********DONNEES DE L EXAMEN PHYSIQUE***********
		 */
		/**
		 * ********DONNEES DE L EXAMEN PHYSIQUE***********
		 */
		$this->add ( array (
				'name' => 'examen_donnee1',
				'type' => 'Text',
				'options' => array (
						'label' => 'donn&eacute;e 1'
				),
				'attributes' => array (
						'readonly' => 'readonly',
				'id'  => 'examen_donnee1'
				)
		) );
		$this->add ( array (
				'name' => 'examen_donnee2',
				'type' => 'Text',
				'options' => array (
						'label' => 'donn&eacute;e 2'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'examen_donnee2'
				)
		) );
		$this->add ( array (
				'name' => 'examen_donnee3',
				'type' => 'Text',
				'options' => array (
						'label' => 'donn&eacute;e 3'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'examen_donnee3'
				)
		) );
		$this->add ( array (
				'name' => 'examen_donnee4',
				'type' => 'Text',
				'options' => array (
						'label' => 'donn&eacute;e 4'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'examen_donnee4'
				)
		) );
		$this->add ( array (
				'name' => 'examen_donnee5',
				'type' => 'Text',
				'options' => array (
						'label' => 'donn&eacute;e 5'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'examen_donnee5'
				)
		) );
		/**
		 * ********** EXAMENS COMPLEMENTAIRES (EXAMENS ET ANALYSE) *************
		 */
		/**
		 * ********** EXAMENS COMPLEMENTAIRES (EXAMENS ET ANALYSE) *************
		 */

		/* A)))*********ANALYSE BIOLOGIQUE******** */
		$this->add ( array (
				'name' => 'groupe_sanguin',
				'type' => 'Text',
				'options' => array (
						'label' => 'Groupe Sanguin: '
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'groupe_sanguin'
				)
		) );
		$this->add ( array (
				'name' => 'hemogramme_sanguin',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Hemogramme sanguin' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'hemogramme_sanguin'
				)
		) );
		$this->add ( array (
				'name' => 'bilan_hemolyse',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan de l\'h&eacute;mostase:' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'bilan_hemolyse'
				)
		) );
		$this->add ( array (
				'name' => 'bilan_hepatique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan h&eacute;patique:' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'bilan_hepatique'
				)
		) );
		$this->add ( array (
				'name' => 'bilan_renal',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan r&eacute;nal:' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'bilan_renal'
				)
		) );
		$this->add ( array (
				'name' => 'bilan_inflammatoire',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan inflammatoire:' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id'  => 'bilan_inflammatoire'
				)
		) );
		/* B)))*********EXAMEN MORPHOLOGIQUE******** */
		/**
		 * * Les balises images dans cette partie ne sont pas utilis�es**
		 */
		$this->add ( array (
				'name' => 'radio',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Radio:'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'radio'
				)
		) );
		/**
		 * *** image de la radio ****
		 */
		$this->add ( array (
				'name' => 'radio_image',
				'type' => 'Image'
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'ecographie',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Echographie: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'ecographie'
				)
		) );
		/**
		 * *** image de l'ecographie ****
		 */
		$this->add ( array (
				'name' => 'ecographie_image',
				'type' => 'Image'
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'fibrocospie',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Fibroscopie: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'fibrocospie'
				)
		) );
		/**
		 * *** image de la fibroscopie ****
		 */
		$this->add ( array (
				'name' => 'fibroscopie_image',
				'type' => 'Image'
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'scanner',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Scanner: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'scanner'
				)
		) );
		/**
		 * *** image du scanner ****
		 */
		$this->add ( array (
				'name' => 'scanner_image',
				'type' => 'Image'
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'irm',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'IRM: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'irm'
				)
		) );
		/**
		 * *** image de l'irm ****
		 */
		$this->add ( array (
				'name' => '$irm_image',
				'type' => 'Image'
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */

		/**
		 * ********************************* DIAGNOSTICS *******************************
		 */
		/**
		 * ********************************* DIAGNOSTICS *******************************
		 */
		$this->add ( array (
				'name' => 'diagnostic1',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 1: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic1'
				)
		) );
		$this->add ( array (
				'name' => 'diagnostic2',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 2: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic2'
				)
		) );
		$this->add ( array (
				'name' => 'diagnostic3',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 3: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic3'
				)
		) );
		$this->add ( array (
				'name' => 'diagnostic4',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 4: ' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic4'
				)
		) );
		/**
		 * ************************* CONSTANTES *****************************************************
		 */
		/**
		 * ************************* CONSTANTES *****************************************************
		 */
		/**
		 * ************************* CONSTANTES *****************************************************
		 */
		$this->add ( array (
				'name' => 'date_cons',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'date_cons'
				)
		) );
		$this->add ( array (
				'name' => 'poids',
				'type' => 'Text',
				'options' => array (
						'label' => 'Poids (kg)'
				),
				'attributes' => array (
						'class' => 'poids_only_numeric',
						'readonly' => 'readonly',
						'id' => 'poids'
				)
		) );
		$this->add ( array (
				'name' => 'taille',
				'type' => 'Text',
				'options' => array (
						'label' => 'Taille (cm)'
				),
				'attributes' => array (
						'class' => 'taille_only_numeric',
						'readonly' => 'readonly',
						'id' => 'taille'
				)
		) );
		$this->add ( array (
				'name' => 'temperature',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Temperature (C)' )
				),
				'attributes' => array (
						'class' => 'temperature_only_numeric',
						'readonly' => 'readonly',
						'id' => 'temperature'
				)
		) );
		$this->add ( array (
				'name' => 'tension',
				'type' => 'Text',
				'options' => array (
						'label' => 'Tension'
				),
				'attributes' => array (
						'class' => 'tension_only_numeric',
						'readonly' => 'readonly',
						'id' => 'tension'
				)
		) );
		$this->add ( array (
				'name' => 'pouls',
				'type' => 'Text',
				'options' => array (
						'label' => 'Pouls'
				),
				'attributes' => array (
						'class' => 'pouls_only_numeric',
						'readonly' => 'readonly',
						'id' => 'pouls'
				)
		) );
		$this->add ( array (
				'name' => 'frequence_respiratoire',
				'type' => 'Text',
				'options' => array (
						'label' => 'Frequence respiratoire'
				),
				'attributes' => array (
						'class' => 'frequence_only_numeric',
						'readonly' => 'readonly',
						'id' => 'frequence_respiratoire'
				)
		) );
		$this->add ( array (
				'name' => 'glycemie_capillaire',
				'type' => 'Text',
				'options' => array (
						'label' => 'Glycemie capillaire'
				),
				'attributes' => array (
						'class' => 'glycemie_only_numeric',
						'readonly' => 'readonly',
						'id' => 'glycemie_capillaire'
				)
		) );
		$this->add ( array (
				'name' => 'bu',
				'type' => 'Text',
				'options' => array (
						'label' => 'Bandelette urinaire'
				),
				'attributes' => array (
						'class' => 'bu_only_numeric',
						'readonly' => 'readonly',
						'id' => 'bu'
				)
		) );
		$this->add ( array (
				'name' => 'observation',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Observations'
				),
				'attributes' => array (
						'rows' => 1,
						'cols' => 180
				)
		) );
		$this->add ( array (
				'name' => 'submit',
				'type' => 'Submit',
				'options' => array (
						'label' => 'Valider'
				)
		) );
		// ************** TRAITEMENTS *************
		// ************** TRAITEMENTS *************
		// ************** TRAITEMENTS *************
		/**
		 * ************* traitement chirurgicaux ************
		 */
		/**
		 * ************* traitement chirurgicaux ************
		 */
		$this->add ( array (
				'name' => 'diagnostic_traitement_chirurgical',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Diagnostic :'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic_traitement_chirurgical'
				)
		) );
		$this->add ( array (
				'name' => 'type_anesthesie_demande',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Type d\'anesth&eacute;sie :' ),
						'value_options' => array (
								'Anesthesie 1' => iconv ( 'ISO-8859-1', 'UTF-8', 'Anesthésie1' ),
								'Anesthesie 2' => iconv ( 'ISO-8859-1', 'UTF-8', 'Anesthésie2' ),
								'Anesthesie 3' => iconv ( 'ISO-8859-1', 'UTF-8', 'Anesthésie3' )
						)
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'type_anesthesie_demande'
				)
		) );
		$this->add ( array (
				'name' => 'intervention_prevue',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Intervention Prévue :' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'intervention_prevue'
				)
		) );
		$this->add ( array (
				'name' => 'numero_vpa',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'VPA Num&eacute;ro:' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'numero_vpa'
				)
		) );
		$this->add ( array (
				'name' => 'observation',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Observation :' )
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'observation'
				)
		) );
		/**
		 * ************* Autres (Transfert / hospitalisation / Rendez-vous! ************
		 */
		/**
		 * ************* Autres (Transfert / hospitalisation / Rendez-vous! ************
		 */
		/**
		 * ************* Autres (Transfert / hospitalisation / Rendez-vous! ************
		 */

		/* A))************** Transfert ************ */
		/*A))************** Transfert *************/
		$this->add ( array (
				'name' => 'hopital_accueil',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Hopital d\'accueil :' )
// 						'value_options' => array (
// 								'' => ''
// 						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getservices(this.value)',
						'id' => 'hopital_accueil'
				)
		) );
		$this->add ( array (
				'name' => 'service_accueil',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'accueil :' )
// 						'value_options' => array (
// 								'' => ''
// 						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => false,
						'id' => 'service_accueil'
				)
		) );
		$this->add ( array (
				'name' => 'motif_transfert',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Motif du transfert :'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_transfert'
				)
		) );
		/* B))************** Hospitalisation ************ */
		/*B))************** Hospitalisation *************/
		$this->add ( array (
				'name' => 'motif_hospitalisation',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Motif hospitalisation :'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_hospitalisation'
				)
		) );
		/* C))************** Rendez-vous ************ */
		/*C))************** Rendez-vous *************/
		$this->add ( array (
				'name' => 'motif_rv',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Motif du rendez-vous :'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_rv'
				)
		) );
		$this->add ( array (
				'name' => 'habitude_vie1',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 1'
				),
				'attributes' => array (
						'id'  => 'habitude_vie1'
				)
		) );
		$this->add ( array (
				'name' => 'habitude_vie2',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 2'
				),
				'attributes' => array (
						'id'  => 'habitude_vie2'
				)
		) );
		$this->add ( array (
				'name' => 'habitude_vie3',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 3'
				),
				'attributes' => array (
						'id'  => 'habitude_vie3'
				)
		) );
		$this->add ( array (
				'name' => 'habitude_vie4',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 4'
				),
				'attributes' => array (
						'id'  => 'habitude_vie4'
				)
		) );
		$this->add ( array (
				'name' => 'antecedent_familial1',
				'type' => 'Text',
				'options' => array (
						'label' => 'Ant&eacute;c&eacute;dent 1'
				),
				'attributes' => array (
						'id'  => 'antecedent_familial1'
				)
		) );
		$this->add ( array (
				'name' => 'antecedent_familial2',
				'type' => 'Text',
				'options' => array (
						'label' => 'Ant&eacute;c&eacute;dent 2'
				),
				'attributes' => array (
						'id'  => 'antecedent_familial2'
				)
		) );
		$this->add ( array (
				'name' => 'antecedent_familial3',
				'type' => 'Text',
				'options' => array (
						'label' => 'Ant&eacute;c&eacute;dent 3'
				),
				'attributes' => array (
						'id'  => 'antecedent_familial3'
				)
		) );
		$this->add ( array (
				'name' => 'antecedent_familial4',
				'type' => 'Text',
				'options' => array (
						'label' => 'Ant&eacute;c&eacute;dent 4'
				),
				'attributes' => array (
						'id'  => 'antecedent_familial4'
				)
		) );
		$this->add ( array (
				'name' => 'date_rv',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date :'
				),
				'attributes' => array (
						'id' => 'date_rv',
				)
		) );
		$this->add ( array (
				'name' => 'heure_rv',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Heure :',
						'empty_option' => 'Choisir une heure svp',
						'value_options' => array (
								'08:00' => '08:00'
						)
				),
				'attributes' => array (
						'id' => 'heure_rv'
				)
		) );
		// $this->add ( array (
		// 'name' => 'terminer',
		// 'type' => 'Submit',
		// 'options' => array (
		// 'label' => 'terminer',
		// )
		// ) );
		// $this->add ( array (
		// 'name' => 'annuler',
		// 'type' => 'Submit',
		// 'options' => array (
		// 'label' => 'annuler',
		// )
		// ) );
	}
}