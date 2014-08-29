<?php

namespace Consultation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConsultationController extends AbstractActionController {
	public function  rechercheAction(){
		$this->layout()->setTemplate('layout/consultation');
		$view = new ViewModel(array(
				'donnees' => 'Hello world',
		));
		return $view;
	}
}
