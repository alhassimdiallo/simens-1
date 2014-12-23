<?php

namespace Hospitalisation\Form;

use Zend\Form\Form;

class SoinForm extends Form {
	public function __construct($name = null) {
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_personne',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'id_personne'
				)
		) );
		
		$this->add ( array (
				'name' => 'soin',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Soin',
				),
				'attributes' => array (
						'id' => 'soin',
						//'required' => true
				)
		) );
		
		$this->add ( array (
				'name' => 'duree',
				'type' => 'Text',
				'options' => array (
						'label' => 'Duree (en jour)'
				),
				'attributes' => array (
						'id' => 'duree',
						//'required' => true
				)
		) );
		
		$this->add ( array (
				'name' => 'date_recommandee',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date recommandee'
				),
				'attributes' => array (
						'id' => 'date_recommandee',
						'required' => true
				)
		) );
		
		$this->add ( array (
				'name' => 'heure_recommandee',
				'type' => 'Text',
				'options' => array (
						'label' => 'Heure recommandee'
				),
				'attributes' => array (
						'id' => 'heure_recommandee',
						//'required' => true
				)
		) );
		
		$this->add ( array (
				'name' => 'note',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Note'
				),
				'attributes' => array (
						'id' => 'note',
						//'required' => true
				)
		) );
		
		$this->add( array(
				'name' => 'valider',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Valider',
						'id' => 'valider',
				),
		));
		
		$this->add( array(
				'name' => 'annuler',
				'type' => 'Button',
				'attributes' => array(
						'value' => 'Annuler',
						'id' => 'annuler',
				),
		));
		
	}
}