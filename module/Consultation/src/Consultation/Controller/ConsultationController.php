<?php

namespace Consultation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facturation\Model\Patient;

class ConsultationController extends AbstractActionController {
	protected $patientTable;
	public function getPatientTable(){
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function  rechercheAction(){
		$this->layout()->setTemplate('layout/consultation');
		$patient = $this->getPatientTable();
		$patientsAdmis = $patient->tousPatientsAdmis();
		$view = new ViewModel(array(
				'donnees' => $patientsAdmis,
		));
		return $view;
	}
	public function espaceRechercheMedAction(){
		$this->layout()->setTemplate('layout/consultation');
		return new ViewModel();
	}
	public function espaceRechercheSurvAction(){
		$this->layout()->setTemplate('layout/consultation');
		return new ViewModel();
	}
	public function consultationMedecinAction(){
		$this->layout()->setTemplate('layout/consultation');
		return new ViewModel();
	}
}
