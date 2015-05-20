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
    	
    	if(!$user){
    		return $this->redirect()->toRoute('admin', array('action' => 'login'));
    	}
    	
    	if($user['role'] == "superAdmin")
    	{
    		return array(
    				'user' => $user,
    		);
    	}
    	else if($user['role'] == "medecin")
    	{
    		return $this->redirect()->toRoute('consultation', array('action' => 'consultation-medecin'));
    	}
    	else if($user['role'] == "surveillant")
    	{
    		return $this->redirect()->toRoute('consultation', array('action' => 'recherche'));
    	}
    	else if($user['role'] == "infirmier")
    	{
    		return $this->redirect()->toRoute('hospitalisation', array('action' => 'liste'));
    	}
    	else if($user['role'] == "facturation")
    	{
    		return $this->redirect()->toRoute('facturation');
    	}
    	else if($user['role'] == "laborantin")
    	{
    		return $this->redirect()->toRoute('hospitalisation', array('action' => 'liste-demandes-examens'));
    	}
    	else if($user['role'] == "radiologie")
    	{
    		return $this->redirect()->toRoute('hospitalisation', array('action' => 'liste-demandes-examens-morpho'));
    	}
    	else if($user['role'] == "anesthesie")
    	{
    		return $this->redirect()->toRoute('hospitalisation', array('action' => 'liste-demandes-vpa'));
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
    	$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
    	
    	$utilisateur = $this->getUtilisateurTable()->getUtilisateurs($id);
    	$unAgent = $this->getUtilisateurTable()->getAgentPersonnel($utilisateur->id_personne);
    	$photo = $this->getUtilisateurTable()->getPhoto($utilisateur->id_personne);
    	
    	$date = $this->convertDate ( $unAgent['DATE_NAISSANCE'] );
    	
    	$serviceAgent = $this->getUtilisateurTable()->getServiceAgent($utilisateur->id_personne);
    	
    	$html ="<script> 
    			  $('#id').val('".$utilisateur->id."');
    			  $('#username').val('".$utilisateur->username."');
    			  $('#nomUtilisateur').val('".$unAgent['NOM']."');
    			  $('#prenomUtilisateur').val('".$unAgent['PRENOM']."');
    			  $('#idService').val('".$serviceAgent['IdService']."');
    			  $('#fonction').val('".$utilisateur->fonction."');
    			  $('#idPersonne').val('".$utilisateur->id_personne."'); 
    			  $('#LesChoixRadio input[name=role]').attr('checked', false);
    			  $('#LesChoixRadio input[name=role][value=".$utilisateur->role."] ').attr('checked', true);
    			 
    			  $('.nom').text('".$unAgent['NOM']."');
    			  $('.prenom').text('".$unAgent['PRENOM']."');
    			  $('.date_naissance').html('".$date."');		
    			  $('.adresse').html('".$unAgent['ADRESSE']."');
    			  $('.service').html('".$serviceAgent['NomService']."');
    			  $('#photo').html('<img style=\'width:105px; height:105px;\' src=\'".$chemin."/img/photos_personnel/" . $photo . "  \' >');
    			  		
    			  //$('#RoleSelect').val('".$utilisateur->role."');  
    			  		
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
    		//var_dump($donnees); exit();
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
    	$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
    	$username = $uAuth->getAuthService()->getIdentity();
    	$user = $this->getUtilisateurTable()->getUtilisateursWithUsername($username);
    	 
    	if(!$user){
    		return $this->redirect()->toRoute('admin', array('action' => 'login'));
    	}
    	
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
  			} else if($controller == 7){
  				return $this->redirect()->toRoute('hospitalisation' , array('action' => 'liste-demandes-vpa'));
  			}
  			
  		}
    
  		$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
  		$username = $uAuth->getAuthService()->getIdentity();
  		$user = $this->getUtilisateurTable()->getUtilisateursWithUsername($username);
  		
  		$data = array(
  				'id' => $user['id'],
  				'nomUtilisateur' => $user['Nom'],
  				'prenomUtilisateur' => $user['Prenom'],
  				'username' => $user['username'],
  				'fonction' => $user['fonction'],
  				'service' => $user['IdService'],
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
    
    //Liste des AGENTS DU PERSONNEL
    public function listeAgentPersonnelAjaxAction() {
    	$output = $this->getUtilisateurTable()->getListeAgentPersonnelAjax();
    	return $this->getResponse ()->setContent ( Json::encode ( $output, array (
    			'enableJsonExprFinder' => true
    	) ) );
    }
    
    public function convertDate($date) {
    	$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
    	return $nouv_date;
    }
    
    public function visualisationAction() {
    	
    	$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
    		
    	$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
    	
    	$unAgent = $this->getUtilisateurTable()->getAgentPersonnel($id);
    	$photo = $this->getUtilisateurTable()->getPhoto($id);
    	
    	$date = $this->convertDate ( $unAgent['DATE_NAISSANCE'] );
    	
    	$html = "<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='".$chemin."/img/photos_personnel/" . $photo . "'></div>";
    	
    	$html .= "<table id='PopupVisualisation'>";
    	
    	$html .= "<tr>";
    	$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unAgent['NOM'] . "</p></td>";
    	$html .= "</tr><tr>";
    	$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unAgent['PRENOM'] . "</p></td>";
    	$html .= "</tr><tr>";
    	$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
    	$html .= "</tr>";
    	$html .= "<tr>";
    	$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unAgent['ADRESSE'] . "</p></td>";
    	$html .= "</tr><tr>";
    	$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unAgent['TELEPHONE'] . "</p></td>";
    	$html .= "</tr>";
    	
    	$html .= "</table>";
    	
    	$html .= "<script> $('#PopupVisualisation tr').css({'background':'white'}); </script>";
    	
    	$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function nouvelUtilisateurAction() {

    	$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
    	
    	$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
    	 
    	$unAgent = $this->getUtilisateurTable()->getAgentPersonnel($id);
    	$photo = $this->getUtilisateurTable()->getPhoto($id);
    	
    	$date = $this->convertDate ( $unAgent['DATE_NAISSANCE'] );
    	 
    	$serviceAgent = $this->getUtilisateurTable()->getServiceAgent($id);
    	
    	$html = "<script> 
    			   $('.nom').text('".$unAgent['NOM']."');
    			   $('.prenom').text('".$unAgent['PRENOM']."');
    			   $('.date_naissance').text('".$date."');		
    			   $('.adresse').text('".$unAgent['ADRESSE']."');
    			   $('.service').text('".$serviceAgent['NomService']."');
    			   		
    			   $('#nomUtilisateur').val('".$unAgent['NOM']."');
    			   $('#prenomUtilisateur').val('".$unAgent['PRENOM']."');
    			   $('#idService').val('".$serviceAgent['IdService']."');
    			   $('#idPersonne').val('".$id."');
    			   		 
    			   $('#photo').html('<img style=\'width:105px; height:105px;\' src=\'".$chemin."/img/photos_personnel/" . $photo . " \' >');
    			 </script>";
    	
    	$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    
}
