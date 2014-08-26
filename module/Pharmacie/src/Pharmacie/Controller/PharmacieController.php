<?php
namespace Pharmacie\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PharmacieController extends AbstractActionController {
	public function  indexAction(){
		$view = new ViewModel(array(
				'message' => 'Hello world',
		));
		$view->setTemplate('pharmacie/pharmacie/index');
		return $view;
	}
}
