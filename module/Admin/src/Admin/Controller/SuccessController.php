<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class SuccessController extends AbstractActionController {
	public function indexAction() {
		if (! $this->getServiceLocator ()->get ( 'AuthService' )->hasIdentity ()) {
			return $this->redirect ()->toRoute ( 'login' );
		}
		// $sessionTimer = new Container('timer');
		// if ($sessionTimer && $sessionTimer->endTime) {
		// return new ViewModel(array('time'=>$sessionTimer->endTime));
		// return sprintf(
		// "Page rendered in %s seconds.",
		// $sessionTimer->executionTime
		// );
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		return new ViewModel(array('identity'=>$identity));
	}

}
