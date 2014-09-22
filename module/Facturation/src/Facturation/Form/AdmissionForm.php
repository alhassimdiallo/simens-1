<?php
namespace Facturation\Form;

use Zend\Form\Form;
// use Personnel\Model\Service;
// use Personnel\Model\ServiceTable;

class AdmissionForm extends Form{

	//protected $serviceTable;
	public function __construct() {
		//$this->serviceTable = $serviceTable;
		parent::__construct ();

		/*******************************************************************/
		/*** INSTANCIATION POUR LA RECUPERATION DE LA LISTE DES SERVICES ***/
		/*******************************************************************/
		//$service = new ServiceTable();
// 		$laliste_service = $this->serviceTable->listeService();
// 		$afficheTous = array(""=>'Tous');
// 		$tab_service = array_merge($afficheTous , $laliste_service);

		/*******************************************************************/
		/*******************************************************************/

		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden'
		) );

		$this->add ( array (
				'name' => 'service',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Service')
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getmontant(this.value)'
				)
		) );

		$this->add ( array (
				'name' => 'montant',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Montant')
				)
		) );

		$this->add ( array (
				'name' => 'numero',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Numéro facture')
				)
		) );
		$this->add ( array (
				'name' => 'liste_service',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								''=>'A faire'
						)
				)
		) );
	}
}