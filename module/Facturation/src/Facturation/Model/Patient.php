<?php

namespace Facturation\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Patient {
	public $id_personne;
	public $civilite;
	public $nom;
	public $prenom;
	public $date_naissance;
	public $lieu_naissance;
	public $adresse;
	public $sexe;
	public $nationalite_actuelle;
	public $nationalite_origine;
	public $telephone;
	public $email;
	public $profession;
	protected $inputFilter;

	public function exchangeArray($data) {
		$this->id_personne = (! empty ( $data ['ID_PERSONNE'] )) ? $data ['ID_PERSONNE'] : null;
		$this->civilite = (! empty ( $data ['CIVILITE'] )) ? $data ['CIVILITE'] : null;
		$this->lieu_naissance = (! empty ( $data ['LIEU_NAISSANCE'] )) ? $data ['LIEU_NAISSANCE'] : null;
		$this->nom = (! empty ( $data ['NOM'] )) ? $data ['NOM'] : null;
		$this->prenom = (! empty ( $data ['PRENOM'] )) ? $data ['PRENOM'] : null;
		$this->date_naissance = (! empty ( $data ['DATE_NAISSANCE'] )) ? $data ['DATE_NAISSANCE'] : null;
		$this->adresse = (! empty ( $data ['ADRESSE'] )) ? $data ['ADRESSE'] : null;
		$this->sexe = (! empty ( $data ['SEXE'] )) ? $data ['SEXE'] : null;
		$this->nationalite_actuelle = (! empty ( $data ['NATIONALITE_ACTUELLE'] )) ? $data ['NATIONALITE_ACTUELLE'] : null;
		$this->nationalite_origine = (! empty ( $data ['NATIONALITE_ORIGINE'] )) ? $data ['NATIONALITE_ORIGINE'] : null;
		$this->telephone = (! empty ( $data ['TELEPHONE'] )) ? $data ['TELEPHONE'] : null;
		$this->email = (! empty ( $data ['EMAIL'] )) ? $data ['EMAIL'] : null;
		$this->profession = (! empty ( $data ['PROFESSION'] )) ? $data ['PROFESSION'] : null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();

			$inputFilter->add($factory->createInput(array(
					'name'     => 'id_personne',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			)));

			$inputFilter->add($factory->createInput(array(
					'name'     => 'nom',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			$inputFilter->add($factory->createInput(array(
					'name'     => 'prenom',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}