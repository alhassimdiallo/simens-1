<?php
namespace Personnel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Personnel\Form\PersonnelForm;
use Personnel\Model\Personnel;
use Personnel\Form\TypePersonnelForm;
use Zend\Json\Json;
use Facturation\View\Helper\DateHelper;

class PersonnelController extends AbstractActionController {
	
	protected $formPersonnel;
	protected $dateHelper;
	
	protected $patientTable;
	protected $personnelTable;
	protected $medecinTable;
	protected $medicotechniqueTable;
	protected $logistiqueTable;
	protected $affectationTable;
	protected $typePersonnelTable;
	protected $serviceTable;

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
	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Personnel\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	/**
	 ***************************************************************************
	 *
	 *==========================================================================
	 *
	 * *************************************************************************
	 */
	Public function getDateHelper(){
		$this->dateHelper = new DateHelper();
	}
	
	public function baseUrl(){
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		return $tabURI[0];
	}
	
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
		$formPersonnel->get('nationalite')->setvalueOptions($listeDesPays);

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
			    	imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_personnel\\' . $nomPhoto . '.jpg' );

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
	
	public function supprimerAction() {
		$id_personne = (int) $this->params() ->fromPost('id');
		$agent = $this->getPersonnelTable()->getPersonne($id_personne);

		if($agent->type_personnel == 'Logistique'){
			$donneesComplement = $this->getLogistiqueTable()->deleteLogistique($id_personne);
		}else
		if($agent->type_personnel == 'Médico-technique'){
			$donneesComplement = $this->getMedicoTechniqueTable()->deleteMedicoTechnique($id_personne);
		}else
		if($agent->type_personnel == 'Médecin'){
			$donneesComplement = $this->getMedecinTable()->deleteMedecin($id_personne);
		}
		
		$this->getAffectationTable()->deleteAffectation($id_personne);
		$this->getPersonnelTable()->deletePersonne($id_personne);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode (  ) );
	}
	
	public function infoPersonnelAction() {
		$id_personne = (int) $this->params() ->fromPost('id');
		$this->getDateHelper();
		
		$unAgent = $this->getPersonnelTable()->getPersonne($id_personne);
		$photoAgent = $this->getPersonnelTable()->getPhoto($id_personne);
		
		/****************************************************************
		 * ======= COMPLEMENTS DES INFORMATIONS SUR L'AGENT==============
		 * **************************************************************
		 * **************************************************************/
		$donneesComplement = "";
		if($unAgent->type_personnel == 'Logistique'){
			$donneesComplement = $this->getLogistiqueTable()->getLogistique($id_personne);
		}else
		if($unAgent->type_personnel  == 'Médico-technique'){
			$donneesComplement = $this->getMedicoTechniqueTable()->getMedicoTechnique($id_personne);
		}else
		if($unAgent->type_personnel  == 'Médecin'){
			$donneesComplement = $this->getMedecinTable()->getMedecin($id_personne);
		}
		
		/****************************************************************
		 * ========= AFFICHAGE DES INFORMATION SUR LA VUE ===============
		 * **************************************************************
		 * **************************************************************/
		 $donneesAffectation = $this->getAffectationTable()->getAffectation($id_personne);
		 $leService = $this->getServiceTable()->getServiceAffectation($donneesAffectation->id_service);
		 
		
		
		/****************************************************************
		 * ========= AFFICHAGE DES INFORMATION SUR LA VUE ===============
		 * **************************************************************
		 * **************************************************************/
		$html ="<div style='width: 100%;'>
		
		       <img id='photo' src='".$this->baseUrl()."public/img/photos_personnel/" . $photoAgent . "'  style='float:left; margin-left:20px; margin-right:40px; width:105px; height:105px;'/>
		
		       <p style='color: white; opacity: 0.09;'>
		         <img id='photo' src='".$this->baseUrl()."public/img/photos_personnel/" . $photoAgent . "'   style='float:right; margin-right:15px; width:95px; height:95px;'/>
		       </p>
		         		
		       <table>
                 <tr>
			   	   <td style='width:160px; font-family: police1;font-size: 12px;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Pr&eacute;nom</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->prenom."</p></div>
			   	   </td>

			   	   <td style='width:160px; font-family: police1;font-size: 12px;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Date de naissance</a><br><p style='font-weight: bold;font-size: 17px;'>".$this->dateHelper->convertDate($unAgent->date_naissance)."</p></div>
			   	   </td>

			       <td style='width:160px; font-family: police1;font-size: 12px;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>T&eacute;l&eacute;phone</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->telephone."</p></div>
			   	   </td>
			   		   		
			   	   <td style='width:160px; font-family: police1;font-size: 12px;'>
			   	   </td>
			   		   		
			      </tr>
			   		   		
			   	  <tr>
			   	   <td style='width:160px; font-family: police1;font-size: 12px;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Nom</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->nom."</p></div>
			   	   </td>

			   	   <td style='width:160px; font-family: police1;font-size: 12px;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Lieu de naissance</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->lieu_naissance."</p></div>
			   	   </td>

			       <td style='width:160px; font-family: police1;font-size: 12px;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Nationalit&eacute;</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->nationalite."</p></div>
			   	   </td>
			   		   		
			   	   <td style='width:160px; font-family: police1;font-size: 12px; padding-left: 15px;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>@-Email</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->email."</p></div>
			   	   </td>
			   		   		
			      </tr>
			   		   		
			   	  <tr>
			   	   <td style='width:160px; font-family: police1;font-size: 12px; vertical-align: top;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Sexe</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->sexe."</p></div>
			   	   </td>

			   	   <td style='width:160px; font-family: police1;font-size: 12px; vertical-align: top;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Profession</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->profession."</p></div>
			   	   </td>

			       <td style='width:180px; font-family: police1;font-size: 12px; vertical-align: top;'>
			   		   <div id='aa'><a style='text-decoration: underline;'>Adresse</a><br><p style='font-weight: bold;font-size: 17px;'>".$unAgent->adresse."</p></div>
			   	   </td>
			   		   		
			   	   <td style='width:160px; font-family: police1;font-size: 12px;'>
			   	   </td>
			   		   		
			      </tr>
			   		   		
		        </table>

			    <div id='titre_info_deces'>Compl&eacute;ments informations (Personnel ".$unAgent->type_personnel.") </div>
			    <div id='barre'></div>";
			   		   		
		if($unAgent->type_personnel == 'Logistique'){
			$html .="<table style='margin-top:10px; margin-left:185px;'>";
			$html .="<tr>";
			$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Matricule:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->matricule."</div></td>";
			$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Grade:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->grade."</div></td>";
			$html .="<td style='width:270px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Domaine:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->domaine."</div></td>";
			$html .="<td style='width:230px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Autres:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->autres."</div></td>";
			$html .="</tr>";
			$html .="</table>";
		}else
		if($unAgent->type_personnel == 'Médico-technique'){
			$html .="<table style='margin-top:10px; margin-left:185px;'>";
			$html .="<tr>";
			$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Matricule:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->matricule."</div></td>";
			$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Grade:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->grade."</div></td>";
			$html .="<td style='width:270px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Domaine:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->domaine."</div></td>";
			$html .="<td style='width:230px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Fonction:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->autres."</div></td>";
			$html .="</tr>";
			$html .="</table>";
		}else
		if($unAgent->type_personnel == 'Médecin'){
			$html .="<table style='margin-top:10px; margin-left:185px;'>";
			$html .="<tr>";
			$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Matricule:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->matricule."</div></td>";
			$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Grade:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->grade."</div></td>";
			$html .="<td style='width:270px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Specialit&eacute;:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->specialite."</div></td>";
			$html .="<td style='width:230px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Fonction:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->fonction."</div></td>";
			$html .="</tr>";
			$html .="</table>";
		}

		$html .="<div id='titre_info_deces' style='margin-top: 25px;' >Affectation</div>";
		$html .="<div id='barre'></div>";
		
		$html .="<table style='margin-top:10px; margin-left:185px; margin-bottom: 30px;'>";
		$html .="<tr>";
		$html .="<td style='width:310px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Service:</a><div id='inform' style='float:left; font-weight:bold; font-size:15px;'>".$leService->nom."</div></td>";
		$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date d&eacute;but:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$this->dateHelper->convertDate($donneesAffectation->date_debut)."</div></td>";
		$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date fin:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$this->dateHelper->convertDate($donneesAffectation->date_fin)."</div></td>";
		$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Num&eacute;ro OS:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesAffectation->numero_os."</div></td>";
		$html .="</tr>";
		$html .="</table>";
		
			    
	    $html .="<div style='width: 100%; height: 100px;'>
	    		 <div style='color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:right;'>
                    <img  src='".$this->baseUrl()."public/images_icons/fleur1.jpg' />
                 </div>
                
			     <div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                 </div>";

		$html .="</div>";
		        
	    $html .="<script>listepatient();</script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function modifierDossierAction() {
		$this->layout()->setTemplate('layout/personnel');
		$this->getDateHelper();
		
		$id_personne = (int) $this->params()->fromRoute('val', 0);
		if (!$id_personne) {
			return $this->redirect()->toRoute('personnel', array(
					'action' => 'dossier-personnel'
			));
		}
		
		try {
			$laPersonne = $this->getPersonnelTable()->getPersonne($id_personne);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('personnel', array(
					'action' => 'liste-personnel'
			));
		}
		
		$this->getFormPersonnel();
		$formPersonnel = $this->formPersonnel;
		
		$patientTable = $this->getPatientTable();
		$vide = array(0 =>'');
		$listeDesPays = array_merge($vide, $patientTable->listePays());
		$formPersonnel->get('nationalite_origine')->setvalueOptions($listeDesPays);
		$formPersonnel->get('nationalite')->setvalueOptions($listeDesPays);
		$date = array('date_naissance' => $this->dateHelper->convertDate($laPersonne->date_naissance));
		
		$formPersonnel->bind($laPersonne);
		$formPersonnel->populateValues($date);

		//var_dump($laPersonne); exit();
		
		return array (
				'id_personne' =>$id_personne,
				'form' =>$formPersonnel,
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