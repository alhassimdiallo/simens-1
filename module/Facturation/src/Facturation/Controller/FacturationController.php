<?php
namespace Facturation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facturation\Model\Patient;
use Facturation\Form\PatientForm;
use Facturation\Form\AjoutNaissanceForm;
use Zend\Json\Expr;

class FacturationController extends AbstractActionController {
	protected $patientTable;
	protected $formPatient;

	public function getPatientTable(){
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm ();
		}
		return $this->formPatient;
	}
	public function  listePatientAction(){
		$layout = $this->layout();
		$layout->setTemplate('layout/facturation');
		$view = new ViewModel();
		return $view;
	}
	public function admissionAction(){
		return new ViewModel();
	}

	public function listePatientsAdmisAction(){
		return new ViewModel();
	}
	public function listePatientsDecedesAction(){
		return new ViewModel();
	}
	public function listeNaissanceAction(){
		return new ViewModel();
	}
	public function ajouterAction(){
		$this->layout()->setTemplate('layout/facturation');
		$form = $this->getForm();
		return new ViewModel(array('form'=>$form));
	}
	public function declarerDecesAction(){
		return new ViewModel();
	}
	public function listePatientAjaxAction(){
		$patient = $this->getPatientTable();
		$output = $patient->getListePatient();
		$this->json ( $output, array (
				'enableJsonExprFinder' => true
		));
	}
	public function enregistrementAction(){
		return new ViewModel();
	}
	public function convertDate($date){
		$nouv_date = substr($date, 8, 2).'/'.substr($date, 5, 2).'/'.substr($date, 0, 4);
		return $nouv_date;
	}
	public function ajouterNaissanceAction(){
		$this->layout()->setTemplate('layout/facturation');

		$patient = $this->getPatientTable();
		//AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->listePatients();
		//var_dump($liste);
		//INSTANCIATION DU FORMULAIRE
		$ajoutNaissForm = new AjoutNaissanceForm();

		if ($this->getRequest()->isPost()){

			$id = (int)$this->getRequest()->getParam ('id');
			$pat = $this->getPatientTable();
			$unPatient = $pat->getPatient($id);
			$photo = $pat->getPhoto($id);

			$date = $this->convertDate($unPatient['DATE_NAISSANCE']);

			$html ="<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='/simens_derniereversion/public/img/photos_patients/".$photo."'></div>";

			$html .="<table>";

			$html .="<tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unPatient['NOM']."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unPatient['PRENOM']."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$date."</p></td>";
			$html .="</tr>";
			//$html .="<td><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$Laliste['SEXE']."</p></td>";
			$html .="<tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unPatient['ADRESSE']."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$unPatient['TELEPHONE']."</p></td>";
			$html .= "</tr>";

			$html .="</table>";

			$this->getResponse()->setHeader('Content-Type','application/html');
			$this->_helper->json->sendJson($html);

		}
		return array('donnees'=>$liste, 'form'=>$ajoutNaissForm);
	}
	public function enregistrerBebeAction(){

	}
}