<?php

namespace Facturation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
// use Zend\View\Helper\Json;
use Zend\Json\Json;
use Facturation\Model\Patient;
use Facturation\Model\Deces;
use Facturation\Model\Naissance;
use Personnel\Model\Service;
use Facturation\Form\PatientForm;
use Facturation\Form\AjoutNaissanceForm;
use Facturation\Form\AdmissionForm;
use Zend\Json\Expr;
use Facturation\Form\AjoutDecesForm;
use Zend\Stdlib\DateTime;
use Zend\Mvc\Service\ViewJsonRendererFactory;

class FacturationController extends AbstractActionController {
	protected $patientTable;
	protected $decesTable;
	protected $formPatient;
	protected $serviceTable;
	protected $facturationTable;
	protected $naissanceTable;
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
	public function admissionAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/facturation' );
		$patient = $this->getPatientTable ();
		// AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->LalistePatients ();

		// INSTANCIATION DU FORMULAIRE d'ADMISSION
		$formAdmission = new AdmissionForm ();
		// r�cup�ration de la liste des hopitaux
		$service = $this->getServiceTable ()->fetchService ();
		// $formAdmission->get('service')->setOptions($service);
		// $Form->service->addMultiOptions($service);

		if ($this->getRequest ()->isPost ()) {
			// $numero = Zend_Date::now ()->toString ( 'MMHHmmss' );
			$today = new \DateTime ( "now" );
			$numero = $today->format ( 'mHis' );
			$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getPatient ( $id );
			$photo = $list->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient ['DATE_NAISSANCE'] );

			$html = "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='/simens_derniereversion/public/img/photos_patients/" . $photo . "' ></div>";

			$html .= "<table style='margin-top:10px; float:left'>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['LIEU_NAISSANCE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ORIGINE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ACTUELLE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient ['EMAIL'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . "</p></td>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PROFESSION'] . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";

			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='/simens_derniereversion/public/img/photos_patients/" . $photo . "'></div>";

			$html .= "<script>$('#numero').val('" . $numero . "');
					         $('#numero').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					         $('#numero').attr('readonly',true);

					         $('#service').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'14px'});

					         $('#montant').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'blue','font-family': 'Times  New Roman','font-size':'22px'});
					         $('#montant').attr('readonly',true);
					 </script>"; // Uniquement pour la facturation

			$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
			// $jsonHelp = new Json ();
			// $data = $jsonHelp->__invoke ( $html );
			// $this->_helper->json->sendJson($html);
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
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$form = $this->getForm ();
		return new ViewModel ( array (
				'form' => $form
		) );
	}
	public function declarerDecesAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );
		$patient = $this->getPatientTable ();
		// AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->laListePatients ();
		// INSTANCIATION DU FORMULAIRE DE DECES
		$ajoutDecesForm = new AjoutDecesForm ();

		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getPatient ( $id );
			$photo = $pat->getPhoto ( $id );
			$date = $this->convertDate ( $unPatient ['DATE_NAISSANCE'] );

			$html = "<div id='photo' style='float:left; margin-right:20px;'> <img  src='/simens_derniereversion/public/img/photos_patients/" . $photo . "'  style='width:105px; height:105px;'></div>";

			$html .= "<table>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr>";
			// $html .="<td><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$Laliste['SEXE']."</p></td>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";

			$htmlViewPart = new ViewModel ();
			$htmlViewPart->setTerminal ( true )->setTemplate ( 'layout/facturation' )->setVariables ( array (
					$html
			) );
			$htmlOutput = $this->getServiceLocator ()->get ( 'viewrenderer' )->render ( $htmlViewPart );
			$jsonModel = new JsonModel ();
			$jsonModel->setVariables ( array (
					'html' => $htmlOutput
			) );

			return $jsonModel;
			// $this->getResponse()->setMetadata('Content-Type', 'application/html');
			// $jsonHelp = new Json();
			// $data = $jsonHelp->__invoke($html);
			// return new ViewJsonRendererFactory();
			// $this->getResponse()->setHeader('Content-Type','application/html');
			// $this->->json->sendJson($html);
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
	public function enregistrementAction() {

		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] )) 		// si formulaire soumis
		{

			$form = new PatientForm ();
			$patient = $this->getPatientTable ();
			// $nomfile = Zend_Date::now ()->toString ( 'ddMMyy_HHmmss' );
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'ddMMyy_His' );
			$date_enregistrement = $today->format ( 'YY-MM-dd' );
			$fileBase64 = $this->params('fichier_tmp');
			$fileBase64 = substr ( $fileBase64, 23 );

			//$img = imagecreatefromstring ( base64_decode ( $fileBase64 ) );
			$patientModel = new Patient ();
