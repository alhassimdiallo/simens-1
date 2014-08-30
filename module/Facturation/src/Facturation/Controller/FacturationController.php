<?php
namespace Facturation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facturation\Model\Patient;

class FacturationController extends AbstractActionController {
	protected $patientTable;

	public function getPatientTable(){
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function  listePatientAction(){
		$layout = $this->layout();
		$layout->setTemplate('layout/facturation');
		$view = new ViewModel();
		return $view;
	}
	public function admissionAction(){
		return new ViewModel();
	}

	public function listePatientsAdmisAction(){
		return new ViewModel();
	}
	public function listePatientsDecedesAction(){
		return new ViewModel();
	}
	public function listeNaissanceAction(){
		return new ViewModel();
	}
	public function ajouterAction(){
		return new ViewModel();
	}
	public function declarerDecesAction(){
		return new ViewModel();
	}
	public function listePatientAjaxAction(){
		$patient = $this->getPatientTable();
		$output = $patient->getListePatient();
		$this->_helper->json ( $output, array (
				'enableJsonExprFinder' => true
		));
		//return new ViewModel();
	}
}