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
						'id' => 'civilite',
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
						'id' => 'nom'
				)
		) );
		$this->add ( array (
				'name' => 'prenom',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Pr&eacute;nom' )
				),
				'attributes' => array (
						'id' => 'prenom'
				)
		) );


		$this->add ( array (
				'name' => 'sexe',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Sexe',
						'value_options' => array (
								'Masculin' => 'Masculin',
								'Féminin' => 'Féminin'
						)
				),
				'attributes' => array (
						'id' => 'sexe'
				)
		// 'required' => true,
				) );


		$this->add ( array (
				'name' => 'date_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date de naissance'
				),
				'attributes' => array (
						'id' => 'date_naissance'
				)
				) );


		$this->add ( array (
				'name' => 'lieu_naissance',
				'type' => 'Text',
				'options' => array (
						'label' => 'Lieu de naissance'
				),
				'attributes' => array (
						'id' => 'lieu_naissance'
				)
				) );


		$this->add ( array (
				'name' => 'nationalite_origine',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Nationalit&eacute; origine',
						'value_options' => array (
								'' => ''
						)
				),
				'attributes' => array (
						'id' => 'nationalite_origine'
				)
		// 'attributes' => array (
		// 'required' => true,
		// )
				) );
		$this->add ( array (
				'name' => 'nationalite_actuelle',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Nationalit&eacute; actuelle',
						'value_options' => array (
								'' => ''
						)
				),
				'attributes' => array (
						'id' => 'nationalite_actuelle'
				)
		// 'attributes' => array (
		// 'required' => true,
		// )
				) );
		$this->add ( array (
				'name' => 'adresse',
				'type' => 'Text',
				'options' => array (
						'label' => 'Adresse'
				),
				'attributes' => array (
						'id' => 'adresse'
				)
		) );
		$this->add ( array (
				'name' => 'telephone',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'T&eacute;l&eacute;phone' )
				),
				'attributes' => array (
						'id' => 'telephone'
				)
		) );
		$this->add ( array (
				'type' => 'Zend\Form\Element\Email',
				'name' => 'email',
				'options' => array (
						'label' => 'Email'
				),
				'attributes' => array (
						'placeholder' => 'you@domain.com',
						'id' => 'email'
				)
		) );
		$this->add ( array (
				'name' => 'profession',
				'type' => 'Text',
				'options' => array (
						'label' => 'Profession'
				),
				'attributes' => array (
						'id' => 'profession'
				)
		) );
		$this->add ( array (
				'name' => 'submit',
				'type' => 'Submit',
				'options' => array (
						'label' => 'Sauvegarder'
				)
		) );
	}
}