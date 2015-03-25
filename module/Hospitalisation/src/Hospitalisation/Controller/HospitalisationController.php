<?php
namespace Hospitalisation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Facturation\View\Helper\DateHelper;
use Hospitalisation\Form\HospitaliserForm;
use Hospitalisation\Form\SoinForm;
use Hospitalisation\Model\Soinhospitalisation2;
use Hospitalisation;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormSelect;
use Zend\Form\View\Helper\FormTextarea;
use Hospitalisation\Form\SoinmodificationForm;
use Hospitalisation\Form\LibererPatientForm;
use Zend\Form\View\Helper\FormHidden;
use Hospitalisation\Form\AppliquerSoinForm;
use Hospitalisation\Form\AppliquerExamenForm;
use Zend\Server\Method\Prototype;
use Hospitalisation\Model\ResultatExamen;
use Zend\Crypt\PublicKey\Rsa\PublicKey;
use Hospitalisation\Form\VpaForm;
use Zend\Form\Element\Radio;
use Zend\Form\View\Helper\FormRadio;

class HospitalisationController extends AbstractActionController {
	
	protected $dateHelper;
	protected $path;
	
	protected $demandeHospitalisationTable;
	protected $patientTable;
	protected $batimentTable;
	protected $hospitalisationTable;
	protected $hospitalisationlitTable;
	protected $litTable;
	protected $salleTable;
	protected $soinhospitalisationTable;
	protected $soinsTable;
	protected $demandeTable;
	protected $examenTable;
	Protected $resultatExamenTable;
	protected $soinhospitalisation3Table;
	protected $resultatVpaTable;
	
	public function getDemandeHospitalisationTable() {
		if (! $this->demandeHospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeHospitalisationTable = $sm->get ( 'Hospitalisation\Model\DemandehospitalisationTable' );
		}
		return $this->demandeHospitalisationTable;
	}
	
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Hospitalisation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	
	public function getBatimentTable() {
		if (! $this->batimentTable) {
			$sm = $this->getServiceLocator ();
			$this->batimentTable = $sm->get ( 'Hospitalisation\Model\BatimentTable' );
		}
		return $this->batimentTable;
	}
	
	public function getHospitalisationTable() {
		if (! $this->hospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->hospitalisationTable = $sm->get ( 'Hospitalisation\Model\HospitalisationTable' );
		}
		return $this->hospitalisationTable;
	}
	
	public function getHospitalisationlitTable() {
		if (! $this->hospitalisationlitTable) {
			$sm = $this->getServiceLocator ();
			$this->hospitalisationlitTable = $sm->get ( 'Hospitalisation\Model\HospitalisationlitTable' );
		}
		return $this->hospitalisationlitTable;
	}
	
	public function getLitTable() {
		if (! $this->litTable) {
			$sm = $this->getServiceLocator ();
			$this->litTable = $sm->get ( 'Hospitalisation\Model\LitTable' );
		}
		return $this->litTable;
	}
	
	public function getSalleTable() {
		if (! $this->salleTable) {
			$sm = $this->getServiceLocator ();
			$this->salleTable = $sm->get ( 'Hospitalisation\Model\SalleTable' );
		}
		return $this->salleTable;
	}
	
	public function getSoinHospitalisationTable() {
		if (! $this->soinhospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->soinhospitalisationTable = $sm->get ( 'Hospitalisation\Model\SoinhospitalisationTable' );
		}
		return $this->soinhospitalisationTable;
	}
	
	public function getSoinsTable() {
		if (! $this->soinsTable) {
			$sm = $this->getServiceLocator ();
			$this->soinsTable = $sm->get ( 'Hospitalisation\Model\SoinsTable' );
		}
		return $this->soinsTable;
	}
	
    public function getDemandeTable() {
		if (! $this->demandeTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeTable = $sm->get ( 'Hospitalisation\Model\DemandeTable' );
		}
		return $this->demandeTable;
	}
	
	public function getExamenTable() {
		if (! $this->examenTable) {
			$sm = $this->getServiceLocator ();
			$this->examenTable = $sm->get ( 'Hospitalisation\Model\ExamenTable' );
		}
		return $this->examenTable;
	}
	
	public function getResultatExamenTable() {
		if (! $this->resultatExamenTable) {
			$sm = $this->getServiceLocator ();
			$this->resultatExamenTable = $sm->get ( 'Hospitalisation\Model\ResultatExamenTable' );
		}
		return $this->resultatExamenTable;
	}
	
	public function getSoinHospitalisation3Table() {
		if (! $this->soinhospitalisation3Table) {
			$sm = $this->getServiceLocator ();
			$this->soinhospitalisation3Table = $sm->get ( 'Hospitalisation\Model\Soinhospitalisation3Table' );
		}
		return $this->soinhospitalisation3Table;
	}
	
	public function getResultatVpa() {
		if (! $this->resultatVpaTable) {
			$sm = $this->getServiceLocator ();
			$this->resultatVpaTable = $sm->get ( 'Hospitalisation\Model\ResultatVisitePreanesthesiqueTable' );
		}
		return $this->resultatVpaTable;
	}
	/*/*********************************************************************************************************************************
	 * ==============================================================================================================================
	 * ******************************************************************************************************************************
	 * ******************************************************************************************************************************
	 * ==============================================================================================================================
	 */
	
	Public function getDateHelper(){
		$this->dateHelper = new DateHelper();
	}
	
	public function getPath(){
		$this->path = $this->getServiceLocator()->get('Request')->getBasePath();
		return $this->path;
	}
	
	public function  indexAction(){
		$this->layout()->setTemplate('layout/Hospitalisation');
		$view = new ViewModel(array(
				'message' => '<text style="margin-left: 15%; font-size: 40px; font-weight: bold; color: green; font-family: Times New Roman;"> Bienvenue au module hospitalisation </text> </br></br> 
				              <text style="margin-left: 30%; font-size: 25px; color: green; font-family: Times New Roman;"> Utilisez le menu a gauche</text>',
		));
		$view->setTemplate('hospitalisation/hospitalisation/index');
		return $view;
	}
	
