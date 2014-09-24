<?php

namespace Facturation\Form;

use Zend\Form\Form;

class PatientForm extends Form {
	public function __construct($name = null) {
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_personne',
				'type' => 'Hidden',
				'attributes' => array (
						'value' => 0
				)
		) );
		$this->add ( array (
				'name' => 'civilite',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Civilite',
						'value_options' => array (
								'Mme' => 'Mme',
								'Mlle' => 'Mlle',
								'M' => 'M'
						)
				),
				'attributes' => array (
						//'required' => true,
						'value' => 'M'
				)
		) );
		$this->add ( array (
				'name' => 'nom',
				'type' => 'Text',
				'options' => array (
						'label' => 'Nom'
				),
				'attributes' => array (
						'class' => 'only_Char',
						//'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'prenom',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Prénom')
				),
				'attributes' => array (
						//'required' => true
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
						//'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'date_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date de naissance'
				),
				'attributes' => array (
						//'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'lieu_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Lieu de naissance'
				),
				'attributes' => array (
						//'required' => true
				)
		) );
		$this->add ( array (
				'name' => 'nationalite_origine',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Nationalité origine',
						'value_options' => array (
								''=>''
						)
				)
// 				'attributes' => array (
// 						'required' => true,
// 				)
		) );
		$this->add ( array (
				'name' => 'nationalite_actuelle',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Nationalité actuelle',
						'value_options' => array (
								''=>''
						)
				)
// 				'attributes' => array (
// 						'required' => true,
// 				)
		) );
		$this->add ( array (
				'name' => 'adresse',
				'type' => 'Text',
				'options' => array (
						'label' => 'Adresse'
				)
		) );
		$this->add ( array (
				'name' => 'telephone',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Téléphone')
				)
		) );
		$this->add(array(
				'type' => 'Zend\Form\Element\Email',
				'name' => 'email',
				'options' => array(
						'label' => 'Email'
				),
				'attributes' => array(
						'placeholder' => 'you@domain.com'
				)
		));
		$this->add ( array (
				'name' => 'profession',
				'type' => 'Text',
				'options' => array (
						'label' => 'Profession'
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