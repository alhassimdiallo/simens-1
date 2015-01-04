<?php

namespace Hospitalisation\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * POUR LA RECUPERATION DES DONNEES DU FORMULAIRE
 * @author hassim
 *
 */
class Soinhospitalisation2 {
	
	public $id_sh;
	public $id_hosp;
	public $id_soins;
	public $date_recommandee;
	public $heure_recommandee;
	public $duree;
	public $note;
	public $motif;
	
	protected $inputFilter;
	
	public function exchangeArray($data) {
		$this->id_sh = (! empty ( $data ['id_sh'] )) ? $data ['id_sh'] : null;
		$this->id_hosp = (! empty ( $data ['id_hosp'] )) ? $data ['id_hosp'] : null;
		$this->id_soins = (! empty ( $data ['id_soins'] )) ? $data ['id_soins'] : null;
		$this->date_recommandee = (! empty ( $data ['date_recommandee'] )) ? $data ['date_recommandee'] : null;
		$this->heure_recommandee = (! empty ( $data ['heure_recommandee'] )) ? $data ['heure_recommandee'] : null;
		$this->duree = (! empty ( $data ['duree'] )) ? $data ['duree'] : null;
		$this->note = (! empty ( $data ['note'] )) ? $data ['note'] : null;
		$this->motif = (! empty ( $data ['motif'] )) ? $data ['motif'] : null;
	}
	
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	
	public function getInputFilter() {
		if (! $this->inputFilter) {
	
			$inputFilter = new InputFilter ();
			
			$inputFilter->add (array (
					'name' => 'id_sh',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
			
			$inputFilter->add (array (
					'name' => 'id_hosp',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
			
			$inputFilter->add (array (
					'name' => 'id_soins',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
	
			$inputFilter->add (array (
					'name' => 'date_recommandee',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
			
			$inputFilter->add (array (
					'name' => 'heure_recommandee',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
			
			$inputFilter->add (array (
					'name' => 'duree',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
			
			$inputFilter->add (array (
					'name' => 'note',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
			
			$inputFilter->add (array (
					'name' => 'motif',
					'required' => false,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
			) );
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}