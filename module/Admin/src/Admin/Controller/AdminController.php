<?php
/**
 * File for User Controller Class
 *
 * @category  User
 * @package   User_Controller
 * @author    Marco Neumann <webcoder_at_binware_dot_org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */

/**
 * @namespace
 */
namespace Admin\Controller;

/**
 * @uses Zend\Mvc\Controller\ActionController
 * @uses User\Form\Login
 */
use Zend\Mvc\Controller\AbstractActionController,
    Admin\Form\LoginForm as LoginForm;
use Zend\Json\Json;
use Admin\Form\UtilisateurForm;
use Admin\Form\ModifierUtilisateurForm;

/**
 * User Controller Class
 *
 * User Controller
 *
 * @category  User
 * @package   User_Controller
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class AdminController extends AbstractActionController
{
	protected $utilisateurTable;
	protected $serviceTable;
	
	public function getUtilisateurTable(){
		if(!$this->utilisateurTable){
			$sm = $this->getServiceLocator();
			$this->utilisateurTable = $sm->get('Admin\Model\UtilisateursTable');
		}
		return $this->utilisateurTable;
	}

	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Personnel\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	/**
	 * =========================================================================
	 * =========================================================================
	 * =========================================================================
	 */
	
    /**
     * Index Action
     */
    public function indexAction()
    {
        //@todo - Implement indexAction
    }

    /**
     * Login Action
     *
     * @return array
     */
    public function loginAction()
    {
    	$erreur_message = $this->params()->fromRoute('id', 0);
    	$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
    	if ($uAuth->getAuthService()->hasIdentity()) {
    		return $this->redirect ()->toRoute ('admin', array('action'=>'bienvenue') );
    	}
    	
        $form = new LoginForm();
        $request = $this->getRequest();

        if ($request->isPost()){ 
        
            $form->setData ( $request->getPost () );
            
        	if($form->isValid()) {
        
            $uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
            $authAdapter = $uAuth->getAuthAdapter();

            $username = $request->getPost ( 'username' );
            $password = $request->getPost ( 'password' );
            
            if($username && $password) {
            	$authAdapter->setIdentity($username);
            	$authAdapter->setCredential($this->getUtilisateurTable()->encryptPassword($password));
            	
            	if( $uAuth->getAuthService()->authenticate($authAdapter)->isValid()) {
            		return $this->redirect()->toRoute('admin', array('action' => 'bienvenue'));
            	}else {
            		return $this->redirect()->toRoute('admin', array('action' => 'login', 'id' => '1'));
            	}
            }
        	
        	}
        }
        return array(
        		'loginForm' => $form,
        		'erreur_message' => $erreur_message
        );
    }

    /**
     * Logout Action
     */
    public function logoutAction()
    {
        $uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!

        $uAuth->getAuthService()->clearIdentity();
        
        return $this->redirect()->toRoute('admin', array('action' => 'login'));
    }
    
    public function bienvenueAction() 
    {
    	$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
    	
    	$username = $uAuth->getAuthService()->getIdentity();
    	
    	$user = $this->getUtilisateurTable()->getUtilisateursWithUsername($username);
    	
    	if($user->role == "superAdmin")
    	{
    		return array(
    				'user' => $user,
    		);
    	}
    	elseif($user->role == "medecin")
    	{
    		return $this->redirect()->toRoute('consultation', array('action' => 'consultation-medecin'));
    	}
    	elseif($user->role == "surveillant")
    	{
    		return $this->redirect()->toRoute('consultation', array('action' => 'recherche'));
    	}
    	elseif($user->role == "infirmier")
    	{
    		return $this->redirect()->toRoute('hospitalisation', array('action' => 'liste'));
    	}
    	elseif($user->role == "facturation")
    	{
    		return $this->redirect()->toRoute('facturation');
    	}
    	elseif($user->role == "laborantin")
    	{
    		return $this->redirect()->toRoute('hospitalisation', array('action' => 'liste-demandes-examens'));
    	}
    	elseif($user->role == "radiologie")
    	{
    		return $this->redirect()->toRoute('hospitalisation', array('action' => 'liste-demandes-examens-morpho'));
    	}
    	
    	
    	echo '<div style="font-size: 25px; color: green; padding-bottom: 15px;" >vous n\'avez aucun privilège. Contacter l\'administrateur ----> Merci !!! </div>'; 
    	echo '<a style="font-size: 20px; color: red;" href="http://localhost/simens/public/admin/logout">Terminer</a>';
    	exit();
    }
    
    
    /**
     * GESTION DES UTILISATEURS
     */
    public function modifierUtilisateurAction() 
    {
    	$id = $this->params()->fromPost('id');
    
    	$utilisateur = $this->getUtilisateurTable()->getUtilisateurs($id);
    	$html  = "";
    	$html .="<script> 
    			  $('#id').val('".$utilisateur->id."');
    			  $('#username').val('".$utilisateur->username."');
    			  $('#nomUtilisateur').val('".$utilisateur->nom."');
    			  $('#prenomUtilisateur').val('".$utilisateur->prenom."');
    			  $('#service').val('".$utilisateur->id_service."');
    			  $('#fonction').val('".$utilisateur->fonction."');
    			  $('input[type=radio][name=role][value=".$utilisateur->role."]').attr('checked', true);
    			 
    			  $('#RoleSelect').val('".$utilisateur->role."');  
    			 </script>"; 
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ($html) );
    }
    
    public function listeUtilisateursAjaxAction() {
    	$output = $this->getUtilisateurTable()->getListeUtilisateurs();
    	return $this->getResponse ()->setContent ( Json::encode ( $output, array (
    			'enableJsonExprFinder' => true
    	) ) );
    }
    
    public function utilisateursAction()
    {
    	$this->layout ()->setTemplate ( 'layout/layoutUtilisateur' );
    	
    	$formUtilisateur = new UtilisateurForm();
    	
    	$listeService = $this->getServiceTable ()->fetchService ();
    	$formUtilisateur->get ( 'service' )->setValueOptions ( array_merge( array(""), $listeService ) );
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()){
    	
    		$donnees = $request->getPost ();
    		$this->getUtilisateurTable()->saveDonnees($donnees);
    	    
    		return $this->redirect()->toRoute('admin' , array('action' => 'utilisateurs'));
    		
    	}
    	    	
    	return array(
    		'formUtilisateur' => $formUtilisateur
    	);
    }
    
    //************************************************************************************
    //************************************************************************************
    //************************************************************************************
    public function modifierPasswordAction()
    {
    	$this->layout ()->setTemplate ( 'layout/consultation' );
    	$controller = $this->params()->fromRoute('id', 0);
    
    	$formUtilisateur = new ModifierUtilisateurForm();
    		
    	$listeService = $this->getServiceTable ()->fetchService ();
    	$formUtilisateur->get ( 'service' )->setValueOptions ( array_merge( array(""), $listeService ) );
    		
 		$request = $this->getRequest();
    		
  		if ($request->isPost()){
  			$donnees = $request->getPost ();
  			
  			$this->getUtilisateurTable()->modifierPassword($donnees);
   
  			if($controller == 1){
  				return $this->redirect()->toRoute('consultation' , array('action' => 'consultation-medecin'));
  			} else if($controller == 2){
  				return $this->redirect()->toRoute('consultation' , array('action' => 'recherche'));
  			} else if($controller == 3){
  				return $this->redirect()->toRoute('facturation' , array('action' => 'liste-patient'));
  			} else if($controller == 4){
  				return $this->redirect()->toRoute('hospitalisation' , array('action' => 'liste'));
  			} else if($controller == 5){
  				return $this->redirect()->toRoute('hospitalisation' , array('action' => 'liste-demandes-examens'));
  			} else if($controller == 6){
  				return $this->redirect()->toRoute('hospitalisation' , array('action' => 'liste-demandes-examens-morpho'));
  			}
  			
  		}
    
  		$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
  		$username = $uAuth->getAuthService()->getIdentity();
  		$user = $this->getUtilisateurTable()->getUtilisateursWithUsername($username);
  		$utilisateur = $this->getUtilisateurTable()->getUtilisateurs($user->id);
  		
  		$data = array(
  				'id' => $utilisateur->id,
  				'nomUtilisateur' => $utilisateur->nom,
  				'prenomUtilisateur' => $utilisateur->prenom,
  				'username' => $utilisateur->username,
  				'fonction' => $utilisateur->fonction,
  				'service' => $utilisateur->id_service,
  		);
  		
  		$formUtilisateur->populateValues($data);
    	return array(
    			'formUtilisateur' => $formUtilisateur,
    			'controller' => $controller,
    	);
    }
    
    public function verifierPasswordAction()
    {
    	$id = $this->params()->fromPost('id');
    	$password = $this->params()->fromPost('password');
    
    	$utilisateur = $this->getUtilisateurTable()->getUtilisateurs($id);
    	$passwordDecrypte = $this->getUtilisateurTable()->encryptPassword($password);
    	$resultComparer = 0;
    	if($passwordDecrypte == $utilisateur->password) {
    		$resultComparer = 1;
    	}
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ($resultComparer) );
    }
}
