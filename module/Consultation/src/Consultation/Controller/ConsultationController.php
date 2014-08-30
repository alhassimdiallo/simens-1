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
