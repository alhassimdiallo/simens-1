<?php
namespace Personnel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PersonnelController extends AbstractActionController {

	public function  indexAction(){
		$view = new ViewModel(array(
				'message' => 'Hello world',
		));
		$view->setTemplate('personnel/personnel/index');
		return $view;
	}
}