<?php
namespace Hospitalisation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Facturation\View\Helper\DateHelper;
use Hospitalisation\Form\HospitaliserForm;
use Hospitalisation\Form\SoinForm;

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
			
			$this->redirect()->toRoute('hospitalisation' , array('action' => 'liste'));
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
		
		$html .="<div style='width: 100%; height: 100px;'>
	    		 <div style='color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:right;'>
                    <img  src='".$this->path."/images_icons/fleur1.jpg' />
                 </div>
		
			     <div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminer'>Terminer</button></div>
                 </div>";
		$html .="</div>";
		
		$html .="<script> listepatient(); </script>";
		
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
		
		if($this->getRequest()->isPost()) {
// 			$id_lit = $this->params()->fromPost('lit',0);
// 			$code_demande = $this->params()->fromPost('code_demande',0);
				
// 			$id_hosp = $this->getHospitalisationTable()->saveHospitalisation($code_demande);
// 			$this->getHospitalisationlitTable()->saveHospitalisationlit($id_hosp, $id_lit);
				
// 			$this->getDemandeHospitalisationTable()->validerDemandeHospitalisation($code_demande);
				
// 			$this->getLitTable()->updateLit($id_lit);
				
			$this->redirect()->toRoute('hospitalisation' , array('action' => 'en-cours'));
		}
		
		return array(
				'form' => $formSoin
		);
	}
	
	public function raffraichirListeSoins(){
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; margin-left:195px; width:80%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer;'>
					<th style='width: 40%;'>Services</th>
					<th style='width: 15%;'>Date debut</th>
					<th style='width: 15%;'>Date fin</th>
					<th style='width: 18%;'>Intervention</th>
				    <th style='width: 12%;'>Options</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
			
// 		$listeIntervention = $this->getPersonnelTable()->getListeInterventions($id_personne);
			
// 		foreach ($listeIntervention as $Liste){
	
// 			$html .="<tr style='width: 100%;' id='".$Liste['numero_intervention']."'>";
// 			$html .="<td style='width: 40%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->getServiceTable()->getServiceAffectation($Liste['id_service'])->nom."</div></td>";
// 			$html .="<td style='width: 15%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->dateHelper->convertDate($Liste['date_debut'])."</div></td>";
// 			$html .="<td style='width: 15%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->dateHelper->convertDate($Liste['date_fin'])."</div></td>";
// 			$html .="<td style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['type_intervention']."</div></td>";
// 			$html .="<td style='width: 12%;'> <a href='javascript:vueintervention(".$Liste['numero_intervention'].") '>
// 					       <img style='display: inline;' src='/simens/public/images_icons/vue.PNG' alt='Constantes' title='details' />
// 					  </a>&nbsp;
	
// 				      <a href='javascript:modifierintervention(".$Liste['numero_intervention'].",".$id_personne.")'>
// 					    	<img style='display: inline;' src='/simens/public/images_icons/suivant.PNG' alt='Constantes' title='modifier' />
// 					  </a>&nbsp;
	
// 				      <a href='javascript:supprimeruneintervention(".$Liste['numero_intervention'].",".$id_personne.")' >
// 					    	<img  style='display: inline;' src='/simens/public/images_icons/sup.PNG' alt='Constantes' title='annuler' />
// 					  </a>
// 				     </td>";
// 			$html .="</tr>";
	
// 		}
		$html .="</tbody>";
			
		$html .="</table>";
			
		$html .="<script> listepatient (); listeDesSoins();	</script>";
	
		return $html;
	}
	
	public function listeSoinAction() {
		$html = "<div id='titre_info_deces'>Liste des soins</div>
		          <div id='barre'></div>";
		$html .= $this->raffraichirListeSoins();
		
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
}
