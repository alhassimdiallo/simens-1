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
		$user = $this->layout ()->user;
		$service = $user ['service'];
		$patient = $this->getPatientTable ();
		$patientsAdmis = $patient->tousPatientsAdmis ( $service );
		$view = new ViewModel ( array (
				'donnees' => $patientsAdmis
		) );
		return $view;
	}
	public function espaceRechercheMedAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$user = $this->layout ()->user;
		$service = $user ['service'];
		$patients = $this->getPatientTable ();
		$tab = $patients->listePatientsConsMedecin ( $service );
		return new ViewModel ( array (
				'donnees' => $tab
		) );
	}
	public function espaceRechercheSurvAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$user = $this->layout ()->user;
		$service = $user ['service'];
		$patients = $this->getPatientTable ();
		$tab = $patients->tousPatientsCons ( $service );
		return new ViewModel ( array (
				'donnees' => $tab
		) );
	}
	// Liste des patients Ã  consulter par le medecin aprï¿½s prise des constantes par le surveillant de service
	public function consultationMedecinAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$user = $this->layout ()->user;
		$service = $user ['service'];
		// $LeService = $this->_service;
		// Recherher l'id du service
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
		// var_dump($id_pat);exit();
		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );

		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );

		// crÃ©er le formulaire
		$today = new \DateTime ();
		$date = $today->format ( 'Y-m-d H:i:s' );
		$form = new ConsultationForm ();
		$id_cons = $form->get ( 'id_cons' )->getValue ();
		$heure_cons = $form->get ( 'heure_cons' )->getValue ();
		// peupler le formulaire
		$dateonly = $today->format ( 'Y-m-d' );
		$id_med = 100;
		$consult = array (
				'id_patient' => $id_pat,
				'id_medecin' => $id_med,
				'date_cons' => $date,
				'dateonly' => $dateonly
		);
		$form->populateValues ( $consult );
		return new ViewModel ( array (
				'lesdetails' => $liste,
				'image' => $image,
				'form' => $form,
				'id_cons' => $id_cons,
				'heure_cons' => $heure_cons
		) );
	}
	public function ajoutDonneesConstantesAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$user = $this->layout ()->user;
		$LeService = $user ['service'];
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
			$form->remove('heure_rv');
			$form->remove('type_anesthesie_demande');
			$form->remove('hopital_accueil');
			$form->remove('service_accueil');
			if ($form->isValid() == true) {
				
				$id_cons = $form->get ( "id_cons" )->getValue ();
				$infos = $form->getData ();
				
				// instancier Consultation
				$consultation = $this->getConsultationTable ();
				$consultation->addConsultation ( $infos, $IdDuService );

				// instancier motif admission
				$motif_admission = $this->getMotifAdmissionTable ();
				$motif_admission->addMotifAdmission ( $infos );

				$this->redirect ()->toRoute ( 'consultation', array (
						'action' => 'recherche'
				));
			}
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
				'id_medecin' => $consult->id_personne,
				'id_patient' => $consult->pat_id_personne,
				'motif_admission' => $consult->motif_admission,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
				'temperature' => $consult->temperature,
				'tension' => $consult->tension,
				'pouls' => $consult->pouls,
				'frequence_respiratoire' => $consult->frequence_respiratoire,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
				'bu' => $consult->bu
		);

		$k = 1;
		foreach ( $motif_admission as $Motifs ) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k ++;
		}

		$form->populateValues ( $data );
		return array (
				'lesdetails' => $liste,
				'image' => $image,
				'form' => $form,
				'id_cons' => $id,
				'verifieRV' => $rendez_vous,
				'heure_cons' => $consult->heurecons,
				'nbMotifs' => $nbMotif
		);
	}
	public function majConsDonneesAction() {
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$consultation = new Consultation ();
		if (isset ( $_POST ['terminer'] )) {

			$form = new ConsultationForm ();
			//$form->bind ( $consultation );
			if ($this->getRequest ()->isPost ()) {
				$formData = $this->getRequest ()->getPost ();
				//$form->setInputFilter ( $consultation->getInputFilter () );
				$form->setData ( $formData );
				$form->remove('heure_rv');
				$form->remove('type_anesthesie_demande');
				$form->remove('hopital_accueil');
				$form->remove('service_accueil');
				
				if ($form->isValid ()) {
					$infos = $form->getData ();

					// mettre a jour la consultation
					$cons = $this->getConsultationTable ();
					$cons->updateConsultation ( $infos );
					
					// mettre a jour les motifs d'admission
					$motifs = $this->getMotifAdmissionTable ();
					$motifs->deleteMotifAdmission ( $form->get ( 'id_cons' )->getValue () );
					$motifs->addMotifAdmission ( $infos );
					
					$this->redirect ()->toRoute ( 'consultation', array (
							'action' => 'recherche'
					) );
				}
				$this->redirect ()->toRoute ( 'consultation', array (
						'action' => 'recherche'
				) );
			}
		} else {
			$this->redirect ()->toRoute ( 'consultation', array (
					'action' => 'recherche'
			) );
		}
	}
	// DonnÃ©es du patient Ã  consulter par le medecin et complÃ©ment Ã  faire par le medecin
	public function complementConsultationAction() { 
		$this->layout ()->setTemplate ( 'layout/consultation' );
		$id_pat = $this->params ()->fromQuery ( 'id_patient', 0 );
		$id = $this->params ()->fromQuery ( 'id_cons' );
		$consommable = $this->getConsommableTable();
		$listeMedicament = $consommable->fetchConsommable();
		$list = $this->getPatientTable ();
		$liste = $list->getPatient ( $id_pat );

		// Recuperer la photo du patient
		$image = $list->getPhoto ( $id_pat );

		$form = new ConsultationForm ();

		// instancier la consultation et rï¿½cupï¿½rer l'enregistrement
		$cons = $this->getConsultationTable ();
		$consult = $cons->getConsult ( $id );

		// instancier le motif d'admission et recupï¿½rer l'enregistrement
		$motif = $this->getMotifAdmissionTable ();
		$motif_admission = $motif->getMotifAdmission ( $id );
		$nbMotif = $motif->nbMotifs ( $id );

		// instanciation du model transfert
		$transferer = $this->getTransfererPatientServiceTable ();
		// rï¿½cupï¿½ration de la liste des hopitaux
		$hopital = $transferer->fetchHopital ();

		$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );

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
				'id_medecin' => $consult->id_personne,
				'id_patient' => $consult->pat_id_personne,
				'motif_admission' => $consult->motif_admission,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
				'temperature' => $consult->temperature,
				'tension' => $consult->tension,
				'pouls' => $consult->pouls,
				'frequence_respiratoire' => $consult->frequence_respiratoire,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
				'bu' => $consult->bu
		);
		$k = 1;
		foreach ( $motif_admission as $Motifs ) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k ++;
		}
		$form->populateValues ( $data );
		return array (
				'lesdetails' => $liste,
				'id_cons' => $id,
				'nbMotifs' => $nbMotif,
				'image' => $image,
				'form' => $form,
				'heure_cons' => $consult->heurecons,
				'liste_med' => $listeMedicament

		);

	}
	public function majComplementConsultationAction() {

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
		  // instancier la consultation et rï¿½cupï¿½rer l'enregistrement
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
		 		'tension' => $consult->tension,
		 		'pouls' => $consult->pouls,
		 		'frequence_respiratoire' => $consult->frequence_respiratoire,
		 		'glycemie_capillaire' => $consult->glycemie_capillaire,
		 		'bu' => $consult->bu
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
		  $k = 1;
		  foreach ($examen_physique as $Examen) {
		  	$data['examen_donnee'.$k] = $Examen['libelle_examen'];
		  	$k++;
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
		  $listeDemandes = $demandeExamen->getDemande($id);
		  
		  //\Zend\Debug\Debug::dump($donnee); exit();
		  
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
		  $listeMedicament = $consommable->fetchConsommable();

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
		  //\Zend\Debug\Debug::dump($donneesDemandeVPA['DIAGNOSTIC']); exit();
		  
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
		  
		  $form->populateValues($data);
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
		  		'listeDemande' => $listeDemandes,
		  		'hopitalSelect' =>$hopitalSelect
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
		
		//POUR LES DEMANDES DES EXAMENS BIOLOGIQUES ET MORPHOLOGIQUES 
		//POUR LES DEMANDES DES EXAMENS BIOLOGIQUES ET MORPHOLOGIQUES 
		//POUR LES DEMANDES DES EXAMENS BIOLOGIQUES ET MORPHOLOGIQUES
		
		$examenDemande = array(
				'id_cons'=> $id_cons,
				'1'  => $this->params()->fromPost('groupe'),
				'2'  => $this->params()->fromPost('hemmogramme'),
				'3'  => $this->params()->fromPost('hepatique'),
				'4'  => $this->params()->fromPost('renal'),
				'5'  => $this->params()->fromPost('hemostase'),
				'6'  => $this->params()->fromPost('inflammatoire'),
				'7'  => $this->params()->fromPost('autreb'),
				'8'  => $this->params()->fromPost('radio'),
				'9'  => $this->params()->fromPost('ecographie'),
				'10' => $this->params()->fromPost('irm'),
				'11' => $this->params()->fromPost('scanner'),
				'12' => $this->params()->fromPost('fibroscopie'),
				'13' => $this->params()->fromPost('autrem'),
		);
		
		$noteExamen = array(
				'1'  => $this->params()->fromPost('ngroupe'),
				'2'  => $this->params()->fromPost('nhemmogramme'),
				'3'  => $this->params()->fromPost('nhepatique'),
				'4'  => $this->params()->fromPost('nrenal'),
				'5'  => $this->params()->fromPost('nhemostase'),
				'6'  => $this->params()->fromPost('ninflammatoire'),
				'7'  => $this->params()->fromPost('nautreb'),
				'8'  => $this->params()->fromPost('nradio'),
				'9'  => $this->params()->fromPost('necographie'),
				'10' => $this->params()->fromPost('nirm'),
				'11' => $this->params()->fromPost('nscanner'),
				'12' => $this->params()->fromPost('nfibroscopie'),
				'13' => $this->params()->fromPost('nautrem')
		);
		
		$demandeExamens = $this->demandeExamensTable();
		$demandeExamens->updateDemande($examenDemande, $noteExamen);
		
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
		$tab = array();
		$j = 1;
		for($i = 1 ; $i < 10 ; $i++ ){
			if($this->params()->fromPost("medicament_0".$i)){
				$tab[$j++] = $this->params()->fromPost("medicament_0".$i);
				$tab[$j++] = $this->params()->fromPost("medicament_1".$i);
				$tab[$j++] = $this->params()->fromPost("medicament_2".$i);
				$tab[$j++] = $this->params()->fromPost("medicament_3".$i);
			}
		}

		/*Mettre a jour la duree du traitement de l'ordonnance*/
		$Ordonnance = $this->getOrdonnanceTable();
		$idOrdonnance = $Ordonnance->updateOrdonnance($tab, $donnees);

		/*Mettre a jour les medicaments*/
		$Consommable = $this->getOrdonConsommableTable();
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
				'ID_SERVICE'  => '2',
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
		//\Zend\Debug\Debug::dump($info_transfert); exit();
		
		//POUR LA PAGE complement-consultation
		//POUR LA PAGE complement-consultation
		//POUR LA PAGE complement-consultation
		if ($this->params ()->fromPost ( 'terminer' ) == 'save') {
		
			//VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
			$valide = array (
					'valide' => 1,
					'id_cons' => $id_cons
			);
			$consultation = $this->getConsultationTable ();
			$consultation->validerConsultation ( $valide );
		}
		
		$this->redirect ()->toRoute ( 'consultation', array (
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
			
			for($i = 1 ; $i < 10 ; $i++ ){
				$codeMedicament = $this->params()->fromPost("medicament_0".$i);
				if($codeMedicament == true){
					$tab[$j++] = $medicaments[$codeMedicament]; //on récupère le médicament par son nom
					$tab[$j++] = $this->params()->fromPost("medicament_1".$i);
					$tab[$j++] = $this->params()->fromPost("medicament_2".$i);
					$tab[$j++] = $this->params()->fromPost("medicament_3".$i);
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
}
