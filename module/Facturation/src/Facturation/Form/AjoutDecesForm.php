<?php
namespace Facturation\Form;

use Zend\Form\Form;

class AjoutDecesForm extends Form{
	public function __construct($name = null) {
		parent::__construct ();
		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden'
		) );

		$this->add ( array (
				'name' => 'date_deces',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date du décès')
				)
		) );

		$this->add ( array (
				'name' => 'heure_deces',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Heure du décès')
				)
		) );

		$this->add ( array (
				'name' => 'age_deces',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Age au décès')
				)
		) );

		$this->add ( array (
				'name' => 'lieu_deces',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Lieu du décès')
				)
		) );

		$this->add ( array (
				'name' => 'circonstances_deces',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Circonstances du décès')
				)
		) );

		$this->add ( array (
				'name' => 'note',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Note importante')
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