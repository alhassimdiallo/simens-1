<?php
namespace Admin;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController{

	protected $authentificationServiceTable;

	public function getAlbumTable()
	{
		if (!$this->authentificationServiceTable) {
			$sm = $this->getServiceLocator();
			$this->authentificationServiceTable = $sm->get('Admin\Model\AuthentificationServiceTable');
		}
		return $this->authentificationServiceTable;
	}

	public function indexAction() {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$identity = (array) Zend_Auth::getInstance()->getIdentity();
			$this->view->identity = $identity['name'];
		}else{
			$this->_forward('login');
		}
	}

	/*=======================================================================================================================*/
	//NOUVEAUX TRUCS D'AUTHENTIFICATION
	/*=======================================================================================================================*/
	public function loginAction()
	{
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()){
			$form = new Admin_Form_FormConnexion();

			if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())){

				$username = $form->getValue('login');
				$password = $form->getValue('password');

				$authAdapter = new Zend_Auth_Adapter_DbTable ( Zend_Db_Table::getDefaultAdapter () );
				$authAdapter->setTableName ('authentification')
				->setIdentityColumn ( 'login' )
				->setCredentialColumn ( 'password' )
				->setIdentity ( $username )
				->setCredential ( $password );

				$identification = $authAdapter->authenticate ();
				if ($identification->isValid ()) {
					$storage = Zend_Auth::getInstance ()->getStorage ();
					$storage->write ((array) $authAdapter->getResultRowObject ( null, 'password' ) );
					$this->_forward("index");
				}
				else {
					//$form->getElement('password')->addError ( "Il n'existe pas d'utilisateur avec ce mot de passe et ce username" );
					//throw new Exception ( "Il n'existe pas d'utilisateur avec ce mot de passe et ce username" );
					$this->view->form = $form;
					//$this->view->error = "erreur";
				}
			}else {
				$this->view->form = $form;
			}

		} else {
			$this->_forward('index');
		}

	}

	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		$this->_forward('index');
	}

	public function confirmationAction()
	{

	}

	/**************************************************************************************************************************

	================================== NOUVEAU CODE | NOUVEAU CODE | NOUVEAU CODE ==========================================

	**************************************************************************************************************************
	*/
	public function connexionserviceAction(){

		if ($this->getRequest()->isPost()) {
			$login = $this->getRequest()->getParam('login');
			$password = $this->getRequest()->getParam('password');

			//INSTANCIATION POUR RECUPERER LE NOM DU SERVICE
			$service = new Personnel_Model_Managers_Personnel();

			//INSTANCIATION POUR LA LISTE DES AUTHENTIFICATIONS
			$authentif = new Admin_Model_Managers_AuthentificationService();
			$ListeAuthentif = $authentif->listeAuthentification();

			$html = '';

			foreach ($ListeAuthentif as $Ligne){
				if($Ligne->Username == $login && $Ligne->Password == $password){
					if($Ligne->Idservice){
						$tabService = $service->getServiceAffectation($Ligne->Idservice);
						$html = $tabService['NOM'];
					}
					else{
						$html = 1;
					}
					break;
				}
			}

			$this->getResponse()->setHeader('Content-Type','application/html');
			$this->_helper->json->sendJson($html);
		}
		else{
			$form = new Admin_Form_FormConnexion();
			$this->view->form = $form;
		}
	}
}