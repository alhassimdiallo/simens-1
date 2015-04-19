<?php

namespace Archivage\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Consultation\Model\Consultation;
use Zend\Json\Json;
use Facturation\View\Helper\DateHelper;
use Consultation\Form\LibererPatientForm;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormTextarea;
use Zend\Form\View\Helper\FormHidden;
use Consultation\Form\SoinmodificationForm;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormSelect;
use Archivage\Form\PatientForm;
use Archivage\Form\AdmissionForm;
use Archivage\Form\ConsultationForm;
use Archivage\Form\HospitaliserForm;
use Archivage;
use Archivage\Form\SoinForm;
use Archivage\Form\AppliquerSoinForm;

class ArchivageController extends AbstractActionController {
	protected $controlDate;
	protected $patientTable;
	protected $consultationTable;
	protected $motifAdmissionTable;
	protected $rvPatientConsTable;
	protected $serviceTable;
	protected $hopitalTable;
	protected $transfererPatientServiceTable;
	protected $consommableTable;
	protected $donneesExamensPhysiquesTable;
	protected $diagnosticsTable;
	protected $ordonnanceTable;
	protected $demandeVisitePreanesthesiqueTable;
	protected $notesExamensMorphologiquesTable;
	protected $demandeExamensTable;
	protected $ordonConsommableTable;
	protected $antecedantPersonnelTable;
	protected $antecedantsFamiliauxTable;
	protected $demandeHospitalisationTable;

	protected $soinhospitalisationTable;
	protected $soinsTable;
	protected $hospitalisationTable;
	protected $hospitalisationlitTable;
	protected $litTable;
	protected $salleTable;
	protected $batimentTable;
	protected $soinhospitalisation4Table;
	protected $resultatVpaTable;
	
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Archivage\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getConsultationTable() {
		if (! $this->consultationTable) {
			$sm = $this->getServiceLocator ();
			$this->consultationTable = $sm->get ( 'Archivage\Model\ConsultationTable' );
		}
		return $this->consultationTable;
	}
	public function getMotifAdmissionTable() {
		if (! $this->motifAdmissionTable) {
			$sm = $this->getServiceLocator ();
			$this->motifAdmissionTable = $sm->get ( 'Consultation\Model\MotifAdmissionTable' );
		}
		return $this->motifAdmissionTable;
	}
	public function getRvPatientConsTable() {
		if (! $this->rvPatientConsTable) {
			$sm = $this->getServiceLocator ();
			$this->rvPatientConsTable = $sm->get ( 'Consultation\Model\RvPatientConsTable' );
		}
		return $this->rvPatientConsTable;
	}
	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Archivage\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	public function getHopitalTable() {
		if (! $this->hopitalTable) {
			$sm = $this->getServiceLocator ();
			$this->hopitalTable = $sm->get ( 'Personnel\Model\HopitalTable' );
		}
		return $this->hopitalTable;
	}
	public function getTransfererPatientServiceTable() {
		if (! $this->transfererPatientServiceTable) {
			$sm = $this->getServiceLocator ();
			$this->transfererPatientServiceTable = $sm->get ( 'Archivage\Model\TransfererPatientServiceTable' );
		}
		return $this->transfererPatientServiceTable;
	}
	public function getConsommableTable() {
		if (! $this->consommableTable) {
			$sm = $this->getServiceLocator ();
			$this->consommableTable = $sm->get ( 'Pharmacie\Model\ConsommableTable' );
		}
		return $this->consommableTable;
	}
	public function getDonneesExamensPhysiquesTable() {
		if (! $this->donneesExamensPhysiquesTable) {
			$sm = $this->getServiceLocator ();
			$this->donneesExamensPhysiquesTable = $sm->get ( 'Consultation\Model\DonneesExamensPhysiquesTable' );
		}
		return $this->donneesExamensPhysiquesTable;
	}
	public function getDiagnosticsTable() {
		if (! $this->diagnosticsTable) {
			$sm = $this->getServiceLocator ();
			$this->diagnosticsTable = $sm->get ( 'Consultation\Model\DiagnosticsTable' );
		}
		return $this->diagnosticsTable;
	}
	public function getOrdonnanceTable() {
		if (! $this->ordonnanceTable) {
			$sm = $this->getServiceLocator ();
			$this->ordonnanceTable = $sm->get ( 'Consultation\Model\OrdonnanceTable' );
		}
		return $this->ordonnanceTable;
	}
	public function getDemandeVisitePreanesthesiqueTable() {
		if (! $this->demandeVisitePreanesthesiqueTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeVisitePreanesthesiqueTable = $sm->get ( 'Consultation\Model\DemandeVisitePreanesthesiqueTable' );
		}
		return $this->demandeVisitePreanesthesiqueTable;
	}
	public function getNotesExamensMorphologiquesTable() {
		if (! $this->notesExamensMorphologiquesTable) {
			$sm = $this->getServiceLocator ();
			$this->notesExamensMorphologiquesTable = $sm->get ( 'Consultation\Model\NotesExamensMorphologiquesTable' );
		}
		return $this->notesExamensMorphologiquesTable;
	}
	public function demandeExamensTable() {
		if (! $this->demandeExamensTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeExamensTable = $sm->get ( 'Consultation\Model\DemandeTable' );
		}
		return $this->demandeExamensTable;
	}
	public function getOrdonConsommableTable() {
		if (! $this->ordonConsommableTable) {
			$sm = $this->getServiceLocator ();
			$this->ordonConsommableTable = $sm->get ( 'Consultation\Model\OrdonConsommableTable' );
		}
		return $this->ordonConsommableTable;
	}
	public function getAntecedantPersonnelTable() {
		if (! $this->antecedantPersonnelTable) {
			$sm = $this->getServiceLocator ();
			$this->antecedantPersonnelTable = $sm->get ( 'Consultation\Model\AntecedentPersonnelTable' );
		}
		return $this->antecedantPersonnelTable;
	}
	
	public function getAntecedantsFamiliauxTable() {
		if (! $this->antecedantsFamiliauxTable) {
			$sm = $this->getServiceLocator ();
			$this->antecedantsFamiliauxTable = $sm->get ( 'Consultation\Model\AntecedentsFamiliauxTable' );
		}
		return $this->antecedantsFamiliauxTable;
	}
	
	public function getDemandeHospitalisationTable() {
		if (! $this->demandeHospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->demandeHospitalisationTable = $sm->get ( 'Archivage\Model\DemandehospitalisationTable' );
		}
		return $this->demandeHospitalisationTable;
	}
	
	/*POUR LA GESTION DES HOSPITALISATIONS*/
	public function getSoinHospitalisationTable() {
		if (! $this->soinhospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->soinhospitalisationTable = $sm->get ( 'Consultation\Model\SoinhospitalisationTable' );
		}
		return $this->soinhospitalisationTable;
	}
	
	public function getSoinsTable() {
		if (! $this->soinsTable) {
			$sm = $this->getServiceLocator ();
			$this->soinsTable = $sm->get ( 'Consultation\Model\SoinsTable' );
		}
		return $this->soinsTable;
	}
	
	public function getHospitalisationTable() {
		if (! $this->hospitalisationTable) {
			$sm = $this->getServiceLocator ();
			$this->hospitalisationTable = $sm->get ( 'Archivage\Model\HospitalisationTable' );
		}
		return $this->hospitalisationTable;
	}
	
	public function getHospitalisationlitTable() {
		if (! $this->hospitalisationlitTable) {
			$sm = $this->getServiceLocator ();
			$this->hospitalisationlitTable = $sm->get ( 'Archivage\Model\HospitalisationlitTable' );
		}
		return $this->hospitalisationlitTable;
	}
	
	public function getLitTable() {
		if (! $this->litTable) {
			$sm = $this->getServiceLocator ();
			$this->litTable = $sm->get ( 'Archivage\Model\LitTable' );
		}
		return $this->litTable;
	}
	
	public function getSalleTable() {
		if (! $this->salleTable) {
			$sm = $this->getServiceLocator ();
			$this->salleTable = $sm->get ( 'Archivage\Model\SalleTable' );
		}
		return $this->salleTable;
	}
	
	public function getBatimentTable() {
		if (! $this->batimentTable) {
			$sm = $this->getServiceLocator ();
			$this->batimentTable = $sm->get ( 'Archivage\Model\BatimentTable' );
		}
		return $this->batimentTable;
	}
	
	public function getSoinHospitalisation4Table() {
		if (! $this->soinhospitalisation4Table) {
			$sm = $this->getServiceLocator ();
			$this->soinhospitalisation4Table = $sm->get ( 'Consultation\Model\Soinhospitalisation4Table' );
		}
		return $this->soinhospitalisation4Table;
	}
	
	public function getResultatVpa() {
		if (! $this->resultatVpaTable) {
			$sm = $this->getServiceLocator ();
			$this->resultatVpaTable = $sm->get ( 'Consultation\Model\ResultatVisitePreanesthesiqueTable' );
		}
		return $this->resultatVpaTable;
	}
	/**
	 * =========================================================================
	 * =========================================================================
	 * =========================================================================
	 */
	protected $utilisateurTable;
	
	public function getUtilisateurTable(){
		if(!$this->utilisateurTable){
			$sm = $this->getServiceLocator();
			$this->utilisateurTable = $sm->get('Admin\Model\UtilisateursTable');
		}
		return $this->utilisateurTable;
	}
	
	public function user(){
		$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
		$username = $uAuth->getAuthService()->getIdentity();
		$user = $this->getUtilisateurTable()->getUtilisateursWithUsername($username);
		
		return $user;
	}
	
	/**
	 * =========================================================================
	 * ==================== FACTURATION ----- FACTURATION ======================
	 * =========================================================================
	 */
	protected $tarifConsultationTable;
	protected $facturationTable;
	
	public function getTarifConsultationTable() {
		if (! $this->tarifConsultationTable) {
			$sm = $this->getServiceLocator ();
			$this->tarifConsultationTable = $sm->get ( 'Archivage\Model\TarifConsultationTable' );
		}
		return $this->tarifConsultationTable;
	}
	
	public function getFacturationTable() {
		if (! $this->facturationTable) {
			$sm = $this->getServiceLocator ();
			$this->facturationTable = $sm->get ( 'Archivage\Model\FacturationTable' );
		}
		return $this->facturationTable;
	}
	
	/**
	 * =========================================================================
	 * ================== HSOPITALISATION ----- HSOPITALISATION ================
	 * =========================================================================
	 */
	protected $soinhospitalisation3Table;
	
	public function getSoinHospitalisation3Table() {
		if (! $this->soinhospitalisation3Table) {
			$sm = $this->getServiceLocator ();
			$this->soinhospitalisation3Table = $sm->get ( 'Archivage\Model\Soinhospitalisation3Table' );
		}
		return $this->soinhospitalisation3Table;
	}
	
/***
 * *********************************************************************************************************************************
 * *********************************************************************************************************************************
 * *********************************************************************************************************************************
 */	
	
	public function  getDateHelper(){
		$this->controlDate = new DateHelper();
	}
	
	/**
	 * ARCHIVAGE ARCHIVAGE ARCHIVAGE
	 */
	public function consulterAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$service = $this->layout ()->service;
	
		$serviceTable = $this->getServiceTable ();
		$LigneDuService = $serviceTable->getServiceParNom ( $service );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
	
		$patients = $this->getPatientTable ();
		$lespatients = $patients->listePatientsConsParMedecin ( $IdDuService );
	
		//RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $this->getPatientTable ()->getPatientsRV($IdDuService);
	
