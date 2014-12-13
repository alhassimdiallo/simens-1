<?php
namespace Personnel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Personnel\Form\PersonnelForm;
use Personnel\Model\Personnel;
use Personnel\Form\TypePersonnelForm;
use Zend\Json\Json;
use Facturation\View\Helper\DateHelper;
use Personnel\Form\TransfertPersonnelForm;
use Zend\File\Transfer\Transfer;
use Personnel\Model\Transfert;
use Personnel\Model\Transfert1;
use Zend\XmlRpc\Value\String;

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
	protected $transfertTable;

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
	public function getTransfertTable() {
		if (! $this->transfertTable) {
			$sm = $this->getServiceLocator ();
			$this->transfertTable = $sm->get ( 'Personnel\Model\TransfertTable' );
		}
		return $this->transfertTable;
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
		
		$listeDesPays = array_merge(array(0 =>''), $patientTable->listePays());
		$formPersonnel->get('nationalite')->setvalueOptions($listeDesPays);
		$listeDesServices = array_merge(array(0 =>''), $this->getPatientTable()->listeServices());
		$formPersonnel->get('service_accueil')->setValueOptions($listeDesServices);

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
		
		$identif = (int) $this->params() ->fromPost('identif', null);
		
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
		 * = COMPLEMENTS DES INFORMATIONS SUR L'AFFECTATION DE L'AGENT ==
		 * **************************************************************
		 * **************************************************************/
		 $donneesAffectation = $this->getAffectationTable()->getAffectation($id_personne);
		 if($donneesAffectation){
		 	$leService = $this->getServiceTable()->getServiceAffectation($donneesAffectation->service_accueil);
		 }
		
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
			   		   		
		if($unAgent->type_personnel == 'Logistique' && $donneesComplement){
			$html .="<table style='margin-top:10px; margin-left:185px;'>";
			$html .="<tr>";
			$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Matricule:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->matricule_logistique."</div></td>";
			$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Grade:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->grade_logistique."</div></td>";
			$html .="<td style='width:270px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Domaine:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->domaine_logistique."</div></td>";
			$html .="<td style='width:230px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'></a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'></div></td>";
			$html .="</tr>";
			$html .="</table>";
		}else
		if($unAgent->type_personnel == 'Médico-technique' && $donneesComplement){
			$html .="<table style='margin-top:10px; margin-left:185px;'>";
			$html .="<tr>";
			$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Matricule:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->matricule_medico."</div></td>";
			$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Grade:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->grade_medico."</div></td>";
			$html .="<td style='width:270px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Domaine:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->domaine_medico."</div></td>";
			$html .="<td style='width:230px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Fonction:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesComplement->autres."</div></td>";
			$html .="</tr>";
			$html .="</table>";
		}else
		if($unAgent->type_personnel == 'Médecin' && $donneesComplement){
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
		if($donneesAffectation){
		$html .="<table style='margin-top:10px; margin-left:185px; margin-bottom: 30px;'>";
		$html .="<tr>";
		$html .="<td style='width:310px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Service:</a><div id='inform' style='float:left; font-weight:bold; font-size:15px;'>".$leService->nom."</div></td>";
		$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date d&eacute;but:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$this->dateHelper->convertDate($donneesAffectation->date_debut)."</div></td>";
		$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date fin:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$this->dateHelper->convertDate($donneesAffectation->date_fin)."</div></td>";
		$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Num&eacute;ro OS:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesAffectation->numero_os."</div></td>";
		$html .="</tr>";
		$html .="</table>";
		}
		

		//APPLIQUER UNIQUEMENT SUR L'INTERFACE DE VISUALISATION SUR LA LISTE DES AGENTS TRANSFERES
		
		if($identif == 1){
			
			$data = array(
					'id_personne' => $id_personne,
					'id_service_origine' => $donneesAffectation->service_accueil
			);
			
			$transfert = $this->getTransfertTable()->getTransfert($data);
			
			if($transfert) {
				$html .="<div id='titre_info_deces' style='margin-top: 25px;' >Transfert ( ".$transfert->type_transfert." ) </div>";
				$html .="<div id='barre'></div>";
			
				if($transfert->type_transfert == "Interne") {
				
					$leService = $this->getServiceTable()->getServiceAffectation($transfert->service_accueil);
					$html .="<table style='margin-top:10px; margin-left:185px; margin-bottom: 30px;'>";
					$html .="<tr>";
					$html .="<td style='width:310px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Service:</a><div id='inform' style='float:left; font-weight:bold; font-size:15px;'>".$leService->nom."</div></td>";
					$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date :</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$this->dateHelper->convertDate($transfert->date_debut)."</div></td>";
					$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date fin:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>  </div></td>";
					$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Num&eacute;ro OS:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesAffectation->numero_os."</div></td>";
					$html .="</tr>";
					$html .="</table>";
				
					$html .="<table style='margin-top:10px; margin-left:185px;'>";
					$html .="<tr>";
					$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px'><a style='text-decoration:underline; font-size:13px;'>Motif du transfert:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> ".$transfert->motif_transfert." </p></td>";
					$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 20px'><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> $transfert->note </p></td>";
					$html .="</tr>";
					$html .="</table>";
				}
				else {
					
					$leService = $this->getServiceTable()->getServiceAffectation($transfert->service_accueil_externe);
					$html .="<table style='margin-top:10px; margin-left:185px; margin-bottom: 30px;'>";
					$html .="<tr>";
					$html .="<td style='width:310px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Service:</a><div id='inform' style='float:left; font-weight:bold; font-size:15px;'>".$leService->nom."</div></td>";
					$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date :</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$this->dateHelper->convertDate($transfert->date_debut)."</div></td>";
					$html .="<td style='width:190px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date fin:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'> </div></td>";
					$html .="<td style='width:200px; vertical-align: top;'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Num&eacute;ro OS:</a><div id='inform' style='float:left; font-weight:bold; font-size:16px;'>".$donneesAffectation->numero_os."</div></td>";
					$html .="</tr>";
					$html .="</table>";
					
					$html .="<table style='margin-top:10px; margin-left:185px;'>";
					$html .="<tr>";
					$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px'><a style='text-decoration:underline; font-size:13px;'>Motif du transfert:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> ".(String)$transfert->motif_transfert_externe." </p></td>";
					$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 20px'><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>  </p></td>";
					$html .="</tr>";
					$html .="</table>";
				}
			}
		}
		
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
			var_dump($id_personne); exit();
			return $this->redirect()->toRoute('personnel', array(
					'action' => 'dossier-personnel'
			));
		}
		
		/****************************************************************
		 * ============== INITIALISATION DU FORMULAIRE ==================
		 * **************************************************************
		 * **************************************************************/
		$this->getFormPersonnel();
		$formPersonnel = $this->formPersonnel;
		
		$listeDesPays = array_merge(array(0 =>''), $this->getPatientTable()->listePays());
		$formPersonnel->get('nationalite')->setvalueOptions($listeDesPays);
		
		$listeDesServices = array_merge(array(0 =>''), $this->getPatientTable()->listeServices());
		$formPersonnel->get('service_accueil')->setValueOptions($listeDesServices);
		
		/****************************************************************
		 * ============= ENREGISTREMENT DES MODIFICATIONS ===============
		 * **************************************************************
		 * **************************************************************/
		$request = $this->getRequest();
		if ($request->isPost()) {
			$personnel =  new Personnel();
			$formPersonnel->setInputFilter($personnel->getInputFilter());
			$formPersonnel->setData($request->getPost());
		
			if ($formPersonnel->isValid()) {
				$personnel->exchangeArray($formPersonnel->getData());
				
				/*************************************************************
				 ============ ENREGISTREMENT DE L'ETAT CIVIL =================
				 *************************************************************
				 *************************************************************/
				$today = new \DateTime ( 'now' );
				$nomPhoto = $today->format ( 'dmy_His' );
				$fileBase64 = $this->params ()->fromPost ('fichier_tmp');
				$fileBase64 = substr($fileBase64, 23);
				
				if($fileBase64){
					$img = imagecreatefromstring(base64_decode($fileBase64));
				} else {
					$img = false;
				}
				$anciennePhoto = $this->getPersonnelTable()->getPersonne($id_personne)->photo;
				
				if ($img != false) {
					if($anciennePhoto){ //SI LA PHOTO EXISTE BIEN ELLE EST SUPPRIMER DU DOSSIER POUR ETRE REMPLACER PAR LA NOUVELLE
						unlink('C:\wamp\www\simens\public\img\photos_personnel\\'.$anciennePhoto.'.jpg');
					}
					imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_personnel\\' . $nomPhoto . '.jpg' );
				
					//ON ENREGISTRE AVEC LA NOUVELLE PHOTO
					$id_personnel = $this->getPersonnelTable()->savePersonnel($personnel,$nomPhoto);
				} else {
					//PAS DE NOUVELLE PHOTO
					$id_personnel = $this->getPersonnelTable()->savePersonnel($personnel,$anciennePhoto);
				}
				 
				/***************************************************************
				 ============ ENREGISTREMENT DES DONNEES DES COMPLEMENTS =======
				 ***************************************************************
				 ***************************************************************/
				if($personnel->type_personnel == 1) {
					$this->getMedicoTechniqueTable()->deleteMedicoTechnique($id_personne);
					$this->getLogistiqueTable()->deleteLogistique($id_personne);
					$this->getMedecinTable()->saveMedecin($personnel, $id_personne);
				}else
				if($personnel->type_personnel == 2){
					$this->getMedecinTable()->deleteMedecin($id_personne);
					$this->getLogistiqueTable()->deleteLogistique($id_personne);
					$this->getMedicoTechniqueTable()->saveMedicoTechnique($personnel, $id_personne);
				}else
				if($personnel->type_personnel == 3){
					$this->getMedecinTable()->deleteMedecin($id_personne);
					$this->getMedicoTechniqueTable()->deleteMedicoTechnique($id_personne);
					$this->getLogistiqueTable()->saveLogistique($personnel, $id_personne);
				}
				
				/***************************************************************
				 ============ ENREGISTREMENT DES DONNEES SUR L'AFFECTATION =====
				***************************************************************
				***************************************************************/
				 
				$this->getAffectationTable()->saveAffectation($personnel, $id_personne);
				
				// Redirection a la liste du personnel
				return $this->redirect()->toRoute('personnel', array('action' =>'liste-personnel') );
			}
		}
		
		/****************************************************************
		 * ====== AFFICHAGE DES DONNEES POUR LES MODIFICATIONS ==========
		 * **************************************************************
		 * **************************************************************/
		try {
			$laPersonne = $this->getPersonnelTable()->getPersonne($id_personne);
			
			if($laPersonne->type_personnel == 'Logistique'){
				$donneesComplement = $this->getLogistiqueTable()->getLogistique($id_personne);
			}else
			if($laPersonne->type_personnel == 'Médico-technique'){
				$donneesComplement = $this->getMedicoTechniqueTable()->getMedicoTechnique($id_personne);
			}else
			if($laPersonne->type_personnel == 'Médecin'){
				$donneesComplement = $this->getMedecinTable()->getMedecin($id_personne);
			}
			$donneesAffectation = $this->getAffectationTable()->getAffectation($id_personne);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('personnel', array(
					'action' => 'liste-personnel'
			));
		}
		
		$date = array();
		if($laPersonne){
			$date['date_naissance'] = $this->dateHelper->convertDate($laPersonne->date_naissance);
		}
		if($donneesAffectation){
			$date['date_debut'] = $this->dateHelper->convertDate($donneesAffectation->date_debut);
			$date['date_fin']   = $this->dateHelper->convertDate($donneesAffectation->date_fin);
		}
		
		$laPhoto = $laPersonne->photo;
		if(!$laPersonne->photo){ $laPhoto = 'identite'; }
		
		if($laPersonne){ $formPersonnel->bind($laPersonne); }
		if($donneesComplement){ $formPersonnel->bind($donneesComplement);}
		if($donneesAffectation){ $formPersonnel->bind($donneesAffectation);}
		$formPersonnel->populateValues($date);

		return array (
				'photo' => $laPhoto,
				'type_personnel' =>$laPersonne->type_personnel,
				'id_personne' =>$id_personne,
				'form' =>$formPersonnel,
		);
	}
	
	public function listePersonnelTransfertAjaxAction() {
		$personnel = $this->getPersonnelTable();
		$output = $personnel->getListeRechercheTransfertPersonnel();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	/**
	 * Pour avoir une vue sur l'agent
	 */
	public function vueAgentPersonnelAction(){
		
		$id_personne = ( int ) $this->params ()->fromPost ( 'id', 0 );
		
		$unAgent = $this->getPersonnelTable()->getPersonne($id_personne);
 		$photo = $this->getPersonnelTable()->getPhoto($id_personne);
		

 		$affectation = $this->getAffectationTable()->getServiceAgentAffecter($id_personne);
 		$service = $this->getServiceTable()->getServiceAffectation($affectation);
 		if($service){ $nomService = $service->nom;} else {$nomService = null;}
 		
		$this->getDateHelper();
		$date = $this->dateHelper->convertDate( $unAgent->date_naissance );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_personnel/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unAgent->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unAgent->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unAgent->nationalite . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unAgent->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unAgent->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Sit. matrimoniale:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unAgent->situation_matrimoniale . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unAgent->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unAgent->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unAgent->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_personnel/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		//SCRIPT UTILISER UNIQUEMENT DANS L'INTERFACE TRANSFERT D'UN AGENT
		$html .="<script> 
				  //TRANSFERT INTERNE
				    $('#service_origine').val('".$nomService."');
				    $('#service_origine').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					$('#service_origine').attr('readonly',true);

				    $('#service_accueil').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});
				    $('#motif_transfert').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});
				    $('#note').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});
				    
				  //TRANSFERT EXTERNE
				    $('#service_origine_externe').val('".$nomService."');
				    $('#service_origine_externe').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					$('#service_origine_externe').attr('readonly',true);

				    $('#hopital_accueil').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});
				    $('#service_accueil_externe').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});
				    $('#motif_transfert_externe').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});
				 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	/**
	 * Pour la visualisation de quelques d�tails sur l'agent
	 */
	public function popupAgentPersonnelAction() {
		
			$id_personne = (int)$this->params()->fromPost('id');
			$unAgent = $this->getPersonnelTable()->getPersonne($id_personne);
			$photo = $this->getPersonnelTable()->getPhoto($id_personne);
		
			$this->getDateHelper();
			$date = $this->dateHelper->convertDate($unAgent->date_naissance);
		
			$html ="<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='/simens/public/img/photos_personnel/".$photo."'></div>";
		
			$html .="<table>";
		
			$html .="<tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unAgent->nom."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unAgent->prenom."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$date."</p></td>";
			$html .="</tr>";
		
			$html .="<tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unAgent->adresse."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unAgent->telephone."</p></td>";
			$html .= "</tr>";
		
			$html .="</table>";
		
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		    return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		    
	}
	
	public function transfertAction(){
		$this->layout()->setTemplate('layout/personnel');
		
		$formTypePersonnel = new TypePersonnelForm();
		$formTypePersonnel->get('type_personnel')->setvalueOptions($this->getTypePersonnelTable()->listeTypePersonnel());
		
		$formTransfertPersonnel = new TransfertPersonnelForm();
		
		$formTransfertPersonnel->get('service_accueil')->setValueOptions($this->getPatientTable()->listeServices());
		$formTransfertPersonnel->get('hopital_accueil')->setValueOptions($this->getPatientTable()->listeHopitaux());
		
		
		/****************************************************************
		 * ======== ENREGISTREMENT DES DONNEES SUR LE TRANSFERT =========
		 * **************************************************************
		 * **************************************************************/
		$request = $this->getRequest();
		if ($request->isPost()) {
			$transfert =  new Transfert1();
			$formTransfertPersonnel->setInputFilter($transfert->getInputFilter());
			$formTransfertPersonnel->setData($request->getPost());
			$donneesPlus = array(
					'id_service_origine' => $this->getServiceTable()->getServiceParNom($this->params()->fromPost('service_origine')),
					'service_accueil_externe' => $this->params()->fromPost('service_accueil_externe'),
			);
			$formTransfertPersonnel->remove('service_accueil_externe');
			$formTransfertPersonnel->remove('hopital_accueil');

			if ($formTransfertPersonnel->isValid()) {
				$transfert->exchangeArray($formTransfertPersonnel->getData());
				
				$this->getTransfertTable()->saveTransfert($transfert, $donneesPlus);
				if($transfert->id_verif == 0){ 
					$this->getPersonnelTable()->updateEtatForTransfert($transfert->id_personne);
				}
				$this->redirect()->toRoute('personnel', array('action' => 'liste-transfert'));
			}else {
				$this->redirect()->toRoute('personnel', array('action' => 'transfert'));
			}
		}
		
		return array(
				'formTypePersonnel' => $formTypePersonnel,
				'formTransfertPersonnel' => $formTransfertPersonnel
		);
	}
	
	public function listeTransfertAjaxAction() {
		$personnel = $this->getPersonnelTable();
		$output = $personnel->getListeTransfertPersonnel();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeTransfertAction(){
		$this->layout()->setTemplate('layout/personnel');
	
		$formTypePersonnel = new TypePersonnelForm();
		$formTypePersonnel->get('type_personnel')->setvalueOptions($this->getTypePersonnelTable()->listeTypePersonnel());
	
		return array(
				'form' => $formTypePersonnel,
		);
	}
	
	public function supprimerTransfertAction() {
		
		$id_personne = (int) $this->params() ->fromPost('id');
	
		if($id_personne){
			$this->getPersonnelTable()->updateEtatForDeleteTransfert($id_personne);
			$this->getTransfertTable()->deleteTransfert($id_personne);
		}
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode (  ) );
	}
	
	public function interventionAction(){
		return new ViewModel();
	}
	public function listingInterventionAction(){
		return new ViewModel();
	}
}