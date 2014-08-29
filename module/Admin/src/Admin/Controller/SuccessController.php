<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SuccessController extends AbstractActionController
{
	public function indexAction()
	{
		if (! $this->getServiceLocator()
				->get('AuthService')->hasIdentity()){
			return $this->redirect()->toRoute('login');
		}
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		return new ViewModel(array('identity'=>$identity));
	}
}