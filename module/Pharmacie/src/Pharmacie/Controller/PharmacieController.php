<?php
namespace Pharmacie\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PharmacieController extends AbstractActionController {
	public function  indexAction(){
		$this->layout()->setTemplate('layout/pharmacie');
		$view = new ViewModel();
		return $view;
	}
	public function ajouterAction() {
		return new ViewModel();
	}
	public function commandesAction(){
		return new ViewModel();
	}
	public function listeMedicamentsAction(){
		return new ViewModel();
	}
}
