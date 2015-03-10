<?php

namespace Consultation\Model;

use Zend\InputFilter\InputFilterInterface;

/**
 * POUR LA RECUPERATION DES DONNEES DE LA BASE
 * @author hassim
 *
 */
class Soinhospitalisation {
	
	public $id_sh;
	public $id_hosp;
	public $id_soins;
	public $date_enreg;
	public $date_recommandee;
	public $date_application;
	public $duree;
	public $appliquer;
	public $motif;
	public $note;
	public $note_application;
	
	protected $inputFilter;
	
	public function exchangeArray($data) {
 			$this->id_sh = (! empty ( $data ['id_sh'] )) ? $data ['id_sh'] : null;
 			$this->id_hosp = (! empty ( $data ['id_hosp'] )) ? $data ['id_hosp'] : null;
 			$this->id_soins = (! empty ( $data ['id_soins'] )) ? $data ['id_soins'] : null;
 			$this->date_enreg = (! empty ( $data ['date_enreg'] )) ? $data ['date_enreg'] : null;
 			$this->date_recommandee = (! empty ( $data ['date_recommandee'] )) ? $data ['date_recommandee'] : null;
 			$this->duree = (! empty ( $data ['duree'] )) ? $data ['duree'] : null;
 			$this->date_application = (! empty ( $data ['date_application'] )) ? $data ['date_application'] : null;
 			$this->appliquer = (! empty ( $data ['appliquer'] )) ? $data ['appliquer'] : null;
 			$this->motif = (! empty ( $data ['motif'] )) ? $data ['motif'] : null;
 			$this->note = (! empty ( $data ['note'] )) ? $data ['note'] : null;
 			$this->note_application = (! empty ( $data ['note_application'] )) ? $data ['note_application'] : null;
	}
	
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
}