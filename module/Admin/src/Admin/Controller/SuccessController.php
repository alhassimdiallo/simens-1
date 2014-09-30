<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Admin\Model\Utilisateur;

class SuccessController extends AbstractActionController {
	protected $utilisateurTable;
	public function getUtilisateurTable(){
		if(!$this->utilisateurTable){
			$sm = $this->getServiceLocator();
			$this->utilisateurTable = $sm->get('Admin\Model\UtilisateurTable');
		}
		return $this->utilisateurTable;
	}
	public function indexAction() {
		if (! $this->getServiceLocator ()->get ( 'AuthService' )->hasIdentity ()) {
			return $this->redirect ()->toRoute ( 'login' );
		}
		$identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
		$utilisateur = $this->getUtilisateurTable();
		$type = $utilisateur->getProfilUtilisateur($identity);
		$user = $utilisateur->fetchUtilisateur($identity);
 		return new ViewModel(array('user'=>$user));
	}

}