	public function sallesAction()
	{
		$id_batiment = (int)$this->params()->fromPost ('id_batiment');
	
		if ($this->getRequest()->isPost()){
			$liste_select = "";
			
			foreach($this->getBatimentTable()->listeSalleDisponible($id_batiment) as $listeSalles){
				$liste_select.= "<option value=".$listeSalles['IdSalle'].">".$listeSalles['NumeroSalle']."</option>";
			}
			
			$liste_select.="<script> $('#salle').val(''); $('#lit').html('');</script>";
		}
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( $liste_select));
	}
	
	public function litsAction()
	{
		$id_salle = (int)$this->params()->fromPost ('id_salle');
	
		if ($this->getRequest()->isPost()){
			$liste_select = "";
				
			foreach($this->getBatimentTable()->listeLitDisponible($id_salle) as $listeLits){
				$liste_select.= "<option value=".$listeLits['IdLit'].">".$listeLits['NomLit']."</option>";
			}
			
			$liste_select.="<script> $('#lit').val('');</script>";
		}
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( $liste_select));
	}
	
	public function listePatientAjaxAction() {
		$output = $this->getDemandeHospitalisationTable()->getListeDemandeHospitalisation();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
		
		$formHospitalisation = new HospitaliserForm();
		$formHospitalisation->get('division')->setvalueOptions($this->getBatimentTable()->listeBatiments());
		
		if($this->getRequest()->isPost()) {
			$id_lit = $this->params()->fromPost('lit',0);
			$code_demande = $this->params()->fromPost('code_demande',0);
			
			$id_hosp = $this->getHospitalisationTable()->saveHospitalisation($code_demande);
			$this->getHospitalisationlitTable()->saveHospitalisationlit($id_hosp, $id_lit);
			
			$this->getDemandeHospitalisationTable()->validerDemandeHospitalisation($code_demande);
			
			$this->getLitTable()->updateLit($id_lit);
			
			return $this->redirect()->toRoute('hospitalisation' , array('action' => 'liste'));
		}
		
		return array(
			'form' => $formHospitalisation
		);
	}
	
	public function infoPatientAction() {
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
		
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
		
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
		
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .= "<div id='titre_info_deces'>D&eacute;tails des infos sur la demande </div>
		          <div id='barre'></div>";
		
		$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
		$html .= "<tr style='width: 80%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDateTime($demande['date_demande_hospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
		
		$html .="<table style='margin-top:0px; margin-left:195px; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$this->getDateHelper();
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
			
			$html .= "<div id='titre_info_deces'>Infos sur l'hospitalisation </div>
		          <div id='barre'></div>";
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
 			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDateTime($hospitalisation->date_debut) . "</p></td>";
 			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
 			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
 			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
		}
		
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                     </div>";
		}
		/***
		 * UTILISER UNIQUEMENT DANS LA PAGE POUR LA LIBERATION DU PATIENT EN COURS D'HOSPITALISATION
		*/
		else if($terminer == 111) {
			$html .="<div style='width: 100%; height: 270px;'>";
			
			$html .= "<div id='titre_info_deces'>Info lib&eacute;ration du patient </div>
		              <div id='barre'></div>";
			
			$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
			$formLiberation = new LibererPatientForm();
			$data = array('id_demande_hospi' => $id_demande_hospi);
			$formLiberation->populateValues($data);
			
			$formRow = new FormRow();
			$formTextArea = new FormTextarea();
			$formHidden = new FormHidden();
			
			$html .="<form  method='post' action='".$chemin."/hospitalisation/liberer-patient'>";
			$html .=$formHidden($formLiberation->get('id_demande_hospi'));
			$html .="<div style='width: 80%; margin-left: 195px;'>";
			$html .="<table id='form_patient' style='width: 100%; '>
					 <tr class='comment-form-patient' style='width: 100%'>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('resumer_medical')).$formTextArea($formLiberation->get('resumer_medical'))."</td>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('motif_sorti')).$formTextArea($formLiberation->get('motif_sorti'))."</td>
					   <td  style='width: 10%;'><a href='javascript:vider_liberation()'><img id='test' style=' margin-left: 25%;' src='/simens/public/images_icons/118.png' title='vider tout'></a></td>
					 </tr>
					</table>";
			$html .="</div>";
			
			$html .="<div style=' margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			
			$html .="<div style='width: 10%; padding-left: 30%; float:left;'>";
			$html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='liberer'>Lib&eacute;rer</button></div>
                     </div>";
			$html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button id='terminerLiberer'>Annuler</button></div>
                     </div>";
			$html .="</div>";
			$html .="</form>";
				
			$html .="<script>  
					  function vider_liberation(){
	                   $('#resumer_medical').val('');
	                   $('#motif_sorti').val('');
		              }
					  $('#resumer_medical, #motif_sorti').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'16px'});
					</script>
					";
		}
		$html .="</div>";
		
		$html .="<script> 
				  listepatient(); 
				 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function infoPatientHospiAction(){
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$administrerSoin = $this->params()->fromPost('administrerSoin',0);
		
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
		
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		if($administrerSoin != 111) {
		$html .= "<div id='titre_info_deces'>Attribution d'un lit</div>
		          <div id='barre'></div>";
		
		$html .= "<script>$('#salle, #division, #lit').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});</script>";
		}else if($administrerSoin == 111){
			$html .= "<div id='titre_info_deces'>Ajout d'un soin</div>
		          <div id='barre'></div>";
			
			$html .= "<script>$('#salle, #division, #lit').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});</script>";
		}
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function listePatientEncoursAjaxAction() {
		$output = $this->getDemandeHospitalisationTable()->getListePatientEncoursHospitalisation();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function enCoursAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
		
		$formSoin = new SoinForm();
		$formSoin->get('id_soins')->setvalueOptions($this->getSoinsTable()->listeSoins());
		
		if($this->getRequest()->isPost()) {

			$SoinHospitalisation =  new Soinhospitalisation2();
			$formSoin->setInputFilter($SoinHospitalisation->getInputFilter());
 			$formSoin->setData($this->getRequest()->getPost());
			
			if ($formSoin->isValid()) {
				$SoinHospitalisation->exchangeArray($formSoin->getData());
				$this->getSoinHospitalisationTable()->saveSoinhospitalisation($SoinHospitalisation);
			}
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		    return $this->getResponse ()->setContent ( Json::encode () );
		}
		
		return array(
				'form' => $formSoin
		);
	}
	
	public function raffraichirListeSoins($id_hosp){
		$liste_soins = $this->getSoinHospitalisationTable()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; margin-left:195px; width:80%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer;'>
					<th style='width: 28%;'>Soin</th>
					<th style='width: 8%;'>Dur&eacute;e</th>
					<th style='width: 23%;'>Date prescrite</th>
					<th style='width: 23%;'>Date recommand&eacute;e</th>
				    <th style='width: 12%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";

		rsort($liste_soins);
		foreach ($liste_soins as $cle => $Liste){	
			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
			$html .="<td style='width: 28%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->getSoinsTable()->getSoins($Liste['id_soins'])->libelle."</div></td>";
			$html .="<td style='width: 8%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['duree']." <minus>jrs</minus></div></td>";
			$html .="<td style='width: 23%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->dateHelper->convertDateTime($Liste['date_enreg'])."</div></td>";
			$html .="<td style='width: 23%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->dateHelper->convertDateTime($Liste['date_recommandee'])."</div></td>";
			$html .="<td style='width: 12%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='/simens/public/images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
			if($Liste['appliquer'] == 0) {
			   
				$html .="<a href='javascript:modifiersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	<img class='modifier".$Liste['id_sh']."'  src='/simens/public/images_icons/modifier.png' alt='Constantes' title='modifier'/>
					     </a>&nbsp;
	
				         <a href='javascript:supprimersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	<img class='supprimer".$Liste['id_sh']."'  src='/simens/public/images_icons/sup.png' alt='Constantes' title='annuler' />
					     </a>
				         </td>";
			
			    $html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='/simens/public/images_icons/non.png' alt='Constantes' title='soin non encore appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
				
				$html .="<a>
					    	<img class='modifier".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='/simens/public/images_icons/modifier.png' alt='Constantes' title='modifier'/>
					     </a>&nbsp;
				
				         <a >
					    	<img class='supprimer".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='/simens/public/images_icons/sup.png' alt='Constantes' title='annuler' />
					     </a>
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='/simens/public/images_icons/oui.png' alt='Constantes' title='soin d&eacute;j&agrave; appliqu&eacute;' />
					     &nbsp;
				         </td>";
				
			}
			
			$html .="</tr>";
			
			$html .="<script> 
					  $('.visualiser".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['id_sh']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/	
	                  /*************************/
	                  /*************************/	
	                  $('.supprimer".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                    		
	                  /*************************/	
	                  /*************************/
	                  /*************************/	
	                  $('.etat_oui".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/	
	                  /*************************/
	                  /*************************/	
	                  $('.etat_non".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
			        </script>";
		}
		$html .="</tbody>";
		$html .="</table>";

		$html .="<style>
				  #listeDataTable{
	                margin-left: 185px;
                  }
		
				  div .dataTables_paginate
                  {
				    margin-right: 20px;
                  }
				
				  #listeSoin tbody tr{
				    background: #fbfbfb;
				  }
				
				  #listeSoin tbody tr:hover{
				    background: #fefefe;
				  }
				 </style>";
		$html .="<script> listepatient (); listeDesSoins(); </script>";
	
		return $html;
	}
	
	public function listeSoinAction() {
		$id_hosp = $this->params()->fromPost('id_hosp', 0);
		
		$html = "<div id='titre_info_deces'>Liste des soins</div>
		          <div id='barre'></div>";
		$html .= $this->raffraichirListeSoins($id_hosp);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function vueSoinAppliquerAction() {
		$this->getDateHelper();
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$soinHosp = $this->getSoinHospitalisation3Table()->getSoinhospitalisationWithId_sh($id_sh);
		$heure = $this->getSoinHospitalisation3Table()->getHeures($id_sh);
		
		$lesHeures = "";
		if($heure){
			for ($i = 0; $i<count($heure); $i++){
				if($i == count($heure)-1) {
					$lesHeures.= $heure[$i];
				} else {
					$lesHeures.= $heure[$i].'  -  ';
				}
			}
		}
		
		$html  ="<table style='width: 99%;'>";
		$html .="<tr style='width: 99%;'>";
		$html .="<td style='width: 30%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;dicament:</a><br><p style='font-weight:bold; font-size:17px;'> ".$soinHosp->medicament." </p></td>";
		$html .="<td style='width: 22%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Voie d'administration:</a><br><p style='font-weight:bold; font-size:17px;'> ".$soinHosp->voie_administration." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Date prescription:</a><br><p style='font-weight:bold; font-size:17px;'> ".$this->dateHelper->convertDateTime($soinHosp->date_enregistrement)." </p></td>";
		$html .="<td style='width: 20%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Date recommand&eacute;e:</a><br><p style='font-weight:bold; font-size:17px;'> ".$this->dateHelper->convertDate($soinHosp->date_application_recommandee)." </p></td>";
		$html .="</tr>";
		
		$html .="<tr style='width: 99%;'>";
		$html .="<td colspan='3' style='width: 80%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Heures recommand&eacute;es:</a><br><p style='font-weight:bold; font-size:17px;'> ".$lesHeures." </p></td>";
		
		$html .="</table>";
		
		$html .="<table style='width: 95%;'>";
		$html .="<tr style='width: 95%;'>";
		$html .="<td style='width: 50%; padding-top: 10px; padding-right:25px;'><a style='text-decoration:underline; font-size:13px;'>Motif:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 10px;'> ".$soinHosp->motif." </p></td>";
		$html .="<td style='width: 50%; padding-top: 10px;'><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ".$soinHosp->note." </p></td>";
		$html .="<td style='width: 0%;'> </td>";
		$html .= "</tr>";
		
		if($soinHosp->appliquer == 1) {
			$html .="<tr style='width: 95%;'>
					   <td colspan='2' style='width: 95%;'>
					     <div id='titre_info_admis'>Informations sur l'application du soin</div><div id='barre_admis'></div>
					   </td>
					 </tr>";
			
			$html .="<table style='width: 95%; margin-top: 10px;'>";
			$html .="<tr style='width: 95%;'>";
			$html .="<td style='width: 50%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Date d'application:</a><br><p style='font-weight:bold; font-size:17px;'> ".$this->dateHelper->convertDate($soinHosp->date_application)." </p></td>";
			$html .="<td style='width: 50%; vertical-align:top;'><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ".$soinHosp->note_application." </p></td>";
			$html .= "</tr>";
		}
		
		$html .="</table>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
		
		
		
	}
	
	public function supprimerSoinAction() {
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$this->getSoinHospitalisationTable()->supprimerHospitalisation($id_sh);

		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode () );
	}
	
	public function modifierSoinAction() {
		$id_sh = $this->params()->fromPost('id_sh', 0);
		
		$this->getDateHelper();
 		$soin = $this->getSoinHospitalisationTable()->getSoinhospitalisationWithId_sh($id_sh);
		
		$form = new SoinmodificationForm();
		$form->get('id_soins_m')->setvalueOptions($this->getSoinsTable()->listeSoins());
		if($soin){
			$duree = $soin->duree;
			if(strlen($soin->duree) == 1){
				$duree = "0".$soin->duree;
			}
				
			
			$data = array(
					'id_soins_m' => $soin->id_soins,
					'duree_m' => $duree,
					'date_recommandee_m' => $this->dateHelper->convertDate($soin->date_recommandee),
					'heure_recommandee_m'=> $this->dateHelper->convertTime($soin->date_recommandee),
					
					'motif_m' => $soin->motif,
					'note_m' => $soin->note,
			);
			
			$form->populateValues($data);
		}
		
		$formRow = new FormRow();
		$formText = new FormText();
		$formSelect = new FormSelect();
		$formTextArea = new FormTextarea();
		
		$html ="<table id='form_patient' style='width: 100%;'>  
		      
		           <tr class='comment-form-patient' style='width: 100%;'>
		             <td style='width: 30%;'> ".$formRow($form->get('id_soins_m')).$formSelect($form->get('id_soins_m'))."</td> 
		             <td id='duree_soin' style='width: 18%;'>".$formRow($form->get('duree_m')).$formText($form->get('duree_m'))."</td> 
		             <td id='duree_recommandee_soin' style='width: 30%;'>".$formRow($form->get('date_recommandee_m')).$formText($form->get('date_recommandee_m'))."</td> 
		             <td id='heure_soin' style='width: 22%;'>".$formRow($form->get('heure_recommandee_m')).$formText($form->get('heure_recommandee_m'))."</td> 
		           </tr>
		         </table>
		    
		         <table id='form_patient' style='width: 100%;'> 
		           <tr class='comment-form-patient'>
		             <td id='note_soin'  style='width: 40%; '>". $formRow($form->get('motif_m')).$formTextArea($form->get('motif_m'))."</td>
		             <td id='note_soin'  style='width: 40%; '>". $formRow($form->get('note_m')).$formTextArea($form->get('note_m'))."</td>
		             <td  style='width: 10%;' id='ajouter'></td>   
		             <td  style='width: 10%;'></td>           
		           </tr>
		         </table>";
		$html .="<script>
				$('#date_recommandee_m, #heure_recommandee_m, #id_soins_m, #duree_m, #note_m, #motif_m').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'16px'});
				
				$(function($){
		          $('#heure_soin input').mask('23:59:59');
	            });
	
	            $(function($){
		          $('#duree_soin input').mask('99');
	            });
				
				listepatient();
				</script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function libererPatientAction() {
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi', 0);
		$resumer_medical = $this->params()->fromPost('resumer_medical', 0);
		$motif_sorti = $this->params()->fromPost('motif_sorti', 0);
		
		$this->getHospitalisationTable()->libererPatient($id_demande_hospi, $resumer_medical, $motif_sorti);
		
		return $this->redirect()->toRoute('hospitalisation', array('action' =>'en-cours'));
	}
	
	public function detailInfoLiberationPatientAction() {
		$this->getDateHelper();
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
	
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
	
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>
				     <span id='titre_info_demande' style='margin-left: -10px; cursor:pointer;'> 
				        <img src='".$chemin."/img/light/plus.png' /> D&eacute;tails des infos sur la demande
				     </span>
				  </div>
		          <div id='barre'></div>";
	
		$html .= "<div id='info_demande'>";
		$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
		$html .= "<tr style='width: 80%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDateTime($demande['Datedemandehospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
	
		$html .="<table style='margin-top:0px; margin-left:195px; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .= "</div>";
	
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$this->getDateHelper();
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
				
			$html .= "<div id='titre_info_deces'>
					   <span id='titre_info_hospitalisation' style='margin-left:-10px; cursor:pointer;'> 
				          <img src='".$chemin."/img/light/plus.png' /> Infos sur l'hospitalisation 
				       </span>  
					  </div>
		              <div id='barre'></div>";
			
			$html .= "<div id='info_hospitalisation'>";
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDateTime($hospitalisation->date_debut) . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
	
		$html .= "<div id='titre_info_deces'>
				    <span id='titre_info_liste' style='margin-left:-10px; cursor:pointer;'> 
				      <img src='".$chemin."/img/light/plus.png' /> Liste des soins 
				    </span>
				  </div>
		          <div id='barre'></div>";

		$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
		$html .= "<div id='info_liste'>";
		$html .= $this->raffraichirListeSoins($hospitalisation->id_hosp);
		$html .= "</div>";
		
		$html .= "<div id='titre_info_deces'>
				   <span id='titre_info_liberation' style='margin-left:-10px; cursor:pointer;'> 
				      <img src='".$chemin."/img/light/plus.png' /> Infos sur la lib&eacute;ration du patient 
				   </span>
				  </div>
		          <div id='barre'></div>";
		
		$html .= "<div id='info_liberation'>";
		$html .= "<table style='margin-top:0px; margin-left:195px; width: 70%;'>";
		$html .= "<tr style='width: 70%'>";
		$html .= "<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$hospitalisation->resumer_medical."</p></td>";
		$html .= "<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$hospitalisation->motif_sorti."</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
		
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminerdetailhospi'>Terminer</button></div>
                     </div>";
		}	

		$html .="<script>
				  listepatient();
				  initAnimation();
				  animationPliantDepliant();
				  animationPliantDepliant2();
				  animationPliantDepliant3();
		          animationPliantDepliant4();
				 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	/*/*********************************************************************************************************************************
	 * ==============================================================================================================================
	* ******************************************************************************************************************************
	* ******************************************************************************************************************************
	* ==============================================================================================================================
	*/
	public function listePatientSuiviAjaxAction() {
		$output = $this->getDemandeHospitalisationTable()->getListePatientSuiviHospitalisation();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function suiviPatientAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
		
		$formAppliquerSoin = new AppliquerSoinForm();
		
		return array(
				'form' => $formAppliquerSoin
		);
	}
	
	public function listeSoinsAAppliquer($id_hosp){
		$liste_soins = $this->getSoinHospitalisation3Table()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; margin-left:195px; width:80%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer; '>
					<th style='width: 24%;'>M<minus>&eacute;dicament</minus></th>
					<th style='width: 21%;'>V<minus>oie d'administration</minus></th>
					<th style='width: 21%;'>D<minus>ate prescription</minus></th>
					<th style='width: 18%;'>D<minus>ate recommand&eacute;e </minus></th>
				    <th style='width: 10%;'>O<minus>ptions</minus></th>
				    <th style='width: 6%;'>E<minus>tat</minus></th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
	
		sort($liste_soins);
		foreach ($liste_soins as $cle => $Liste){
			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
			$html .="<td style='width: 24%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['medicament']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['voie_administration']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->dateHelper->convertDateTime($Liste['date_enregistrement'])."</div></td>";
			$html .="<td style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->dateHelper->convertDate($Liste['date_application_recommandee'])."</div></td>";
	
			if($Liste['appliquer'] == 0) {
				$html .="<td style='width: 10%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='/simens/public/images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				$html .="<a href='javascript:appliquerSoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	<img class='modifier".$Liste['id_sh']."'  src='/simens/public/img/dark/blu-ray.png' alt='Constantes' title='appliquer le soin'/>
					     </a>&nbsp;
	
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='/simens/public/images_icons/non.png' alt='Constantes' title='soin non encore appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
				$html .="<td style='width: 10%;'> <a href='javascript:vuesoinApp(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='/simens/public/images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				$html .="<a>
					    	<img class='modifier".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='/simens/public/img/dark/blu-ray.png' alt='Constantes' title=''/>
					     </a>&nbsp;
	
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='/simens/public/images_icons/oui.png' alt='Constantes' title='soin d&eacute;j&agrave; appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}
				
			$html .="</tr>";
				
			$html .="<script>
					  $('.visualiser".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['id_sh']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['id_sh']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	           
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['id_sh']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['id_sh']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['id_sh']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
			        </script>";
		}
		$html .="</tbody>";
		$html .="</table>";
	
		$html .="<style>
				  #listeDataTable{
	                margin-left: 185px;
                  }
	
				  div .dataTables_paginate
                  {
				    margin-right: 20px;
                  }
				
				  #listeSoin tbody tr{
				    background: #fbfbfb;
				  }
				
				  #listeSoin tbody tr:hover{
				    background: #fefefe;
				  }
				 </style>";
		$html .="<script> listepatient (); listeDesSoins(); </script>";
	
		return $html;
	}
	
	public function administrerSoinPatientAction() {
		$this->getDateHelper();
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
	
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
	
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>
				     <span id='titre_info_demande' style='margin-left: -10px; cursor:pointer;'>
				        <img src='".$chemin."/img/light/plus.png' /> D&eacute;tails des infos sur la demande
				     </span>
				  </div>
		          <div id='barre'></div>";
	
		$html .= "<div id='info_demande'>";
		$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
		$html .= "<tr style='width: 80%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDateTime($demande['Datedemandehospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
	
		$html .="<table style='margin-top:0px; margin-left:195px; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .= "</div>";
	
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$this->getDateHelper();
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
	
			$html .= "<div id='titre_info_deces'>
					   <span id='titre_info_hospitalisation' style='margin-left:-10px; cursor:pointer;'>
				          <img src='".$chemin."/img/light/plus.png' /> Infos sur l'hospitalisation
				       </span>
					  </div>
		              <div id='barre'></div>";
				
			$html .= "<div id='info_hospitalisation'>";
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->dateHelper->convertDateTime($hospitalisation->date_debut) . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
	
		$html .= "<div id='titre_info_deces'>
				    <span id='titre_info_liste' style='margin-left:-10px; cursor:pointer;'>
				      <img src='".$chemin."/img/light/minus.png' /> Liste des soins
				    </span>
				  </div>
		          <div id='barre'></div>";
	
		$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
		$html .= "<div id='info_liste'>";
		$html .= $this->listeSoinsAAppliquer($hospitalisation->id_hosp);
		$html .= "</div>";
	
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminerdetailhospi'>Terminer</button></div>
                     </div>";
		}
	
		$html .="<script>
				  listepatient();
				  initAnimation();
				  animationPliantDepliant2();
				  animationPliantDepliant3();
		          animationPliantDepliant4();
				 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	
	public function applicationSoinAction() {
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$note = $this->params()->fromPost('note', 0);
		$user = $this->layout()->user;
		$id_personne = $user->id_personne; //L'infirmier qui a appliqué le soin au patient
		
		$this->getSoinHospitalisation3Table()->appliquerSoin($id_sh, $note, $id_personne);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode (  ) );
	}
	
	
	public function raffraichirListeAction() {
		$id_hosp = $this->params()->fromPost('id_hosp',0);
		
		$html = $this->listeSoinsAAppliquer($id_hosp);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	
	/*/*********************************************************************************************************************************
	 * ==============================================================================================================================
	* ******************************************************************************************************************************
	* ******************************************************************************************************************************
	* ==============================================================================================================================
	*/
	/*EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN EXAMEN */
	/*****************************************************************************************************************************/
	/*****************************************************************************************************************************/
	
	public function listeDemandesExamensAjaxAction() {
		$output = $this->getDemandeTable()->getListeDemandesExamens();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeDemandesExamensAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
		
		$formAppliquerExamen = new AppliquerExamenForm();
		
		return array(
				'form' => $formAppliquerExamen
		);
	}
	
	
	public function listeExamensBiologiquesAction($id_cons) {
	
		$liste_examens_demandes = $this->getDemandeTable()->getDemandesExamensBiologiques($id_cons);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; margin-left:195px; width:80%;' id='listeDesExamens'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer; font-family: Times New Roman; font-weight: bold;'>
					<th style='width: 9%;'>Num&eacute;ro</th>
					<th style='width: 32%;'>Libelle examen</th>
					<th style='width: 40%;'>Note</th>
				    <th style='width: 13%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
		$cmp = 1;
		foreach ($liste_examens_demandes as $Liste){
			$html .="<tr style='width: 100%;' id='".$Liste['idDemande']."'>";
			$html .="<td style='width: 9%;'><div id='inform' style='margin-left: 25%; float:left; font-weight:bold; font-size:17px;'> " .$cmp++. ". </div></td>";
			$html .="<td style='width: 32%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$this->getExamenTable()->getExamen($Liste['idExamen'])->libelleExamen. " </div></td>";
			$html .="<td style='width: 40%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$Liste['noteDemande']. " </div></td>";
			$html .="<td style='width: 13%;'>
  					    <a href='javascript:vueExamenBio(".$Liste['idDemande'].") '>
  					       <img class='visualiser".$Liste['idDemande']."' style='margin-right: 9%; margin-left: 3%;' src='../images_icons/voird.png' title='d&eacute;tails' />
  					    </a>&nbsp";
	
			if($Liste['appliquer'] == 0) {
				$html .="<a href='javascript:appliquerExamenBio(".$Liste['idDemande'].")'>
 					    	<img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/aj.gif' title='Entrer les r&eacute;sultats'/>
 					     </a>";
					
				$html .="<a>
 					    	<img style='color: white; opacity: 0.09;' src='../images_icons/74biss.png'  />
 					     </a>
 				         </td>";
					
				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_non".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/non.png' title='examen non encore effectu&eacute;' />
  					     </a>
  					     </td>";
			}else {
					
				$resultat = $this->getResultatExamenTable()->getResultatExamen($Liste['idDemande']);
	
				if($resultat->envoyer == 1) {
					$html .="<a>
 					    	<img style='margin-right: 16%; color: white; opacity: 0.09;' src='../images_icons/pencil_16.png'/>
 					     </a>";
	
					if($Liste['responsable'] == 1) { /*Envoyer par le medecin*/
						$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen valid&eacute; par le medecin'/>
 					     </a>
 				         </td>";
					} else
					{ /*Envoyer par le laborantin*/
						$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen envoy&eacute;'/>
 					     </a>
 				         </td>";
					}
	
	
				} else {
					$html .="<a href='javascript:modifierExamenBio(".$Liste['idDemande'].")'>
 					    	<img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/pencil_16.png'  title='modifier r&eacute;sultat'/>
 					     </a>";
					$html .="<a href='javascript:envoyerBio(".$Liste['idDemande'].")'>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/74biss.png'  title='envoyer'/>
 					     </a>
 				         </td>";
				}
					
					
				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_oui".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/oui.png' title='examen d&eacute;ja effectu&eacute;' />
  					     </a>
  					     </td>";
			}
	
			$html .="</tr>";
	
			$html .="<script>
					  $('.visualiser".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['idDemande']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                   /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.envoyer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.envoyer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
			        </script>";
		}
		$html .="</tbody>";
		$html .="</table>";
	
		$html .="<style>
				  #listeDataTable{
	                margin-left: 185px;
                  }
	
				  div .dataTables_paginate
                  {
				    margin-right: 20px;
                  }
	
				  #listeDesExamens tbody tr{
				    background: #fbfbfb;
				  }
	
				  #listeDesExamens tbody tr:hover{
				    background: #fefefe;
				  }
	
				 </style>";
		$html .="<script> listepatient (); listeDesSoins(); $('#Examen_id_cons').val('".$id_cons."'); </script>";
	
		return $html;
	
	}
	
	
	public function listeExamensDemanderAction() {

		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$terminer = $this->params()->fromPost('terminer',0); 
		$examensBio = $this->params()->fromPost('examensBio',0);
		
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);

		$demande = $this->getDemandeTable()->getDemandeWithIdcons($id_cons);
		
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .= "<div id='titre_info_deces'>Informations sur la demande d'examen </div>
		          <div id='barre'></div>";
		foreach ($demande as $donnees) {
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->dateHelper->convertDateTime($donnees['Datedemande']). "</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
		}

		$html .= "<div id='titre_info_deces'>Liste des examens demand&eacute;s </div>
		          <div id='barre'></div>
				
				 <div id='info_liste'>";
		if($examensBio == 1){
			$html .= $this->listeExamensBiologiquesAction($id_cons);
		}
		else /* POUR LES EXAMENS MORPHOLOGIQUES (Radiologie ... )*/
		   {
		   	$html .= $this->listeExamensAction($id_cons);
		   }
		$html .="</div>";
		
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                     </div>";
		}
	
		$html .="</div>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function verifierSiResultatExisteAction() {
		$idDemande = $this->params()->fromPost('idDemande', 0);
		$demande = $this->getDemandeTable()->getDemande($idDemande);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($demande->appliquer) );
	}
	
	public function vueExamenAppliquerAction() {
		$this->getDateHelper();
		$idDemande = $this->params()->fromPost('idDemande', 0);
	
		$demande = $this->getDemandeTable()->getDemande($idDemande);
		
		$html  ="<table style='width: 95%;'>";
		$html .="<tr style='width: 95%;'>";
		$html .="<td style='width: 100%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Libelle examen:</a><br><p style='font-weight:bold; font-size:17px;'> ". $this->getExamenTable()->getExamen($demande->idExamen)->libelleExamen ." </p></td>";
		$html .="</tr>";
		$html .="</table>";
	
		$html .="<table style='width: 95%; margin-bottom: 25px;'>";
		$html .="<tr style='width: 95%;'>";
		$html .="<td style='width: 90%; padding-top: 10px; padding-right:25px;'><a style='text-decoration:underline; font-size:13px;'>Motif:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $demande->noteDemande ." </p></td>";
		$html .="<td style='width: 10%;'> </td>";
		$html .= "</tr>";
		$html .="</table>";
		
		if($demande->appliquer == 1){
			$resultat = $this->getResultatExamenTable()->getResultatExamen($idDemande);
			$date = 'pas de date';
			if($this->dateHelper->convertDateTime($resultat->date_modification) == '00/00/0000 - 00:00:00'){
				$date = $this->dateHelper->convertDateTime($resultat->date_enregistrement);
			} else {
				$date = $this->dateHelper->convertDateTime($resultat->date_modification);
			}
			$html .= "<div id='titre_info_resultat_examen'>R&eacute;sultat de l'examen  <span style='position: absolute; right: 20px; font-size: 14px; font-weight: bold;'>". $date ." </span></div>
			          <div id='barre_resultat' ></div>";
			
			$html .="<table style='width: 100%; margin-top: 10px;'>";
			$html .="<tr style='width: 100%;'>";
			$html .="<td style='width: 50%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Technique utilis&eacute;e:</a><br><p style='font-weight:bold; font-size:17px;'> ". $resultat->techniqueUtiliser ." </p></td>";
			$html .="<td id='visualisationImageResultats' style='width: 50%; vertical-align:top;'><img style='height: 50px;' src='../images_icons/jpg_file.png' title='Visualiser'/></td>";
			$html .="</tr>";
			$html .="</table>";
			
			$html .="<table style='width: 100%;'>";
			$html .="<tr style='width: 100%;'>";
			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Note R&eacute;sultat:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->noteResultat ." </p></td>";
			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Conclusion:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->conclusion ." </p></td>";
			$html .= "</tr>";
			$html .="</table>";
		}
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function appliquerExamenAction() {
		
	    $donnees = $this->getRequest()->getPost();
	    $user = $this->layout()->user;
	    $id_personne = $user->id_personne;
	    
	    $this->getResultatExamenTable()->saveResultatsExamens($donnees, $id_personne);
	    $this->getDemandeTable()->demandeEffectuee($donnees->idDemande);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode () );
	}
	
	public function raffraichirListeExamensAction() {
		$id_cons = $this->params()->fromPost('id_cons');
		
		$html = $this->listeExamensAction($id_cons);
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function raffraichirListeExamensBioAction() {
		$id_cons = $this->params()->fromPost('id_cons');
	
		$html = $this->listeExamensBiologiquesAction($id_cons);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function modifierExamenAction() {
		$idDemande = $this->params()->fromPost('idDemande');
		
		$demandeDem = $this->getDemandeTable()->getDemande($idDemande);
		
		$demande = $this->getResultatExamenTable()->getResultatExamen($idDemande);
		$html ="<script>
				   $('#technique_utilise').val('".$demande->techniqueUtiliser."');
				   $('#resultat').val('".$demande->noteResultat."');
				   $('#conclusion').val('".$demande->conclusion."');
				   $('#typeExamen_tmp').val(".$demandeDem->idExamen.");
				</script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	//POUR SAVOIR DE QUEL EXAMEN IL S'AGIT
	//POUR SAVOIR DE QUEL EXAMEN IL S'AGIT
	public function ajouterExamenAction() {
		$idDemande = $this->params()->fromPost('idDemande');
	
		$demandeDem = $this->getDemandeTable()->getDemande($idDemande);
	
		$html ="<script>
				   $('#typeExamen_tmp').val(".$demandeDem->idExamen.");
				</script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function envoyerExamenAction() {
		$idDemande = $this->params()->fromPost('idDemande');
		$id_cons = $this->params()->fromPost('id_cons');
	
		$this->getResultatExamenTable()->examenEnvoyer($idDemande);
		$html = $this->listeExamensAction($id_cons);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	
	public function envoyerExamenBioAction() {
		$idDemande = $this->params()->fromPost('idDemande');
		$id_cons = $this->params()->fromPost('id_cons');
	
		$this->getResultatExamenTable()->examenEnvoyer($idDemande);
		$html = $this->listeExamensBiologiquesAction($id_cons);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	//POUR LA LISTE DES EXAMENS EFFECTUES PAR LE LABORANTIN (BIOLOGISTE)
	public function listeRechercheExamensEffectuesAjaxAction() {
		$output = $this->getDemandeTable()->getListeExamensEffectues();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeExamensEffectuesAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
		
		$formAppliquerExamen = new AppliquerExamenForm();
		
		return array(
				'form' => $formAppliquerExamen
		);
	}
	
	
	
	/* POUR LES EXAMENS MORPHOLOGIQUES ------ POUR LES EXAMENS MORPHOLOGIQUES ------ POUR LES EXAMENS MORPHOLOGIQUES */
	/* POUR LES EXAMENS MORPHOLOGIQUES ------ POUR LES EXAMENS MORPHOLOGIQUES ------ POUR LES EXAMENS MORPHOLOGIQUES */
	/* POUR LES EXAMENS MORPHOLOGIQUES ------ POUR LES EXAMENS MORPHOLOGIQUES ------ POUR LES EXAMENS MORPHOLOGIQUES */
	public function vueExamenAppliquerMorphoAction() {
		$this->getDateHelper();
		$idDemande = $this->params()->fromPost('idDemande', 0);
	
		$demande = $this->getDemandeTable()->getDemande($idDemande);
	
		$html  ="<table style='width: 95%;'>";
		$html .="<tr style='width: 95%;'>";
		$html .="<td style='width: 100%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Libelle examen:</a><br><p style='font-weight:bold; font-size:17px;'> ". $this->getExamenTable()->getExamen($demande->idExamen)->libelleExamen ." </p></td>";
		$html .="</tr>";
		$html .="</table>";
	
		$html .="<table style='width: 95%; margin-bottom: 25px;'>";
		$html .="<tr style='width: 95%;'>";
		$html .="<td style='width: 90%; padding-top: 10px; padding-right:25px;'><a style='text-decoration:underline; font-size:13px;'>Motif:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $demande->noteDemande ." </p></td>";
		$html .="<td style='width: 10%;'> </td>";
		$html .= "</tr>";
		$html .="</table>";
	
		if($demande->appliquer == 1){
			$resultat = $this->getResultatExamenTable()->getResultatExamen($idDemande);
			$date = 'pas de date';
			if($this->dateHelper->convertDateTime($resultat->date_modification) == '00/00/0000 - 00:00:00'){
				$date = $this->dateHelper->convertDateTime($resultat->date_enregistrement);
			} else {
				$date = $this->dateHelper->convertDateTime($resultat->date_modification);
			}
			$html .= "<div id='titre_info_resultat_examen'>R&eacute;sultat de l'examen  <span style='position: absolute; right: 20px; font-size: 14px; font-weight: bold;'>". $date ." </span></div>
			          <div id='barre_resultat' ></div>";
				
			$html .="<table style='width: 100%; margin-top: 10px;'>";
			$html .="<tr style='width: 100%;'>";
			$html .="<td style='width: 100%; vertical-align:top;'><a style='text-decoration:underline; font-size:12px;'>Technique utilis&eacute;e:</a><br><p style='font-weight:bold; font-size:17px;'> ". $resultat->techniqueUtiliser ." </p></td>";
			$html .="</tr>";
			$html .="</table>";
				
			$html .="<table style='width: 100%;'>";
			$html .="<tr style='width: 100%;'>";
			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Note R&eacute;sultat:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->noteResultat ." </p></td>";
			$html .="<td style='width: 50%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Conclusion:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $resultat->conclusion ." </p></td>";
			$html .= "</tr>";
			$html .="</table>";
		}
		
		$html .="<script> $('#typeExamen_tmp').val(".$demande->idExamen.");</script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function listeExamensAction($id_cons, $idListe=null) {
	
		$liste_examens_demandes = $this->getDemandeTable()->getDemandesExamensMorphologiques($id_cons);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; margin-left:195px; width:80%;' id='listeDesExamens'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer; font-family: Times New Roman; font-weight: bold;'>
					<th style='width: 9%;'>Num&eacute;ro</th>
					<th style='width: 32%;'>Libelle examen</th>
					<th style='width: 40%;'>Note</th>
				    <th style='width: 13%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
		$cmp = 1;
		foreach ($liste_examens_demandes as $Liste){
			$html .="<tr style='width: 100%;' id='".$Liste['idDemande']."'>";
			$html .="<td style='width: 9%;'><div id='inform' style='margin-left: 25%; float:left; font-weight:bold; font-size:17px;'> " .$cmp++. ". </div></td>";
			$html .="<td style='width: 32%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$this->getExamenTable()->getExamen($Liste['idExamen'])->libelleExamen. " </div></td>";
			$html .="<td style='width: 40%;'><div  style='color: green; font-family: Times New Roman; float:left; font-weight: bold; font-size:18px;'> " .$Liste['noteDemande']. " </div></td>";
			$html .="<td style='width: 13%;'>
  					    <a href='javascript:vueExamenMorpho(".$Liste['idDemande'].") '>
  					       <img class='visualiser".$Liste['idDemande']."' style='margin-right: 9%; margin-left: 3%;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
  					    </a>&nbsp";
	
			if($Liste['appliquer'] == 0) {
				
				if($idListe != 2){ //L'APPEL EST FAIT DANS LA LISTE 'RECHERCHE' POUR UNIQUEMENT LA VISUALISATION
				$html .="<a href='javascript:appliquerExamen(".$Liste['idDemande'].")'>
 				     	 <img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/aj.gif' alt='Constantes' title='Entrer les r&eacute;sultats'/>
 					     </a>";
				
				$html .="<a>
 					    	<img style='color: white; opacity: 0.09;' src='../images_icons/74biss.png' alt='Constantes' />
 					     </a>
 				         </td>";
					
				}
				
				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_non".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/non.png' alt='Constantes' title='examen non encore effectu&eacute;' />
  					     </a>
  					     </td>";
			}else {
				
				if($idListe != 2){ //L'APPEL EST FAIT DANS LA LISTE 'RECHERCHE' POUR UNIQUEMENT LA VISUALISATION
					
				$resultat = $this->getResultatExamenTable()->getResultatExamen($Liste['idDemande']);
	
				if($resultat->envoyer == 1) {
					
					$html .="<a>
 					  	     <img style='margin-right: 16%; color: white; opacity: 0.09;' src='../images_icons/pencil_16.png'/>
 					         </a>";
					
					if($Liste['responsable'] == 1) { /*Envoyer par le medecin*/
						$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen valid&eacute; par le medecin'/>
 					     </a>
 				         </td>";
					} else
					{ /*Envoyer par le laborantin*/
						$html .="<a>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/tick_16.png' title='examen envoy&eacute;'/>
 					     </a>
 				         </td>";
					}
	
	
				} else {
					$html .="<a href='javascript:modifierExamen(".$Liste['idDemande'].")'>
 					    	<img class='modifier".$Liste['idDemande']."' style='margin-right: 16%;' src='../images_icons/pencil_16.png' alt='Constantes' title='modifier r&eacute;sultat'/>
 					     </a>";
					$html .="<a href='javascript:envoyer(".$Liste['idDemande'].")'>
 					    	<img class='envoyer".$Liste['idDemande']."' src='../images_icons/74biss.png' alt='Constantes' title='envoyer'/>
 					     </a>
 				         </td>";
				}
					
			
				}	
				
				$html .="<td style='width: 6%;'>
  					     <a>
  					        <img class='etat_oui".$Liste['idDemande']."' style='margin-left: 25%;' src='../images_icons/oui.png' alt='Constantes' title='examen d&eacute;ja effectu&eacute;' />
  					     </a>
  					     </td>";
			}
	
			$html .="</tr>";
	
			$html .="<script>
					  $('.visualiser".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.visualiser".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.visualiser".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /************************/
	                  /************************/
	                  /************************/
                      $('.modifier".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
				      $('.modifier".$Liste['idDemande']." ').mouseleave(function(){
	                    var tooltips = $( '.modifier".$Liste['idDemande']." ' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.supprimer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.supprimer".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.supprimer".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_oui".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_oui".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_oui".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                  /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.etat_non".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
	                  $('.etat_non".$Liste['idDemande']."').mouseleave(function(){
	                    var tooltips = $( '.etat_non".$Liste['idDemande']."' ).tooltip();
	                    tooltips.tooltip( 'close' );
	                  });
	                   /*************************/
	                  /*************************/
	                  /*************************/
	                  $('.envoyer".$Liste['idDemande']." ').mouseenter(function(){
	                    var tooltips = $( '.envoyer".$Liste['idDemande']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
	                    tooltips.tooltip( 'open' );
	                  });
			        </script>";
		}
		$html .="</tbody>";
		$html .="</table>";
	
		$html .="<style>
				  #listeDataTable{
	                margin-left: 185px;
                  }
	
				  div .dataTables_paginate
                  {
				    margin-right: 20px;
                  }
	
				  #listeDesExamens tbody tr{
				    background: #fbfbfb;
				  }
	
				  #listeDesExamens tbody tr:hover{
				    background: #fefefe;
				  }
	
				 </style>";
		$html .="<script> listepatient (); listeDesSoins(); $('#Examen_id_cons').val('".$id_cons."'); </script>";
	
		return $html;
	
	}
	
	
	Public function listeExamensDemanderMorphoAction() {
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$examensBio = $this->params()->fromPost('examensBio',0);
		$idListe = $this->params()->fromPost('id',0); //POUR SAVOIR S'IL S'AGIT DE LA LISTE 'RECHERCHE' ou 'EN-COURS'
		
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
		
		$demande = $this->getDemandeTable()->getDemandeWithIdcons($id_cons);
		
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .= "<div id='titre_info_deces'>Informations sur la demande d'examen </div>
		          <div id='barre'></div>";
		foreach ($demande as $donnees) {
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->dateHelper->convertDateTime($donnees['Datedemande']). "</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
		}
		
		$html .= "<div id='titre_info_deces'>Liste des examens demand&eacute;s </div>
		          <div id='barre'></div>
		
				 <div id='info_liste'>";
		if($examensBio == 1){
			$html .= $this->listeExamensBiologiquesAction($id_cons);
		}
		else /* POUR LES EXAMENS MORPHOLOGIQUES (Radiologie ... )*/
		{
			$html .= $this->listeExamensAction($id_cons, $idListe);
		}
		$html .="</div>";
		
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                     </div>";
		}
		
		$html .="</div>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function listeDemandesExamensMorphoAjaxAction() {
		$output = $this->getDemandeTable()->getListeDemandesExamensMorpho();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeDemandesExamensMorphoAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
	
		$formAppliquerExamen = new AppliquerExamenForm();
	
		return array(
				'form' => $formAppliquerExamen
		);
	}
	
    public function listeExamensEffectuesMorphoAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
		
		$formAppliquerExamen = new AppliquerExamenForm();
		
		return array(
				'form' => $formAppliquerExamen
		);
	}
	//POUR LA LISTE DES EXAMENS DEJA EFFECTUES PAR LE RADIOLOGUE 
	public function listeRechercheExamensEffectuesMorphoAjaxAction() {
		$output = $this->getDemandeTable()->getListeExamensMorphoEffectues();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	
	
	//POUR LES VISITES PRE-ANESTHESIQUE
	//POUR LES VISITES PRE-ANESTHESIQUE
	//POUR LES VISITES PRE-ANESTHESIQUE
	public function listeDemandesVpaAjaxAction() {
		$output = $this->getDemandeTable()->getListeDemandesVpa();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeDemandesVpaAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
	}
	
	public function detailsDemandeVisiteAction() {

		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$idVpa = $this->params()->fromPost('idVpa',0);
		
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
		
		$demande = $this->getDemandeTable()->getDemandeVpaWidthIdcons($id_cons);
		
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
		
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .= "<div id='titre_info_deces'>Informations sur la demande de VPA </div>
		          <div id='barre'></div>";
		foreach ($demande as $donnees) {
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->dateHelper->convertDateTime($donnees['Datedemande']). "</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Diagnostic:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['DIAGNOSTIC'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>observation:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['OBSERVATION'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Intervention pr&eacute;vue:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['INTERVENTION_PREVUE'] ." </p></td>";
			$html .= "</tr>";
			$html .= "</table>";
		}
		
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$formVpa = new VpaForm();
		
		$user = $this->layout()->user;
		$id_personne = $user->id_personne;
		
		$formRow = new FormRow();
		$formText = new FormText();
		$formTextArea = new FormTextarea();
		$formRadio = new FormRadio();
		$formHidden = new FormHidden();
		
		$html .= "<div id='titre_info_deces'>Entrez les r&eacute;sultats </div>
		          <div id='barre'></div>";
		$html .="<form  method='post' action='".$chemin."/hospitalisation/save-result-vpa'>";
		$html .= $formHidden($formVpa->get('idVpa'));
		$html .= $formHidden($formVpa->get('idPersonne'));
		
		$html .="<div style='width: 80%; margin-left: 195px;'>";
		$html .="<table id='form_patient_vpa' style='width: 100%; '>
					 <tr  style='width: 100%'>
					   <td  class='comment-form-patient'  style='width: 35%; '>". $formRow($formVpa->get('numero_vpa')).$formText($formVpa->get('numero_vpa'))."</td>
					   <td  class='comment-form-patient'  style='width: 35%; '>". $formRow($formVpa->get('type_intervention')).$formText($formVpa->get('type_intervention'))."</td>
				       <td  style='width: 10%; '> <span class='comment-form-patient'> <label style=''>Aptitude</label> </span> <span style='width: 10%;' class='comment-form-patient-radio'>".$formRadio($formVpa->get('aptitude'))."</span></td>
					   <td  class='comment-form-patient-label-im'>
				       		<label style='width: 48px; height: 48px; position: relative; right: 43px; top: 25px; z-index: 3;'> <img id='DeCoche' src='../images_icons/negatif.png'> </label>
				            <label style='width: 40px; height: 40px; position: relative; right: 40px; top: 20px; z-index: 3;'> <img id='Coche' src='../images_icons/tick-icon2.png'>   </label>
				       </td>
				       <td  style='width: 15%;'><a href='javascript:vider()'><img style=' margin-left: 45%;' src='../images_icons/118.png' title='vider tout'></a></td>
					 </tr>
					</table>";
		$html .="</div>";
		
		$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			
		$html .="<div class='block' id='thoughtbot' style='position: absolute; right: 40%; bottom: 70px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                 </div>";
		$html .="<div class='block' id='thoughtbot' style='position: absolute; right: 49%; bottom: 70px; font-size: 18px; font-weight: bold;'><button type='submit' id='annuler'>Annuler</button></div>
                 </div>";
		
		$html .="</div>";
		
		$typeAnesthesie = $this->getDemandeTable()->listeDesTypeAnesthesie();
		
		$html .="<script> 
				  scriptTerminer(); 
				  $('#DeCoche').toggle(false);
				  $('#Coche').toggle(false);
				  $('#idVpa').val(".$idVpa.");
				  $('#idPersonne').val(".$id_personne.");
				  $('#form_patient_vpa input[name=aptitude]').click(function(){
				      var boutons = $('#form_patient_vpa input[name=aptitude]'); 
				      if( boutons[1].checked){ $('#Coche').toggle(true);  $('#DeCoche').toggle(false); }
				      if(!boutons[1].checked){ $('#Coche').toggle(false); $('#DeCoche').toggle(true);}
			      });
				  $('#form_patient_vpa input').attr('autocomplete', 'off');
				  $('#form_patient_vpa input').css({'font-size':'18px', 'color':'#065d10'});
				  
				  var myArrayTypeAnesthesie = [''];
				  var j = 0; 		
				 </script>";
		      
		      foreach ($typeAnesthesie as $liste){
		      	$html .="<script> myArrayTypeAnesthesie[j++]  = '" .$liste['libelle']. "'</script>";
		      }
		$html .="<script> 
				  $(function(){
                     $( '#type_intervention' ).autocomplete({
	                 source: myArrayTypeAnesthesie
	                 });
				  });
                 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function saveResultVpaAction(){
		$resultatVpa = $this->getRequest()->getPost();
		$this->getResultatVpa()->saveResultat($resultatVpa);
		
		return $this->redirect()->toRoute('hospitalisation' , array('action' => 'liste-demandes-vpa'));
	}
	
	public function listeRechercheVpaAction() {
		$this->layout()->setTemplate('layout/Hospitalisation');
	}
	
	public function listeRechercheVpaAjaxAction() {
		$output = $this->getDemandeTable()->getListeRechercheVpa();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function detailsRechercheVisiteAction() {
	
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$idVpa = $this->params()->fromPost('idVpa',0);
	
		$unPatient = $this->getPatientTable()->getPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$demande = $this->getDemandeTable()->getDemandeVpaWidthIdcons($id_cons);
	
		$date = $this->dateHelper->convertDate( $unPatient->date_naissance );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient->profession . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>Informations sur la demande de VPA </div>
		          <div id='barre'></div>";
		foreach ($demande as $donnees) {
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$this->dateHelper->convertDateTime($donnees['Datedemande']). "</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $donnees['PrenomMedecin'] ." ".$donnees['NomMedecin'] . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
				
			$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Diagnostic:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['DIAGNOSTIC'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Observation:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['OBSERVATION'] ." </p></td>";
			$html .= "<td style='width: 25%; padding-top: 10px; padding-right:10px;'><a style='text-decoration:underline; font-size:13px;'>Intervention pr&eacute;vue:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px; padding-left: 5px;'> ". $donnees['INTERVENTION_PREVUE'] ." </p></td>";
			$html .= "</tr>";
			$html .= "</table>";
		}
		$html .= "<div id='titre_info_deces'>Informations sur les r&eacute;sultats de la VPA </div>
		          <div id='barre'></div>";
		
		$resultatVpa = $this->getResultatVpa()->getResultatVpa($idVpa);
		
		$html .= "<table style='margin-top:10px; margin-left: 195px; width: 80%;'>";
		
		$html .= "<tr style='width: 80%; font-family: time new romans'>";
		$html .= "<td style='width: 55%; height: 50px; '><span style='font-size:15px; font-family: Felix Titling;'>Num&eacute;ro VPA: </span> <span style='font-weight:bold; font-size:20px; color: #065d10;'>" .$resultatVpa->numeroVpa. "</span></td>";
		$html .= "<td rowspan='2' style='width: 2%; vertical-align: top;'> <div style='width: 4px; height: 110px; background: #ccc;'> </div> </td>";
		
		if($resultatVpa->aptitude == 1){
			$html .= "<td rowspan='2' style='width: 43%; height: 50px; '><span style='font-size:17px; font-family: Felix Titling;'>APTITUDE:  </span> <span style='font-weight:bold; font-size:25px; color: #065d10;'>  Oui <img src='../images_icons/coche.PNG' /></span></td>";
		}else {
			$html .= "<td rowspan='2' style='width: 43%; height: 50px; '><span style='font-size:17px; font-family: Felix Titling;'>APTITUDE:  </span> <span style='font-weight:bold; font-size:25px; color: #e91a1a;'>  Non <img src='../images_icons/decoche.PNG' /></span></td>";
		}
		
		$html .= "</tr>";
		
		$html .= "<tr style='width: 80%; font-family: time new romans; vertical-align: top;'>";
		$html .= "<td style='width: 50%; height: 50px; '><span style='font-size:15px; font-family: Felix Titling;'>Type d'intervention: </span> <span style=' font-weight:bold; font-size:20px; color: #065d10;'>" . $resultatVpa->typeIntervention. "</span></td>";
		$html .= "</tr>";
		
		$html .= "</table>";
		
		$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			
		$html .="<div class='block' id='thoughtbot' style='position: absolute; right: 40%; bottom: 70px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer2'>Terminer</button></div>
                 </div>";
		
		$html .="<script>
				  scriptAnnulerVisualisation();
				 </script>";
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
}
