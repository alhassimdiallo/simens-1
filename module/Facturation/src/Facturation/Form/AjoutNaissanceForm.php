<?php

namespace Facturation\Form;

use Zend\Form\Form;

class AjoutNaissanceForm extends Form {
	public function __construct($name = null) {
		parent::__construct ();
		$this->add ( array (
				'name' => 'id_personne',
				'type' => 'Hidden'
		) );

		$this->add ( array (
				'name' => 'nom',
				'type' => 'Text',
				'options' => array (
						'label' => 'Nom'
				),
				'attributes' => array (
						'class' => 'only_Char',
						'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'prenom',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Prénom')
				),
				'attributes' => array (
						'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'sexe',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Sexe',
						'value_options' => array (
								'Masculin'=>'Masculin','Féminin'=>'Féminin'
						)
				),
				'attributes' => array (
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'date_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date de naissance'
				),
				'attributes' => array (
						'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'heure_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Heure de naissance'
				),
				'attributes' => array (
						'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'lieu_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Lieu de naissance'
				),
				'attributes' => array (
						'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'nationalite_origine',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Nationalité origine',
						'value_options' => array (
								'liste'=>''
						)
				),
				'attributes' => array (
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'nationalite_actuelle',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Nationalité actuelle',
						'value_options' => array (
								'liste'=>''
						)
				),
				'attributes' => array (
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'adresse',
				'type' => 'Text',
				'options' => array (
						'label' => 'Adresse'
				)
		) );
		$this->add ( array (
				'name' => 'taille',
				'type' => 'Text',
				'options' => array (
						'label' => 'Taille (cm)'
				)
		) );
		$this->add(array(
				'type' => 'Text',
				'name' => 'poids',
				'options' => array(
						'label' => 'Poids (kg)'
				)
		));
		$this->add ( array (
				'name' => 'groupe_sanguin',
				'type' => 'Text',
				'options' => array (
						'label' => 'Groupe sanguin'
				)
		) );
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'options' => array(
						'label' => 'Sauvegarder'
				),

		));
	}
}