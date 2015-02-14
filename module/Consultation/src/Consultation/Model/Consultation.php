<?php
namespace Consultation\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Consultation implements InputFilterAwareInterface{
	public $id_cons;
	public $id_personne;
	public $pat_id_personne;
	public $motif_admission;
	public $date;
	public $poids;
	public $taille;
	public $temperature;
	public $tension;
	public $pouls;
	public $frequence_respiratoire;
	public $glycemie_capillaire;
	public $bu;
	public $observation;
	public $consprise;
	public $dateonly;
	public $heurecons;
	public $id_service;
	public $pression_arterielle;
	
	protected $inputFilter;

	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
		$this->id_personne = (! empty ( $data ['ID_PERSONNE'] )) ? $data ['ID_PERSONNE'] : null;
		$this->pat_id_personne = (! empty ( $data ['PAT_ID_PERSONNE'] )) ? $data ['PAT_ID_PERSONNE'] : null;
		$this->motif_admission = (! empty ( $data ['MOTIF_ADMISSION'] )) ? $data ['MOTIF_ADMISSION'] : null;
		$this->date = (! empty ( $data ['DATE'] )) ? $data ['DATE'] : null;
		$this->poids = (! empty ( $data ['POIDS'] )) ? $data ['POIDS'] : null;
		$this->taille = (! empty ( $data ['TAILLE'] )) ? $data ['TAILLE'] : null;
		$this->temperature = (! empty ( $data ['TEMPERATURE'] )) ? $data ['TEMPERATURE'] : null;
		$this->tension = (! empty ( $data ['TENSION'] )) ? $data ['TENSION'] : null;
		$this->pouls = (! empty ( $data ['POULS'] )) ? $data ['POULS'] : null;
		$this->frequence_respiratoire = (! empty ( $data ['FREQUENCE_RESPIRATOIRE'] )) ? $data ['FREQUENCE_RESPIRATOIRE'] : null;
		$this->glycemie_capillaire = (! empty ( $data ['GLYCEMIE_CAPILLAIRE'] )) ? $data ['GLYCEMIE_CAPILLAIRE'] : null;
		$this->bu = (! empty ( $data ['BU'] )) ? $data ['BU'] : null;
		$this->observation = (! empty ( $data ['OBSERVATION'] )) ? $data ['OBSERVATION'] : null;
		$this->consprise = (! empty ( $data ['CONSPRISE'] )) ? $data ['CONSPRISE'] : null;
		$this->dateonly = (! empty ( $data ['DATEONLY'] )) ? $data ['DATEONLY'] : null;
		$this->heurecons = (! empty ( $data ['HEURECONS'] )) ? $data ['HEURECONS'] : null;
		$this->id_service = (! empty ( $data ['ID_SERVICE'] )) ? $data ['ID_SERVICE'] : null;
		$this->pression_arterielle = (! empty ( $data ['PRESSION_ARTERIELLE'] )) ? $data ['PRESSION_ARTERIELLE'] : null;
	}
// 	public function exchangeArray($data) {
// 		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
// 		$this->id_personne = (! empty ( $data ['id_personne'] )) ? $data ['id_personne'] : null;
// 		$this->pat_id_personne = (! empty ( $data ['pat_id_personne'] )) ? $data ['pat_id_personne'] : null;
// 		$this->motif_admission = (! empty ( $data ['motif_admission'] )) ? $data ['motif_admission'] : null;
// 		$this->date = (! empty ( $data ['date'] )) ? $data ['date'] : null;
// 		$this->poids = (! empty ( $data ['poids'] )) ? $data ['poids'] : null;
// 		$this->taille = (! empty ( $data ['TAILLE'] )) ? $data ['TAILLE'] : null;
// 		$this->temperature = (! empty ( $data ['temperature'] )) ? $data ['temperature'] : null;
// 		$this->tension = (! empty ( $data ['tension'] )) ? $data ['tension'] : null;
// 		$this->pouls = (! empty ( $data ['POULS'] )) ? $data ['POULS'] : null;
// 		$this->frequence_respiratoire = (! empty ( $data ['frequence_respiratoire'] )) ? $data ['frequence_respiratoire'] : null;
// 		$this->glycemie_capillaire = (! empty ( $data ['glycemie_capillaire'] )) ? $data ['glycemie_capillaire'] : null;
// 		$this->bu = (! empty ( $data ['bu'] )) ? $data ['bu'] : null;
// 		$this->observation = (! empty ( $data ['observation'] )) ? $data ['observation'] : null;
// 		$this->consprise = (! empty ( $data ['consprise'] )) ? $data ['consprise'] : null;
// 		$this->dateonly = (! empty ( $data ['dateonly'] )) ? $data ['dateonly'] : null;
// 		$this->heurecons = (! empty ( $data ['HEURECONS'] )) ? $data ['HEURECONS'] : null;
// 		$this->id_service = (! empty ( $data ['id_service'] )) ? $data ['id_service'] : null;
// 	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();

			$inputFilter->add ($factory->createInput( array (
					'name' => 'id_medecin',
					'filters' => array (
							array (
									'name' => 'Int'
							)
					)
			) ));
			$inputFilter->add ($factory->createInput( array (
					'name' => 'id_patient',
					'filters' => array (
							array (
									'name' => 'Int'
							)
					)
			) ));

			$inputFilter->add (array (
					'name' => 'motif_admission',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			 ) );
			$inputFilter->add (array (
					'name' => 'motif_admission1',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'motif_admission2',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'motif_admission3',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'motif_admission4',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'motif_admission5',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'examen_donnee1',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'examen_donnee2',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'examen_donnee3',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'examen_donnee4',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'examen_donnee5',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'groupe_sanguin',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'hemogramme_sanguin',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'bilan_hemolyse',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'bilan_hepatique',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'bilan_renal',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'bilan_inflammatoire',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'radio',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'radio_image',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'ecographie',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'ecographie_image',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'fibrocospie',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'fibrocospie_image',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'scanner',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'scanner_image',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'irm',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'irm_image',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'diagnostic1',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'diagnostic2',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'diagnostic3',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'diagnostic4',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'date_cons',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'poids',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'taille',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'temperature',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'tension',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'pouls',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'frequence_respiratoire',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'glycemie_capillaire',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'bu',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'diagnostic_traitement_chirurgical',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'intervention_prevue',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'numero_vpa',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'observation',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'motif_transfert',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'motif_hospitalisation',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			$inputFilter->add (array (
					'name' => 'motif_rv',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					)
			) );
			// 			$inputFilter->add (array (
			// 					'name' => 'prenom',
			// 					'required' => true,
			// 					'filters' => array (
			// 							array (
			// 									'name' => 'StripTags'
			// 							),
			// 							array (
			// 									'name' => 'StringTrim'
			// 							)
			// 					),
			// 					'validators' => array (
			// 							array (
			// 									'name' => 'StringLength',
			// 									'options' => array (
			// 											'encoding' => 'UTF-8',
			// 											'min' => 1,
			// 											'max' => 100
			// 									)
			// 							)
			// 					)
			// 			 ) );

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}