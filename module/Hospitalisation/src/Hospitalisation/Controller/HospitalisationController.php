<?php
namespace Hospitalisation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HospitalisationController extends AbstractActionController {
	public function  hospiAction(){
		$view = new ViewModel(array(
				'message' => 'Hello world',
		));
		$view->setTemplate('hospitalisation/hospitalisation/hospi');
		return $view;
	}
}