// 			var_dump($img);exit();
// 			if ($img != false) {
// // 				$root = $_SERVER['DOCUMENT_ROOT'];
// // 				var_dump($root);exit();
// 				$chemin = $this->basePath() . '/img/photos_patients/';
// 				//var_dump($chemin);exit();
// 				imagejpeg ( $img, $chemin . $nomfile . '.jpg' );

// 				$request = $this->getRequest ();
// 				$formData = $request->getPost ();
// 				$form->setInputFilter ( $patientModel->getInputFilter () );
// 				$form->setData ( $formData );

// 				if ($form->isValid ()) {
// 					$donnees = $form->getData ();

// 					$donnees['PHOTO'] = $nomfile;
// 					$donnees['date_enregistrement'] = $date_enregistrement;
// 					$patientModel->exchangeArray ( $donnees );
// 					$patient->savePatient ( $patientModel );
// 				}

// 				$this->redirect ()->toRoute('facturation', array('action' =>'liste-patient')  );
// 			} else {
				// On enregistre sans la photo //echo "cette image n'est pas support�e";

				$request = $this->getRequest ();
				$formData = $request->getPost ();
				$form->setInputFilter ( $patientModel->getInputFilter () );
				$form->setData ( $formData );
				if ($form->isValid ()) {
					$donnees = $form->getData ();
					$donnees['date_enregistrement'] = $date_enregistrement;
					$patientModel->exchangeArray ( $donnees );
					$patient->savePatient ( $patientModel );
				//}

				$this->redirect ()->toRoute('facturation', array('action' =>'liste-patient')  );
			}
		}
		$this->redirect ()->toRoute('facturation', array('action' =>'liste-patient')  );
	}
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		return $nouv_date;
	}
	public function ajouterNaissanceAction() {
		$this->layout ()->setTemplate ( 'layout/facturation' );

		$patient = $this->getPatientTable ();
		// AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->listePatients ();
		// var_dump($liste);
		// INSTANCIATION DU FORMULAIRE D'AJOUT
		$ajoutNaissForm = new AjoutNaissanceForm ();

		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
			// var_dump($id);exit();
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getPatient ( $id );
			$photo = $pat->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient ['DATE_NAISSANCE'] );

			$html = "<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='/simens/public/img/photos_patients/" . $photo . "'></div>";

			$html .= "<table>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr>";
			// $html .="<td><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>".$Laliste['SEXE']."</p></td>";
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";

			$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
			// $this->_helper->json->sendJson($html);
			// $jsonHelp = new Json ();
			// $data = $jsonHelp->__invoke ( $html );
		}
		return array (
				'donnees' => $liste,
				'form' => $ajoutNaissForm
		);
	}
	public function enregistrerBebeAction() {

		// if ($this->getRequest()->isPost()){
		// $date_enregistrement = Zend_Date::now ()->toString ( 'yyMMdd' );
		// $patient = new Facturation_Model_Managers_Patient();

		// $id_maman = (int)$this->getRequest()->getParam ('id'); //id de la m�re
		// $info_maman = $patient->getPatient($id_maman);

		// $nom = $this->getRequest()->getParam ('nom');
		// $prenom = $this->getRequest()->getParam ('prenom');
		// $date_naissance = $this->convertDateInAnglais($this->getRequest()->getParam ('date_naissance'));
		// $lieu_naissance = $this->getRequest()->getParam ('lieu_naissance');
		// $heure_naissance = $this->getRequest()->getParam ('heure_naissance');
		// $sexe = $this->getRequest()->getParam ('sexe');
		// $groupe_sanguin = $this->getRequest()->getParam ('groupe_sanguin');
		// $poids = (int)$this->getRequest()->getParam ('poids');
		// $taille = (int)$this->getRequest()->getParam ('taille');

		// if($sexe =='Féminin'){ $civilite = "Mme";}
		// else{$civilite = "M";}

		// $donnees = array(
		// 'id_maman' => $id_maman,
		// 'nom' => $nom,
		// 'prenom' => $prenom,
		// 'date_naissance' => $date_naissance,
		// 'lieu_naissance' => $lieu_naissance,
		// 'heure_naissance' => $heure_naissance,
		// 'groupe_sanguin' => $groupe_sanguin,
		// 'sexe' => $sexe,
		// 'civilite' => $civilite,
		// 'telephone' => $info_maman['TELEPHONE'],
		// 'email' => $info_maman['EMAIL'],
		// 'taille' => $taille,
		// 'poids' => $poids,
		// 'adresse' => $info_maman['ADRESSE'],
		// 'nationalite_actuelle' => $info_maman['NATIONALITE_ACTUELLE'],
		// );

		// //enregistrement du b�b� dans la table PATIENTS
		// $id_bebe = $patient->addPatientSansPhoto($donnees, $date_enregistrement);

		// //ajouter l'identit� du b�b� dans le tableau des donn�es
		// $donnees['id_bebe'] = $id_bebe;

		// $naiss = new Facturation_Model_Managers_Naissances();
		// $naiss->addBebe($donnees, $date_enregistrement);

		// $this->getResponse()->setHeader('Content-Type','application/html');
		// $this->_helper->json->sendJson();
		// }
	}
	public function birthday2Age($value) {
		if (! $value instanceof DateTime)
			$value = new \DateTime ( $value );
		$today = new \DateTime ( "now" );
		return floor ( $value->sub ( $today )->toValue () / 86400 / 365 * - 1 );
	}
	public function lePatientAction() {
		if ($this->getRequest ()->isPost ()) {

			$id = $this->params ()->fromRoute ( 'id', 0 );
			$unPatient = $this->getPatientTable ()->getPatient ( $id );
			$photo = $list->getPhoto ( $id );

			$date = $this->convertDate ( $unPatient ['DATE_NAISSANCE'] );

			$html = "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='/simens_derniereversion/public/img/photos_patients/" . $photo . "' ></div>";

			$html .= "<table style='margin-top:10px; float:left'>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['LIEU_NAISSANCE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ORIGINE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ACTUELLE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient ['EMAIL'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . "</p></td>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PROFESSION'] . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";

			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='/simens/public/img/photos_patients/" . $photo . "'></div>";

			$html .= "<script>$('#age_deces').val('" . $this->birthday2Age ( $unPatient ['DATE_NAISSANCE'] ) . " ans');
					         $('#age_deces').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					         $('#age_deces').attr('readonly',true);
					 </script>"; // Uniquement pour la d�claration du d�c�s
			$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
			// $this->_helper->json->sendJson($html);
			// $jsonHelp = new Json ();
			// $data = $jsonHelp->__invoke ( $html );
		}
	}
	public function enregistrerDecesAction() {
		return new ViewModel ();

		// if ($this->getRequest()->isPost()){
		// $date_enregistrement = Zend_Date::now ()->toString ( 'yyMMdd' );

		// $id_patient = (int)$this->getRequest()->getParam ('id'); //id du patient

		// $date_deces = $this->getRequest()->getParam ('date_deces');
		// $heure_deces = $this->getRequest()->getParam ('heure_deces');
		// $age_deces = $this->getRequest()->getParam ('age_deces');
		// $lieu_deces = $this->getRequest()->getParam ('lieu_deces');
		// $circonstances_deces = $this->getRequest()->getParam ('circonstances_deces');
		// $note_importante = $this->getRequest()->getParam('note');

		// $donnees = array('id_patient' =>$id_patient,
		// 'date_deces' => $date_deces,
		// 'heure_deces' => $heure_deces,
		// 'age_deces' => $age_deces,
		// 'lieu_deces' => $lieu_deces,
		// 'circonstances_deces' => $circonstances_deces,
		// 'note_importante' =>$note_importante,
		// );

		// $naiss = new Facturation_Model_Managers_Deces();
		// $naiss->addDeces($donnees, $date_enregistrement);

		// $this->getResponse()->setHeader('Content-Type','application/html');
		// $this->_helper->json->sendJson();
		// }
	}
	public function listePatientsDecedesAction() {
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
	}
	public function montantAction() {
		// if ($this->getRequest()->isPost()){

		// $id_service = (int) $this->params()->fromRoute('id', 0); //id du service

		// $tarifs = new Facturation_Model_Managers_TarifConsultation();
		// $tarif = $tarifs->getActe($id_service);

		// if($tarif['PASF_TN']){ $montant = $tarif['PASF_TN'].' frs';}
		// else{$montant = '';}
		// $this->getResponse()->setHeader('Content-Type','application/html');
		// $this->_helper->json->sendJson($montant);
		// }
	}
	public function supprimerNaissanceAction() {
		// if ($this->getRequest()->isPost()){
		// $id = (int)$this->getRequest()->getParam ('id');
		// $list = new Facturation_Model_Managers_Naissances();
		// $list->deleteNaissance($id);

		// $nb = $list->nbPatientNaissance();

		// $html ="$nb au total";
		// $this->getResponse()->setHeader('Content-Type','application/html');
		// $this->_helper->json->sendJson($html);
		// }
	}
	public function vueNaissanceAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getPatient ( $id );
		$photo = $patient->getPhoto ( $id );

		$date = $this->convertDate ( $unPatient ['DATE_NAISSANCE'] );

		// Informations sur la naissance
		$Naiss = $this->getNaissanceTable ();
		$InfoNaiss = $Naiss->getPatientNaissance ( $id );

		$html = "<div id='photo' style='float:left; margin-left:20px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='/simens/public/img/photos_patients/" . $photo . "'></div>";

		$html .= "<table style='margin-top:10px; float:left'>";

		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:13px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:13px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:13px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ORIGINE'] . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:13px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:13px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:13px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:13px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient ['EMAIL'] . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . "</p></td>";
		$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:13px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PROFESSION'] . "</p></td>";
		$html .= "</tr>";

		$html .= "</table>";

		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='/simens/public/img/photos_patients/" . $photo . "'></div>";

		$html .= "<div id='titre_info_deces'>Informations sur la naissance</div>";
		$html .= "<div id='barre_separateur'></div>";

		$html .= "<table style='margin-top:10px; margin-left:170px;'>";
		$html .= "<tr>";
		$html .= "<td style='width:150px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Heure:</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss ['heure_naissance'] . "</div></td>";
		$html .= "<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Poids:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss ['poids'] . " kg</div></td>";
		$html .= "<td style='width:120px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Taille:</a><div id='inform' style='width:60px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss ['taille'] . " cm</div></td>";
		$html .= "<td style='width:250px'><a style='float:left; margin-right: 10px; text-decoration:underline; font-size:13px;'>Groupe Sanguin :</a><div id='inform' style='width:100px; float:left; font-weight:bold; font-size:17px;'>" . $InfoNaiss ['groupe_sanguin'] . "</div></td>";
		$html .= "<td style='width:250px'><a href='javascript:infomaman(" . $InfoNaiss ['id_maman'] . ")' style='float:right; margin-right: 10px; font-size:27px; font-family: Edwardian Script ITC; color:green; font-weight:bold;'><img style='margin-right:5px;' src='/simens/public/images_icons/vuemaman.png' >Info maman</a></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "<table style='margin-top:10px; margin-left:170px;'>";
		$html .= "<tr>";
		$html .= "<td style='padding-top: 10px;'><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>" . $InfoNaiss ['note'] . "</p></td>";
		$html .= "<td class='block' id='thoughtbot' style='display: inline-block;  vertical-align: bottom; padding-left:300px; padding-bottom: 15px;'><button type='submit' id='terminer'>Terminer</button></td>";
		$html .= "</tr>";
		$html .= "</table>";

		$html .= "<div style='color: white; opacity: 1; margin-top: -100px; margin-right:20px; width:95px; height:40px; float:right'>
                          <img  src='/simens/public/images_icons/fleur1.jpg' />
                     </div>";

		$html .= "<script>listepatient();</script>";

		// $this->getResponse()->setHeader('Content-Type','application/html');
		// $this->_helper->json->sendJson($html);
	}
	public function vueInfoMamanAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getPatient ( $id );
		$photo = $patient->getPhoto ( $id );

		$date = $this->convertDate ( $unPatient ['DATE_NAISSANCE'] );

		$html = "<div id='photo' style='float:left; margin-right:20px;' > <img  style='width:105px; height:105px;' src='/simens_derniereversion/public/img/photos_patients/" . $photo . "'></div>";

		$html .= "<table>";

		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></td>";
		$html .= "</tr><tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient ['EMAIL'] . "</p></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient ['LIEU_NAISSANCE'] . "</p></td>";
		$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style='width:240px; font-weight:bold; font-size:17px;'>" . $unPatient ['PROFESSION'] . "</p></td>";
		$html .= "</tr><tr>";

		$html .= "</tr>";

		$html .= "</table>";

		// $this->getResponse()->setHeader('Content-Type','application/html');
		// $this->_helper->json->sendJson($html);
	}
	public function modifierNaissanceAction() {
		if ($this->getRequest ()->isGet ()) {

			$id = ( int ) $this->params ()->fromRoute ( 'id', 0 ); // CODE DU BEBE

			// RECUPERONS LE CODE DE LA MAMAN
			$naiss = $this->getNaissanceTable ();
			$enreg = $naiss->getPatientNaissance ( $id );
			$id_maman = $enreg ['id_maman'];

			// RECUPERONS LES DONNEES DE LA MAMAN
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getPatient ( $id_maman );
			$photo = $pat->getPhoto ( $id_maman );

			$date_naiss_maman = $this->convertDate ( $unPatient ['DATE_NAISSANCE'] );

			// RECUPERONS LES INFOS DU BEBE
			$DonneesBebe = $pat->getPatient ( $id );

			$form = new AjoutNaissanceForm ();
			// PEUPLER LE FORMULAIRE
			$donnees = array (
					'nom' => $DonneesBebe ['NOM'],
					'prenom' => $DonneesBebe ['PRENOM'],
					'sexe' => $DonneesBebe ['SEXE'],
					'date_naissance' => $this->convertDate ( $DonneesBebe ['DATE_NAISSANCE'] ),
					'heure_naissance' => $enreg ['heure_naissance'],
					'lieu_naissance' => $DonneesBebe ['LIEU_NAISSANCE'],
					'poids' => $enreg ['poids'],
					'taille' => $enreg ['taille'],
					'groupe_sanguin' => $enreg ['groupe_sanguin']
			);

			$form->populateValues ( $donnees );

			$html = "<a href='' id='precedent' style='font-family: police2; width:50px; margin-left:30px; margin-top:5px;'>
	                <img style='' src='/simens/public/images_icons/left_16.PNG' title='Retour'>
				    Retour
		         </a>

		  <div id='info_maman'> ";

			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='/simens/public/img/photos_patients/" . $photo . "' ></div>";

			$html .= "<table style='margin-top:10px; float:left'>";

			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['LIEU_NAISSANCE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; d'origine:</a><br><p style='width:150px; font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ORIGINE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ACTUELLE'] . "</p></td>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><p style='width:200px; font-weight:bold; font-size:17px;'>" . $unPatient ['EMAIL'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $date_naiss_maman . "</p></td>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . "</p></td>";
			$html .= "<td style='display: inline-block;  vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PROFESSION'] . "</p></td>";
			$html .= "</tr>";

			$html .= "</table>";

			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='/simens/public/img/photos_patients/" . $photo . "'></div>";

			$html .= "</div>
		  <div id='barre_separateur_modifier'>
		  </div>

		  <div id='info_bebe'>
               <div  style='float:left; margin-left:40px; margin-top:25px; margin-right:20px; width:125px; height:105px;'>
		       <img style='display: inline;' src='/simens/public/images_icons/bebe.jpg' alt='Photo bebe'>
		       </div>

		       <table id='form_patient' style='float:left; margin-top:15px;'>
		             <tr>
		                 <td class='comment-form-patient'>" . $form->get ( 'nom' ) . "</td>
		                 <td class='comment-form-patient'>" . $form->get ( 'date_naissance' ) . "</td>
		                 <td class='comment-form-patient'>" . $form->get ( 'poids' ) . "</td>

		             </tr>

		             <tr>
		                 <td class='comment-form-patient'>" . $form->prenom . "</td>
		                 <td class='comment-form-patient'>" . $form->heure_naissance . "</td>
		                 <td class='comment-form-patient'>" . $form->taille . "</td>

		             </tr>

		             <tr>
		                 <td class='comment-form-patient'>" . $form->get ( 'sexe' ) . "</td>
		                 <td class='comment-form-patient'>" . $form->get ( 'lieu_naissance' ) . "</td>
		                 <td class='comment-form-patient'>" . $form->get ( 'groupe_sanguin' ) . "</td>

		             </tr>
		       </table>

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

               <div id='terminer_annuler'>
                    <div class='block' id='thoughtbot'>
                       <button id='terminer_modif' style='height:35px; margin-right:10px;'>Terminer</button>
                    </div>

                    <div class='block' id='thoughtbot'>
                       <button id='annuler_modif' style='height:35px;'>Annuler</button>
                    </div>
               </div>

		  </div>";
			// $this->getResponse()->setHeader('Content-Type','application/html');
			// $this->_helper->json->sendJson($html);
		} else if ($this->getRequest ()->isPost ()) {

			$modif_naiss = $this->getNaissanceTable ();
			$modif_pat = $this->getPatientTable ();

			$id_bebe = ( int ) $this->params ()->fromRoute ( 'id' ); // id du bebe
			$nom = $this->params ()->fromRoute ( 'nom' );
			$prenom = $this->params ()->fromRoute ( 'prenom' );
			$date_naissance = $this->convertDateInAnglais ( $this->params ()->fromRoute ( 'date_naissance' ) );
			$lieu_naissance = $this->params ()->fromRoute ( 'lieu_naissance' );
			$heure_naissance = $this->params ()->fromRoute ( 'heure_naissance' );
			$sexe = $this->params ()->fromRoute ( 'sexe' );
			$groupe_sanguin = $this->params ()->fromRoute ( 'groupe_sanguin' );
			$poids = ( int ) $this->params ()->fromRoute ( 'poids' );
			$taille = ( int ) $this->params ()->fromRoute ( 'taille' );

			if ($sexe == 'Féminin') {
				$civilite = "Mme";
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

			$this->getResponse ()->setMetadata ( 'Content-Type', 'application/html' );
			// $jsonHelp = new Json ();
			// $data = $jsonHelp->__invoke ( $html );
			return new JsonModel ( array (
					$data
			) );
			// $this->_helper->json->sendJson();
		}
	}
	public function convertDateInAnglais($date) {
		$nouv_date = substr ( $date, 6, 4 ) . '-' . substr ( $date, 3, 2 ) . '-' . substr ( $date, 0, 2 );
		return $nouv_date;
	}
	public function infoPatientAction() {
		$this->layout()->setTemplate ( 'layout/facturation' );
		$id_pat = $this->params()->fromRoute ( 'val', 0 );
		//var_dump($id_pat); exit();
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getPatient ( $id_pat );
		return array (
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'id_cons' => $unPatient->id_personne,
				'heure_cons' => $unPatient->date_enregistrement
		);
	}
	public function supprimerAction(){
// 		$id = (int)$this->params()->fromPost ( 'val', 0 );
// 		var_dump($id); exit();
		$this->layout()->setTerminal(true);
		if ($this->getRequest()->isPost()){
			$id = (int)$this->params()->fromRoute ( 'id', 0 );
			var_dump($id); exit();
			$patientTable = $this->getPatientTable();
			$patientTable->deletePatient($id);

			//Supprimer le patient s'il est dans la liste des naissances
			$naiss = $this->getNaissanceTable();
			$naiss->deleteNaissance($id);

			//$Patient = new Facturation_Model_Managers_Patient();
			//AFFICHAGE DE LA LISTE DES PATIENTS
			$liste = $patientTable->tousPatients();
			$nb = $patientTable->nbPatientSUP900();
			//return array('donneees'=>$liste);

			$html =$nb." patients";
			$this->getResponse()->setMetadata('Content-Type','application/html');
// 			$this->_helper->json->sendJson($html);
			//return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
	}
	public function modifierAction(){
		$this->layout()->setTemplate ( 'layout/facturation' );
		$id_patient = $this->params()->fromRoute ( 'val', 0 );
		//$id_patient = $this->getParam('id_patient');

		$infoPatient = $this->getPatientTable();
		try {
			$info = $infoPatient->getPatient($id_patient);
		}catch (\Exception $ex){
			return $this->redirect()->toRoute('facturation', array(
					'action' => 'liste-patient'
			));
		}
		$form = new PatientForm();
		$form->bind($info);
// 		$values = array(
// 				'id_personne'=>$id_patient,
// 				'nom' => $info['NOM'],
// 				'prenom' => $info['PRENOM'],
// 				'date_naissance' => $this->convertDate($info['DATE_NAISSANCE']),
// 				'lieu_naissance' => $info['LIEU_NAISSANCE'],
// 				'nationalite_origine' => $info['NATIONALITE_ORIGINE'],
// 				'nationalite_actuelle'=> $info['NATIONALITE_ACTUELLE'],
// 				'adresse' => $info['ADRESSE'],
// 				'telephone' => $info['TELEPHONE'],
// 				'email' => $info['EMAIL'],
// 				'sexe' => $info['SEXE'],
// 				'profession' => $info['PROFESSION'],
// 				'civilite' => $info['CIVILITE'],
// 		);
// 		$form->populate($values);
		//$this->view->form = $form;
		if(!$info->photo){$info->photo="identite";}
		//$this->view->photo = $info['PHOTO']; //envoi de la photo
		return 	array('form'=>$form, 'photo'=>$info->photo);
	}
	public function enregistrementModificationAction(){

		//INSTENTIATION DU FORMULAIRE
		//$form = new Facturation_Form_FormPatient();

		//CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if( isset($_POST['terminer']) ) // si formulaire soumis
		{
			$Patient = new Facturation_Model_Managers_Patient();
			$nomfile  = Zend_Date::now ()->toString ( 'ddMMyy_HHmmss' );
			$fileBase64 = $this->_getParam('fichier_tmp');
			$fileBase64 = substr($fileBase64, 23);

			$img = imagecreatefromstring(base64_decode($fileBase64));

			$donnees = array('id_patient' =>$this->_getParam('id_patient'),
					'nom'    =>$this->_getParam('nom'),
					'prenom' =>$this->_getParam('prenom'),
					'date_naissance' =>$this->convertDateInAnglais($this->_getParam('date_naissance')),
					'lieu_naissance' =>$this->_getParam('lieu_naissance'),
					'nationalite_origine' =>$this->_getParam('nationalite_origine'),
					'nationalite_actuelle' =>$this->_getParam('nationalite_actuelle'),
					'adresse' =>$this->_getParam('adresse'),
					'email' =>	$this->_getParam('email'),
					'telephone' => $this->_getParam('telephone'),
					'civilite' =>$this->_getParam('civilite'),
					'profession' =>	$this->_getParam('profession'),
					'sexe' =>$this->_getParam('sexe')
			);

			if($img != false)
			{
				//R�cup�rer le nom de l'ancienne image
				$ancimage = $Patient->getPatient($this->_getParam('id_patient'));
				$filename = $ancimage['PHOTO'];
				unlink('C:\wamp\www\simens_derniereversion\public\img\photos_patients\\'.$filename.'.jpg');

				imagejpeg($img, 'C:\wamp\www\simens_derniereversion\public\img\photos_patients\\'.$nomfile.'.jpg');
				$Patient->updatePatient($donnees,$nomfile);
				$this->redirect("facturation/facturation/listepatient/");

			}else {
				//On enregistre sans la photo //echo  "cette image n'est pas support�e";
				$Patient->updatePatientSansPhoto($donnees);
				$this->redirect("facturation/facturation/listepatient");
			}
		}
		$this->redirect()->toRoute('facturation', array('action'=>'liste-patient'));


	}
}