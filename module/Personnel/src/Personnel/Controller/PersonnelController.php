<?php
namespace Personnel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Personnel\Form\PersonnelForm;
use Personnel\Model\Personnel;
use Personnel\Form\TypePersonnelForm;
use Zend\Json\Json;

class PersonnelController extends AbstractActionController {
	
	protected $formPersonnel;
	
	protected $patientTable;
	protected $personnelTable;
	protected $medecinTable;
	protected $medicotechniqueTable;
	protected $logistiqueTable;
	protected $affectationTable;
	protected $typePersonnelTable;

	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getPersonnelTable() {
		if (! $this->personnelTable) {
			$sm = $this->getServiceLocator ();
			$this->personnelTable = $sm->get ( 'Personnel\Model\PersonnelTable' );
		}
		return $this->personnelTable;
	}
	public function getMedecinTable() {
		if (! $this->medecinTable) {
			$sm = $this->getServiceLocator ();
			$this->medecinTable = $sm->get ( 'Personnel\Model\MedecinTable' );
		}
		return $this->medecinTable;
	}
	public function getMedicoTechniqueTable() {
		if (! $this->medicotechniqueTable) {
			$sm = $this->getServiceLocator ();
			$this->medicotechniqueTable = $sm->get ( 'Personnel\Model\MedicotechniqueTable' );
		}
		return $this->medicotechniqueTable;
	}
	public function getLogistiqueTable() {
		if (! $this->logistiqueTable) {
			$sm = $this->getServiceLocator ();
			$this->logistiqueTable = $sm->get ( 'Personnel\Model\LogistiqueTable' );
		}
		return $this->logistiqueTable;
	}
	public function getAffectationTable() {
		if (! $this->affectationTable) {
			$sm = $this->getServiceLocator ();
			$this->affectationTable = $sm->get ( 'Personnel\Model\AffectationTable' );
		}
		return $this->affectationTable;
	}
	public function getTypePersonnelTable() {
		if (! $this->typePersonnelTable) {
			$sm = $this->getServiceLocator ();
			$this->typePersonnelTable = $sm->get ( 'Personnel\Model\TypepersonnelTable' );
		}
		return $this->typePersonnelTable;
	}
	/**
	 ***************************************************************************
	 *
	 *==========================================================================
	 *
	 * *************************************************************************
	 */
	
	public function getFormPersonnel() {
		if (! $this->formPersonnel) {
			$this->formPersonnel = new PersonnelForm();
		}
		return $this->formPersonnel;
	}
	
	public function  indexAction(){
		$this->layout()->setTemplate('layout/personnel');
		$view = new ViewModel();
		return $view;
	}
	
	public function dossierPersonnelAction(){
		$this->layout()->setTemplate('layout/personnel');
		$this->getFormPersonnel();
		$formPersonnel = $this->formPersonnel;
		$patientTable = $this->getPatientTable();
		$vide = array(0 =>'');
		$listeDesPays = array_merge($vide, $patientTable->listePays());
		$formPersonnel->get('nationalite_origine')->setvalueOptions($listeDesPays);
		$formPersonnel->get('nationalite_actuelle')->setvalueOptions($listeDesPays);

		$request = $this->getRequest();
		if ($request->isPost()) {
			$personnel =  new Personnel();
			$formPersonnel->setInputFilter($personnel->getInputFilter());
			$formPersonnel->setData($request->getPost());
			if ($formPersonnel->isValid()) {
				$personnel->exchangeArray($formPersonnel->getData());
				//**************************************************************
			
			    //============ ENREGISTREMENT DE L'ETAT CIVIL ==================
			
			    //**************************************************************
				$today = new \DateTime ( 'now' );
				$nomPhoto = $today->format ( 'dmy_His' );
				$fileBase64 = $this->params ()->fromPost ('fichier_tmp');
				$fileBase64 = substr($fileBase64, 23);
				
				if($fileBase64){
					$img = imagecreatefromstring(base64_decode($fileBase64));
				} else {
					$img = false;
				}
				
			    if ($img != false) {
			    	//imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_personnel\\' . $nomPhoto . '.jpg' );

			    	//ON ENREGISTRE AVEC LA PHOTO
			    	$id_personnel = $this->getPersonnelTable()->savePersonnel($personnel,$nomPhoto);
			    } else {
			    	//ON ENREGISTRE SANS LA PHOTO
			    	$id_personnel = $this->getPersonnelTable()->savePersonnel($personnel);
			    }
			    
			    //***************************************************************
			    	
			    //============ ENREGISTREMENT DES DONNEES DES COMPLEMENTS =======
			    	
			    //***************************************************************
			    
			    if($personnel->type_personnel == 1) {
			    	$this->getMedecinTable()->saveMedecin($personnel, $id_personnel);
			    }else 
			        if($personnel->type_personnel == 2){
			        	$this->getMedicoTechniqueTable()->saveMedicoTechnique($personnel, $id_personnel);
			        }else
			    	    if($personnel->type_personnel == 3){
			    	    	$this->getLogistiqueTable()->saveLogistique($personnel, $id_personnel);
			    	    }		    	
			    	    
			    //***************************************************************
			    	    
			    //========== ENREGISTREMENT DES DONNEES SUR L'AFFECTATION =======
			    	    
			    //***************************************************************
			    
			    $this->getAffectationTable()->saveAffectation($personnel, $id_personnel);
			    	
			    return $this->redirect ()->toRoute ( 'personnel', array ('action' => 'liste-personnel'));
			} 
			//Quelque soit alpha le formulaire doit etre valide avant d'enregistrer les donnees. Donc pas besoin de ELSE
		}
		
		return array (
				'form' =>$formPersonnel,
		);
	}
	
	public function listePersonnelAjaxAction() {
		$personnel = $this->getPersonnelTable();
		$output = $personnel->getListePersonnel();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listePersonnelAction(){
		$this->layout()->setTemplate('layout/personnel');
		
		$formTypePersonnel = new TypePersonnelForm();
		$formTypePersonnel->get('type_personnel')->setvalueOptions($this->getTypePersonnelTable()->listeTypePersonnel());
		
		return array(
			'form' => $formTypePersonnel,
		);
	}
	
	public function infoPersonnelAction() {
		$this->layout()->setTemplate('layout/personnel');
		$id_personne = $this->params ()->fromRoute ('val', 0);
		
		return array(
			'id_personne' => $id_personne,
		);
	}
	
	public function rechercheAction(){
		return new ViewModel();
	}
	public function listingAction(){
		return new ViewModel();
	}
	public function interventionAction(){
		return new ViewModel();
	}
	public function listingInterventionAction(){
		return new ViewModel();
	}
}