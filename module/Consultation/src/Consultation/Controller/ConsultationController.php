<?php

namespace Consultation\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facturation\Model\Patient;
use Consultation\Model\Consultation;
use Consultation\Model\MotifAdmission;
use Consultation\Model\RvPatientCons;
use Consultation\Model\RvPatientConsTable;
use Personnel\Model\Service;
use Consultation\Form\ConsultationForm;
use Zend\Json\Json;
use Zend\Mvc\Service\ViewJsonRendererFactory;
use Zend\Json\Expr;
use Consultation\Model\Consommable;
use Consultation\View\Helpers;
use Consultation\View\Helpers\DocumentPdf;
use Consultation\View\Helpers\OrdonnancePdf;
use ZendPdf\Font;
use ZendPdf\Page;
use ZendPdf\PdfDocument;
use Consultation\Model\ConsultationTable;
use Consultation\View\Helpers\TraitementChirurgicalPdf;
use Personnel\Model\ServiceTable;
use Consultation\View\Helpers\TransfertPdf;
use Consultation\View\Helpers\RendezVousPdf;
use Facturation\View\Helper\DateHelper;
use Zend\Mvc\Controller\Plugin\Layout;
use Admin\Form\UtilisateurForm;

class ConsultationController extends AbstractActionController {
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

	
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getConsultationTable() {
		if (! $this->consultationTable) {
			$sm = $this->getServiceLocator ();
			$this->consultationTable = $sm->get ( 'Consultation\Model\ConsultationTable' );
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
			$this->serviceTable = $sm->get ( 'Personnel\Model\ServiceTable' );
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
			$this->transfererPatientServiceTable = $sm->get ( 'Consultation\Model\TransfererPatientServiceTable' );
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
	
/***
 * *********************************************************************************************************************************
 * *********************************************************************************************************************************
 * *********************************************************************************************************************************
 */	
	public function  getDateHelper(){
		$this->controlDate = new DateHelper();
	}
	
	public function rechercheAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$user = $this->user();

		$LeService = $this->getServiceTable()->getServiceparId($user->id_service);
		$service = $LeService['NOM']; 
		
		$patient = $this->getPatientTable ();
		$patientsAdmis = $patient->tousPatientsAdmis ( $service );
		$view = new ViewModel ( array (
				'donnees' => $patientsAdmis,
		) );
		return $view;
	}
	
	public function espaceRechercheMedAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$service = $this->layout ()->service; 

		$patients = $this->getPatientTable ();
		$tab = $patients->listePatientsConsMedecin ( $service );
		return new ViewModel ( array (
				'donnees' => $tab
		) );
	}
	
	public function espaceRechercheSurvAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$service = $this->layout ()->service; 
		
