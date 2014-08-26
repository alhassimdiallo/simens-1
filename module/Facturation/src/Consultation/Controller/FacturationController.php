<?php
namespace Facturation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FacturationController extends AbstractActionController {
	public function  listePatientAction(){
		$view = new ViewModel(array(
				'message' => 'Hello world',
		));
		$view->setTemplate('facturation/facturation/liste-patient');
		return $view;
	}
}