<?php
namespace Personnel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PersonnelController extends AbstractActionController {

	public function  indexAction(){
		$this->layout()->setTemplate('layout/personnel');
		$view = new ViewModel();
		return $view;
	}
	public function dossierPersonnelAction(){
		return new ViewModel();
	}
	public function listePersonnelAction(){
		return new ViewModel();
	}
	public function rechercheAction(){
		return new ViewModel();
	}
	public function listingAction(){
		return new ViewModel();
	}
	public function interventionAction(){
		return new ViewModel();
	}
	public function listingInterventionAction(){
		return new ViewModel();
	}
}