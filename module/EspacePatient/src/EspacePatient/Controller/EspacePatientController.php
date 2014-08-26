<?php
namespace EspacePatient\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EspacePatientController extends AbstractActionController{
	public function rechercheAction(){
		$view = new ViewModel(array(
				'message' => 'Hello world',
		));
		$view->setTemplate('espace-patient/espace-patient/recherche');
		return $view;
	}
}