		return new ViewModel ( array (
				'LeService' => $service,
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV,
		) );
	}
	
	/**
	 * ARCHIVAGE ARCHIVAGE ARCHIVAGE
	 */
	public function consultationAction() {
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
	
		$user = $this->layout()->user;
		$id_medecin = $user->id_personne; 
	
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$id_facturation_patient = $this->params ()->fromQuery ( 'id_fact_patient', 0 );

		$fact_patient = $this->getPatientTable ()->facturationPatient ( $id_facturation_patient );
		$id_pat = $fact_patient['id_patient'];
		
		$consommable = $this->getConsommableTable();
		$listeMedicament = $consommable->listeDeTousLesMedicaments();
		$listeForme = $consommable->formesMedicaments();
		$listetypeQuantiteMedicament = $consommable->typeQuantiteMedicaments();
	
		$detailInfoPatient = $this->getPatientTable ()->getPatient ( $id_pat );
	
		// Recuperer la photo du patient
		$image = $this->getPatientTable ()->getPhoto ( $id_pat );
	
		$form = new ConsultationForm ();
	
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		$listeConsultation = $this->getConsultationTable ()->getConsultationPatient($id_pat);
	
		// instanciation du model transfert
		$transferer = $this->getTransfererPatientServiceTable ();
		// recuperation de la liste des hopitaux
		$hopital = $transferer->fetchHopital ();
		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		// RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
	
		// LISTE DES SERVICES DE L'HOPITAL
		$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	
		// liste des heures rv
		$heure_rv = array (
				'08:00' => '08:00',
				'09:00' => '09:00',
				'10:00' => '10:00',
				'15:00' => '15:00',
				'16:00' => '16:00'
		);
		$form->get ( 'heure_rv' )->setValueOptions ( $heure_rv );
	
		$id_cons = 'arch_'. $id_pat.'_'.$id_facturation_patient;
		$data = array (
				'id_cons' => $id_cons,
				'id_medecin' => $id_medecin,
				'id_patient' => $id_pat,
				'hopital_accueil' => $idHopital,
				'dateonly' =>  $fact_patient['date_cons'],
				'id_facturation' => $id_facturation_patient,
		);
		
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux  = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		
		$form->populateValues ( array_merge($data,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
		return array (
				'lesdetails' => $detailInfoPatient,
				'id_cons' => $id_cons,
				'nbMotifs' => 1,
				'image' => $image,
				'form' => $form,
				'dateBasVue' => $fact_patient['date_cons'],
				'liste_med' => $listeMedicament,
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
				'temoin' => 0,
		);
	}
	
	/**
	 * ARCHIVAGE ARCHIVAGE ARCHIVAGE
	 */
	public function updateComplementConsultationAction(){
		
		$this->getDateHelper();
		$id_cons = $this->params()->fromPost('id_cons');
		$id_facturation = $this->params()->fromPost('id_facturation');
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		//var_dump($id_facturation); exit();
		$user = $this->layout()->user;
		$id_medecin = $user->id_personne;
	
		//**********-- MODIFICATION DES CONSTANTES --********
		//**********-- MODIFICATION DES CONSTANTES --********
		//**********-- MODIFICATION DES CONSTANTES --********
		$form = new ConsultationForm ();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
	
		// instancier Consultation
		$consultation = $this->getConsultationTable ();
		$consultation->addConsultation ( $form, $IdDuService, $id_medecin );
		
		// mettre a jour les motifs d'admission
		$this->getMotifAdmissionTable ()->deleteMotifAdmission ( $id_cons );
		$this->getMotifAdmissionTable ()->addMotifAdmission ( $form );
	
		//Recuperer les donnees sur les bandelettes urinaires
		//Recuperer les donnees sur les bandelettes urinaires
		$bandelettes = array(
				'id_cons' => $id_cons,
				'albumine' => $this->params()->fromPost('albumine'),
				'sucre' => $this->params()->fromPost('sucre'),
				'corpscetonique' => $this->params()->fromPost('corpscetonique'),
				'croixalbumine' => $this->params()->fromPost('croixalbumine'),
				'croixsucre' => $this->params()->fromPost('croixsucre'),
				'croixcorpscetonique' => $this->params()->fromPost('croixcorpscetonique'),
		);
		
		//mettre a jour les bandelettes urinaires
		$this->getConsultationTable ()->deleteBandelette($id_cons);
		$this->getConsultationTable ()->addBandelette($bandelettes);
	
	
		//POUR LES EXAMENS PHYSIQUES
		//POUR LES EXAMENS PHYSIQUES
		//POUR LES EXAMENS PHYSIQUES
		$info_donnees_examen_physique = array(
				'id_cons' => $id_cons,
				'donnee1' => $this->params()->fromPost('examen_donnee1'),
				'donnee2' => $this->params()->fromPost('examen_donnee2'),
				'donnee3' => $this->params()->fromPost('examen_donnee3'),
				'donnee4' => $this->params()->fromPost('examen_donnee4'),
				'donnee5' => $this->params()->fromPost('examen_donnee5')
		);
		$this->getDonneesExamensPhysiquesTable()->updateExamenPhysique($info_donnees_examen_physique);
	
		//POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		//POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		//POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
		$donneesDesAntecedents = array(
				//**=== ANTECEDENTS PERSONNELS
				//**=== ANTECEDENTS PERSONNELS
				//LES HABITUDES DE VIE DU PATIENTS
				/*Alcoolique*/
				'AlcooliqueHV' => $this->params()->fromPost('AlcooliqueHV'),
				'DateDebutAlcooliqueHV' => $this->params()->fromPost('DateDebutAlcooliqueHV'),
				'DateFinAlcooliqueHV' => $this->params()->fromPost('DateFinAlcooliqueHV'),
				/*Fumeur*/
				'FumeurHV' => $this->params()->fromPost('FumeurHV'),
				'DateDebutFumeurHV' => $this->params()->fromPost('DateDebutFumeurHV'),
				'DateFinFumeurHV' => $this->params()->fromPost('DateFinFumeurHV'),
				'nbPaquetFumeurHV' => $this->params()->fromPost('nbPaquetFumeurHV'),
				/*Droguer*/
				'DroguerHV' => $this->params()->fromPost('DroguerHV'),
				'DateDebutDroguerHV' => $this->params()->fromPost('DateDebutDroguerHV'),
				'DateFinDroguerHV' => $this->params()->fromPost('DateFinDroguerHV'),
				 
				//LES ANTECEDENTS MEDICAUX
		'DiabeteAM' => $this->params()->fromPost('DiabeteAM'),
		'htaAM' => $this->params()->fromPost('htaAM'),
		'drepanocytoseAM' => $this->params()->fromPost('drepanocytoseAM'),
		'dislipidemieAM' => $this->params()->fromPost('dislipidemieAM'),
		'asthmeAM' => $this->params()->fromPost('asthmeAM'),
		 
		//GYNECO-OBSTETRIQUE
		/*Menarche*/
		'MenarcheGO' => $this->params()->fromPost('MenarcheGO'),
		'NoteMenarcheGO' => $this->params()->fromPost('NoteMenarcheGO'),
		/*Gestite*/
		'GestiteGO' => $this->params()->fromPost('GestiteGO'),
		'NoteGestiteGO' => $this->params()->fromPost('NoteGestiteGO'),
		/*Parite*/
		'PariteGO' => $this->params()->fromPost('PariteGO'),
		'NotePariteGO' => $this->params()->fromPost('NotePariteGO'),
		/*Cycle*/
		'CycleGO' => $this->params()->fromPost('CycleGO'),
		'DureeCycleGO' => $this->params()->fromPost('DureeCycleGO'),
		'RegulariteCycleGO' => $this->params()->fromPost('RegulariteCycleGO'),
		'DysmenorrheeCycleGO' => $this->params()->fromPost('DysmenorrheeCycleGO'),
		 
		//**=== ANTECEDENTS FAMILIAUX
		//**=== ANTECEDENTS FAMILIAUX
		'DiabeteAF' => $this->params()->fromPost('DiabeteAF'),
		'NoteDiabeteAF' => $this->params()->fromPost('NoteDiabeteAF'),
		'DrepanocytoseAF' => $this->params()->fromPost('DrepanocytoseAF'),
		'NoteDrepanocytoseAF' => $this->params()->fromPost('NoteDrepanocytoseAF'),
		'htaAF' => $this->params()->fromPost('htaAF'),
		'NoteHtaAF' => $this->params()->fromPost('NoteHtaAF'),
		);
		 
		$id_personne = $this->getAntecedantPersonnelTable()->getIdPersonneParIdCons($id_cons);
		$this->getAntecedantPersonnelTable()->addAntecedentsPersonnels($donneesDesAntecedents, $id_personne);
		$this->getAntecedantsFamiliauxTable()->addAntecedentsFamiliaux($donneesDesAntecedents, $id_personne);
		 
		//var_dump($id_personne); exit();
		//POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		//POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		//POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
	
		$info_examen_morphologique = array(
				'id_cons'=> $id_cons,
				'8'  => $this->params()->fromPost('radio_'),
				'9'  => $this->params()->fromPost('ecographie_'),
				'12' => $this->params()->fromPost('irm_'),
				'11' => $this->params()->fromPost('scanner_'),
				'10' => $this->params()->fromPost('fibroscopie_'),
		);
	
		$examensMorphologiques = $this->getNotesExamensMorphologiquesTable();
		$examensMorphologiques->updateNotesExamensMorphologiques($info_examen_morphologique);
	
		//POUR LES DIAGNOSTICS
		//POUR LES DIAGNOSTICS
		//POUR LES DIAGNOSTICS
	
		$info_diagnostics = array(
				'id_cons' => $id_cons,
				'diagnostic1' => $this->params()->fromPost('diagnostic1'),
				'diagnostic2' => $this->params()->fromPost('diagnostic2'),
				'diagnostic3' => $this->params()->fromPost('diagnostic3'),
				'diagnostic4' => $this->params()->fromPost('diagnostic4'),
		);
	
		$diagnostics = $this->getDiagnosticsTable();
		$diagnostics->updateDiagnostics($info_diagnostics);
	
		//POUR LES TRAITEMENTS
		//POUR LES TRAITEMENTS
		//POUR LES TRAITEMENTS
		/**** MEDICAUX ****/
		/**** MEDICAUX ****/
		$dureeTraitement = $this->params()->fromPost('duree_traitement_ord');
		$donnees = array('id_cons' => $id_cons, 'duree_traitement' => $dureeTraitement);
	
		$Consommable = $this->getOrdonConsommableTable();
		$tab = array();
		$j = 1;
		for($i = 1 ; $i < 10 ; $i++ ){
			if($this->params()->fromPost("medicament_0".$i)){
				$tab[$j++] = $Consommable->getMedicamentByName($this->params()->fromPost("medicament_0".$i))['ID_MATERIEL'];
				$tab[$j++] = $this->params()->fromPost("forme_".$i);
				$tab[$j++] = $this->params()->fromPost("nb_medicament_".$i);
				$tab[$j++] = $this->params()->fromPost("quantite_".$i);
			}
		}
	
	
		/*Mettre a jour la duree du traitement de l'ordonnance*/
		$Ordonnance = $this->getOrdonnanceTable();
		$idOrdonnance = $Ordonnance->updateOrdonnance($tab, $donnees);
	
		/*Mettre a jour les medicaments*/
		$resultat = $Consommable->updateOrdonConsommable($tab, $idOrdonnance);
	
		/*si aucun médicament n'est ajouté ($resultat = false) on supprime l'ordonnance*/
		if($resultat == false){ $Ordonnance->deleteOrdonnance($idOrdonnance);}
	
		/**** CHIRURGICAUX ****/
		/**** CHIRURGICAUX ****/
		/**** CHIRURGICAUX ****/
		$infoDemande = array(
				'diagnostic' => $this->params()->fromPost("diagnostic_traitement_chirurgical"),
				'intervention_prevue' => $this->params()->fromPost("intervention_prevue"),
				'observation' => $this->params()->fromPost("observation"),
				'ID_CONS'=>$id_cons
		);
	
		$DemandeVPA = $this->getDemandeVisitePreanesthesiqueTable();
		$DemandeVPA->updateDemandeVisitePreanesthesique($infoDemande);
	
		//POUR LES RENDEZ VOUS
		//POUR LES RENDEZ VOUS
		//POUR LES RENDEZ VOUS
		$id_patient = $this->params()->fromPost('id_patient');
		$date_RV_Recu = $this->params()->fromPost('date_rv');
		if($date_RV_Recu){
			$date_RV = $this->controlDate->convertDateInAnglais($date_RV_Recu);}
			else{
				$date_RV = $date_RV_Recu;
			}
			$infos_rv = array(
					'ID_PERSONNE' => $id_patient,
					'ID_SERVICE'  => $IdDuService,
					'ID_CONS'     => $id_cons,
					'date'     => $date_RV,
					'NOTE'  => $this->params()->fromPost('motif_rv'),
					'heure'    => $this->params()->fromPost('heure_rv')
			);
			$rendezvous = $this->getRvPatientConsTable();
			$rendezvous->updateRendezVous($infos_rv);
	
			//POUR LES TRANSFERT
			//POUR LES TRANSFERT
			//POUR LES TRANSFERT
			$info_transfert = array(
					'ID_SERVICE'      => $this->params()->fromPost('id_service'),
					'ID_PERSONNE'     => $id_patient,
					'MED_ID_PERSONNE' => $this->params()->fromPost('med_id_personne'),
					'DATE'            => $this->params()->fromPost('date'),
					'motif_transfert' => $this->params()->fromPost('motif_transfert'),
					'ID_CONS' => $id_cons
			);
			$transfert = $this->getTransfererPatientServiceTable();
			$transfert->updateTransfertPatientService($info_transfert);
	
			//POUR LES HOSPITALISATION
			//POUR LES HOSPITALISATION
			//POUR LES HOSPITALISATION
			$today = new \DateTime ();
			$dateAujourdhui = $today->format ( 'Y-m-d H:i:s' );
			$this->getDateHelper();
			$infoDemandeHospitalisation = array(
					'motif_demande_hospi' => $this->params()->fromPost('motif_hospitalisation'),
					'date_demande_hospi' => $dateAujourdhui,
					'date_fin_prevue_hospi' => $this->controlDate->convertDateInAnglais($this->params()->fromPost('date_fin_hospitalisation_prevue')),
					'id_cons' => $id_cons,
			);
	
			$this->getDemandeHospitalisationTable()->saveDemandehospitalisation($infoDemandeHospitalisation);
			//var_dump($infoDemandeHospitalisation); exit();
			//POUR LA PAGE complement-consultation
			//POUR LA PAGE complement-consultation
			//POUR LA PAGE complement-consultation
			if ($this->params ()->fromPost ( 'terminer' ) == 'save') {
	
				//VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
				//Ajouter l'id du medecin ayant consulter le patient
				$valide = array (
						'valide' => 1,
						'id_cons' => $id_cons,
						'id_personne' => $this->params()->fromPost('med_id_personne')
				);
				$this->getConsultationTable ()->validerConsultation ( $valide );
				$this->getConsultationTable ()->validerFacturation ( $id_facturation );
				
			}
	
			return $this->redirect ()->toRoute ( 'archivage', array (
					'action' => 'liste-consultation'
			) );
	}
	
	public function listeConsultationAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$service = $this->layout ()->service;
	
		$tab =  $this->getPatientTable ()->listePatientsConsMedecin ( $service );
		return new ViewModel ( array (
				'donnees' => $tab
		) );
	}
	
	public function visualisationConsultationAction() {

		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$this->getDateHelper();
		$id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
		$id = $this->params()->fromQuery ( 'id_cons' );
		$form = new ConsultationForm();
			
		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );
		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );
			
		//GESTION DES ALERTES
		//GESTION DES ALERTES
		//GESTION DES ALERTES
		$patient = $this->getPatientTable ();
		//RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $patient->getPatientsRV($IdDuService);
		$resultRV = null;
		if(array_key_exists($id_pat, $tabPatientRV)){
			$resultRV = $tabPatientRV[ $id_pat ];
		}
			
		//POUR LES CONSTANTES
		//POUR LES CONSTANTES
		//POUR LES CONSTANTES
		$cons = $this->getConsultationTable ();
		$consult = $cons->getConsult ( $id );
		
		$data = array (
				'id_cons' => $consult->id_cons,
				'id_medecin' => $consult->id_personne,
				'id_patient' => $consult->pat_id_personne,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
				'temperature' => $consult->temperature,
				'pressionarterielle' => $consult->pression_arterielle,
				'pouls' => $consult->pouls,
				'frequence_respiratoire' => $consult->frequence_respiratoire,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
		);
		
		//POUR LES MOTIFS D'ADMISSION
		//POUR LES MOTIFS D'ADMISSION
		//POUR LES MOTIFS D'ADMISSION
		// instancier le motif d'admission et recupï¿½rer l'enregistrement
		$motif = $this->getMotifAdmissionTable ();
		$motif_admission = $motif->getMotifAdmission ( $id );
		$nbMotif = $motif->nbMotifs ( $id );
		//POUR LES MOTIFS D'ADMISSION
		$k = 1;
		foreach ( $motif_admission as $Motifs ) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k ++;
		}
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES
		//instancier les donnï¿½es de l'examen physique
		$examen = $this->getDonneesExamensPhysiquesTable();
		$examen_physique = $examen->getExamensPhysiques($id);
		//POUR LES EXAMEN PHYSIQUES
		$kPhysique = 1;
		foreach ($examen_physique as $Examen) {
			$data['examen_donnee'.$kPhysique] = $Examen['libelle_examen'];
			$kPhysique++;
		}
		
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		$listeConsultation = $cons->getConsultationPatient($id_pat);
		
		//POUR LES EXAMENS COMPLEMENTAIRES
		//POUR LES EXAMENS COMPLEMENTAIRES
		//POUR LES EXAMENS COMPLEMENTAIRES
		// DEMANDES DES EXAMENS COMPLEMENTAIRES
		$demandeExamen = $this->demandeExamensTable();
		$listeDemandesMorphologiques = $demandeExamen->getDemandeExamensMorphologiques($id);
		$listeDemandesBiologiques = $demandeExamen->getDemandeExamensBiologiques($id);
		
		////RESULTATS DES EXAMENS BIOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
		$listeDemandesBiologiquesEffectuerEnvoyer = $demandeExamen->getDemandeExamensBiologiquesEffectuesEnvoyer($id);
		$listeDemandesBiologiquesEffectuer = $demandeExamen->getDemandeExamensBiologiquesEffectues($id);
		
		foreach ($listeDemandesBiologiquesEffectuerEnvoyer as $listeExamenBioEffectues){
			if($listeExamenBioEffectues['idExamen'] == 1){
				$data['groupe_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 2){
				$data['hemogramme_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 3){
				$data['bilan_hepatique'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 4){
				$data['bilan_renal'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 5){
				$data['bilan_hemolyse'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 6){
				$data['bilan_inflammatoire'] =  $listeExamenBioEffectues['noteResultat'];
			}
		}
		
		////RESULTATS DES EXAMENS MORPHOLOGIQUE
		$resultatExamenMorphologique = $this->getNotesExamensMorphologiquesTable();
		$examen_morphologique = $resultatExamenMorphologique->getNotesExamensMorphologiques($id);
		
		$data['radio'] = $examen_morphologique['radio'];
		$data['ecographie'] = $examen_morphologique['ecographie'];
		$data['fibrocospie'] = $examen_morphologique['fibroscopie'];
		$data['scanner'] = $examen_morphologique['scanner'];
		$data['irm'] = $examen_morphologique['irm'];
		
		////RESULTATS DES EXAMENS MORPHOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
		$listeDemandesMorphologiquesEffectuer = $demandeExamen->getDemandeExamensMorphologiquesEffectues($id);
		
		//DIAGNOSTICS
		//DIAGNOSTICS
		//DIAGNOSTICS
		//instancier les donnï¿½es des diagnostics
		$diagnostics = $this->getDiagnosticsTable();
		$infoDiagnostics = $diagnostics->getDiagnostics($id);
		// POUR LES DIAGNOSTICS
		$k = 1;
		foreach ($infoDiagnostics as $diagnos){
			$data['diagnostic'.$k] = $diagnos['libelle_diagnostics'];
			$k++;
		}
		
		//TRAITEMENT (Ordonnance) *********************************************************
		//TRAITEMENT (Ordonnance) *********************************************************
		//TRAITEMENT (Ordonnance) *********************************************************
		
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		// INSTANCIATION DES MEDICAMENTS de l'ordonnance
		$consommable = $this->getConsommableTable();
		$listeMedicament = $consommable->listeDeTousLesMedicaments();
		$listeForme = $consommable->formesMedicaments();
		$listetypeQuantiteMedicament = $consommable->typeQuantiteMedicaments();
		
		// INSTANTIATION DE L'ORDONNANCE
		$ordonnance = $this->getOrdonnanceTable();
		$infoOrdonnance = $ordonnance->getOrdonnance($id); //on recupere l'id de l'ordonnance
		
		if($infoOrdonnance) {
			$idOrdonnance = $infoOrdonnance->id_document;
			$duree_traitement = $infoOrdonnance->duree_traitement;
		
			//LISTE DES MEDICAMENTS PRESCRITS
			$listeMedicamentsPrescrits = $ordonnance->getMedicamentsParIdOrdonnance($idOrdonnance);
			$nbMedPrescrit = $listeMedicamentsPrescrits->count();
		}else{
			$nbMedPrescrit = null;
			$listeMedicamentsPrescrits =null;
			$duree_traitement = null;
		}
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		$DemandeVPA = $this->getDemandeVisitePreanesthesiqueTable();
		$donneesDemandeVPA = $DemandeVPA->getDemandeVisitePreanesthesique($id);
		
		$resultatVpa = null;
		if($donneesDemandeVPA) {
			$data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
			$data['observation'] = $donneesDemandeVPA['OBSERVATION'];
			$data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
			 
			$resultatVpa = $this->getResultatVpa()->getResultatVpa($donneesDemandeVPA['idVpa']);
		}
		
		//POUR LE TRANSFERT
		//POUR LE TRANSFERT
		//POUR LE TRANSFERT
		// INSTANCIATION DU TRANSFERT
		$transferer = $this->getTransfererPatientServiceTable ();
		// RECUPERATION DE LA LISTE DES HOPITAUX
		$hopital = $transferer->fetchHopital ();
		//LISTE DES HOPITAUX
		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		// RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
		$transfertPatientService = $transferer->getServicePatientTransfert($id);
		
		if( $transfertPatientService ){
			$idService = $transfertPatientService['ID_SERVICE'];
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $transferer->getHopitalPatientTransfert($idService);
			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
			$serviceHopital = $transferer->fetchServiceWithHopital($idHopital);
		
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		
			// SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
			$data['hopital_accueil'] = $idHopital;
			$data['service_accueil'] = $idService;
			$data['motif_transfert'] = $transfertPatientService['motif_transfert'];
			$hopitalSelect = 1;
		}else {
			$hopitalSelect = 0;
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
			$data['hopital_accueil'] = $idHopital;
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
			$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		}
		//POUR LE RENDEZ VOUS
		//POUR LE RENDEZ VOUS
		//POUR LE RENDEZ VOUS
		// RECUPERE LE RENDEZ VOUS
		$rendezVous = $this->getRvPatientConsTable();
		$leRendezVous = $rendezVous->getRendezVous($id);
		
		if($leRendezVous) {
			$data['heure_rv'] = $leRendezVous->heure;
			$data['date_rv']  = $this->controlDate->convertDate($leRendezVous->date);
			$data['motif_rv'] = $leRendezVous->note;
		}
		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable ()->getBandelette($id);
		
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		
		//POUR LES DEMANDES D'HOSPITALISATION
		//POUR LES DEMANDES D'HOSPITALISATION
		//POUR LES DEMANDES D'HOSPITALISATION
		$donneesHospi = $this->getDemandeHospitalisationTable()->getDemandehospitalisationParIdcons($id);
		if($donneesHospi){
			$data['motif_hospitalisation'] = $donneesHospi->motif_demande_hospi;
			$data['date_fin_hospitalisation_prevue'] = $this->controlDate->convertDate($donneesHospi->date_fin_prevue_hospi);
		}
		$form->populateValues ( array_merge($data,$bandelettes,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
		return array(
				'id_cons' => $id,
				'lesdetails' => $liste,
				'form' => $form,
				'nbMotifs' => $nbMotif,
				'image' => $image,
				'heure_cons' => $consult->heurecons,
				'liste' => $listeConsultation,
				'liste_med' => $listeMedicament,
				'nb_med_prescrit' => $nbMedPrescrit,
				'liste_med_prescrit' => $listeMedicamentsPrescrits,
				'duree_traitement' => $duree_traitement,
				'verifieRV' => $leRendezVous,
				'listeDemandesMorphologiques' => $listeDemandesMorphologiques,
				'listeDemandesBiologiques' => $listeDemandesBiologiques,
				'hopitalSelect' =>$hopitalSelect,
				'nbDiagnostics'=> $infoDiagnostics->count(),
				'nbDonneesExamenPhysique' => $kPhysique,
				'dateonly' => $consult->dateonly,
				'temoin' => $bandelettes['temoin'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
				'resultRV' => $resultRV,
				'listeDemandesBioEff' => $listeDemandesBiologiquesEffectuer->count(),
				'listeDemandesMorphoEff' => $listeDemandesMorphologiquesEffectuer->count(),
				'resultatVpa' => $resultatVpa,
		);
		
	}
	
	
	public function visualiserConsultationAction(){
	
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
	
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$this->getDateHelper();
		$id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
		$id = $this->params()->fromQuery ( 'id_cons' );
		$form = new ConsultationForm();
			
		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );
		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );
			
		//POUR LES CONSTANTES
		//POUR LES CONSTANTES
		//POUR LES CONSTANTES
		$cons = $this->getConsultationTable ();
		$consult = $cons->getConsult ( $id );
	
		$data = array (
				'id_cons' => $consult->id_cons,
				'id_medecin' => $consult->id_personne,
				'id_patient' => $consult->pat_id_personne,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
				'temperature' => $consult->temperature,
				'pressionarterielle' => $consult->pression_arterielle,
				'pouls' => $consult->pouls,
				'frequence_respiratoire' => $consult->frequence_respiratoire,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
		);
	
		//POUR LES MOTIFS D'ADMISSION
		//POUR LES MOTIFS D'ADMISSION
		//POUR LES MOTIFS D'ADMISSION
		// instancier le motif d'admission et recupï¿½rer l'enregistrement
		$motif = $this->getMotifAdmissionTable ();
		$motif_admission = $motif->getMotifAdmission ( $id );
		$nbMotif = $motif->nbMotifs ( $id );
		//POUR LES MOTIFS D'ADMISSION
		$k = 1;
		foreach ( $motif_admission as $Motifs ) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k ++;
		}
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES
		//instancier les donnï¿½es de l'examen physique
		$examen = $this->getDonneesExamensPhysiquesTable();
		$examen_physique = $examen->getExamensPhysiques($id);
		//POUR LES EXAMEN PHYSIQUES
		$kPhysique = 1;
		foreach ($examen_physique as $Examen) {
			$data['examen_donnee'.$kPhysique] = $Examen['libelle_examen'];
			$kPhysique++;
		}
	
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		$listeConsultation = $cons->getConsultationPatient($id_pat);
	
		//POUR LES EXAMENS COMPLEMENTAIRES
		//POUR LES EXAMENS COMPLEMENTAIRES
		//POUR LES EXAMENS COMPLEMENTAIRES
		// DEMANDES DES EXAMENS COMPLEMENTAIRES
		$demandeExamen = $this->demandeExamensTable();
		$listeDemandesMorphologiques = $demandeExamen->getDemandeExamensMorphologiques($id);
		$listeDemandesBiologiques = $demandeExamen->getDemandeExamensBiologiques($id);
	
		////RESULTATS DES EXAMENS BIOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
		$listeDemandesBiologiquesEffectuerEnvoyer = $demandeExamen->getDemandeExamensBiologiquesEffectuesEnvoyer($id);
	
		foreach ($listeDemandesBiologiquesEffectuerEnvoyer as $listeExamenBioEffectues){
			if($listeExamenBioEffectues['idExamen'] == 1){
				$data['groupe_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 2){
				$data['hemogramme_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 3){
				$data['bilan_hepatique'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 4){
				$data['bilan_renal'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 5){
				$data['bilan_hemolyse'] =  $listeExamenBioEffectues['noteResultat'];
			}
			if($listeExamenBioEffectues['idExamen'] == 6){
				$data['bilan_inflammatoire'] =  $listeExamenBioEffectues['noteResultat'];
			}
		}
	
		// RESULTATS DES EXAMENS COMPLEMENTAIRES
		$resultatExamenMorphologique = $this->getNotesExamensMorphologiquesTable();
		$examen_morphologique = $resultatExamenMorphologique->getNotesExamensMorphologiques($id);
	
		$data['radio'] = $examen_morphologique['radio'];
		$data['ecographie'] = $examen_morphologique['ecographie'];
		$data['fibrocospie'] = $examen_morphologique['fibroscopie'];
		$data['scanner'] = $examen_morphologique['scanner'];
		$data['irm'] = $examen_morphologique['irm'];
	
		//DIAGNOSTICS
		//DIAGNOSTICS
		//DIAGNOSTICS
		//instancier les donnï¿½es des diagnostics
		$diagnostics = $this->getDiagnosticsTable();
		$infoDiagnostics = $diagnostics->getDiagnostics($id);
		// POUR LES DIAGNOSTICS
		$k = 1;
		foreach ($infoDiagnostics as $diagnos){
			$data['diagnostic'.$k] = $diagnos['libelle_diagnostics'];
			$k++;
		}
	
		//TRAITEMENT (Ordonnance) *********************************************************
		//TRAITEMENT (Ordonnance) *********************************************************
		//TRAITEMENT (Ordonnance) *********************************************************
	
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		//POUR LES MEDICAMENTS
		// INSTANCIATION DES MEDICAMENTS de l'ordonnance
		$consommable = $this->getConsommableTable();
		$listeMedicament = $consommable->listeDeTousLesMedicaments();
		$listeForme = $consommable->formesMedicaments();
		$listetypeQuantiteMedicament = $consommable->typeQuantiteMedicaments();
	
		// INSTANTIATION DE L'ORDONNANCE
		$ordonnance = $this->getOrdonnanceTable();
		$infoOrdonnance = $ordonnance->getOrdonnance($id); //on recupere l'id de l'ordonnance
	
		if($infoOrdonnance) {
			$idOrdonnance = $infoOrdonnance->id_document;
			$duree_traitement = $infoOrdonnance->duree_traitement;
	
			//LISTE DES MEDICAMENTS PRESCRITS
			$listeMedicamentsPrescrits = $ordonnance->getMedicamentsParIdOrdonnance($idOrdonnance);
			$nbMedPrescrit = $listeMedicamentsPrescrits->count();
		}else{
			$nbMedPrescrit = null;
			$listeMedicamentsPrescrits =null;
			$duree_traitement = null;
		}
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		//POUR LA DEMANDE PRE-ANESTHESIQUE
		$DemandeVPA = $this->getDemandeVisitePreanesthesiqueTable();
		$donneesDemandeVPA = $DemandeVPA->getDemandeVisitePreanesthesique($id);
		$resultatVpa = null;
		if($donneesDemandeVPA) {
			$data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
			$data['observation'] = $donneesDemandeVPA['OBSERVATION'];
			$data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
			 
			$resultatVpa = $this->getResultatVpa()->getResultatVpa($donneesDemandeVPA['idVpa']);
		}
	
		//POUR LE TRANSFERT
		//POUR LE TRANSFERT
		//POUR LE TRANSFERT
		// INSTANCIATION DU TRANSFERT
		$transferer = $this->getTransfererPatientServiceTable ();
		// RECUPERATION DE LA LISTE DES HOPITAUX
		$hopital = $transferer->fetchHopital ();
		//LISTE DES HOPITAUX
		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		// RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
		$transfertPatientService = $transferer->getServicePatientTransfert($id);
	
		if( $transfertPatientService ){
			$idService = $transfertPatientService['ID_SERVICE'];
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $transferer->getHopitalPatientTransfert($idService);
			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
			$serviceHopital = $transferer->fetchServiceWithHopital($idHopital);
	
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	
			// SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
			$data['hopital_accueil'] = $idHopital;
			$data['service_accueil'] = $idService;
			$data['motif_transfert'] = $transfertPatientService['motif_transfert'];
			$hopitalSelect = 1;
		}else {
			$hopitalSelect = 0;
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
			$idHopital = $transfertPatientHopital['ID_HOPITAL'];
			$data['hopital_accueil'] = $idHopital;
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
			$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		}
		//POUR LE RENDEZ VOUS
		//POUR LE RENDEZ VOUS
		//POUR LE RENDEZ VOUS
		// RECUPERE LE RENDEZ VOUS
		$rendezVous = $this->getRvPatientConsTable();
		$leRendezVous = $rendezVous->getRendezVous($id);
	
		if($leRendezVous) {
			$data['heure_rv'] = $leRendezVous->heure;
			$data['date_rv']  = $this->controlDate->convertDate($leRendezVous->date);
			$data['motif_rv'] = $leRendezVous->note;
		}
		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable ()->getBandelette($id);
	
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
	
		$form->populateValues ( array_merge($data,$bandelettes,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
		return array(
				'id_cons' => $id,
				'lesdetails' => $liste,
				'form' => $form,
				'nbMotifs' => $nbMotif,
				'image' => $image,
				'heure_cons' => $consult->heurecons,
				'liste' => $listeConsultation,
				'liste_med' => $listeMedicament,
				'nb_med_prescrit' => $nbMedPrescrit,
				'liste_med_prescrit' => $listeMedicamentsPrescrits,
				'duree_traitement' => $duree_traitement,
				'verifieRV' => $leRendezVous,
				'listeDemandesMorphologiques' => $listeDemandesMorphologiques,
				'listeDemandesBiologiques' => $listeDemandesBiologiques,
				'hopitalSelect' =>$hopitalSelect,
				'nbDiagnostics'=> $infoDiagnostics->count(),
				'nbDonneesExamenPhysique' => $kPhysique,
				'dateonly' => $consult->dateonly,
				'temoin' => $bandelettes['temoin'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
				'resultatVpa' => $resultatVpa,
		);
	
	}
	
	//******* Rï¿½cupï¿½rer les services correspondants en cliquant sur un hopital
	public function servicesAction()
	{
		$id=(int)$this->params()->fromPost ('id');
	
		if ($this->getRequest()->isPost()){
			$liste_select = "";
			$services= $this->getServiceTable();
			foreach($services->getServiceHopital($id) as $listeServices){
				$liste_select.= "<option value=".$listeServices['Id_service'].">".$listeServices['Nom_service']."</option>";
			}
				
			$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
			return $this->getResponse ()->setContent(Json::encode ( $liste_select));
		}
	
	}
	
	/***
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	 * *********************************************************************************************************************************
	* *********************************************************************************************************************************
	* *********************************************************************************************************************************
	
	*/
	

	public function majComplementConsultationAction() {

		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		 $this->layout ()->setTemplate ( 'layout/archivage' );
		 $this->getDateHelper(); 
		 $id_pat = $this->params()->fromQuery ( 'id_patient', 0 );
		 $id = $this->params()->fromQuery ( 'id_cons' );
		 $form = new ConsultationForm();
		 
		 $list = $this->getPatientTable ();
		 $liste = $list->getPatient ( $id_pat );
		 // Recuperer la photo du patient
		 $image = $list->getPhoto ( $id_pat );
		 
		 //GESTION DES ALERTES
		 //GESTION DES ALERTES
		 //GESTION DES ALERTES
		 $patient = $this->getPatientTable ();
		 //RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		 $tabPatientRV = $patient->getPatientsRV($IdDuService);
		 $resultRV = null;
		 if(array_key_exists($id_pat, $tabPatientRV)){
		 	$resultRV = $tabPatientRV[ $id_pat ];
		 }
		 
		 //POUR LES CONSTANTES
		 //POUR LES CONSTANTES
		 //POUR LES CONSTANTES
		  $cons = $this->getConsultationTable ();
		  $consult = $cons->getConsult ( $id );
		  
		  $data = array (
		 		'id_cons' => $consult->id_cons,
		 		'id_medecin' => $consult->id_personne,
		 		'id_patient' => $consult->pat_id_personne,
		 		'date_cons' => $consult->date,
		 		'poids' => $consult->poids,
		 		'taille' => $consult->taille,
		 		'temperature' => $consult->temperature,
		 		'pressionarterielle' => $consult->pression_arterielle,
		 		'pouls' => $consult->pouls,
		 		'frequence_respiratoire' => $consult->frequence_respiratoire,
		 		'glycemie_capillaire' => $consult->glycemie_capillaire,
		  );
		  
		  //POUR LES MOTIFS D'ADMISSION
		  //POUR LES MOTIFS D'ADMISSION
		  //POUR LES MOTIFS D'ADMISSION
		  // instancier le motif d'admission et recupï¿½rer l'enregistrement
		  $motif = $this->getMotifAdmissionTable ();
		  $motif_admission = $motif->getMotifAdmission ( $id );
		  $nbMotif = $motif->nbMotifs ( $id );
		  //POUR LES MOTIFS D'ADMISSION
		  $k = 1;
		  foreach ( $motif_admission as $Motifs ) {
		 	$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
		 	$k ++;
		  }
		  //POUR LES EXAMEN PHYSIQUES
		  //POUR LES EXAMEN PHYSIQUES
		  //POUR LES EXAMEN PHYSIQUES
		  //instancier les donnï¿½es de l'examen physique
		  $examen = $this->getDonneesExamensPhysiquesTable();
		  $examen_physique = $examen->getExamensPhysiques($id);
		  //POUR LES EXAMEN PHYSIQUES
		  $kPhysique = 1;
		  foreach ($examen_physique as $Examen) {
		  	$data['examen_donnee'.$kPhysique] = $Examen['libelle_examen'];
		  	$kPhysique++;
		  }
		  
		  // POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		  // POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		  // POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		  $listeConsultation = $cons->getConsultationPatient($id_pat);
		  
		  //POUR LES EXAMENS COMPLEMENTAIRES
		  //POUR LES EXAMENS COMPLEMENTAIRES
		  //POUR LES EXAMENS COMPLEMENTAIRES
		  // DEMANDES DES EXAMENS COMPLEMENTAIRES
		  $demandeExamen = $this->demandeExamensTable();
		  $listeDemandesMorphologiques = $demandeExamen->getDemandeExamensMorphologiques($id);
		  $listeDemandesBiologiques = $demandeExamen->getDemandeExamensBiologiques($id);
		  
		  ////RESULTATS DES EXAMENS BIOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
		  $listeDemandesBiologiquesEffectuerEnvoyer = $demandeExamen->getDemandeExamensBiologiquesEffectuesEnvoyer($id);
		  $listeDemandesBiologiquesEffectuer = $demandeExamen->getDemandeExamensBiologiquesEffectues($id);

		  foreach ($listeDemandesBiologiquesEffectuerEnvoyer as $listeExamenBioEffectues){
		  	if($listeExamenBioEffectues['idExamen'] == 1){
		  		$data['groupe_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
		  	}
		  	if($listeExamenBioEffectues['idExamen'] == 2){
		  		$data['hemogramme_sanguin'] =  $listeExamenBioEffectues['noteResultat'];
		  	}
		  	if($listeExamenBioEffectues['idExamen'] == 3){
		  		$data['bilan_hepatique'] =  $listeExamenBioEffectues['noteResultat'];
		  	}
		  	if($listeExamenBioEffectues['idExamen'] == 4){
		  		$data['bilan_renal'] =  $listeExamenBioEffectues['noteResultat'];
		  	}
		  	if($listeExamenBioEffectues['idExamen'] == 5){
		  		$data['bilan_hemolyse'] =  $listeExamenBioEffectues['noteResultat'];
		  	}
		  	if($listeExamenBioEffectues['idExamen'] == 6){
		  		$data['bilan_inflammatoire'] =  $listeExamenBioEffectues['noteResultat'];
		  	}
		  }
		  
		  ////RESULTATS DES EXAMENS MORPHOLOGIQUE
		  $resultatExamenMorphologique = $this->getNotesExamensMorphologiquesTable();
		  $examen_morphologique = $resultatExamenMorphologique->getNotesExamensMorphologiques($id);
		  
		  $data['radio'] = $examen_morphologique['radio'];
		  $data['ecographie'] = $examen_morphologique['ecographie'];
		  $data['fibrocospie'] = $examen_morphologique['fibroscopie'];
		  $data['scanner'] = $examen_morphologique['scanner'];
		  $data['irm'] = $examen_morphologique['irm'];
		  
		  ////RESULTATS DES EXAMENS MORPHOLOGIQUES DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
		  $listeDemandesMorphologiquesEffectuer = $demandeExamen->getDemandeExamensMorphologiquesEffectues($id);

		  //DIAGNOSTICS
		  //DIAGNOSTICS
		  //DIAGNOSTICS
		  //instancier les donnï¿½es des diagnostics
		  $diagnostics = $this->getDiagnosticsTable();
		  $infoDiagnostics = $diagnostics->getDiagnostics($id);
		  // POUR LES DIAGNOSTICS
		  $k = 1;
		  foreach ($infoDiagnostics as $diagnos){
		  	$data['diagnostic'.$k] = $diagnos['libelle_diagnostics'];
		  	$k++;
		  }
		  
		  //TRAITEMENT (Ordonnance) *********************************************************
		  //TRAITEMENT (Ordonnance) *********************************************************
		  //TRAITEMENT (Ordonnance) *********************************************************
		  
		  //POUR LES MEDICAMENTS
		  //POUR LES MEDICAMENTS
		  //POUR LES MEDICAMENTS
		  // INSTANCIATION DES MEDICAMENTS de l'ordonnance
		  $consommable = $this->getConsommableTable();
		  $listeMedicament = $consommable->listeDeTousLesMedicaments();
		  $listeForme = $consommable->formesMedicaments();
		  $listetypeQuantiteMedicament = $consommable->typeQuantiteMedicaments();

		  // INSTANTIATION DE L'ORDONNANCE
		  $ordonnance = $this->getOrdonnanceTable();
		  $infoOrdonnance = $ordonnance->getOrdonnance($id); //on recupere l'id de l'ordonnance
		  
		  if($infoOrdonnance) {
		  	$idOrdonnance = $infoOrdonnance->id_document; 
		  	$duree_traitement = $infoOrdonnance->duree_traitement;

		    //LISTE DES MEDICAMENTS PRESCRITS
		  	$listeMedicamentsPrescrits = $ordonnance->getMedicamentsParIdOrdonnance($idOrdonnance);
		  	$nbMedPrescrit = $listeMedicamentsPrescrits->count();
		  }else{
		  	$nbMedPrescrit = null;
		  	$listeMedicamentsPrescrits =null;
		  	$duree_traitement = null;
		  }
		  //POUR LA DEMANDE PRE-ANESTHESIQUE
		  //POUR LA DEMANDE PRE-ANESTHESIQUE
		  //POUR LA DEMANDE PRE-ANESTHESIQUE
		  $DemandeVPA = $this->getDemandeVisitePreanesthesiqueTable();
		  $donneesDemandeVPA = $DemandeVPA->getDemandeVisitePreanesthesique($id);
		  
		  $resultatVpa = null;
		  if($donneesDemandeVPA) {
		  	$data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
		  	$data['observation'] = $donneesDemandeVPA['OBSERVATION'];
		  	$data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
		  	
		  	$resultatVpa = $this->getResultatVpa()->getResultatVpa($donneesDemandeVPA['idVpa']);
		  }
		  
		  //POUR LE TRANSFERT
		  //POUR LE TRANSFERT
		  //POUR LE TRANSFERT
		  // INSTANCIATION DU TRANSFERT
		  $transferer = $this->getTransfererPatientServiceTable ();
		  // RECUPERATION DE LA LISTE DES HOPITAUX
		  $hopital = $transferer->fetchHopital ();
		  //LISTE DES HOPITAUX
		  $form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		  // RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
		  $transfertPatientService = $transferer->getServicePatientTransfert($id);
		  
		  if( $transfertPatientService ){
		  	$idService = $transfertPatientService['ID_SERVICE'];
		    // RECUPERATION DE L'HOPITAL DU SERVICE
		  	$transfertPatientHopital = $transferer->getHopitalPatientTransfert($idService);
		  	$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		    // RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
		  	$serviceHopital = $transferer->fetchServiceWithHopital($idHopital);

		  	// LISTE DES SERVICES DE L'HOPITAL
		  	$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		  
		    // SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
		  	$data['hopital_accueil'] = $idHopital;
		  	$data['service_accueil'] = $idService;
		  	$data['motif_transfert'] = $transfertPatientService['motif_transfert'];
		  	$hopitalSelect = 1;
		  }else {
		  	$hopitalSelect = 0;
		  	// RECUPERATION DE L'HOPITAL DU SERVICE
		  	$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
		  	$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		  	$data['hopital_accueil'] = $idHopital;
		  	// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		  	$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
		  	// LISTE DES SERVICES DE L'HOPITAL
		  	$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		  }
		  //POUR LE RENDEZ VOUS
		  //POUR LE RENDEZ VOUS
		  //POUR LE RENDEZ VOUS
		  // RECUPERE LE RENDEZ VOUS
		  $rendezVous = $this->getRvPatientConsTable();
		  $leRendezVous = $rendezVous->getRendezVous($id);
		  
		  if($leRendezVous) { 
		  	$data['heure_rv'] = $leRendezVous->heure;
		  	$data['date_rv']  = $this->controlDate->convertDate($leRendezVous->date);
		  	$data['motif_rv'] = $leRendezVous->note;
		  }
		  // Pour recuper les bandelettes
		  $bandelettes = $this->getConsultationTable ()->getBandelette($id);
		  
		  //RECUPERATION DES ANTECEDENTS
		  //RECUPERATION DES ANTECEDENTS
		  //RECUPERATION DES ANTECEDENTS
		  $donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		  $donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		  //FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		  //FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		  
		  //POUR LES DEMANDES D'HOSPITALISATION
		  //POUR LES DEMANDES D'HOSPITALISATION
		  //POUR LES DEMANDES D'HOSPITALISATION
		  $donneesHospi = $this->getDemandeHospitalisationTable()->getDemandehospitalisationParIdcons($id);
		  if($donneesHospi){
		  	$data['motif_hospitalisation'] = $donneesHospi->motif_demande_hospi;
		  	$data['date_fin_hospitalisation_prevue'] = $this->controlDate->convertDate($donneesHospi->date_fin_prevue_hospi);
		  }
		  $form->populateValues ( array_merge($data,$bandelettes,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
		  return array(
		 		'id_cons' => $id,
		 		'lesdetails' => $liste,
		 		'form' => $form,
		 		'nbMotifs' => $nbMotif,
		 		'image' => $image,
		 		'heure_cons' => $consult->heurecons,
		 		'liste' => $listeConsultation,
		  		'liste_med' => $listeMedicament,
		  		'nb_med_prescrit' => $nbMedPrescrit,
		  		'liste_med_prescrit' => $listeMedicamentsPrescrits,
		  		'duree_traitement' => $duree_traitement,
		  		'verifieRV' => $leRendezVous, 
		  		'listeDemandesMorphologiques' => $listeDemandesMorphologiques,
		  		'listeDemandesBiologiques' => $listeDemandesBiologiques,
		  		'hopitalSelect' =>$hopitalSelect,
		  		'nbDiagnostics'=> $infoDiagnostics->count(),
		  		'nbDonneesExamenPhysique' => $kPhysique,
		  		'dateonly' => $consult->dateonly,
		  		'temoin' => $bandelettes['temoin'],
		  		'listeForme' => $listeForme,
		  		'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
		  		'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
		  		'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
		  		'resultRV' => $resultRV,
		  		'listeDemandesBioEff' => $listeDemandesBiologiquesEffectuer->count(),
		  		'listeDemandesMorphoEff' => $listeDemandesMorphologiquesEffectuer->count(),
		  		'resultatVpa' => $resultatVpa,
		  );
	
	}
	
	//***-*-*-*-*-*-*-*-**-*-*-*-*--*-**-*-*-*-*-*-*-*--*--**-*-*-*-*-*-**-*-*-*--**-*-*-*-*-*--*-**-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-
	//***-**-*-*-*-*-**-*-*-*-*-*-*-*-*-*--**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*-**--*-**-*-*-
	
// 	public function impressionPdfAction(){
		
// 		//*************************************
// 		//*************************************
// 		//***DONNEES COMMUNES A TOUS LES PDF***
// 		//*************************************
// 		//*************************************
// 		$id_patient = $this->params ()->fromPost ( 'id_patient', 0 );
// 		$id_cons = $this->params ()->fromPost ( 'id_cons', 0 );
		
// 		//*************************************
// 		$infoServiceMedecin = $this->getConsultationTable();
// 		$values = $infoServiceMedecin->getInfoPatientMedecin($id_cons);
// 		foreach ($values as $val) {
// 			//Information sur le médecin
// 			$donneesMedecin['service'] = $val['NomService'];
// 			$donneesMedecin['nomMedecin'] = $val['NomMedecin'];
// 			$donneesMedecin['prenomMedecin'] = $val['PrenomMedecin'];
// 			//Information sur le patient
// 			$donneesPatient['nomPatient'] = $val['NOM'];
// 			$donneesPatient['prenomPatient'] = $val['PRENOM'];
// 			$donneesPatient['adressePatient'] = $val['ADRESSE'];
// 			$donneesPatient['dateNaissancePatient'] = $val['DATE_NAISSANCE'];
// 			$donneesPatient['sexePatient'] = $val['SEXE'];
// 		}
		
// 		//**********ORDONNANCE*****************
// 		//**********ORDONNANCE*****************
// 		//**********ORDONNANCE*****************
// 		if(isset($_POST['ordonnance'])){
// 			//RECUPERATION DE LA LISTE DES MEDICAMENTS
// 			$consommable = $this->getconsommableTable();
// 			//récupération de la liste des médicaments
// 			$medicaments = $consommable->fetchConsommable();
			
// 			$tab = array();
// 			$j = 1;
			
// 			//NOUVEAU CODE AVEC AUTOCOMPLETION 
// 			for($i = 1 ; $i < 10 ; $i++ ){
// 				$nomMedicament = $this->params()->fromPost("medicament_0".$i);
// 				if($nomMedicament == true){
// 					$tab[$j++] = $this->params()->fromPost("medicament_0".$i);
// 					$tab[$j++] = $this->params()->fromPost("forme_".$i);
// 					$tab[$j++] = $this->params()->fromPost("nb_medicament_".$i);
// 					$tab[$j++] = $this->params()->fromPost("quantite_".$i);
// 				}
// 			}
			
// 			$patient = $this->getPatientTable();
// 			$donneesPatientOR = $patient->getPatient($id_patient);
// 			//\Zend\Debug\Debug::dump($donneesPatient); exit();
// 			//-***************************************************************
// 			//Création du fichier pdf
// 			//*************************
// 			//Créer le document
// 			$DocPdf = new DocumentPdf();
// 			//Créer la page
// 			$page = new OrdonnancePdf();

// 			//Envoyer l'id_cons
// 			$page->setIdCons($id_cons);
// 			//Envoyer les données sur le partient
// 			$page->setDonneesPatient($donneesPatientOR);
// 			//Envoyer les médicaments
// 			$page->setMedicaments($tab);
			
// 			//Ajouter une note à la page
// 			$page->addNote();
// 			//Ajouter la page au document
// 			$DocPdf->addPage($page->getPage());

// 			//Afficher le document contenant la page
// 			$DocPdf->getDocument();
// 		}
// 		else
// 		//**********TRAITEMENT CHIRURGICAL*****************
// 		//**********TRAITEMENT CHIRURGICAL*****************
// 		//**********TRAITEMENT CHIRURGICAL*****************
// 		if(isset($_POST['traitement_chirurgical'])){
// 			//Récupération des données
// 			$donneesDemande['diagnostic'] = $this->params ()->fromPost ( 'diagnostic_traitement_chirurgical' );
// 			$donneesDemande['intervention_prevue'] = $this->params ()->fromPost (  'intervention_prevue' );
// 			$donneesDemande['observation'] = $this->params()->fromPost('observation');
			
// 			//var_dump($donneesDemande); exit();
			
// 			//CREATION DU DOCUMENT PDF
// 			//Créer le document
// 			$DocPdf = new DocumentPdf();
// 			//Créer la page
// 			$page = new TraitementChirurgicalPdf();
			
// 			//Envoi Id de la consultation
// 			$page->setIdConsTC($id_cons);
// 			//Envoi des données du patient
// 			$page->setDonneesPatientTC($donneesPatient);
// 			//Envoi des données du medecin
// 			$page->setDonneesMedecinTC($donneesMedecin);
// 			//Envoi les données de la demande
// 			$page->setDonneesDemandeTC($donneesDemande);
			
// 			//Ajouter les donnees a la page
// 			$page->addNoteTC();
// 			//Ajouter la page au document
// 			$DocPdf->addPage($page->getPage());
			
// 			//Afficher le document contenant la page
// 			$DocPdf->getDocument();
			
// 		}
// 		else 
// 		//**********TRANSFERT DU PATIENT*****************
// 		//**********TRANSFERT DU PATIENT*****************
// 		//**********TRANSFERT DU PATIENT*****************
// 			if (isset ($_POST['transfert']))
// 			{
// 				$id_hopital = $this->params()->fromPost('hopital_accueil_tampon');
// 				$id_service = $this->params()->fromPost('service_accueil_tampon');
// 				$motif_transfert = $this->params()->fromPost('motif_transfert');
		
// 				//Récupérer le nom du service d'accueil
//  				$service = $this->getServiceTable();
//  				$infoService = $service->getServiceparId($id_service);
//  				//Récupérer le nom de l'hopital d'accueil
//  				$hopital = $this->getHopitalTable();
//  				$infoHopital = $hopital->getHopitalParId($id_hopital);
 				
//  				$donneesDemandeT['NomService'] = $infoService['NOM'];
//  				$donneesDemandeT['NomHopital'] = $infoHopital['NOM_HOPITAL'];
//  				$donneesDemandeT['MotifTransfert'] = $motif_transfert;

// 				//-***************************************************************
// 				//Création du fichier pdf
			
// 				//-***************************************************************
//  				//Créer le document
//  				$DocPdf = new DocumentPdf();
//  				//Créer la page
//  				$page = new TransfertPdf();
 					
//  				//Envoi Id de la consultation
//  				$page->setIdConsT($id_cons);
//  				//Envoi des données du patient
//  				$page->setDonneesPatientT($donneesPatient);
//  				//Envoi des données du medecin
//  				$page->setDonneesMedecinT($donneesMedecin);
//  				//Envoi les données de la demande
//  				$page->setDonneesDemandeT($donneesDemandeT);
 					
//  				//Ajouter les donnees a la page
//  				$page->addNoteT();
//  				//Ajouter la page au document
//  				$DocPdf->addPage($page->getPage());
 					
//  				//Afficher le document contenant la page
//  				$DocPdf->getDocument();
// 			}
// 			else
// 			//**********RENDEZ VOUS ****************
// 			//**********RENDEZ VOUS ****************
// 			//**********RENDEZ VOUS ****************
// 			if(isset ($_POST['rendezvous'])){
					
// 				$donneesDemandeT['dateRv'] = $this->params()->fromPost('date_rv_tampon');
// 				$donneesDemandeT['heureRV']   = $this->params()->fromPost('heure_rv_tampon');
// 				$donneesDemandeT['MotifRV'] = $this->params()->fromPost('motif_rv');
				
// 				//\Zend\Debug\Debug::dump($note); exit();
// 				//Création du fichier pdf
// 				//Créer le document
// 				$DocPdf = new DocumentPdf();
// 				//Créer la page
// 				$page = new RendezVousPdf();
				
// 				//Envoi Id de la consultation
// 				$page->setIdConsR($id_cons);
// 				//Envoi des données du patient
// 				$page->setDonneesPatientR($donneesPatient);
// 				//Envoi des données du medecin
// 				$page->setDonneesMedecinR($donneesMedecin);
// 				//Envoi les données du redez vous
// 				$page->setDonneesDemandeR($donneesDemandeT);
				
// 				//Ajouter les donnees a la page
// 				$page->addNoteR();
// 				//Ajouter la page au document
// 				$DocPdf->addPage($page->getPage());
				
// 				//Afficher le document contenant la page
// 				$DocPdf->getDocument();
			
// 			}
// 			else
// 			//**********TRAITEMENT INSTRUMENTAL ****************
// 			//**********TRAITEMENT INSTRUMENTAL ****************
// 			//**********TRAITEMENT INSTRUMENTAL ****************
// 			if(isset ($_POST['traitement_instrumental'])){
// 					echo ('<span style="font-size: 20px; font-family: Times New Roman; font-weight: bold; color: green;">En cours de develppement "TRAITEMENT INSTRUMENTAL"</span>'); exit();
// 			}
// 			else 
// 				//**********HOSPITALISATION ****************
// 				//**********HOSPITALISATION ****************
// 				//**********HOSPITALISATION ****************
// 				if(isset ($_POST['hospitalisation'])){
// 					echo ('<span style="font-size: 20px; font-family: Times New Roman; font-weight: bold; color: green;">En cours de develppement "HOSPITALISATION" </span>'); exit();
// 				}
			
// 	}
	
	//********************************************************
	//********************************************************
	//********************************************************
	public function imagesExamensMorphologiquesAction()
	{
		$id_cons = $this->params()->fromPost( 'id_cons' );
		$ajout = (int)$this->params()->fromPost( 'ajout' );
		$idExamen = (int)$this->params()->fromPost( 'typeExamen' ); /*Le type d'examen*/
		$utilisateur = (int)$this->params()->fromPost( 'utilisateur' ); /* 1==radiologue sinon Medecin  */
		
		$user = $this->layout()->user;
		$id_personne = $user->id_personne; //Identité de l'utilisateur connecté
		
		/***
		 * INSERTION DE LA NOUVELLE IMAGE
		 */
		if($ajout == 1) {
			/***
			 * Enregistrement de l'image
			 * Enregistrement de l'image
			 * Enregistrement de l'image
			*/
			$today = new \DateTime ( 'now' );
			$nomImage = $today->format ( 'dmy_His' );
			if($idExamen == 8) { $nomImage = "radio_".$nomImage;}
			if($idExamen == 9) { $nomImage = "echographie_".$nomImage;}
			if($idExamen == 10) { $nomImage = "irm_".$nomImage;}
			if($idExamen == 11) { $nomImage = "scanner_".$nomImage;}
			if($idExamen == 12) { $nomImage = "fibroscopie_".$nomImage;}
			
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			
			$typeFichier = substr ( $fileBase64, 5, 5 );
			$formatFichier = substr ($fileBase64, 11, 4 );
			$fileBase64 = substr ( $fileBase64, 23 );
			
			if($utilisateur == 1){
				
				if($fileBase64 && $typeFichier == 'image' && $formatFichier =='jpeg'){
					$img = imagecreatefromstring(base64_decode($fileBase64));
					if($img){
						$resultatAjout = $this->demandeExamensTable()->ajouterImageMorpho($id_cons, $idExamen, $nomImage, $date_enregistrement, $id_personne);
					}
					if($resultatAjout){
						imagejpeg ( $img, 'C:\wamp\www\simens\public\images\images\\' . $nomImage . '.jpg' );
					}
				}
				
			}else {
				
				if($fileBase64 && $typeFichier == 'image' && $formatFichier =='jpeg'){
					$img = imagecreatefromstring(base64_decode($fileBase64));
					if($img){
						$resultatAjout = $this->demandeExamensTable()->ajouterImage($id_cons, $idExamen, $nomImage, $date_enregistrement, $id_personne);
					}
					if($resultatAjout){
						imagejpeg ( $img, 'C:\wamp\www\simens\public\images\images\\' . $nomImage . '.jpg' );
					}
				}
				
			}
			
		}
		
		/**
		 * RECUPERATION DE TOUS LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		 */
		if($utilisateur == 1){
			$result = $this->demandeExamensTable()->resultatExamensMorpho($id_cons);
		}else {
			$result = $this->demandeExamensTable()->resultatExamens($id_cons);
		}

		$radio = false;
		$echographie = false;
		$irm = false;
		$scanner = false;
		$fibroscopie = false;
		
		$html = "";
		$pickaChoose = "";
		
		if($result){
			foreach ($result as $resultat) {
				/**==========================**/
				/**Recuperer les images RADIO**/
				/**==========================**/
				if($resultat['idExamen'] == 8 && $idExamen == 8){
					$radio = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images ECHOGRAPHIE**/
				/**================================**/
				if($resultat['idExamen'] == 9 && $idExamen == 9){
					$echographie = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images IRM**/
				/**================================**/
				if($resultat['idExamen'] == 10 && $idExamen == 10){
					$irm = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images SCANNER**/
				/**================================**/
				if($resultat['idExamen'] == 11 && $idExamen == 11){
					$scanner = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				} else
				/**================================**/
				/**Recuperer les images FIBROSCOPIE**/
				/**================================**/
				if($resultat['idExamen'] == 12 && $idExamen == 12){
					$fibroscopie = true;
					$pickaChoose .=" <li><a href='../images/images/".$resultat['NomImage'].".jpg'><img src='../images/images/".$resultat['NomImage'].".jpg'/></a><span></span></li>";
				}
			}
		}

		if($radio) {
			$html ="<div id='pika2'>
				    <div class='pikachoose' style='height: 210px;'>
                      <ul id='pikame' class='jcarousel-skin-pika'>";
			$html .=$pickaChoose;
			$html .=" </ul>
                     </div>
				     </div>";

			$html.="<script>
					  $(function(){ $('.imageRadio').toggle(true);});
					  scriptExamenMorpho();
					</script>";
		} else 
			if($echographie) {
				$html ="<div id='pika4'>
				        <div class='pikachoose' style='height: 210px;'>
                          <ul id='pikameEchographie' class='jcarousel-skin-pika'>";
				$html .=$pickaChoose;
				$html .=" </ul>
                         </div>
				         </div>";
			
				$html.="<script>
						  $(function(){ $('.imageEchographie').toggle(true);});
					      scriptEchographieExamenMorpho();
					    </script>";
			} else 
				if($irm) {
					$html ="<div id='pika6'>
				             <div class='pikachoose' style='height: 210px;'>
                              <ul id='pikameIRM' class='jcarousel-skin-pika'>";
					$html .=$pickaChoose;
					$html .=" </ul>
                              </div>
				             </div>";
						
					$html.="<script>
						     $(function(){ $('.imageIRM').toggle(true);});
					         scriptIRMExamenMorpho();
					        </script>";
				} else 
					if($scanner) {
						$html ="<div id='pika8'>
				             <div class='pikachoose' style='height: 210px;'>
                              <ul id='pikameScanner' class='jcarousel-skin-pika'>";
						$html .=$pickaChoose;
						$html .=" </ul>
                              </div>
				             </div>";
					
						$html.="<script>
						     $(function(){ $('.imageScanner').toggle(true);});
					         scriptScannerExamenMorpho();
					        </script>";
					} else 
						if($fibroscopie) {
							$html ="<div id='pika10'>
				             <div class='pikachoose' style='height: 210px;'>
                              <ul id='pikameFibroscopie' class='jcarousel-skin-pika'>";
							$html .=$pickaChoose;
							$html .=" </ul>
                              </div>
				             </div>";
								
							$html.="<script>
						     $(function(){ $('.imageFibroscopie').toggle(true);});
					         scriptFibroscopieExamenMorpho();
					        </script>";
						}
		
						//$html .="<script> $(".$Responsable."); </script>";

		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( $html ));
	}
	
	
	//************************************************************************************
	//************************************************************************************
	//************************************************************************************
	public function supprimerImageAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$id = $this->params()->fromPost('id'); //numero de l'image dans le diapo
		$typeExamen = $this->params()->fromPost('typeExamen');

		/**
		 * RECUPERATION DE TOUS LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		 */
		$result = $this->demandeExamensTable()->recupererDonneesExamen($id_cons, $id, $typeExamen);
		/**
		 * SUPPRESSION PHYSIQUE DE L'IMAGE
		 */
		unlink ( 'C:\wamp\www\simens\public\images\images\\' . $result['NomImage'] . '.jpg' );
		/**
		 * SUPPRESSION DE L'IMAGE DANS LA BASE
		 */
		$this->demandeExamensTable()->supprimerImage($result['IdImage']);
		
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ( ));
	}
	
	/** POUR LES EXAMENS MORPHOLOGIQUES **/
	/** POUR LES EXAMENS MORPHOLOGIQUES **/
	/** POUR LES EXAMENS MORPHOLOGIQUES **/
	public function supprimerImageMorphoAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$id = $this->params()->fromPost('id'); //numero de l'image dans le diapo
		$typeExamen = $this->params()->fromPost('typeExamen');
	
		/**
		 * RECUPERATION DE TOUS LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		*/
		 $result = $this->demandeExamensTable()->recupererDonneesExamenMorpho($id_cons, $id, $typeExamen);
		/**
		 * SUPPRESSION PHYSIQUE DE L'IMAGE
		*/
		 unlink ( 'C:\wamp\www\simens\public\images\images\\' . $result['NomImage'] . '.jpg' );
		/**
		 * SUPPRESSION DE L'IMAGE DANS LA BASE
		*/
		 $this->demandeExamensTable()->supprimerImage($result['IdImage']);
	
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode ());
	}
	
	//************************************************************************************
	//************************************************************************************
	//************************************************************************************
	public function demandeExamenAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$examens = $this->params()->fromPost('examens');
		$notes = $this->params()->fromPost('notes');
	

		$this->demandeExamensTable()->saveDemandesExamensMorphologiques($id_cons, $examens, $notes);
		
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode (  ));
	}
	
	//************************************************************************************
	//************************************************************************************
	//************************************************************************************
	public function demandeExamenBiologiqueAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$examensBio = $this->params()->fromPost('examensBio');
		$notesBio = $this->params()->fromPost('notesBio');
	
	
		$this->demandeExamensTable()->saveDemandesExamensBiologiques($id_cons, $examensBio, $notesBio);
	
		$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
		return $this->getResponse ()->setContent(Json::encode (  ));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/****************************************************************************************/
	/****************************************************************************************/
	/****************************************************************************************/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/* ======== POUR LA GESTION DES HOSPITALISATIONS =========*/
	/****************************************************************************************/
	/****************************************************************************************/
	/****************************************************************************************/

	public function listeDemandeHospitalisationAction() {
		$this->layout()->setTemplate('layout/Archivage');
	
		$formHospitalisation = new HospitaliserForm();
		$formHospitalisation->get('division')->setvalueOptions($this->getBatimentTable()->listeBatiments());
	
		if($this->getRequest()->isPost()) {
			$id_lit = $this->params()->fromPost('lit',0);
			$code_demande = $this->params()->fromPost('code_demande',0);
			
			$result = $this->getDemandeHospitalisationTable()->getDemandehospitalisationWithIdDemHospi($code_demande);
			if($result) {$date_debut = $result->date_demande_hospi; } else {$result = null;}
	
			$id_hosp = $this->getHospitalisationTable()->saveHospitalisation($code_demande, $date_debut);
			$this->getHospitalisationlitTable()->saveHospitalisationlit($id_hosp, $id_lit);
	
			$this->getDemandeHospitalisationTable()->validerDemandeHospitalisation($code_demande);
	
			$this->getLitTable()->updateLit($id_lit);
	
			return $this->redirect()->toRoute('archivage' , array('action' => 'liste-demande-hospitalisation'));
		}
	
		return array(
				'form' => $formHospitalisation
		);
	}
	
	public function listePatientEncoursAjaxAction() {
		$user = $this->layout()->user;
		$id_medecin = $user->id_personne;
	
		$output = $this->getDemandeHospitalisationTable()->getListePatientEncoursHospitalisation($id_medecin);
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
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
	
		$date = $this->controlDate->convertDate( $unPatient->date_naissance );
	
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
		$html .= "<tr style='width: 95%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
	
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['date_demande_hospi']) . "</p></td>";
	
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
	
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
				
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_debut) . "</p></td>";
			//$html .="<td style='width: 25%; vertical-align:top; padding-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date d&eacute;but</span><br><p id='zoneChampInfo1' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ". $this->controlDate->convertDateTime($hospitalisation->date_debut) ." </p></td>";
	
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			//$html .="<td style='width: 25%; vertical-align:top; padding-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Batiment</span><br><p id='zoneChampInfo1' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$batiment->intitule." </p></td>";
				
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			//$html .="<td style='width: 25%; vertical-align:top; padding-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Salle</span><br><p id='zoneChampInfo1' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$salle->numero_salle." </p></td>";
	
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			//$html .="<td style='width: 25%; vertical-align:top; padding-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Lit</span><br><p id='zoneChampInfo1' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$lit->intitule." </p></td>";
	
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
	
			$html .="<form  method='post' action='".$chemin."/consultation/liberer-patient'>";
			$html .=$formHidden($formLiberation->get('id_demande_hospi'));
			$html .="<div style='width: 80%; margin-left: 195px;'>";
			$html .="<table id='form_patient' style='width: 100%; '>
					 <tr class='comment-form-patient' style='width: 100%'>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('resumer_medical')).$formTextArea($formLiberation->get('resumer_medical'))."</td>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('motif_sorti')).$formTextArea($formLiberation->get('motif_sorti'))."</td>
					   <td  style='width: 10%;'><a href='javascript:vider_liberation()'><img id='test' style=' margin-left: 25%;' src='../images_icons/118.png' title='vider tout'></a></td>
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
	
		$date = $this->controlDate->convertDate( $unPatient->date_naissance );
	
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
		$html .= "</div>";
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		if($administrerSoin != 111) {
			$html .= "<div id='titre_info_deces'>Attribution d'un lit</div>
		              <div id='barre'></div>";
	
			$html .= "<script>$('#salle, #division, #lit').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});</script>";
		}else if($administrerSoin == 111){
			$html .= "<script>$('#salle, #division, #lit').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});</script>";
		}
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	
	}
	
	public function administrerSoinAction() {
		$this->layout()->setTemplate('layout/archivage');
	
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
	
		$user = $this->layout()->user;
		$id_medecin = $user->id_personne;
	
		$formSoin = new SoinForm();
	
		$transferer = $this->getTransfererPatientServiceTable (); //var_dump($transferer); exit();
		$hopital = $transferer->fetchHopital ();
		
		$formSoin->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		//RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		//RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
		//LISTE DES SERVICES DE L'HOPITAL
		$formSoin->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
	
		$data = array (
				'hopital_accueil' => $idHopital,
		);
	
		$formSoin->populateValues($data);
		if($this->getRequest()->isPost()) {
	
			$data = $this->getRequest()->getPost();
				
			$id_sh = $this->getSoinHospitalisation4Table()->saveSoinhospitalisation($data, $id_medecin);
			$this->getSoinHospitalisation4Table()->saveHeure($data,$id_sh);
			//$test = 'En cours de dÃ©veloppement';
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode () );
		}
	
		$listeMedicament = $this->getConsommableTable()->listeDeTousLesMedicaments();
	
		return array(
				'form' => $formSoin,
				'liste_med' => $listeMedicament,
		);
	}
	
	public function listeSoinsPrescritsAction() {
		$id_hosp = $this->params()->fromPost('id_hosp', 0);
	
		$html = "<div id='titre_info_admis'>
				  <span id='titre_info_liste_soin' style='margin-left:-5px; cursor:pointer; margin-top: 100px;'>
				    <img src='../img/light/minus.png' /> Liste des soins</div>
				  </span>
		        <div id='barre_admis'></div>";
		$html .="<div id='Liste_soins_deja_prescrit'>";
		$html .= $this->raffraichirListeSoinsPrescrit($id_hosp);
		$html .="</div>";
	
		$html .="<script>
				  /*$('#Liste_soins_deja_prescrit').toggle(false);*/
				  depliantPlus6();
				 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function raffraichirListeSoinsPrescrit($id_hosp){
	
		$liste_soins = $this->getSoinHospitalisation4Table()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; width:100%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer;'>
					<th style='width: 23%;'>M&eacute;dicament</th>
					<th style='width: 21%;'>Voie d'administration</th>
					<th style='width: 19%;'>Date recommand&eacute;e</th>
					<th style='width: 19%;'>Heure suivante</th>
				    <th style='width: 12%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
	
		rsort($liste_soins);
		foreach ($liste_soins as $cle => $Liste){
			//Récupération de l'heure suivante pour l'application du soin par l'infirmier
			$heureSuivante = $this->getSoinHospitalisation4Table()->getHeureSuivante($Liste['id_sh']);
	
			$heureSuiv = null;
			if($heureSuivante){
				$heureSuiv = "<span style='color: red; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</span>";
			}
				
				
			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
			$html .="<td style='width: 23%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['medicament']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['voie_administration']."</div></td>";
			$html .="<td style='width: 19%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->controlDate->convertDate($Liste['date_application_recommandee'])."</div></td>";
	
			if($heureSuiv == null){
				$html .="<td style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>Termin&eacute; </div></td>";
			}else{
				$html .="<td id='clignoterHeure".$Liste['id_sh']."' style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$heureSuiv."</div></td>";
			}
				
			if($Liste['appliquer'] == 0) {
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				//Si au moin pour une heure un soin a ete applique impossible de Supprimer le soin
				$ListeHeureSoinApplique = $this->getSoinHospitalisation4Table()->getHeureAppliquer($Liste['id_sh']);
				if($ListeHeureSoinApplique != 0){
					$html .="<span>
					    	  <img style='color: white; opacity: 0.15;' src='../images_icons/modifier.png'/>
					         </span>&nbsp;";
					$html .="<span> <img  style='color: white; opacity: 0.15;' src='../images_icons/sup.png' /> </span>
				             </td>";
				} else {
					$html .="<a href='javascript:modifiersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='modifier".$Liste['id_sh']."'  src='../images_icons/modifier.png' alt='Constantes' title='modifier'/>
					         </a>&nbsp;";
					$html .="<a href='javascript:supprimersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='supprimer".$Liste['id_sh']."'  src='../images_icons/sup.png' alt='Constantes' title='annuler' />
					         </a>
				             </td>";
				}
				 
	
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/non.png' alt='Constantes' title='soin non encore appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
	
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoinApp(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				$html .="<a>
					    	<img class='modifier".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/modifier.png' alt='Constantes'/>
					     </a>&nbsp;
	
				         <a >
					    	<img class='supprimer".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/sup.png' alt='Constantes'/>
					     </a>
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/oui.png' alt='Constantes' title='soin d&eacute;ja appliqu&eacute;' />
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
	                /*margin-left: 185px;*/
                  }
	
				  div .dataTables_paginate
                  {
				    /*margin-right: 20px;*/
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
	
	public function appliquerSoinAction() {
		$this->layout()->setTemplate('layout/archivage');
	
		$formAppliquerSoin = new AppliquerSoinForm();
	
		return array(
				'form' => $formAppliquerSoin
		);
	}
	
	public function listePatientSuiviAjaxAction() {
		$output = $this->getDemandeHospitalisationTable()->getListePatientSuiviHospitalisation();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
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
	
		$date = $this->controlDate->convertDate( $unPatient->date_naissance );
	
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
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['Datedemandehospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['date_fin_prevue_hospi']) . "</p></td>";
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
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_debut) . "</p></td>";
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
                        <img  src='".$chemin."/images_icons/fleur1.jpg' />
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
	
	public function listeSoinsAAppliquer($id_hosp){
		$this->getDateHelper();
		$liste_soins = $this->getSoinHospitalisation3Table()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; margin-left:195px; width:80%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer; '>
					<th style='width: 24%;'>M<minus>&eacute;dicament</minus></th>
					<th style='width: 21%;'>V<minus>oie d'administration</minus></th>
					<th style='width: 21%;'>D<minus>ate recommand&eacute;e </minus></th>
					<th style='width: 18%;'>H<minus>eure suivante </minus></th>
				    <th style='width: 10%;'>O<minus>ptions</minus></th>
				    <th style='width: 6%;'>E<minus>tat</minus></th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
	
		sort($liste_soins);
		foreach ($liste_soins as $cle => $Liste){
			//Récupération de l'heure suivante pour l'application du soin
			$heureSuivante = $this->getSoinHospitalisation3Table()->getHeureSuivante($Liste['id_sh']);
				
			$idHeure = null;
			$heureSuiv = null;
			if($heureSuivante){
				$idHeure = $heureSuivante['id_heure'];
				$heureSuiv = "<span style='color: red; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</span>";
	
				$heureSuivPopup = $heureSuivante['heure'];
			}
				
			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
			$html .="<td style='width: 24%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['medicament']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['voie_administration']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->controlDate->convertDate($Liste['date_application_recommandee'])."</div></td>";
			if($heureSuiv == null){
				$html .="<td style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>Termin&eacute; 	<!-- img src='../images_icons/tick_16.png'/--></div></td>";
			}else{
				$html .="<td style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$heureSuiv."</div></td>";
			}
	
			if($Liste['appliquer'] == 0) {
				$html .="<td style='width: 10%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				$html .="<a href='javascript:appliquerSoin(".$Liste['id_sh'].",".$Liste['id_hosp'].",".$idHeure.")'>
					    	<img class='modifier".$Liste['id_sh']."'  src='../img/dark/blu-ray.png' alt='Constantes' title='appliquer le soin'/>
					     </a>&nbsp;
	
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/non.png' title='soin non encore appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
				$html .="<td style='width: 10%;'> <a href='javascript:vuesoinApp(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' title='d&eacute;tails' />
					  </a>&nbsp";
	
				$html .="<a>
					    	<img class='modifier".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../img/dark/blu-ray.png' title=''/>
					     </a>&nbsp;
	
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/oui.png' title='soin d&eacute;j&agrave; appliqu&eacute;' />
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
	
		$html .="<script>
				  listepatient(); listeDesSoins();
				 </script>";
	
		return $html;
	}
	
	
	public function vueSoinAppliquerAction() {
	
		$this->getDateHelper();
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$soinHosp = $this->getSoinHospitalisation4Table()->getSoinhospitalisationWithId_sh($id_sh);
		$heure = $this->getSoinHospitalisation4Table()->getHeures($id_sh);
	
		$heureSuivante = $this->getSoinHospitalisation4Table()->getHeureSuivante($id_sh);
	
		$lesHeures = "";
		if($heure){
			for ($i = 0; $i<count($heure); $i++){
				if($i == count($heure)-1) {
					if($heureSuivante['heure'] == $heure[$i]){
						$lesHeures.= '<span id="clignoterHeure" style="font-weight: bold; color: red;">'.$heure[$i].'</span>';
					}else{
						$lesHeures.= $heure[$i];
					}
				} else {
					if($heureSuivante['heure'] == $heure[$i]){
						$lesHeures.= '<span id="clignoterHeure" style="font-weight: bold; color: red;">'.$heure[$i].'</span>  -  ';
					}else{
						$lesHeures.= $heure[$i].'  -  ';
					}
				}
			}
		}
	
		$html  ="<table style='width: 99%;'>";
		$html .="<tr style='width: 99%;'>";
		$html .="<td style='width: 33%; vertical-align:top;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>M&eacute;dicament</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$soinHosp->medicament." </p></td>";
		$html .="<td style='width: 33%; vertical-align:top;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Voie d'administration</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$soinHosp->voie_administration." </p></td>";
		$html .="<td style='width: 33%; vertical-align:top;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date prescription</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$this->controlDate->convertDateTime($soinHosp->date_enregistrement)." </p></td>";
		$html .="</tr>";
	
		$html .="<tr style='width: 99%;'>";
		$html .="<td style='vertical-align:top;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date recommand&eacute;e</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$this->controlDate->convertDate($soinHosp->date_application_recommandee)." </p></td>";
		$html .="<td colspan='2' style='width: 80%; vertical-align:top;'>
				 <span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Heures recommand&eacute;es</span><br><p id='zoneChampInfo' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$lesHeures." </p>
				 </td>";
	
		$html .="</table>";
	
		$html .="<table style='width: 99%;'>";
		$html .="<tr style='width: 95%;'>";
		$html .="<td style='width: 50%; padding-top: 10px; padding-right:25px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Motif</span><br><p id='circonstance_deces' style='background:#f8faf8; font-size:17px; padding-left: 10px;'> ".$soinHosp->motif." </p></td>";
		$html .="<td style='width: 50%; padding-top: 10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:16px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Note</span><br><p id='circonstance_deces' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$soinHosp->note." </p></td>";
		$html .="<td style='width: 0%;'> </td>";
		$html .= "</tr>";
	
	
		if($soinHosp){
			if($soinHosp->appliquer == 1) {
	
				$listeHeure = $this->getSoinHospitalisation4Table()->getToutesHeures($id_sh);
					
				$html .="<tr style='width: 99%;'>
					   <td colspan='2' style='width: 99%;'>
					     <div id='titre_info_admis'>Informations sur l'application du soin</div><div id='barre_admis'></div>
					   </td>
					 </tr>";
					
				$html .="<table style='width: 99%; margin-top: 10px;'>";
					
				if($listeHeure){
					foreach ($listeHeure as $listeH) {
						//RECUPERATION DES INFORMATIONS DE L'INFIRMIER AYANT APPLIQUER LES DONNEES
						$infosInfirmier = $this->getSoinHospitalisation4Table()->getInfosInfirmiers($listeH['id_personne_infirmier']);
						$PrenomInfirmier = " Prenom  ";
						$NomInfirmier = " Nom ";
						if($infosInfirmier){
							$PrenomInfirmier = $infosInfirmier['prenom'];
							$NomInfirmier = $infosInfirmier['nom'];
						}
	
						$html .="<tr style='width: 99%;'>";
						$html .="<td style='width: 100%; vertical-align:top;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:19px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>".$listeH['heure']."</span>
						
								   <div class='infoUtilisateur".$listeH['id_heure']."' style='float: right; padding-top: 10px; padding-right: 10px; cursor:pointer'> <img src='../images_icons/info_infirmier.png' title='Infirmier: ".$PrenomInfirmier." ".$NomInfirmier." ".$this->controlDate->convertDateTime($listeH['date_application'])." ' /> </div>
								   <br><p id='zoneTexte' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$listeH['note']." </p>
								 </td>";
						$html .= "</tr>";
	
						$html .="<script>
								 $('.infoUtilisateur".$listeH['id_heure']."').mouseenter(function(){
								   var tooltips = $( '.infoUtilisateur".$listeH['id_heure']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
								   tooltips.tooltip( 'open' );
       					         });
	                             $('.infoUtilisateur".$listeH['id_heure']."').mouseleave(function(){
	                               var tooltips = $( '.infoUtilisateur".$listeH['id_heure']."' ).tooltip();
	                               tooltips.tooltip( 'close' );
	                             });
	                           </script>";
					}
				}
					
			}
				
			if($soinHosp->appliquer == 0) {
				$listeHeure = $this->getSoinHospitalisation4Table()->getToutesHeures($id_sh);
					
				$html .="<tr style='width: 99%;'>
					       <td colspan='2' style='width: 99%;'>
					         <div id='titre_info_admis'>Informations sur l'application du soin</div><div id='barre_admis'></div>
					       </td>
					     </tr>";
					
				$html .="<table style='width: 99%; margin-top: 10px;'>";
					
				if($listeHeure){
					foreach ($listeHeure as $listeH) {
						if($listeH['applique'] == 1){
	
							//RECUPERATION DES INFORMATIONS DE L'INFIRMIER AYANT APPLIQUER LES DONNEES
							$infosInfirmier = $this->getSoinHospitalisation4Table()->getInfosInfirmiers($listeH['id_personne_infirmier']);
							$PrenomInfirmier = " Prenom  ";
							$NomInfirmier = " Nom ";
							if($infosInfirmier){
								$PrenomInfirmier = $infosInfirmier['prenom'];
								$NomInfirmier = $infosInfirmier['nom'];
							}
								
							$html .="<tr style='width: 99%;'>";
							$html .="<td style='width: 100%; vertical-align:top;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:19px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>".$listeH['heure']."</span>
	
								   <div class='infoUtilisateur".$listeH['id_heure']."' style='float: right; padding-top: 10px; padding-right: 10px; cursor:pointer'> <img src='../images_icons/info_infirmier.png' title='Infirmier: ".$PrenomInfirmier." ".$NomInfirmier." ".$this->controlDate->convertDateTime($listeH['date_application'])." ' /> </div>
								   <br><p id='zoneTexte' style='background:#f8faf8; font-size:17px; padding-left: 5px;'> ".$listeH['note']." </p>
								 </td>";
							$html .= "</tr>";
								
							$html .="<script>
								      $('.infoUtilisateur".$listeH['id_heure']."').mouseenter(function(){
								        var tooltips = $( '.infoUtilisateur".$listeH['id_heure']."' ).tooltip({show: {effect: 'slideDown', delay: 250}});
								        tooltips.tooltip( 'open' );
       					              });
	                                  $('.infoUtilisateur".$listeH['id_heure']."').mouseleave(function(){
	                                    var tooltips = $( '.infoUtilisateur".$listeH['id_heure']."' ).tooltip();
	                                    tooltips.tooltip( 'close' );
	                                  });
	                                 </script>";
						}
					}
				}
	
	
			}
		}
	
		$html .="</table>";
	
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	
	}
	
	public function heureSuivanteAction() {
		$id_hosp = $this->params()->fromPost('id_hosp',0);
		$id_sh = $this->params()->fromPost('id_sh',0);
		$id_heure = $this->params()->fromPost('id_heure',0);
	
		$heureSuivante = $this->getSoinHospitalisation3Table()->getHeureSuivante($id_sh);
			
		$heureSuivPopup = null;
		if($heureSuivante){
			$heureSuivPopup = $heureSuivante['heure'];
		}
	
		$html = $heureSuivPopup;
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function applicationSoinAction() {
		$id_heure = $this->params()->fromPost('id_heure', 0);
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$note = $this->params()->fromPost('note', 0);
	
		$user = $this->layout()->user;
		$id_personne = $user->id_personne; //L'infirmier qui a appliqué le soin au patient
	
		$this->getSoinHospitalisation3Table()->saveHeureSoinAppliquer($id_heure, $id_sh, $note, $id_personne);
	
		$heureSuivante = $this->getSoinHospitalisation3Table()->getHeureSuivante($id_sh);
		if(!$heureSuivante){ //S'il n y avait aucune heure suivante On met Appliquer a 1 (dans la table soinHospitalisation3)
			$this->getSoinHospitalisation3Table()->appliquerSoin($id_sh, $note, $id_personne);
		}
	
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode (  ) );
	}
	
	public function raffraichirListeAction() {
		$id_hosp = $this->params()->fromPost('id_hosp',0);
	
		$html = $this->listeSoinsAAppliquer($id_hosp);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
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
	
		$date = $this->controlDate->convertDate( $unPatient->date_naissance );
	
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
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['Datedemandehospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
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
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_debut) . "</p></td>";
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
		$html .= "<div id='info_liste' style='margin-left: 195px; width: 80%;'>";
		$html .= $this->raffraichirListeSoins($hospitalisation->id_hosp);
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>
				   <span id='titre_info_liberation' style='margin-left:-10px; cursor:pointer;'>
				      <img src='".$chemin."/img/light/plus.png' /> Infos sur la lib&eacute;ration du patient
				   </span>
				  </div>
		          <div id='barre'></div>";
	
		$html .= "<div id='info_liberation'>";
		$html .= "<table style='margin-top:0px; margin-left:195px; width: 80%;'>";
		$html .= "<tr style='width: 80%'>";
		$html .= "<td style='padding-top: 10px; width: 10%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:14px;'>Date:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_fin) . "</p></td>";
		$html .= "<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:14px;'>R&eacute;sum&eacute; m&eacute;dical:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$hospitalisation->resumer_medical."</p></td>";
		$html .= "<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:14px;'>Motif sortie:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>".$hospitalisation->motif_sorti."</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
	
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$chemin."/images_icons/fleur1.jpg' />
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
	
	public function listeDemandeHospiAjaxAction() {
		$output = $this->getDemandeHospitalisationTable()->getListeDemandeHospitalisation();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
			'enableJsonExprFinder' => true	) ) );
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function HospitaliserAction() {
		$this->layout()->setTemplate('layout/archivage');
		
		//$soinHosp = $this->getSoinHospitalisation4Table()->getSoinhospitalisationWithId_shs(2);
		//var_dump($soinHosp); exit();

		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		$user = $this->layout()->user;
		$id_medecin = $user->id_personne;
		
 		$formSoin = new SoinForm();
		
		$transferer = $this->getTransfererPatientServiceTable ();
		$hopital = $transferer->fetchHopital ();
		$formSoin->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		//RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		//RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
		//LISTE DES SERVICES DE L'HOPITAL
		$formSoin->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		
		$data = array (
				'hopital_accueil' => $idHopital,
		);
		
		$formSoin->populateValues($data);
		if($this->getRequest()->isPost()) {

			$data = $this->getRequest()->getPost();
			
		    $id_sh = $this->getSoinHospitalisation4Table()->saveSoinhospitalisation($data, $id_medecin);
		    $this->getSoinHospitalisation4Table()->saveHeure($data,$id_sh);
			//$test = 'En cours de dÃ©veloppement';
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		    return $this->getResponse ()->setContent ( Json::encode () );
		}
		
		$listeMedicament = $this->getConsommableTable()->listeDeTousLesMedicaments();
		
		return array(
				'form' => $formSoin,
				'liste_med' => $listeMedicament,
		);
	}
	
	public function getPath(){
		$this->path = $this->getServiceLocator()->get('Request')->getBasePath();
		return $this->path;
	}
	
	public function raffraichirListeSoins($id_hosp){
	
		$liste_soins = $this->getSoinHospitalisation4Table()->getAllSoinhospitalisation($id_hosp);
		$html = "";
		$this->getDateHelper();
			
		$html .="<table class='table table-bordered tab_list_mini'  style='margin-top:10px; margin-bottom:20px; width:100%;' id='listeSoin'>";
			
		$html .="<thead style='width: 100%;'>
				  <tr style='height:40px; width:100%; cursor:pointer;'>
					<th style='width: 23%;'>M&eacute;dicament</th>
					<th style='width: 21%;'>Voie d'administration</th>
					<th style='width: 19%;'>Date recommand&eacute;e</th>
					<th style='width: 19%;'>Heure suivante</th>
				    <th style='width: 12%;'>Options</th>
				    <th style='width: 6%;'>Etat</th>
				  </tr>
			     </thead>";
			
		$html .="<tbody style='width: 100%;'>";
	
		rsort($liste_soins);
		foreach ($liste_soins as $cle => $Liste){
			//Récupération de l'heure suivante pour l'application du soin par l'infirmier
			$heureSuivante = $this->getSoinHospitalisation4Table()->getHeureSuivante($Liste['id_sh']);
	
			$heureSuiv = null;
			if($heureSuivante){
				$heureSuiv = "<span style='color: red; font-weight: bold; font-size: 20px;'>".$heureSuivante['heure']."</span>";
			}
				
				
			$html .="<tr style='width: 100%;' id='".$Liste['id_sh']."'>";
			$html .="<td style='width: 23%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['medicament']."</div></td>";
			$html .="<td style='width: 21%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$Liste['voie_administration']."</div></td>";
			$html .="<td style='width: 19%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$this->controlDate->convertDate($Liste['date_application_recommandee'])."</div></td>";
	
			if($heureSuiv == null){
				$html .="<td style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>Termin&eacute; </div></td>";
			}else{
				$html .="<td id='clignoterHeure".$Liste['id_sh']."' style='width: 18%;'><div id='inform' style='float:left; font-weight:bold; font-size:17px;'>".$heureSuiv."</div></td>";
			}
				
			if($Liste['appliquer'] == 0) {
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoin(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				//Si au moin pour une heure un soin a ete applique impossible de Supprimer le soin
				$ListeHeureSoinApplique = $this->getSoinHospitalisation4Table()->getHeureAppliquer($Liste['id_sh']);
				if($ListeHeureSoinApplique != 0){
					$html .="<span>
					    	  <img style='color: white; opacity: 0.15;' src='../images_icons/modifier.png'/>
					         </span>&nbsp;";
					$html .="<span> <img  style='color: white; opacity: 0.15;' src='../images_icons/sup.png' /> </span>
				             </td>";
				} else {
					$html .="<a href='javascript:modifiersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='modifier".$Liste['id_sh']."'  src='../images_icons/modifier.png' alt='Constantes' title='modifier'/>
					         </a>&nbsp;";
					$html .="<a href='javascript:supprimersoin(".$Liste['id_sh'].",".$Liste['id_hosp'].")'>
					    	  <img class='supprimer".$Liste['id_sh']."'  src='../images_icons/sup.png' alt='Constantes' title='annuler' />
					         </a>
				             </td>";
				}
				 
	
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_oui".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/non.png' alt='Constantes' title='soin non encore appliqu&eacute;' />
					     &nbsp;
				         </td>";
			}else {
	
				$html .="<td style='width: 12%;'> <a href='javascript:vuesoinApp(".$Liste['id_sh'].") '>
					       <img class='visualiser".$Liste['id_sh']."' style='display: inline;' src='../images_icons/voird.png' alt='Constantes' title='d&eacute;tails' />
					  </a>&nbsp";
	
				$html .="<a>
					    	<img class='modifier".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/modifier.png' alt='Constantes'/>
					     </a>&nbsp;
	
				         <a >
					    	<img class='supprimer".$Liste['id_sh']."' style='color: white; opacity: 0.15;' src='../images_icons/sup.png' alt='Constantes'/>
					     </a>
				         </td>";
					
				$html .="<td style='width: 6%;'>
					       <img class='etat_non".$Liste['id_sh']."' style='margin-left: 20%;' src='../images_icons/oui.png' alt='Constantes' title='soin d&eacute;ja appliqu&eacute;' />
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
	                /*margin-left: 185px;*/
                  }
	
				  div .dataTables_paginate
                  {
				    /*margin-right: 20px;*/
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
	
		$html = "<div id='titre_info_admis'>Liste des soins</div>
		          <div id='barre_admis'></div>";
		$html .= $this->raffraichirListeSoins($id_hosp);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($html) );
	}
	
	public function supprimerSoinAction() {
		$id_sh = $this->params()->fromPost('id_sh', 0);
		$this->getSoinHospitalisation4Table()->supprimerHospitalisation($id_sh);
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode () );
	}
	
	public function modifierSoinAction() {

		$id_sh = $this->params()->fromPost('id_sh', 0);
		
		$this->getDateHelper();
		$soin = $this->getSoinHospitalisation4Table()->getSoinhospitalisationWithId_sh($id_sh);
		$heure = $this->getSoinHospitalisation4Table()->getHeures($id_sh);
		
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
		
		$form = new SoinmodificationForm();
		if($soin){
				
			$data = array(
					'medicament_m' => $soin->medicament,
 					'voie_administration_m' => $soin->voie_administration,
					'frequence_m' => $soin->frequence,
					'dosage_m' => $soin->dosage,
 					'date_application_m' => $this->controlDate->convertDate($soin->date_application_recommandee),
					'motif_m' => $soin->motif,
					'note_m' => $soin->note,
			);
				
			$form->populateValues($data);
		}
		
		$formRow = new FormRow();
		$formText = new FormText();
		$formSelect = new FormSelect();
		$formTextArea = new FormTextarea();
		
		$listeMedicament = $this->getConsommableTable()->listeDeTousLesMedicaments();
		
		$html ="<table id='form_patient' style='width: 100%;'>
		
		           <tr class='comment-form-patient' style='width: 100%;'>
		             <td style='width: 25%;'> ".$formRow($form->get('medicament_m')).$formText($form->get('medicament_m'))."</td>
		             <td style='width: 25%;'>".$formRow($form->get('voie_administration_m')).$formText($form->get('voie_administration_m'))."</td>
		             <td style='width: 25%;'>".$formRow($form->get('frequence_m')).$formText($form->get('frequence_m'))."</td>
		             <td style='width: 25%;'>".$formRow($form->get('dosage_m')).$formText($form->get('dosage_m'))."</td>
		           </tr>
		             		
		           <tr class='comment-form-patient' style='width: 100%;'>
		             <td style='width: 25%;'> ".$formRow($form->get('date_application_m')).$formText($form->get('date_application_m'))."</td>
		             <td colspan='2' style='width: 25%;'>".$formRow($form->get('heure_recommandee_m')).$formText($form->get('heure_recommandee_m'))."</td>
		             <td style='width: 25%;'></td>
		           </tr>
		         </table>
		
		         <table id='form_patient' style='width: 100%;'>
		           <tr class='comment-form-patient'>
		             <td id='note_soin' style='width: 40%; '>". $formRow($form->get('motif_m')).$formTextArea($form->get('motif_m'))."</td>
		             <td id='note_soin' style='width: 40%; '>". $formRow($form->get('note_m')).$formTextArea($form->get('note_m'))."</td>
		             <td  style='width: 10%;' id='ajouter'></td>
		             <td  style='width: 10%;'></td>
		           </tr>
		         </table>";
		$html .="<script>
				  $('#medicament_m, #voie_administration_m, #frequence_m, #dosage_m, #date_application_m, #heure_recommandee_m, #motif_m, #note_m').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'18px'});
				    $('#heure_recommandee_m').val('".$lesHeures."');
				    $(function() {
    	              $('.SlectBox_m').SumoSelect({ csvDispCount: 6 });
				    });
				    var myArrayMedicament = [''];
			        var j = 0;";
                foreach($listeMedicament as $Liste) {
                	$html .="myArrayMedicament[j++] = '". $Liste['INTITULE']."';"; 
                }
		$html .=" $('#medicament_m' ).autocomplete({
    		         source: myArrayMedicament
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
		
		/**
		 * LIBERATION DU LIT
		 */
		$ligne_hosp = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
		if($ligne_hosp){
			$id_hosp = $ligne_hosp->id_hosp;
			$ligne_lit_hosp = $this->getHospitalisationlitTable()->getHospitalisationlit($id_hosp);
			if($ligne_lit_hosp){
				$id_materiel = $ligne_lit_hosp->id_materiel;
				$this->getLitTable()->libererLit($id_materiel);
			}
		}
	
		return $this->redirect()->toRoute('consultation', array('action' =>'en-cours'));
	}
	
	
	
	
	
	
	
	
	
	//=================================================================================================
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//**** FACTURATION ----- FACTURAIION ----- FACTURATION ****
	//=================================================================================================
	protected $formPatient;
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm ();
		}
		return $this->formPatient;
	}
	public function baseUrl(){
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		return $tabURI[0];
	}
	
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		return $nouv_date;
	}
	
	public function ajouterAction() { 
		$this->layout ()->setTemplate ( 'layout/Archivage' );
		$form = $this->getForm ();
		$patientTable = $this->getPatientTable();
		$form->get('nationalite_origine')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('nationalite_actuelle')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('nationalite_origine' => 'SÃ©nÃ©gal', 'nationalite_actuelle' => 'SÃ©nÃ©gal');
	
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
					'date_enregistrement' => $date_enregistrement,
					'archivage' => 1,
			);
	
			//var_dump($donnees); exit();
			
			if ($img != false) {
	
				$donnees['photo'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
				$Patient->addPatient ( $donnees );
					
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			} else {
				// On enregistre sans la photo
				$Patient->addPatient ( $donnees );
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'archivage', array (
				'action' => 'liste-dossiers-patients'
		) );
	}
	
	public function listePatientAjaxAction() {
		$output = $this->getPatientTable ()->getListePatient ();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function listeDossiersPatientsAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/archivage' );
		$view = new ViewModel ();
		return $view;
	}
	
	public function infoDossierPatientAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$id_pat = $this->params ()->fromRoute ( 'val', 0 );

		$unPatient = $this->getPatientTable ()->getPatient ( $id_pat );
		return array (
				'lesdetails' => $unPatient,
				'image' => $this->getPatientTable ()->getPhoto ( $id_pat ),
				'id_cons' => $unPatient->id_personne,
				'heure_cons' => $unPatient->date_enregistrement
		);
	}
	
	public function modifierAction() {
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/archivage' );
		$id_patient = $this->params ()->fromRoute ( 'val', 0 );
	
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
		$info->date_naissance = $control->convertDate($info->date_naissance); 
	
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
	
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient);
	
				return $this->redirect ()->toRoute ( 'archivage', array (
						'action' => 'liste-dossiers-patients'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'archivage', array (
				'action' => 'liste-dossiers-patients'
		) );
	}
	
	public function admissionAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/archivage' );
		
		$patient = $this->getPatientTable ();
		// AFFICHAGE DE LA LISTE DES PATIENTS
		$liste = $patient->LalistePatients ();
	
		// INSTANCIATION DU FORMULAIRE d'ADMISSION
		$formAdmission = new AdmissionForm ();
		// rï¿½cupï¿½ration de la liste des hopitaux
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
			$html .= "<td style='width: 30%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->convertDate($unPatient->date_naissance) . "</p></td>";
			$html .= "<td style='width: 20%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
			$html .= "<td style='width: 20%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->profession . "</p></td>";
			$html .= "<td style='width: 30%; height: 50px;'>";
					
			
			
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
				
			$html .= "<div style='width: 17%; height: 180px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
				
			$html .= "</div>";
				
			$html .= "<script>
					         //$('#numero').val('" . $numero . "');
					         //$('#numero').css({'background':'#eee','border-bottom-width':'0px','border-top-width':'0px','border-left-width':'0px','border-right-width':'0px','font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'17px'});
					         //$('#numero').attr('readonly',true);
	
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
	
	public function listeAdmissionAjaxAction() {
		$output = $this->getPatientTable ()->laListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	
	public function popupVisualisationAction() {
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
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient->telephone . "</p></td>";
			$html .= "</tr>";
	
			$html .= "</table>";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
	}
	
	
	public function montantAction() {
		if ($this->getRequest ()->isPost ()) {
	
			$id_service = ( int ) $this->params ()->fromPost ( 'id', 0 );
	
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
	
	
	public function enregistrerAdmissionAction() {
		$this->getDateHelper();
		if ($this->getRequest ()->isPost ()) {
	
			$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 ); 
	
			$numero = $this->params ()->fromPost ( 'numero' );
			$id_service = $this->params ()->fromPost ( 'service' );
			$montant = $this->params ()->fromPost ( 'montant' );
			$date = $this->params ()->fromPost ( 'date' );
	
			$donnees = array (
					'id_patient' => $id_patient,
					'id_service' => $id_service,
					'date' => $this->controlDate->convertDateInAnglais($date),
					'montant' => $montant,
					'numero' => $numero,
			);
	
			$this->getFacturationTable ()->addFacturation ( $donnees );
				
			return $this->redirect()->toRoute('archivage', array(
					'action' =>'liste-admission'));
		}
	}
	
	public function listeAdmissionAction() {
		$this->layout ()->setTemplate ( 'layout/archivage' );
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
	
	
	public function vuePatientAdmisAction(){
		$this->getDateHelper();
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
		$html .= "<td style='width: 30%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($unPatient->date_naissance) . "</p></td>";
		$html .= "<td style='width: 20%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:210px; font-weight:bold; font-size:17px;'>" . $unPatient->adresse . "</p></td>";
		$html .= "<td style='width: 20%;vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $unPatient->profession . "</p></td>";
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
			
		$html .= "<div style='width: 17%; height: 180px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:20px; margin-left:25px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->baseUrl()."public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .="<div id='titre_info_admis'>Informations sur la facturation</div>";
		$html .="<div id='barre_separateur'></div>";
	
		$html .="<table style='margin-top:10px; margin-left:195px; width: 80%;'>";
	
		$html .="<tr style='width: 80%;'>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date d'enregistrement</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->controlDate->convertDate($InfoAdmis->date_archivage) .' - '. $InfoAdmis->heure_archivage ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Date consultation</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->convertDate($InfoAdmis->date_cons) ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'></td>";
		$html .="</tr>";
	
		$html .="<tr style='width: 80%;'>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Num&eacute;ro facture</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->numero ." </p></td>";
		$html .="<td colspan='2' style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>Service</span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoService->nom ." </p></td>";
		$html .="<td style='width: 25%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='font-weight:bold; font-size:15px; padding-left: 5px; color: #065d10; font-family: Times  New Roman;'>frais consultation </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $InfoAdmis->montant." francs </p></td>";
		$html .="</tr>";
		
		$html .="</table>";
		$html .="<table style='margin-top:10px; margin-left:195px; width: 80%;'>";
		$html .="<tr style='width: 80%;'>";
	
		$html .="<td class='block' id='thoughtbot' style='width: 35%;  vertical-align: bottom; padding-left:350px; padding-bottom: 15px; padding-top: 30px; padding-right: 150px;'><button type='submit' id='terminer'>Terminer</button></td>";
	
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
}
