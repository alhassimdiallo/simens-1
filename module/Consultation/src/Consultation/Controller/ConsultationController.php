<?php

namespace Consultation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConsultationController extends AbstractActionController {
	public function  rechercheAction(){
		$view = new ViewModel(array(
				'message' => 'Hello world',
		));
		$view->setTemplate('consultation/consultation/recherche');
		return $view;
	}
}