		$patients = $this->getPatientTable ();
		$tab = $patients->tousPatientsCons ( $service );
		return new ViewModel ( array (
				'donnees' => $tab
		) );
	}
	// Liste des patients Ã  consulter par le medecin aprï¿½s prise des constantes par le surveillant de service
	public function consultationMedecinAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$service = $this->layout ()->service; 

		$serviceTable = $this->getServiceTable ();
		$LigneDuService = $serviceTable->getServiceParNom ( $service );
		$IdDuService = $LigneDuService ['ID_SERVICE'];

		$patients = $this->getPatientTable ();
		$lespatients = $patients->listePatientsConsParMedecin ( $IdDuService );

		return new ViewModel ( array (
				'LeService' => $service,
				'donnees' => $lespatients
		) );
	}
	public function ajoutConstantesAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
		
		// Rechercher l'id du surveillant de service pour savoir quel surveillant a pris les constantes du patient
		$user = $this->layout()->user;
		$id_surveillant = $user->id_personne; //Ici c'est l'id du surveillant connecté

		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );

		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );

		// creer le formulaire
		$today = new \DateTime ();
		$date = $today->format ( 'Y-m-d H:i:s' );
		$form = new ConsultationForm ();
		$id_cons = $form->get ( 'id_cons' )->getValue ();
		$heure_cons = $form->get ( 'heure_cons' )->getValue ();
		// peupler le formulaire
		$dateonly = $today->format ( 'Y-m-d' );
		
		$consult = array (
				'id_patient' => $id_pat,
				'id_surveillant' => $id_surveillant,
				'date_cons' => $date,
				'dateonly' => $dateonly
		);
		$form->populateValues ( $consult );
		return new ViewModel ( array (
				'lesdetails' => $liste,
				'image' => $image,
				'form' => $form,
				'id_cons' => $id_cons,
				'heure_cons' => $heure_cons,
				'dateonly' => $consult['dateonly'],
		) );
	}
	
	public function ajoutDonneesConstantesAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$LeService = $this->layout ()->service; 

		// Rechercher l'id du service
		$service = $this->getServiceTable ();
		$LigneDuService = $service->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		$consModel = new Consultation ();

		if (isset ( $_POST ['terminer'] )) { 
			$form = new ConsultationForm ();
			$formData = $this->getRequest ()->getPost ();
			$test = $this->params()->fromPost('date_cons');
			$form->setData ( $formData );

			// instancier Consultation
			$consultation = $this->getConsultationTable ();
			$consultation->addConsultation ( $form, $IdDuService );

			//Recuperer les donnees sur les bandelettes urinaires
			//Recuperer les donnees sur les bandelettes urinaires
			$bandelettes = array(
					'id_cons' => $form->get ( "id_cons" )->getValue (),
					'albumine' => $form->get ( "albumine" )->getValue (),
					'sucre' => $form->get ( "sucre" )->getValue (),
					'corpscetonique' => $form->get ( "corpscetonique" )->getValue (),
					'croixalbumine' => $form->get ( "croixalbumine" )->getValue (),
					'croixsucre' => $form->get ( "croixsucre" )->getValue (),
					'croixcorpscetonique' => $form->get ( "croixcorpscetonique" )->getValue (),
			);
			$this->getConsultationTable ()->addBandelette($bandelettes);
			
			// instancier motif admission
			$motif_admission = $this->getMotifAdmissionTable ();
     	    $motif_admission->addMotifAdmission ( $form );

			return $this->redirect ()->toRoute ( 'consultation', array (
					'action' => 'recherche'
			));
		} 
	}
	
	public function majConsultationAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );

		$id_pat = $this->params ()->fromQuery ( 'id_patient', 0 );
		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );

		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );

		// Formulaire consultation
		$form = new ConsultationForm ();

		$id = $this->params ()->fromQuery ( 'id_cons', 0 );

		$cons = $this->getConsultationTable ();
		$consult = $cons->getConsult ( $id );

		// instancier le motif d'admission et recupï¿½rer l'enregistrement
		$motif = $this->getMotifAdmissionTable ();
		$motif_admission = $motif->getMotifAdmission ( $id );
		$nbMotif = $motif->nbMotifs ( $id );

		// Pour verifier la date du rendez vous afin de le signaler
		$rv = $this->getRvPatientConsTable ();
		$rendez_vous = $rv->getRendezVous ( $id );
		
		$data = array (
				'id_cons' => $consult->id_cons,
				'id_surveillant' => $consult->id_surveillant,
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

		$k = 1;
		foreach ( $motif_admission as $Motifs ) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k ++;
		}

		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable ()->getBandelette($id);
		
		$form->populateValues ( array_merge($data,$bandelettes) );
		return array (
				'lesdetails' => $liste,
				'image' => $image,
				'form' => $form,
				'id_cons' => $id,
				'verifieRV' => $rendez_vous,
				'heure_cons' => $consult->heurecons,
				'dateonly' => $consult->dateonly,
				'nbMotifs' => $nbMotif,
				'temoin' => $bandelettes['temoin']
		);
	}
	
	
	public function majConsDonneesAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$consultation = new Consultation ();
		
		if (isset ( $_POST ['terminer'] )) {
			$form = new ConsultationForm ();
			if ($this->getRequest ()->isPost ()) {
				$formData = $this->getRequest ()->getPost ();
				$form->setData ( $formData );

				//mettre a jour la consultation
				$this->getConsultationTable ()->updateConsultation ( $form );
				
				
				//Recuperer les donnees sur les bandelettes urinaires
				//Recuperer les donnees sur les bandelettes urinaires
				$bandelettes = array(
						'id_cons' => $form->get ( "id_cons" )->getValue (),
						'albumine' => $form->get ( "albumine" )->getValue (),
						'sucre' => $form->get ( "sucre" )->getValue (),
						'corpscetonique' => $form->get ( "corpscetonique" )->getValue (),
						'croixalbumine' => $form->get ( "croixalbumine" )->getValue (),
						'croixsucre' => $form->get ( "croixsucre" )->getValue (),
						'croixcorpscetonique' => $form->get ( "croixcorpscetonique" )->getValue (),
				);
				// mettre a jour les bandelettes urinaires
				$this->getConsultationTable ()->deleteBandelette($form->get ( "id_cons" )->getValue ());
				$this->getConsultationTable ()->addBandelette($bandelettes);
				
				
				
				// mettre a jour les motifs d'admission
				$this->getMotifAdmissionTable ()->deleteMotifAdmission ( $form->get ( 'id_cons' )->getValue () );
				$this->getMotifAdmissionTable ()->addMotifAdmission ( $form );
				
				return $this->redirect ()->toRoute ( 'consultation', array (
						'action' => 'recherche'
				) );
			}
		} else {
			return $this->redirect ()->toRoute ( 'consultation', array (
					'action' => 'recherche'
			) );
		}
	}
	// DonnÃ©es du patient Ã  consulter par le medecin et complÃ©ment Ã  faire par le medecin
	public function complementConsultationAction() { 
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		// Rechercher l'id du surveillant de service pour savoir quel surveillant a pris les constantes du patient
		$user = $this->layout()->user;
		$id_medecin = $user->id_personne; //Ici c'est l'id du surveillant connecté
		
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$id_pat = $this->params ()->fromQuery ( 'id_patient', 0 );
		$id = $this->params ()->fromQuery ( 'id_cons' );
		$consommable = $this->getConsommableTable();
		$listeMedicament = $consommable->listeDeTousLesMedicaments();
		$listeForme = $consommable->formesMedicaments();
		$listetypeQuantiteMedicament = $consommable->typeQuantiteMedicaments();
		
		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );

		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );

		$form = new ConsultationForm ();

		// instancier la consultation et rï¿½cupï¿½rer l'enregistrement
		$cons = $this->getConsultationTable ();
		$consult = $cons->getConsult ( $id );
		
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		$listeConsultation = $cons->getConsultationPatient($id_pat);
		//var_dump($listeConsultation); exit();

		// instancier le motif d'admission et recupï¿½rer l'enregistrement
		$motif = $this->getMotifAdmissionTable ();
		$motif_admission = $motif->getMotifAdmission ( $id );
		$nbMotif = $motif->nbMotifs ( $id );

		// instanciation du model transfert
		$transferer = $this->getTransfererPatientServiceTable ();
		// rï¿½cupï¿½ration de la liste des hopitaux
		$hopital = $transferer->fetchHopital ();
		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		// RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $transferer->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $transferer->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
		
		//Suppression du service actuel dans la liste des services a affiché pour le transfert du patient
		
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

		$data = array (
				'id_cons' => $consult->id_cons,
				'id_medecin' => $id_medecin,
				'id_patient' => $consult->pat_id_personne,
				'motif_admission' => $consult->motif_admission,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
				'temperature' => $consult->temperature,
				'pouls' => $consult->pouls,
				'frequence_respiratoire' => $consult->frequence_respiratoire,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
				'pressionarterielle' => $consult->pression_arterielle,
				'hopital_accueil' => $idHopital,
		);
		$k = 1;
		foreach ( $motif_admission as $Motifs ) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k ++;
		}
		
		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable ()->getBandelette($id);
		
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		//RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux  = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS 
		//FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		
		
		$form->populateValues ( array_merge($data,$bandelettes,$donneesAntecedentsPersonnels,$donneesAntecedentsFamiliaux) );
		return array (
				'lesdetails' => $liste,
				'id_cons' => $id,
				'nbMotifs' => $nbMotif,
				'image' => $image,
				'form' => $form,
				'heure_cons' => $consult->heurecons,
				'dateonly' => $consult->dateonly,
				'liste_med' => $listeMedicament,
				'temoin' => $bandelettes['temoin'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament'  => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux'  => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
		);
	}
	
	public function majComplementConsultationAction() {

		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		 $this->layout ()->setTemplate ( 'layout/consultation' );
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
		  if($donneesDemandeVPA) {
		  	$data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
		  	$data['observation'] = $donneesDemandeVPA['OBSERVATION'];
		  	$data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
		  	$data['numero_vpa'] = $donneesDemandeVPA['NUMERO_VPA'];
		  	$data['type_anesthesie_demande'] = 2;//$donneesDemandeVPA['TYPE_ANESTHESIE_DEMANDE'];
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
		  );
	
	}
	
	//***-*-*-*-*-*-*-*-**-*-*-*-*--*-**-*-*-*-*-*-*-*--*--**-*-*-*-*-*-**-*-*-*--**-*-*-*-*-*--*-**-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-
	//***-**-*-*-*-*-**-*-*-*-*-*-*-*-*-*--**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*-**--*-**-*-*-
	//MISE A JOUR DES DONNEES DU DOSSIER DU PATIENT
	//***************************************************
	//***************************************************
	public function updateComplementConsultationAction(){
		$this->getDateHelper();
		$id_cons = $this->params()->fromPost('id_cons');
		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		//**********-- MODIFICATION DES CONSTANTES --********
		//**********-- MODIFICATION DES CONSTANTES --********
		//**********-- MODIFICATION DES CONSTANTES --********
		$form = new ConsultationForm ();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
		
		// mettre a jour les motifs d'admission
		$this->getMotifAdmissionTable ()->deleteMotifAdmission ( $id_cons );
		$this->getMotifAdmissionTable ()->addMotifAdmission ( $form );
		
		//mettre a jour la consultation
		$this->getConsultationTable ()->updateConsultation ( $form );
		
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
		$examen = $this->getDonneesExamensPhysiquesTable();
		$examen->updateExamenPhysique($info_donnees_examen_physique);
		
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
				'type_anesthesie' => $this->params()->fromPost("type_anesthesie_demande"),
				'numero_vpa' => $this->params()->fromPost("numero_vpa"),
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
			$consultation = $this->getConsultationTable ();
			$consultation->validerConsultation ( $valide );
		}
		
		return $this->redirect ()->toRoute ( 'consultation', array (
		 'action' => 'consultation-medecin'
		) );
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
	
	public function visualisationConsultationAction(){

		$LeService = $this->layout ()->service;
		$LigneDuService = $this->getServiceTable ()->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];
		
		 $this->layout ()->setTemplate ( 'layout/consultation' );
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
		  if($donneesDemandeVPA) {
		  	$data['diagnostic_traitement_chirurgical'] = $donneesDemandeVPA['DIAGNOSTIC'];
		  	$data['observation'] = $donneesDemandeVPA['OBSERVATION'];
		  	$data['intervention_prevue'] = $donneesDemandeVPA['INTERVENTION_PREVUE'];
		  	$data['numero_vpa'] = $donneesDemandeVPA['NUMERO_VPA'];
		  	$data['type_anesthesie_demande'] = 2;//$donneesDemandeVPA['TYPE_ANESTHESIE_DEMANDE'];
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
		  );
	
	}
	
	
	public function impressionPdfAction(){
		
		//*************************************
		//*************************************
		//***DONNEES COMMUNES A TOUS LES PDF***
		//*************************************
		//*************************************
		$id_patient = $this->params ()->fromPost ( 'id_patient', 0 );
		$id_cons = $this->params ()->fromPost ( 'id_cons', 0 );
		
		//*************************************
		$infoServiceMedecin = $this->getConsultationTable();
		$values = $infoServiceMedecin->getInfoPatientMedecin($id_cons);
		foreach ($values as $val) {
			//Information sur le médecin
			$donneesMedecin['service'] = $val['NomService'];
			$donneesMedecin['nomMedecin'] = $val['NomMedecin'];
			$donneesMedecin['prenomMedecin'] = $val['PrenomMedecin'];
			//Information sur le patient
			$donneesPatient['nomPatient'] = $val['NOM'];
			$donneesPatient['prenomPatient'] = $val['PRENOM'];
			$donneesPatient['adressePatient'] = $val['ADRESSE'];
			$donneesPatient['dateNaissancePatient'] = $val['DATE_NAISSANCE'];
			$donneesPatient['sexePatient'] = $val['SEXE'];
		}
		
		//**********ORDONNANCE*****************
		//**********ORDONNANCE*****************
		//**********ORDONNANCE*****************
		if(isset($_POST['ordonnance'])){
			//RECUPERATION DE LA LISTE DES MEDICAMENTS
			$consommable = $this->getconsommableTable();
			//récupération de la liste des médicaments
			$medicaments = $consommable->fetchConsommable();
			
			$tab = array();
			$j = 1;
			
// 			for($i = 1 ; $i < 10 ; $i++ ){
// 				$codeMedicament = $this->params()->fromPost("medicament_0".$i);
// 				//var_dump($codeMedicament); exit();
// 				if($codeMedicament == true){
// 					$tab[$j++] = $medicaments[$codeMedicament]; //on récupère le médicament par son nom
// 					$tab[$j++] = $this->params()->fromPost("medicament_1".$i);
// 					$tab[$j++] = $this->params()->fromPost("medicament_2".$i);
// 					//$tab[$j++] = $this->params()->fromPost("medicament_3".$i);
// 				}
// 			}
			
			//NOUVEAU CODE AVEC AUTOCOMPLETION 
			for($i = 1 ; $i < 10 ; $i++ ){
				$nomMedicament = $this->params()->fromPost("medicament_0".$i);
				if($nomMedicament == true){
					$tab[$j++] = $this->params()->fromPost("medicament_0".$i);
					$tab[$j++] = $this->params()->fromPost("forme_".$i);
					$tab[$j++] = $this->params()->fromPost("nb_medicament_".$i);
					$tab[$j++] = $this->params()->fromPost("quantite_".$i);
				}
			}
			
			$patient = $this->getPatientTable();
			$donneesPatientOR = $patient->getPatient($id_patient);
			//\Zend\Debug\Debug::dump($donneesPatient); exit();
			//-***************************************************************
			//Création du fichier pdf
			//*************************
			//Créer le document
			$DocPdf = new DocumentPdf();
			//Créer la page
			$page = new OrdonnancePdf();

			//Envoyer l'id_cons
			$page->setIdCons($id_cons);
			//Envoyer les données sur le partient
			$page->setDonneesPatient($donneesPatientOR);
			//Envoyer les médicaments
			$page->setMedicaments($tab);
			
			//Ajouter une note à la page
			$page->addNote();
			//Ajouter la page au document
			$DocPdf->addPage($page->getPage());

			//Afficher le document contenant la page
			$DocPdf->getDocument();
		}
		else
		//**********TRAITEMENT CHIRURGICAL*****************
		//**********TRAITEMENT CHIRURGICAL*****************
		//**********TRAITEMENT CHIRURGICAL*****************
		if(isset($_POST['traitement_chirurgical'])){
			//Récupération des données
			$donneesDemande['diagnostic'] = $this->params ()->fromPost ( 'diagnostic_traitement_chirurgical' );
			$donneesDemande['intervention_prevue'] = $this->params ()->fromPost (  'intervention_prevue' );
			$donneesDemande['type_anesthesie_demande'] = $this->params()->fromPost('type_anesthesie_demande');
			$donneesDemande['numero_vpa'] = $this->params()->fromPost('numero_vpa');
			$donneesDemande['observation'] = $this->params()->fromPost('observation');
			
			//CREATION DU DOCUMENT PDF
			//Créer le document
			$DocPdf = new DocumentPdf();
			//Créer la page
			$page = new TraitementChirurgicalPdf();
			
			//Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			//Envoi des données du patient
			$page->setDonneesPatientTC($donneesPatient);
			//Envoi des données du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			//Envoi les données de la demande
			$page->setDonneesDemandeTC($donneesDemande);
			
			//Ajouter les donnees a la page
			$page->addNoteTC();
			//Ajouter la page au document
			$DocPdf->addPage($page->getPage());
			
			//Afficher le document contenant la page
			$DocPdf->getDocument();
			
		}
		else 
		//**********TRANSFERT DU PATIENT*****************
		//**********TRANSFERT DU PATIENT*****************
		//**********TRANSFERT DU PATIENT*****************
			if (isset ($_POST['transfert']))
			{
				$id_hopital = $this->params()->fromPost('hopital_accueil_tampon');
				$id_service = $this->params()->fromPost('service_accueil_tampon');
				$motif_transfert = $this->params()->fromPost('motif_transfert');
		
				//Récupérer le nom du service d'accueil
 				$service = $this->getServiceTable();
 				$infoService = $service->getServiceparId($id_service);
 				//Récupérer le nom de l'hopital d'accueil
 				$hopital = $this->getHopitalTable();
 				$infoHopital = $hopital->getHopitalParId($id_hopital);
 				
 				$donneesDemandeT['NomService'] = $infoService['NOM'];
 				$donneesDemandeT['NomHopital'] = $infoHopital['NOM_HOPITAL'];
 				$donneesDemandeT['MotifTransfert'] = $motif_transfert;

				//-***************************************************************
				//Création du fichier pdf
			
				//-***************************************************************
 				//Créer le document
 				$DocPdf = new DocumentPdf();
 				//Créer la page
 				$page = new TransfertPdf();
 					
 				//Envoi Id de la consultation
 				$page->setIdConsT($id_cons);
 				//Envoi des données du patient
 				$page->setDonneesPatientT($donneesPatient);
 				//Envoi des données du medecin
 				$page->setDonneesMedecinT($donneesMedecin);
 				//Envoi les données de la demande
 				$page->setDonneesDemandeT($donneesDemandeT);
 					
 				//Ajouter les donnees a la page
 				$page->addNoteT();
 				//Ajouter la page au document
 				$DocPdf->addPage($page->getPage());
 					
 				//Afficher le document contenant la page
 				$DocPdf->getDocument();
			}
			else
			//**********RENDEZ VOUS ****************
			//**********RENDEZ VOUS ****************
			//**********RENDEZ VOUS ****************
			if(isset ($_POST['rendezvous'])){
					
				$donneesDemandeT['dateRv'] = $this->params()->fromPost('date_rv_tampon');
				$donneesDemandeT['heureRV']   = $this->params()->fromPost('heure_rv_tampon');
				$donneesDemandeT['MotifRV'] = $this->params()->fromPost('motif_rv');
				
				//\Zend\Debug\Debug::dump($note); exit();
				//Création du fichier pdf
				//Créer le document
				$DocPdf = new DocumentPdf();
				//Créer la page
				$page = new RendezVousPdf();
				
				//Envoi Id de la consultation
				$page->setIdConsR($id_cons);
				//Envoi des données du patient
				$page->setDonneesPatientR($donneesPatient);
				//Envoi des données du medecin
				$page->setDonneesMedecinR($donneesMedecin);
				//Envoi les données du redez vous
				$page->setDonneesDemandeR($donneesDemandeT);
				
				//Ajouter les donnees a la page
				$page->addNoteR();
				//Ajouter la page au document
				$DocPdf->addPage($page->getPage());
				
				//Afficher le document contenant la page
				$DocPdf->getDocument();
			
			}
			
	}
	
	//********************************************************
	//********************************************************
	//********************************************************
	public function imagesExamensMorphologiquesAction()
	{
		$id_cons = $this->params()->fromPost( 'id_cons' );
		$ajout = (int)$this->params()->fromPost( 'ajout' );
		$idExamen = (int)$this->params()->fromPost( 'typeExamen' ); /*Le type d'examen*/
		
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
			
			if($fileBase64 && $typeFichier == 'image' && $formatFichier =='jpeg'){
				$img = imagecreatefromstring(base64_decode($fileBase64));
				if($img){
					$resultatAjout = $this->demandeExamensTable()->ajouterImage($id_cons, $idExamen, $nomImage, $date_enregistrement);
				}
				if($resultatAjout){
					imagejpeg ( $img, 'C:\wamp\www\simens\public\images\images\\' . $nomImage . '.jpg' );
				}
			}
		}
		
		/**
		 * RECUPERATION DE TOUS LES RESULTATS DES EXAMENS MORPHOLOGIQUES
		 */
 		$result = $this->demandeExamensTable()->resultatExamens($id_cons);

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
	public function testAction(){
		
	}
}
