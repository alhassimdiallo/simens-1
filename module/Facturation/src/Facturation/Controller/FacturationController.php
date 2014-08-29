<?php
namespace Facturation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FacturationController extends AbstractActionController {
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
		return new ViewModel();
	}
}