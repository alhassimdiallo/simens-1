<?php

namespace Archivage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
// use Zend\View\Helper\Json;
use Zend\Json\Json;
use Facturation\Model\Patient;
use Facturation\Model\Deces;
use Facturation\Model\Naissance;
use Personnel\Model\Service;
use Facturation\Model\TarifConsultation;
use Facturation\Form\PatientForm;
use Facturation\Form\AjoutNaissanceForm;
use Facturation\Form\AdmissionForm;
use Zend\Json\Expr;
use Facturation\Form\AjoutDecesForm;
use Zend\Stdlib\DateTime;
use Zend\Mvc\Service\ViewJsonRendererFactory;
use Zend\Ldap\Converter\Converter;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormInput;
use Facturation\View\Helper\DateHelper;
use Zend\Debug\Debug;
use Zend\Mail\Header\Sender;
use Zend\Form\View\Helper\FormLabel;
use Zend\Form\Form;
use Zend\Form\View\Helper\FormSelect;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormCollection;
use Zend\Form\View\Helper\FormElement;
use Zend\Form\View\Helper\FormTextarea;
use Zend\Crypt\PublicKey\Rsa\PublicKey;
use Zend\Form\View\Helper\FormHidden;

class FacturationController extends AbstractActionController {
	protected $dateHelper;
	protected $patientTable;
	protected $decesTable;
	protected $formPatient;
	protected $serviceTable;
	protected $facturationTable;
	protected $naissanceTable;
	protected $tarifConsultationTable;
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getDecesTable() {
		if (! $this->decesTable) {
			$sm = $this->getServiceLocator ();
			$this->decesTable = $sm->get ( 'Facturation\Model\DecesTable' );
		}
		return $this->decesTable;
	}
	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Personnel\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	public function getFacturationTable() {
		if (! $this->facturationTable) {
			$sm = $this->getServiceLocator ();
			$this->facturationTable = $sm->get ( 'Facturation\Model\FacturationTable' );
		}
		return $this->facturationTable;
	}
	public function getNaissanceTable() {
		if (! $this->naissanceTable) {
			$sm = $this->getServiceLocator ();
			$this->naissanceTable = $sm->get ( 'Facturation\Model\NaissanceTable' );
		}
		return $this->naissanceTable;
	}
	public function getTarifConsultationTable() {
		if (! $this->tarifConsultationTable) {
			$sm = $this->getServiceLocator ();
			$this->tarifConsultationTable = $sm->get ( 'Facturation\Model\TarifConsultationTable' );
		}
		return $this->tarifConsultationTable;
	}
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
	Public function getDateHelper(){
		$this->dateHelper = new DateHelper();
	}
	public function baseUrl(){
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		return $tabURI[0];
	}
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm ();
		}
		return $this->formPatient;
	}
	public function listePatientAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );
		$view = new ViewModel ();
		return $view;
	}
	public function listeAdmissionAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	public function admissionAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );
		$patient = $this->getPatientTable ();
		// AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->LalistePatients ();

		// INSTANCIATION DU FORMULAIRE d'ADMISSION
		$formAdmission = new AdmissionForm ();
		// r�cup�ration de la liste des hopitaux
		//$service = $this->getServiceTable ()->fetchService ();
		$service = $this->getTarifConsultationTable()->listeService();
		
		$listeService = $this->getServiceTable ()->listeService ();
		$afficheTous = array ("" => 'Tous');
		
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		
		if ($this->getRequest ()->isPost ()) {
			
			$today = new \DateTime ();
			$numero = $today->format ( 'mHis' );
			$dateAujourdhui = $today->format( 'Y-m-d' );
			
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$pat = $this->getPatientTable ();
			
			//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
			$RendezVOUS = $pat->verifierRV($id, $dateAujourdhui);
			
			
			$unPatient = $pat->getPatient ( $id );

			$photo = $pat->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient->date_naissance );

			$html  = "<div style='width:100%;'>";
			
			$html .= "<div style='width: 18%; height: 220px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 65%; height: 220px; float:left;'>";
			$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
			$html .= "<tr style='width: 100%;'>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Nom</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->nom ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Lieu de naissance</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->lieu_naissance ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Nationalit&eacute; d'origine</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->nationalite_origine ." </p></td>";
				
			$html .= "<td style='width: 30%; height: 50px;'></td>";
			$html .= "</tr><tr style='width: 100%;'>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Pr&eacute;nom</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->prenom ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>T&eacute;l&eacute;phone</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->telephone ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Nationalit&eacute; actuelle</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->nationalite_actuelle ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Email</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->email ." </p></td>";
				
			$html .= "</tr><tr style='width: 100%;'>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date de naissance</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $date ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Adresse</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->adresse ." </p></td>";
			$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Profession</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->profession ." </p></td>";
				
			$html .= "<td style='width: 30%; height: 50px;'>";
			if($RendezVOUS){
				$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $pat->getServiceParId($RendezVOUS[ 'ID_SERVICE' ])[ 'NOM' ]." </span> <br> 
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'heure' ]." </span> </i>
			              </span>";
			}
			$html .="</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .="</div>";
			
			$html .= "<div style='width: 17%; height: 220px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			
			$html .= "</div>";
			
			$html .= "<script>
					         $('#numero').val('" . $numero . "');
					         $('#numero').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					         $('#numero').attr('readonly',true);

					         $('#service').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});

					         $('#montant').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'blue','font-family': 'Times  New Roman','font-size':'22px'});
					         $('#montant').attr('readonly',true);
					
					         function FaireClignoterImage (){
                                $('#image-neon').fadeOut(900).delay(300).fadeIn(800);
                             }
                             setInterval('FaireClignoterImage()',2200);
					 </script>"; // Uniquement pour la facturation

			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'donnees' => $liste,
				'form' => $formAdmission
		);
	}
	public function listePatientsAdmisAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$patientsAdmis = $this->getFacturationTable ();
		// INSTANCIATION DU FORMULAIRE
		$formAdmission = new AdmissionForm ();
		$service = $this->getServiceTable ()->fetchService ();
		$listeService = $this->getServiceTable ()->listeService ();
		$afficheTous = array (
				"" => 'Tous'
		);
		$tab_service = array_merge ( $afficheTous, $listeService );
		$formAdmission->get ( 'service' )->setValueOptions ( $service );
		$formAdmission->get ( 'liste_service' )->setValueOptions ( $tab_service );
		return new ViewModel ( array (
				'listePatientsAdmis' => $patientsAdmis->getPatientsAdmis (),
				'form' => $formAdmission,
				'nbPatients' => $patientsAdmis->nbFacturation ()
		) );
	}
	public function listeNaissanceAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$patient = $this->getNaissanceTable ();
		// AFFICHAGE DE LA LISTE DES NAISSANCES
		$liste = $patient->getNaissance ();
		$nbPatientNaissance = $patient->nbPatientNaissance ();
		return new ViewModel ( array (
				'donnees' => $liste,
				'nbPatients' => $nbPatientNaissance
		) );
	}
	public function ajouterAction() {
		$this->layout ()->setTemplate ( 'layout/Archivage' );
		$form = $this->getForm ();
		$patientTable = $this->getPatientTable();
		$form->get('nationalite_origine')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('nationalite_actuelle')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('nationalite_origine' => 'Sénégal', 'nationalite_actuelle' => 'Sénégal');
		
		$form->populateValues($data);
		
		return new ViewModel ( array (
				'form' => $form
		) );
	}
	
	public function enregistrementAction() {
	
		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] )) 		// si formulaire soumis
		{
			$Control = new DateHelper();
			$form = new PatientForm ();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_enregistrement = $today->format ( 'Y-m-d' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
				
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
			$donnees = array(
					'civilite' => $this->params ()->fromPost ( 'civilite' ),
					'lieu_naissance' => $this->params ()->fromPost ( 'lieu_naissance' ),
					'email' => $this->params ()->fromPost ( 'email' ),
					'nom' => $this->params ()->fromPost ( 'nom' ),
					'telephone' => $this->params ()->fromPost ( 'telephone' ),
					'nationalite_origine' => $this->params ()->fromPost ( 'nationalite_origine' ),
					'prenom' => $this->params ()->fromPost ( 'prenom' ),
					'profession' => $this->params ()->fromPost ( 'profession' ),
					'nationalite_actuelle' => $this->params ()->fromPost ( 'nationalite_actuelle' ),
					'date_naissance' => $Control->convertDateInAnglais($this->params ()->fromPost ( 'date_naissance' )),
					'adresse' => $this->params ()->fromPost ( 'adresse' ),
					'sexe' => $this->params ()->fromPost ( 'sexe' ),
					'date_enregistrement' => $date_enregistrement
			);
				
			if ($img != false) {
	
				$donnees['photo'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
				$Patient->addPatient ( $donnees );
					
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			} else {
				// On enregistre sans la photo
				$Patient->addPatient ( $donnees );
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'facturation', array (
				'action' => 'liste-patient'
		) );
	}
	
	public function modifierAction() {
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$id_patient = $this->params ()->fromRoute ( 'val', 0 ); //Pourquoi 'val' au lieu de 'id_patient' (� revoir)
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getPatient ( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'facturation', array (
					'action' => 'liste-patient'
			) );
		}
		$form = new PatientForm ();
		$form->get('nationalite_origine')->setvalueOptions($infoPatient->listePays());
		$form->get('nationalite_actuelle')->setvalueOptions($infoPatient->listePays());
		$info->date_naissance = $control->convertDate($info->date_naissance); //Conversion de la date en fran�ais

		$form->bind ( $info );
		if (! $info->photo) {
			$info->photo = "identite";
		}
		return array (
				'form' => $form,
				'photo' => $info->photo
		);
	}
	
	public function enregistrementModificationAction() {
	
		if (isset ( $_POST ['terminer'] )) 	
		{
			$Control = new DateHelper();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_enregistrement = $today->format ( 'Y-m-d' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
				
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
			$donnees = array(
					'civilite' => $this->params ()->fromPost ( 'civilite' ),
					'lieu_naissance' => $this->params ()->fromPost ( 'lieu_naissance' ),
					'email' => $this->params ()->fromPost ( 'email' ),
					'nom' => $this->params ()->fromPost ( 'nom' ),
					'telephone' => $this->params ()->fromPost ( 'telephone' ),
					'nationalite_origine' => $this->params ()->fromPost ( 'nationalite_origine' ),
					'prenom' => $this->params ()->fromPost ( 'prenom' ),
					'profession' => $this->params ()->fromPost ( 'profession' ),
					'nationalite_actuelle' => $this->params ()->fromPost ( 'nationalite_actuelle' ),
					'date_naissance' => $Control->convertDateInAnglais($this->params ()->fromPost ( 'date_naissance' )),
					'adresse' => $this->params ()->fromPost ( 'adresse' ),
					'sexe' => $this->params ()->fromPost ( 'sexe' ),
					'date_enregistrement' => $date_enregistrement
			);
	
			$id_patient =  $this->params ()->fromPost ( 'id_personne' );
			if ($img != false) {
				
				$lePatient = $Patient->getPatient ( $id_patient );
				$ancienneImage = $lePatient->photo;
				
				if($ancienneImage) {
					unlink ( 'C:\wamp\www\simens\public\img\photos_patients\\' . $ancienneImage . '.jpg' );
				}
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				
				$donnees['photo'] = $nomfile;
				$Patient->updatePatient ( $donnees , $id_patient );
				
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient);
				
				return $this->redirect ()->toRoute ( 'facturation', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'facturation', array (
				'action' => 'liste-patient'
		) );
	}
	
	public function listePatientDecesAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->getListePatientsDecedesAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listePatientDeclarationDecesAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->getListeDeclarationDecesAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function declarerDecesAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$patient = $this->getPatientTable ();
		// AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->laListePatients ();
		// INSTANCIATION DU FORMULAIRE DE DECES
		$ajoutDecesForm = new AjoutDecesForm ();

		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getPatient ( $id );
			$photo = $pat->getPhoto ( $id );
			$date = $this->convertDate ( $unPatient->date_naissance );

			$html = "<div id='photo' style='float:left; margin-right:20px;'> <img  src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'  style='width:105px; height:105px;'></div>";

			$html .= "<table>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr><tr>";
			// $html .="<td><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$Laliste['SEXE']."</p></td>";
			// $html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'donnees' => $liste,
				'form' => $ajoutDecesForm
		);
	}
	public function listePatientAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->getListePatient ();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		return $nouv_date;
	}
	
	public function listeNaissanceAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->getListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function ajouterNaissanceAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->getListeAjouterNaissanceAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function ajouterNaissanceAction() {
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$patient = $this->getPatientTable ();
		// AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->listePatients ();
		// INSTANCIATION DU FORMULAIRE D'AJOUT
		//$local = new Zend\l
		$ajoutNaissForm = new AjoutNaissanceForm ();

		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			// var_dump($id);exit();
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getPatient ( $id );
			$photo = $pat->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient->date_naissance );

			$html = "<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "'></div>";

			$html .= "<table>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr>";
			// $html .="<td><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$Laliste['SEXE']."</p></td>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";

			$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'donnees' => $liste,
				'form' => $ajoutNaissForm
		);
	}
	public function enregistrerBebeAction() {

		if ($this->getRequest ()->isPost ()) {
			$this->getDateHelper();
			$today = new \DateTime ( 'now' );
			$date_enregistrement = $today->format ( 'Y-m-d' ); 
			$patient = $this->getPatientTable ();
			$naissance = $this->getNaissanceTable();

			$id_maman = ( int ) $this->params ()->fromPost ( 'id_personne' ); 
 			$info_maman = $patient->getPatient ( $id_maman );

 			$donnees = array(
 					'nom'             => $this->params ()->fromPost ( 'nom' ),
 					'prenom'          => $this->params ()->fromPost ( 'prenom' ),
 					'date_naissance'  => $this->dateHelper->convertDateInAnglais($this->params ()->fromPost ( 'date_naissance' )),
 					'lieu_naissance'  => $this->params ()->fromPost ( 'lieu_naissance' ),
 					'groupe_sanguin'  => $this->params ()->fromPost ( 'groupe_sanguin' ),
 					'sexe'            => $this->params ()->fromPost ( 'sexe' ),
 					'taille'          => $this->params ()->fromPost ( 'taille' ),
 					'poids'           => $this->params ()->fromPost ( 'poids' ),
 					'telephone'       => $info_maman->telephone,
 					'email'           => $info_maman->email,
 					'adresse'         => $info_maman->adresse,
 					'nationalite_actuelle' => $info_maman->nationalite_actuelle,
 					'nationalite_origine'  => $info_maman->nationalite_origine,
 					'date_enregistrement'  => $date_enregistrement
 			);
		
 			//var_dump($donnees); exit();
			if ($donnees['sexe'] == 'Féminin') {
				$donnees['civilite'] = "Mme";
			} else {
				$donnees['civilite'] = "M";
			}
			//Enegistrement dans la table PATIENT
			$id_bebe = $patient->addPatientNe($donnees); /* id_bebe = ID_PERSONNE dans la table patient*/
			
			$donneesNaissance = array (
					'date_naissance' => $donnees['date_naissance'],
					'groupe_sanguin' => $donnees['groupe_sanguin'],
					'taille' => $donnees['taille'],
					'poids' => $donnees['poids'],
					'heure_naissance' => $this->params ()->fromPost ( 'heure_naissance' ),
					'id_maman' => $id_maman,
					'id_bebe' => $id_bebe,
					'date_enregistrement' => $date_enregistrement,
					'note' => $this->params ()->fromPost ( 'note' ),
			);
			//Enregistrement de la naissance
			$naissance->addNaissance($donneesNaissance);
			
			return $this->redirect ()->toRoute ( 'facturation', array (
					'action' => 'liste-naissance'
			) );
		}
	}
	public function birthday2Age($value) {
		$date = new \DateTime("now");
		$date2 = new \DateTime($value);
		$resultatTab = get_object_vars($date->diff($date2));
		$nbJours = $resultatTab['days'];
		$nbAnnees = floor($nbJours / 365);
		
		if($nbAnnees == 0){ 
			return $nbJours.' jours';
		}
		else if($nbAnnees == 1){ 
			return $nbAnnees.' an';
		}
		else return $nbAnnees.' ans';
	}
	public function lePatientAction() {
		if ($this->getRequest ()->isPost ()) {

			$id = $this->params ()->fromPost ( 'id', 0 );
			$unPatient = $this->getPatientTable ()->getPatient ( $id );
			$photo = $this->getPatientTable ()->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient->date_naissance );
			
			$html  = "<div>";
			
			$html .= "<div style='width: 18%; height: 180px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 65%; height: 180px; float:left;'>";
			$html .= "<table style='margin-top:10px; float:left'>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->profession . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .="</div>";
			
			$html .= "<div style='width: 17%; height: 180px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			
			$html .= "</div>";
			
			$html .= "<script>$('#age_deces').val('" . $this->birthday2Age ( $unPatient->date_naissance ) . "');
					         $('#age_deces').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					         $('#age_deces').attr('readonly',true);
					 </script>"; // Uniquement pour la d�claration du d�c�s

			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
	}
	public function enregistrerDecesAction() {
		$this->getDateHelper();
		if ($this->getRequest ()->isPost ()) {
			$today = new \DateTime ();
			$date_enregistrement = $today->format('ymd');

			$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient' ); 
			
			$date_deces = $this->dateHelper->convertDateInAnglais($this->params ()->fromPost ( 'date_deces' ));
			$heure_deces = $this->params ()->fromPost ( 'heure_deces' );
			$age_deces = $this->params ()->fromPost ( 'age_deces' );
			$lieu_deces = $this->params ()->fromPost ( 'lieu_deces' );
			$circonstances_deces = $this->params ()->fromPost ( 'circonstances_deces' );
			$note_importante = $this->params ()->fromPost ( 'note' );

			$donnees = array (
					'id_patient' => $id_patient,
					'date_deces' => $date_deces,
					'heure_deces' => $heure_deces,
					'age_deces' => $age_deces,
					'lieu_deces' => $lieu_deces,
					'circonstances_deces' => $circonstances_deces,
					'note_importante' => $note_importante
			);

			$deces = $this->getDecesTable();
			$deces->addDeces ( $donnees, $date_enregistrement );

			return $this->redirect()->toRoute('facturation', array(
					'action' => 'liste-patients-decedes'));
		}
	}
	public function listePatientsDecedesAction() {
// 		$list = $this->getPatientTable();
// 		$infoPatient = $list->getPatient(78);
// 		var_dump($infoPatient); exit();
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$Patientsdeces = $this->getDecesTable ();
		$listePatientsDecedes = $Patientsdeces->getPatientsDecedes ();
		$nbPatientsDecedes = $Patientsdeces->nbPatientDecedes ();
		return array (
				'listePatients' => $listePatientsDecedes,
				'nbPatients' => $nbPatientsDecedes
		);
	}
	public function enregistrerAdmissionAction() {
		if ($this->getRequest ()->isPost ()) {
			$today = new \DateTime ( "now" );
			$date_cons = $today->format ( 'ymd' );

			$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 ); // id du patient

			$numero = $this->params ()->fromPost ( 'numero' );
			$id_service = $this->params ()->fromPost ( 'service' );
			$montant = $this->params ()->fromPost ( 'montant' );

			$donnees = array (
					'id_patient' => $id_patient,
					'id_service' => $id_service,
					'date' => $date_cons,
					'montant' => $montant,
					'numero' => $numero
			);

			$naiss = $this->getFacturationTable ();
			$naiss->addFacturation ( $donnees );
			
		return $this->redirect()->toRoute('facturation', array(
					'action' =>'liste-patients-admis'));
		}
	}
	public function montantAction() {
		if ($this->getRequest ()->isPost ()) {

			$id_service = ( int ) $this->params ()->fromPost ( 'id', 0 ); // id du service

			$tarif = $this->getTarifConsultationTable ()->TarifDuService ( $id_service );

			if ($tarif) {
				$montant = $tarif['TARIF'] . ' frs';
			} else {
				$montant = '';
			}
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $montant ) );
		}
	}
	public function supprimerNaissanceAction() {
		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id' );
			$list = $this->getNaissanceTable ();
			$list->deleteNaissance ( $id );

			$nb = $list->nbPatientNaissance ();

			$html = "$nb au total";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		}
	}
	public function vueNaissanceAction() {
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getPatient ( $id );
		$photo = $patient->getPhoto ( $id );

		$date = $this->convertDate ( $unPatient->date_naissance );

		// Informations sur la naissance
		$Naiss = $this->getNaissanceTable ();
		$InfoNaiss = $Naiss->getPatientNaissance ( $id );

		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left'>";
		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine . "</p></td>";
		$html .= "<td></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->profession . "</p></td>";
		$html .= "<td></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
			
		$html .= "<div id='titre_info_deces'>Informations sur la naissance</div>";
		$html .= "<div id='barre_separateur'></div>";

		$html .= "<table style='margin-top:10px; margin-left:170px;'>";
		$html .= "<tr>";
		$html .= "<td style='width:150px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Heure:</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->heure_naissance . "</div></td>";
		$html .= "<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Poids:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->poids . " kg</div></td>";
		$html .= "<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Taille:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->taille . " cm</div></td>";
		$html .= "<td style='width:250px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Groupe Sanguin :</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss->groupe_sanguin . "</div></td>";
		$html .= "<td style='width:250px'><a href='javascript:infomaman(" . $InfoNaiss->id_maman . ")' style='float:right; margin-right: 10px; font-size:27px; font-family: Edwardian Script ITC; color:green; font-weight:bold;'><img style='margin-right:5px;' src='".$chemin."/images_icons/vuemaman.png' >Info maman</a></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "<table style='margin-top:10px; margin-left:170px;'>";
		$html .= "<tr>";
		$html .= "<td style='padding-top: 10px;'><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>" . $InfoNaiss->note . "</p></td>";
		$html .= "<td class='block' id='thoughtbot' style='display: inline-block;  vertical-align: bottom; padding-left:300px; padding-bottom: 15px;'><button type='submit' id='terminer'>Terminer</button></td>";
		$html .= "</tr>";
		$html .= "</table>";

		$html .= "<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";

		$html .= "<script>listepatient();</script>";

		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent(Json::encode($html));
	}
	public function vueInfoMamanAction() {
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getPatient ( $id );
		$photo = $patient->getPhoto ( $id );

		$date = $this->convertDate ( $unPatient->date_naissance );

		$html = "<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "'></div>";

		$html .= "<table>";

		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient->profession . "</p></td>";
		$html .= "</tr><tr>";

		$html .= "</tr>";

		$html .= "</table>";

		 $this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent(Json::encode($html));
	}
	public function modifierNaissanceAction() {
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		if ($this->getRequest ()->isGet ()) {

			$id = ( int ) $this->params ()->fromQuery ( 'id', 0 ); // CODE DU BEBE

			// RECUPERONS LE CODE DE LA MAMAN
			$naiss = $this->getNaissanceTable ();
			$enreg = $naiss->getPatientNaissance ( $id );
			$id_maman = $enreg->id_maman;

			// RECUPERONS LES DONNEES DE LA MAMAN
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getPatient ( $id_maman );
			$photo = $pat->getPhoto ( $id_maman );

			$date_naiss_maman = $this->convertDate ( $unPatient->date_naissance );

			// RECUPERONS LES INFOS DU BEBE
			$DonneesBebe = $pat->getPatient ( $id );

			$formRow = new FormRow();
			$formSelect = new FormSelect();
			$formText = new FormText();
			$formHidden = new FormHidden();
			
			$form = new AjoutNaissanceForm ();
			// PEUPLER LE FORMULAIRE
			$donnees = array (
					'id_personne'=>$id,
					'nom' => $DonneesBebe->nom,
					'prenom' => $DonneesBebe->prenom,
					'sexe' => $DonneesBebe->sexe,
					'date_naissance' => $this->convertDate ( $DonneesBebe->date_naissance ),
					'heure_naissance' => $enreg->heure_naissance,
					'lieu_naissance' => $DonneesBebe->lieu_naissance,
					'poids' => $enreg->poids,
					'taille' => $enreg->taille,
					'groupe_sanguin' => $enreg->groupe_sanguin
			);

			$form->populateValues ( $donnees ); 
			
			$html = "<a href='' id='precedent' style='font-family: police2; width:50px; margin-left:30px; margin-top:5px;'>
	                 <img style='' src='".$chemin."/images_icons/left_16.PNG' title='Retour'>
				     Retour
		             </a>

		    <div id='info_maman'  style=''> ";
				
			$html .= "<div style='width: 18%; height: 200px; float:left;'>";
			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "' ></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 65%; height: 200px; float:left;'>";
			$html .= "<table style='margin-top:10px; float:left'>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine. "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date_naiss_maman . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
			$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->profession . "</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
			
			$html .= "<div style='width: 17%; height: 200px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			
			$html .= "</div>
			
		    <div id='barre_separateur_modifier'>
		    </div>
            
			<form  method='post' action='".$chemin."/facturation/modifier-naissance'>
					
		    <div id='info_bebe' style=''>
               <div  style='float:left; margin-left:40px; margin-top:25px; margin-right:35px; width:11%; height:105px;'>
		       <img style='display: inline;' src='".$this->baseUrl()."public/images_icons/bebe.jpg' alt='Photo bebe'>
		       </div>".$formHidden($form->get( 'id_personne' ))."
		       		
			   <div style='width: 75%; float:left;'>
		       <table id='form_patient' style='width: 100%;'>
		             <tr>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'nom' )) . $formText($form->get ( 'nom' )) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'date_naissance' )) . $formText($form->get ( 'date_naissance' )) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'poids' )) . $formText($form->get ( 'poids' )) . "</td>

		             </tr>

		             <tr>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'prenom' )) . $formText($form->get ( 'prenom')) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'heure_naissance' )) . $formText($form->get ( 'heure_naissance')) . "</td>
		                 <td class='comment-form-patient'>" . $formRow($form->get ( 'taille' )) . $formText($form->get ( 'taille')) . "</td>

		             </tr>

		             <tr>
		                 <td class='comment-form-patient'>" .$formRow($form->get ( 'sexe' )) . $formSelect($form->get ( 'sexe' )). "</td>
		                 <td class='comment-form-patient'>" .$formRow($form->get ( 'lieu_naissance' )) . $formText($form->get ( 'lieu_naissance' )) . "</td>
		                 <td class='comment-form-patient'>" .$formRow($form->get ( 'groupe_sanguin' )) . $formText($form->get ( 'groupe_sanguin' )) . "</td>

		             </tr>
		       </table>
		       </div>

		       <div style='width: 5%; float:left;'>
		       <div id='barre_vertical'></div>

		       <div id='menu'>
		           <div class='vider_formulaire' id='vider_champ'>
                     <hass> <input title='Vider tout' name='vider' id='vider'> </hass>
                   </div>

                   <div class='modifer_donnees' id='div_modifier_donnees'>
                     <hass> <input alt='modifer_donnees' title='modifer les donnees' name='modifer_donnees' id='modifer_donnees'></hass>
                   </div>

                   <div class='supprimer_photo' id='div_supprimer_photo'>
                     <hass> <input name='supprimer_photo'> </hass> <!-- balise sans importance pour le moment -->
                   </div>

                   <div class='ajouter_photo' id='div_ajouter_photo'>
                     <hass> <input type='submit' alt='ajouter_photo' title='Ajouter une photo' name='ajouter_photo' id='ajouter_photo'> </hass>
                   </div>
               </div>
               </div>
               
		       </div>

		        <div id='terminer_annuler' >
                    <div class='block' id='thoughtbot'>
                       <button type='submit' style='height:35px; margin-right:10px;'>Terminer</button>
                    </div>

                    <div class='block' id='thoughtbot'>
                       <button id='annuler_modif' style='height:35px;'>Annuler</button>
                    </div>
                </div>
			   </form>";
			
			$this->getResponse ()->getHeaders ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		} else if ($this->getRequest ()->isPost ()) {

			$modif_naiss = $this->getNaissanceTable ();
			$modif_pat = $this->getPatientTable ();

			$id_bebe = ( int ) $this->params ()->fromPost ( 'id_personne' ); // id du bebe
			$nom = $this->params ()->fromPost ( 'nom' );
			$prenom = $this->params ()->fromPost ( 'prenom' );
			$date_naissance = $this->convertDateInAnglais ( $this->params ()->fromPost ( 'date_naissance' ) );
			$lieu_naissance = $this->params ()->fromPost ( 'lieu_naissance' );
			$heure_naissance = $this->params ()->fromPost ( 'heure_naissance' );
			$sexe = $this->params ()->fromPost ( 'sexe' );
			$groupe_sanguin = $this->params ()->fromPost ( 'groupe_sanguin' );
			$poids = ( int ) $this->params ()->fromPost ( 'poids' );
			$taille = ( int ) $this->params ()->fromPost ( 'taille' );

			if ($sexe == 'Féminin') {
				$civilite = "Mlle";
			} else {
				$civilite = "M";
			}

			$donnees = array (
					'id_bebe' => $id_bebe,
					'nom' => $nom,
					'prenom' => $prenom,
					'date_naissance' => $date_naissance,
					'lieu_naissance' => $lieu_naissance,
					'heure_naissance' => $heure_naissance,
					'groupe_sanguin' => $groupe_sanguin,
					'sexe' => $sexe,
					'civilite' => $civilite,
					'taille' => $taille,
					'poids' => $poids
			);

			// Modification des donn�es du b�b� dans la table Naissance
			$modif_naiss->updateBebe ( $donnees );

			// Modification des donn�es du b�b� dans la table Patient
			$modif_pat->updatePatientBebe ( $donnees );

			return $this->redirect ()->toRoute ( 'facturation', array (
					'action' => 'liste-naissance'
			) );
		}
	}
	public function convertDateInAnglais($date) {
		$nouv_date = substr ( $date, 6, 4 ) . '-' . substr ( $date, 3, 2 ) . '-' . substr ( $date, 0, 2 );
		return $nouv_date;
	}
	public function infoPatientAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$id_pat = $this->params ()->fromRoute ( 'val', 0 );
		// var_dump($id_pat); exit();
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getPatient ( $id_pat );
		return array (
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'id_cons' => $unPatient->id_personne,
				'heure_cons' => $unPatient->date_enregistrement
		);
	}
	public function supprimerAction() {

		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$patientTable = $this->getPatientTable ();
			$patientTable->deletePatient ( $id );

			// Supprimer le patient s'il est dans la liste des naissances
			$naiss = $this->getNaissanceTable ();
			$naiss->deleteNaissance ( $id );

			// AFFICHAGE DE LA LISTE DES PATIENTS
			$liste = $patientTable->tousPatients ();
			$nb = $patientTable->nbPatientSUP900 ();
			$html = " $nb patients";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
	}
	
	public function supprimerDecesAction(){
		if ($this->getRequest()->isPost()){
			$id = (int)$this->params()->fromPost ('id');
			$list = $this->getDecesTable();
			$list->deletePatient($id);

			$nb = $list->nbPatientDecedes();

			$html ="$nb au total";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		}
	}
	public function vuePatientDecedeAction(){

		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = (int)$this->params()->fromPost ('id');
		$list = $this->getPatientTable();
		$infoPatient = $list->getPatient($id);
		$photo = $list->getPhoto($id);

		$date = $this->convertDate($infoPatient->date_naissance);

		//Informations sur le d�c�s
		$deces = $this->getDecesTable();
		$InfoDeces = $deces->getPatientDecede($id);

		$html ="<div id='photo' style='float:left; margin-left:20px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."' ></div>";

		$html .="<table style='margin-top:10px; float:left'>";

		$html .="<tr>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$infoPatient->nom."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient->lieu_naissance."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$infoPatient->nationalite_origine."</p></td>";
		$html .="</tr><tr>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient->prenom."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient->telephone."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient->nationalite_actuelle."</p></td>";
		$html .="<td><a style='text-decoration:underline; font-size:13px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>".$infoPatient->email."</p></td>";
		$html .="</tr><tr>";
		$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$date."</p></td>";
		$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>".$infoPatient->adresse."</p></td>";
		$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>".$infoPatient->profession."</p></td>";
		$html .="</tr>";

		$html .="</table>";

		$html .="<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."'></div>";
		$html .="<div id='titre_info_deces'>Informations sur le d&eacute;c&egrave;s</div>";
		$html .="<div id='barre_separateur'></div>";

		$html .="<table style='margin-top:10px; margin-left:170px;'>";
		$html .="<tr>";
		$html .="<td style='width:150px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Date:</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>".$this->convertDate($InfoDeces->date_deces)."</div></td>";
		$html .="<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Heure:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>".$InfoDeces->heure_deces."</div></td>";
		$html .="<td style='width:100px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Age:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>".$InfoDeces->age_deces." ans</div></td>";
		$html .="<td style='width:150px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Lieu:</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>".$InfoDeces->lieu_deces."</div></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .="<table style='margin-top:10px; margin-left:170px;'>";
		$html .="<tr>";
		$html .="<td style='padding-top: 10px;'><a style='text-decoration:underline; font-size:13px;'>Circonstances:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$InfoDeces->circonstances_deces."</p></td>";
		$html .="<td style='padding-top: 10px; padding-left: 20px;'><a style='text-decoration:underline; font-size:13px;'>Note importante:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$InfoDeces->note_importante."</p></td>";
		$html .="<td class='block' id='thoughtbot' style='display: inline-block;  vertical-align: bottom; padding-left:100px; padding-bottom: 15px;'><button type='submit' id='terminer'>Terminer</button></td>";
		$html .="</tr>";
		$html .="</table>";

		$html .="<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";

		$html .="<script>listepatient();</script>";

		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));

	}
	public function modifierDecesAction(){
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		if ($this->getRequest()->isGet()){

			$id = (int)$this->params()->fromQuery ('id'); //CODE DU DECES

			//RECUPERONS LE CODE DU PATIENT et l'enregistrement sur le deces
			$deces = $this->getDecesTable();
			$enregDeces = $deces->getLePatientDecede($id);
			$id_patient = $enregDeces->id_personne;

			//RECUPERONS LES DONNEES DU PATIENT
			$list = $this->getPatientTable();
			$unPatient = $list->getPatient($id_patient);
			$photo = $list->getPhoto($id_patient);

			$date = $this->convertDate($unPatient->date_naissance);
			
			$formRow = new FormRow();
			$formText = new FormText();
			$formTextarea = new FormTextarea();
			$formHidden = new FormHidden();
			
			$form = new AjoutDecesForm();
			//PEUPLER LE FORMULAIRE
			$donnees = array(
					'id_deces' => $id,
					'date_deces'   =>$this->convertDate($enregDeces->date_deces),
					'heure_deces'  =>$enregDeces->heure_deces,
					'age_deces'    =>$enregDeces->age_deces.' ans',
					'lieu_deces'   =>$enregDeces->lieu_deces,
					'circonstances_deces' =>$enregDeces->circonstances_deces,
					'note'  =>$enregDeces->note_importante,
			);

			$form->populateValues($donnees);


			$html ="<a id='precedent' style='cursor: pointer; text-decoration: none; font-family: police2; width:50px; margin-left:30px;'>
					 <img style='display: inline;' src='".$chemin."/images_icons/left_16.png' />
		             Retour
		           </a>";

			$html .="<div id='info_patient' style='width:100%;'>";
			
			$html .= "<div style='width: 18%; height: 180px; float:left;'>";
			$html .="<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."' ></div>";
			$html .= "</div>";
			
			$html .= "<div style='width: 65%; height: 180px; float:left;'>";
			$html .="<table style='margin-top:10px; float:left'>";
			$html .="<tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$unPatient->nom."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient->lieu_naissance."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>".$unPatient->nationalite_origine."</p></td>";
			$html .="</tr><tr>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient->prenom."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient->telephone."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient->nationalite_actuelle."</p></td>";
			$html .="<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>".$unPatient->email."</p></td>";
			$html .="</tr><tr>";
			$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>".$date."</p></td>";
			$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>".$unPatient->adresse."</p></td>";
			$html .="<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>".$unPatient->profession."</p></td>";
			$html .="</tr>";
			$html .="</table>";
			$html .="</div>";

			$html .= "<div style='width: 17%; height: 180px; float:left;'>";
			$html .="<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$chemin."/img/photos_patients/".$photo."'></div>";
			$html .="</div>";
			
			$html .="</div>

		            <div id='titre_info_deces_modif'>Informations sur le d&eacute;c&egrave;s</div>
		            <div id='barre_separateur_modif'></div>";

			$html .="<form  method='post' action='".$chemin."/facturation/modifier-deces'>";
		    $html .="<div id='info_bebe' style='width: 100%; margin-top:0px;'>
                         <div style='float:left; width:18%; height:105px;'>
		                 </div>";
			
            $html .="<div style='width: 77%; float:left;'>";
			$html .="<table id='form_patient' style='float:left; margin-top:15px;'>
		               <tr>".$formHidden($form->get('id_deces')) ."
		                   <td class='comment-form-patient'>".$formRow($form->get('date_deces')) . $formText($form->get('date_deces')) ."</td>
		                   <td class='comment-form-patient'>".$formRow($form->get('heure_deces')) . $formText($form->get('heure_deces')) ."</td>
		                   <td class='comment-form-patient'>".$formRow($form->get('age_deces')) . $formText($form->get('age_deces'))."</td>
     		           </tr>

		               <tr>
		                   <td class='comment-form-patient' style='display: inline-block; vertical-align: top;'>".$formRow($form->get('lieu_deces')) . $formText($form->get('lieu_deces')) ."</td>
		                   <td class='comment-form-patient'>".$formRow($form->get('circonstances_deces')) . $formTextarea($form->get('circonstances_deces')) ."</td>
		                   <td class='comment-form-patient'>".$formRow($form->get('note')) . $formTextarea($form->get('note'))."</td>
		               </tr>
		            </table>";
            $html .="</div>";
            
            //Rendre non modifiable la date du deces
            //Rendre non modifiable la date du deces
            $html .="<script> 
            		   $('#age_deces').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					   $('#age_deces').attr('readonly',true);
            		 </script>";
            
            
            $html .="<div style='float:left; width:5%;'>";
			$html .="<div id='barre_vertical'></div>
		             <div id='menu'>
		    		      <div class='vider_formulaire' id='vider_champ'>
                               <input title='Vider tout' name='vider' id='vider'>
                          </div>

                          <div class='modifer_donnees' id='div_modifier_donnees'>
                               <input alt='modifer_donnees' title='modifer les donnees' name='modifer_donnees' id='modifer_donnees'>
                          </div>

                          <div class='supprimer_photo' id='div_supprimer_photo'>
                               <input name='supprimer_photo'> <!-- balise sans importance pour le moment -->
                          </div>

                          <div class='ajouter_photo' id='div_ajouter_photo'>
                               <input type='submit' alt='ajouter_photo' title='Ajouter une photo' name='ajouter_photo' id='ajouter_photo'>
                          </div>
                     </div>
				 	 </div>
					 </div>";
			
            $html .="<div style='width:100%;'>
                      <div id='terminer_annuler'>
                          <div class='block' id='thoughtbot'>
                               <button type='submit' id='terminer_modif_dece' style='height:35px;'>Terminer</button>
                          </div>

                          <div class='block' id='thoughtbot'>
                               <button id='annuler_modif_deces' style='height:35px;'>Annuler</button>
                          </div>
                     </div>
		             </div>
            		</form>";
            
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		}
		else if ($this->getRequest()->isPost()){
			$id = (int)$this->params()->fromPost ('id_deces'); 
			$deces = $this->getDecesTable();

			$donnees = array(
					'id' => $id,
					'date_deces' => $this->convertDateInAnglais($this->params()->fromPost('date_deces')),
					'heure_deces' => $this->params()->fromPost('heure_deces'),
					'age_deces' => $this->params()->fromPost('age_deces'),
					'lieu_deces' => $this->params()->fromPost('lieu_deces'),
					'circonstances_deces' =>$this->params()->fromPost('circonstances_deces'),
					'note_importante' => $this->params()->fromPost('note'),
			);
			$deces->updateDeces($donnees);

			return $this->redirect()->toRoute('facturation' , array(
					'action'=>'liste-patients-decedes') );
		}
	}
	public function supprimerAdmissionAction(){
		if ($this->getRequest()->isPost()){
			$id = (int)$this->params()->fromPost ('id');
			$list = $this->getFacturationTable();
			$list->deleteAdmissionPatient($id);

			$nb = $list->nbFacturation();

			$html ="$nb au total";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse()->setContent(Json::encode($html));
		}
	}
	public function vuePatientAdmisAction(){
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$id = (int)$this->params()->fromPost ('id');
		$idFacturation = (int)$this->params()->fromPost ('idFacturation');
		$patientTable = $this->getPatientTable();
		$unPatient = $patientTable->getPatient($id);
		$photo = $patientTable->getPhoto($id);

		//Informations sur l'admission
		$Admis = $this->getFacturationTable();
		$InfoAdmis = $Admis->getPatientAdmis($idFacturation);

		//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		$pat = $this->getPatientTable ();
		$RendezVOUS = $pat->verifierRV($id, $dateAujourdhui);
		
		//Recuperer le service
		$service = $this->getServiceTable();
		$InfoService = $service->getServiceAffectation($InfoAdmis->id_service);

		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 240px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
// 		$html .= "<div style='width: 65%; height: 180px; float:left;'>";
// 		$html .= "<table style='margin-top:10px; float:left'>";
// 		$html .= "<tr>";
// 		//$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nom . "</p></td>";
// 		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Nom</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px;'> ". $unPatient->nom ." </p></td>";
// 		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->lieu_naissance . "</p></td>";
// 		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_origine . "</p></td>";
// 		$html .= "</tr><tr>";
// 		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->prenom . "</p></td>";
// 		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
// 		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->nationalite_actuelle . "</p></td>";
// 		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient->email . "</p></td>";
// 		$html .= "</tr><tr>";
// 		$html .= "<td style='width: 30%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->convertDate($unPatient->date_naissance) . "</p></td>";
// 		$html .= "<td style='width: 20%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
// 		$html .= "<td style='width: 20%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->profession . "</p></td>";
// 		$html .= "<td style='width: 30%; height: 50px;'>";

		
		$html .= "<div style='width: 65%; height: 240px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
		$html .= "<tr style='width: 100%;'>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Nom</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->nom ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Lieu de naissance</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->lieu_naissance ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Nationalit&eacute; d'origine</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->nationalite_origine ." </p></td>";
		
		$html .= "<td style='width: 30%; height: 50px;'></td>";
		$html .= "</tr><tr style='width: 100%;'>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Pr&eacute;nom</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->prenom ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>T&eacute;l&eacute;phone</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->telephone ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Nationalit&eacute; actuelle</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->nationalite_actuelle ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Email</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->email ." </p></td>";
		
		$html .= "</tr><tr style='width: 100%;'>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date de naissance</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->convertDate($unPatient->date_naissance) ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Adresse</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->adresse ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABELVue' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Profession</span><br><p id='zoneChampInfoVue' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $unPatient->profession ." </p></td>";
		$html .= "<td style='width: 30%; height: 50px;'>";
		
		
		
		if($RendezVOUS){
			$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $pat->getServiceParId($RendezVOUS[ 'ID_SERVICE' ])[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'heure' ]." </span> </i>
			              </span>";
		}
		$html .= "</td'>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 17%; height: 240px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
		
		$html .="<div id='titre_info_admis'>Informations sur la facturation</div>";
		$html .="<div id='barre_separateur'></div>";

		$html .="<table style='margin-top:10px; margin-left:195px; width: 80%;'>";

		$html .="<tr style='width: 80%;'>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date consultation</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->convertDate($InfoAdmis->date_cons) ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Num&eacute;ro facture</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->numero ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Service</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoService->nom ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Montant</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->montant." francs </p></td>";
		$html .="</tr>";

		$html .="</table>";
		$html .="<table style='margin-top:10px; margin-left:195px; width: 80%;'>";
		$html .="<tr style='width: 80%;'>";
		
		$html .="<td style='padding-top: 10px; width: 35%; height: 100px; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Note</span><br><p id='zoneChampInfo' style='background:#f8faf8; padding-left: 5px;'> ". $InfoAdmis->note." </p></td>";
		$html .="<td class='block' id='thoughtbot' style='width: 35%; display: inline-block;  vertical-align: bottom; padding-left:350px; padding-bottom: 15px; padding-right: 150px;'><button type='submit' id='terminer'>Terminer</button></td>";

		$html .="</tr>";
		$html .="</table>";

		$html .="<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='".$chemin."/images_icons/fleur1.jpg' />
                     </div>";

		$html .="<script>listepatient();
				  function FaireClignoterImage (){
                    $('#image-neon').fadeOut(900).delay(300).fadeIn(800);
                  }
                  setInterval('FaireClignoterImage()',2200);
				 </script>";

		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));

	}
	
}