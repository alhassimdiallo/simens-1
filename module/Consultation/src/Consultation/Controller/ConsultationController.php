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
	// Liste des patients à consulter par le medecin apr�s prise des constantes par le surveillant de service
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

		if ($this->params ()->fromRoute ( 'terminer' ) == 'save') {

			// Donn�es COMMUNES A TOUTES LES INTERFACES
			$id_cons = $this->params ()->fromPost ( 'id_cons' );

			// VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
			$valide = array (
					'valide' => 1,
					'id_cons' => $id_cons
			);
			$consultation = $this->getConsultationTable ();
			$consultation->validerConsultation ( $valide );

			// **********-- Donnees de l'examen physique --*******
			// **********-- Donnees de l'examen physique --*******
			$DONNEE1 = $this->params ()->fromPost ( 'examen_donnee1' );
			$DONNEE2 = $this->params ()->fromPost ( 'examen_donnee2' );
			$DONNEE3 = $this->params ()->fromPost ( 'examen_donnee3' );
			$DONNEE4 = $this->params ()->fromPost ( 'examen_donnee4' );
			$DONNEE5 = $this->params ()->fromPost ( 'examen_donnee5' );

			$info_donnees_examen_physique = array (
					'id_cons' => $id_cons,
					'donnee1' => $DONNEE1,
					'donnee2' => $DONNEE2,
					'donnee3' => $DONNEE3,
					'donnee4' => $DONNEE4,
					'donnee5' => $DONNEE5
			);
			$cons_donnees_examen_physique = new Consultation_Model_Managers_ExamenPhysiquee ();
			$cons_donnees_examen_physique->addExamenPhysique ( $info_donnees_examen_physique );

			/**
			 * ************** EXAMEN MORPHOLOGIQUE ***********************
			 */
			/**
			 * ************** EXAMEN MORPHOLOGIQUE ***********************
			 */
			$RADIO = $this->getParam ( 'radio_' );
			$ECOGRAPHIE = $this->getParam ( 'ecographie_' );
			$FIBROSCOPIE = $this->getParam ( 'fibroscopie_' );
			$SCANNER = $this->getParam ( 'scanner_' );
			$IRM = $this->getParam ( 'irm_' );

			$info_examen_morphologique = array (
					'id_cons' => $id_cons,
					'8' => $RADIO,
					'9' => $ECOGRAPHIE,
					'12' => $IRM,
					'11' => $SCANNER,
					'10' => $FIBROSCOPIE
			);
			$cons_examen_morphologique = new Consultation_Model_Managers_NoteExamensMorphologiques ();
			$cons_examen_morphologique->addNotesExamensMorphologiques ( $info_examen_morphologique );

			/**
			 * *******************FIN FIN Examen compl�mentaire *****************
			 */
			/**
			 * *******************FIN FIN Examen compl�mentaire *****************
			 */

			/**
			 * ********* DIAGNOSTICS ***********
			 */
			/**
			 * ********* DIAGNOSTICS ***********
			 */
			$diagnostic1 = $this->getParam ( 'diagnostic1' );
			$diagnostic2 = $this->getParam ( 'diagnostic2' );
			$diagnostic3 = $this->getParam ( 'diagnostic3' );
			$diagnostic4 = $this->getParam ( 'diagnostic4' );

			$info_diagnostics = array (
					'id_cons' => $id_cons,
					'diagnostic1' => $diagnostic1,
					'diagnostic2' => $diagnostic2,
					'diagnostic3' => $diagnostic3,
					'diagnostic4' => $diagnostic4
			);
			$cons_diagnostics = new Consultation_Model_Managers_Diagnostics ();
			$cons_diagnostics->addDiagnostics ( $info_diagnostics );

			/**
			 * ******************Traitement (Ordonnance)**********************
			 */
			/**
			 * ******************Traitement (Ordonnance)**********************
			 */

			/**
			 * ** MEDICAL ***
			 */
			/**
			 * ** MEDICAL ***
			 */
			$date = Zend_Date::now ()->toString ( 'yyyy-MM-dd HH:mm:ss' );
			$duree = $this->getParam ( 'duree_traitement_ord' );
			$donnees = array (
					'id_cons' => $id_cons,
					'date_prescription' => $date,
					'duree_traitement' => $duree
			);
			$tab = array ();
			$j = 1;
			for($i = 1; $i < 10; $i ++) {
				if ($this->getParam ( "medicament_0" . $i )) {
					$tab [$j ++] = $this->getParam ( "medicament_0" . $i );
					$tab [$j ++] = $this->getParam ( "medicament_1" . $i );
					$tab [$j ++] = $this->getParam ( "medicament_2" . $i );
					$tab [$j ++] = $this->getParam ( "medicament_3" . $i );
				}
			}
			$ordonnance = new Consultation_Model_Managers_Ordonnance ();
			$id_ordonnance = $ordonnance->addOrdonnance ( $donnees ); // on ajoute l'ordonnace
			$tab [0] = $id_ordonnance; // r�cup�rer l'id de l'ordonnance et l'ajouter dans le tableau
			$medicaments = new Consultation_Model_Managers_OrdonConsommable ();
			$medicaments->addOrdonConsom ( $tab ); // on ajoute les m�dicaments dans l'ordonnance

			/**
			 * ** TRAITEMENTS CHIRURGICAUX ***
			 */
			/**
			 * ** TRAITEMENTS CHIRURGICAUX ***
			 */
			$diagnostic_traitement_chirurgical = $this->getParam ( "diagnostic_traitement_chirurgical" );
			$intervention_prevue = $this->getParam ( "intervention_prevue" );
			$type_anesthesie_demande = $this->getParam ( "type_anesthesie_demande" );
			$numero_vpa = $this->getParam ( "numero_vpa" );
			$observation = $this->getParam ( "observation" );

			// Cr�er le traitement chirurgical
			$info_traitement = array (
					'diagnostic' => $diagnostic_traitement_chirurgical,
					'intervention_prevue' => $intervention_prevue,
					'type_anesthesie' => $type_anesthesie_demande,
					'numero_vpa' => $numero_vpa,
					'observation' => $observation,
					'idcons' => $id_cons
			);

			$ordonnance->insertTraitementsChirurgicaux ( $info_traitement );

			/**
			 * ***********Autres(Transfert/Hospitalisation/ Rendez-Vous )**************
			 */
			/**
			 * ***********Autres(Transfert/Hospitalisation/ Rendez-Vous )**************
			 */

			/**
			 * ** RENDEZ VOUS ***
			 */
			/**
			 * ** RENDEZ VOUS ***
			 */
			$Control = new Facturation_Model_Helpers_Aides ();

			$ID_PERSONNE = $this->getParam ( 'id_patient' );

			// On teste d'abord si le rendez-vous est saisi
			$date_RV_Recu = $this->getParam ( 'date_rv' );
			if ($date_RV_Recu) {
				$date_RV = $Control->convertDateInAnglais ( $date_RV_Recu );
			} else {
				$date_RV = $date_RV_Recu;
			}

			// $date_RV = $Control->convertDateInAnglais($this->getParam('date_rv'));
			$note = $this->getParam ( 'motif_rv' );
			$heure_rv = $this->getParam ( 'heure_rv' );
			// cr�er le Rendez vous et inserer le RV
			$infos_rv = array (
					'id_personne' => $ID_PERSONNE,
					'id_service' => '2',
					'id_cons' => $id_cons,
					'date_RV' => $date_RV,
					'note_prise' => $note,
					'heure_rv' => $heure_rv
			);
			$cons_rv = new Consultation_Model_Managers_RvPatientCons ();
			$cons_rv->insererRendezVous ( $infos_rv );

			/**
			 * ** HOSPITALISATION ***
			 */
			/**
			 * ** HOSPITALISATION ***
			 */
			// $MOTIF_HOSPITALISATION = $this->getParam('motif_hospitalisation');

			/**
			 * ** TRANSFERT ***
			 */
			/**
			 * ** TRANSFERT ***
			 */
			$ID_SERVICE = $this->getParam ( 'id_service' );
			$MED_ID_PERSONNE = $this->getParam ( 'med_id_personne' );
			$DATE = $this->getParam ( 'date' );
			$MOTIF_TRANSFERT = $this->getParam ( 'motif_transfert' );

			$info_transfert = array (
					'id_service' => $ID_SERVICE,
					'id_personne' => $ID_PERSONNE,
					'med_id_personne' => $MED_ID_PERSONNE,
					'date' => $DATE,
					'motif_transfert' => $MOTIF_TRANSFERT,
					'idcons' => $id_cons
			);
			$cons_transfert = new Consultation_Model_Managers_TransfererPatientService ();
			$cons_transfert->insererTransfertPatientService ( $info_transfert );

			/**
			 * *********** FIN FIN Autres(Transfert/Hospitalisation/ Rendez-Vous )**************
			 */
			/**
			 * *********** FIN FIN Autres(Transfert/Hospitalisation/ Rendez-Vous )**************
			 */

			/**
			 * ****************** Demande examens (Biologique et morphologiqe) ******************
			 */
			/**
			 * ****************** Demande examens (Biologique et morphologiqe) ******************
			 */
			/**
			 * ****************** Demande examens (Biologique et morphologiqe) ******************
			 */
			$groupe = $this->getParam ( 'groupe' );
			$hemmogrammes = $this->getParam ( 'hemmogramme' );
			$hepatiques = $this->getParam ( 'hepatique' );
			$renals = $this->getParam ( 'renal' );
			$hemostase = $this->getParam ( 'hemostase' );
			$inflammatoires = $this->getParam ( 'inflammatoire' );
			$radios = $this->getParam ( 'radio' );
			$ecographies = $this->getParam ( 'ecographie' );
			$fibroscopies = $this->getParam ( 'fibroscopie' );
			$scanners = $this->getParam ( 'scanner' );
			$irms = $this->getParam ( 'irm' );
			$autreb = $this->getParam ( 'autreb' );
			$autrem = $this->getParam ( 'autrem' );

			$examenDemande = array (
					'idcons' => $id_cons
			);
			$examenDemande [1] = $groupe;
			$examenDemande [2] = $hemmogrammes;
			$examenDemande [3] = $hepatiques;
			$examenDemande [4] = $renals;
			$examenDemande [5] = $hemostase;
			$examenDemande [6] = $inflammatoires;
			$examenDemande [7] = $autreb;
			$examenDemande [8] = $radios;
			$examenDemande [9] = $ecographies;
			$examenDemande [10] = $irms;
			$examenDemande [11] = $scanners;
			$examenDemande [12] = $fibroscopies;
			$examenDemande [13] = $autrem;

			// --- NOTE SUR LES EXAMENS
			$ngroupe = $this->getParam ( 'ngroupe' );
			$nhemmogramme = $this->getParam ( 'nhemmogramme' );
			$nhepatique = $this->getParam ( 'nhepatique' );
			$nrenal = $this->getParam ( 'nrenal' );
			$nhemostase = $this->getParam ( 'nhemostase' );
			$ninflammatoire = $this->getParam ( 'ninflammatoire' );
			$nradio = $this->getParam ( 'nradio' );
			$necographie = $this->getParam ( 'necographie' );
			$nfibroscopie = $this->getParam ( 'nfibroscopie' );
			$nscanner = $this->getParam ( 'nscanner' );
			$nirm = $this->getParam ( 'nirm' );
			$nautreb = $this->getParam ( 'nautreb' );
			$nautrem = $this->getParam ( 'nautrem' );

			$noteExamen = array ();
			$noteExamen [1] = $ngroupe;
			$noteExamen [2] = $nhemmogramme;
			$noteExamen [3] = $nhepatique;
			$noteExamen [4] = $nrenal;
			$noteExamen [5] = $nhemostase;
			$noteExamen [6] = $ninflammatoire;
			$noteExamen [7] = $nautreb;
			$noteExamen [8] = $nradio;
			$noteExamen [9] = $necographie;
			$noteExamen [10] = $nirm;
			$noteExamen [11] = $nscanner;
			$noteExamen [12] = $nfibroscopie;
			$noteExamen [13] = $nautrem;

			// On ajoute la demande dans la table Demande_Examen s'il y'a au moins un examen demand�
			$dateonly = Zend_Date::now ()->toString ( 'yyyy-MM-dd' );
			$values = array (
					'idcons' => $id_cons,
					'date' => $dateonly
			);
			$demandeExamen = new Consultation_Model_Managers_DemandeExamen ();
			$demandeExamen->addDemandeExamen ( $values, $examenDemande );

			// On ajoute la liste des examens demand�es dans la table Demande_Liste_Examen
			$listeDemandeExamen = new Consultation_Model_Managers_DemandeListeExamen ();
			$listeDemandeExamen->addDemandeListeExamen ( $examenDemande, $noteExamen );

			$this->redirect ()->toRoute ( 'consultation', array (
					'action' => 'consultation-medecin'
			) );
		}

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

		// créer le formulaire
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
			//$form->setInputFilter ( $consModel->getInputFilter () );
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

		// instancier le motif d'admission et recup�rer l'enregistrement
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
			$form->bind ( $consultation );
			if ($this->getRequest ()->isPost ()) {

				$formData = $this->getRequest ()->getPost ();

				$form->setInputFilter ( $consultation->getInputFilter () );
				$form->setData ( $formData );
				//var_dump ( $form->isValid () );
				//exit ();
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
	// Données du patient à consulter par le medecin et complément à faire par le medecin
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

		// instancier la consultation et r�cup�rer l'enregistrement
		$cons = $this->getConsultationTable ();
		$consult = $cons->getConsult ( $id );

		// instancier le motif d'admission et recup�rer l'enregistrement
		$motif = $this->getMotifAdmissionTable ();
		$motif_admission = $motif->getMotifAdmission ( $id );
		$nbMotif = $motif->nbMotifs ( $id );

		// instanciation du model transfert
		$transferer = $this->getTransfererPatientServiceTable ();
		// r�cup�ration de la liste des hopitaux
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
		 $this->getDateHelper(); //Pour la conversion des dates
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
		  // instancier la consultation et r�cup�rer l'enregistrement
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
		  // instancier le motif d'admission et recup�rer l'enregistrement
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
		  //instancier les donn�es de l'examen physique
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
		  
		  
		  //DIAGNOSTICS
		  //DIAGNOSTICS
		  //DIAGNOSTICS
		  //instancier les donn�es des diagnostics
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
		  // RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
		  $transfertPatientService = $transferer->getServicePatientTransfert($id);
		  
		  if( $transfertPatientService ){
		  	$idService = $transfertPatientService['ID_SERVICE'];
		    // RECUPERATION DE L'HOPITAL DU SERVICE
		  	$transfertPatientHopital = $transferer->getHopitalPatientTransfert($idService);
		  	$idHopital = $transfertPatientHopital['ID_HOPITAL'];
		    // RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
		  	$serviceHopital = $transferer->fetchServiceWithHopital($idHopital);

		  	//LISTE DES HOPITAUX ET SERVICES
		  	$form->get ( 'hopital_accueil' )->setValueOptions ( $hopital );
		  	$form->get ( 'service_accueil' )->setValueOptions ($serviceHopital);
		  
		    // SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
		  	$data['hopital_accueil'] = $idHopital;
		  	$data['service_accueil'] = $idService;
		  	$data['motif_transfert'] = $transfertPatientService['motif_transfert'];
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
		  
		  //\Zend\Debug\Debug::dump($leRendezVous); exit();

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
		  );
	
	}
	
	//***-*-*-*-*-*-*-*-**-*-*-*-*--*-**-*-*-*-*-*-*-*--*--**-*-*-*-*-*-**-*-*-*--**-*-*-*-*-*--*-**-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-
	//***-**-*-*-*-*-**-*-*-*-*-*-*-*-*-*--**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**-*-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-*-*-*-**--*-**-*-*-
	//MISE A JOUR DES DONNEES DU DOSSIER DU PATIENT
	//***************************************************
	//***************************************************
	public function updateComplementConsultationAction(){
		
		$id_cons = $this->params()->fromPost('id_cons');
		
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES
		//POUR LES EXAMEN PHYSIQUES

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
		
		//POUR LES EXAMENS MORPHOLOGIQUES 
		//POUR LES EXAMENS MORPHOLOGIQUES 
		//POUR LES EXAMENS MORPHOLOGIQUES
		
		$info_examen_morphologique = array(
				'id_cons'=> $id_cons,
				'8'  => $this->params()->fromPost('radio_'),
				'9'  => $this->params()->fromPost('ecographie_'),
				'12' => $this->params()->fromPost('fibroscopie_'),
				'11' => $this->params()->fromPost('scanner_'),
				'10' => $this->params()->fromPost('irm_'),
		);
		//$cons_examen_morphologique = new Consultation_Model_Managers_NoteExamensMorphologiques();
		//$cons_examen_morphologique->updateNoteExamensMorphologiques($info_examen_morphologique);
		
		\Zend\Debug\Debug::dump($id_cons); exit();
		return array(
			
		);
// 		$Control = new Facturation_Model_Helpers_Aides();
// 		$LeService = $this->_service;
	
// 		//Donn�es COMMUNES A TOUTES LES INTERFACES
// 		$id_cons = $this->getParam('id_cons');
	
// 		/*********************Examen compl�mentaire (examen et analyse)******************/
// 		/*********************Examen compl�mentaire (examen et analyse)******************/
	
// 		/**************** EXAMEN MORPHOLOGIQUE ************************/
// 		/**************** EXAMEN MORPHOLOGIQUE ************************/
// 		$RADIO = $this->getParam('radio_');
// 		$ECOGRAPHIE = $this->getParam('ecographie_');
// 		$FIBROSCOPIE = $this->getParam('fibroscopie_');
// 		$SCANNER = $this->getParam('scanner_');
// 		$IRM = $this->getParam('irm_');
	
// 		$info_examen_morphologique = array('id_cons'=> $id_cons,
// 				'8' => $RADIO,
// 				'9' => $ECOGRAPHIE,
// 				'12' => $IRM,
// 				'11' => $SCANNER,
// 				'10' => $FIBROSCOPIE,
// 		);
// 		$cons_examen_morphologique = new Consultation_Model_Managers_NoteExamensMorphologiques();
// 		$cons_examen_morphologique->updateNoteExamensMorphologiques($info_examen_morphologique);
			
// 		/*********************FIN FIN Examen compl�mentaire ******************/
// 		/*********************FIN FIN Examen compl�mentaire ******************/
	
// 		/*********** DIAGNOSTICS ************/
// 		/*********** DIAGNOSTICS ************/
// 		$diagnostic1 = $this->getParam('diagnostic1');
// 		$diagnostic2 = $this->getParam('diagnostic2');
// 		$diagnostic3 = $this->getParam('diagnostic3');
// 		$diagnostic4 = $this->getParam('diagnostic4');
			
// 		$info_diagnostics = array('id_cons'     => $id_cons,
// 				'diagnostic1' => $diagnostic1,
// 				'diagnostic2' => $diagnostic2,
// 				'diagnostic3' => $diagnostic3,
// 				'diagnostic4' => $diagnostic4,
// 		);
// 		$cons_diagnostics = new Consultation_Model_Managers_Diagnostics();
// 		$cons_diagnostics->updateDiagnostics($info_diagnostics);
	
// 		/*************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************/
// 		/*************Autres(Transfert/Hospitalisation/ Rendez-Vous )***************/
	
// 		/**** RENDEZ VOUS ****/
// 		/**** RENDEZ VOUS ****/
// 		$ID_PERSONNE = $this->getParam('id_patient');
// 		$date_RV_Recu = $this->getParam('date_rv');
// 		if($date_RV_Recu){$date_RV = $Control->convertDateInAnglais($date_RV_Recu);}
// 		else{ $date_RV = $date_RV_Recu;}
// 		$note        = $this->getParam('motif_rv');
// 		$heure_rv    = $this->getParam('heure_rv');
// 		//cr�er le Rendez vous et inserer le RV
// 		$infos_rv = array('id_personne' => $ID_PERSONNE,
// 				'id_service'  => '2',
// 				'id_cons'     => $id_cons,
// 				'date_RV'     => $date_RV,
// 				'note_prise'  => $note,
// 				'heure_rv'    => $heure_rv
// 		);
// 		$cons_rv = new Consultation_Model_Managers_RvPatientCons();
// 		$cons_rv->updateRendezVous($infos_rv);
			
// 		/**** TRANSFERT ****/
// 		/**** TRANSFERT ****/
// 		$ID_SERVICE = $this->getParam('id_service');
// 		$MED_ID_PERSONNE = $this->getParam('med_id_personne');
// 		$DATE = $this->getParam('date');
// 		$MOTIF_TRANSFERT = $this->getParam('motif_transfert');
	
// 		$info_transfert = array('id_service'      => $ID_SERVICE,
// 				'id_personne'     => $ID_PERSONNE,
// 				'med_id_personne' => $MED_ID_PERSONNE,
// 				'date'            => $DATE,
// 				'motif_transfert' => $MOTIF_TRANSFERT,
// 				'idcons' => $id_cons
// 		);
// 		$cons_transfert = new Consultation_Model_Managers_TransfererPatientService();
// 		$cons_transfert->updateTransfertPatientService($info_transfert);
	
// 		/************* FIN FIN Autres(Transfert/Hospitalisation/ Rendez-Vous )***************/
// 		/************* FIN FIN Autres(Transfert/Hospitalisation/ Rendez-Vous )***************/
	
// 		/********************Traitement (Ordonnance)***********************/
// 		/********************Traitement (Ordonnance)***********************/
		  
// 		/**** MEDICAL ****/
// 		/**** MEDICAL ****/
// 		$duree = $this->getParam('duree_traitement_ord');
// 		$donnees = array('id_cons' => $id_cons, 'duree_traitement' => $duree);
	
// 		$ordonnance = new Consultation_Model_Managers_Ordonnance ();
// 		$ordonnance->updateDureeTraitement($donnees); // Mettre � jour la dur�e du traitement
// 		$idOrdonnance = $ordonnance->getIdOrdonnance($id_cons); //on r�cup�re l'$id de l'ordonnance
// 		$medicaments = new Consultation_Model_Managers_OrdonConsommable();
// 		$nbMed = $medicaments->nbmedicaments($idOrdonnance); //on r�cup�re le nombre de m�dicaments
	
// 		$tab = array();
// 		$j = 1;
// 		for($i = 1 ; $i < 10 ; $i++ ){
// 			if($this->getParam("medicament_0".$i)){
// 				$tab[$j++] = $this->getParam("medicament_0".$i);
// 				$tab[$j++] = $this->getParam("medicament_1".$i);
// 				$tab[$j++] = $this->getParam("medicament_2".$i);
// 				$tab[$j++] = $this->getParam("medicament_3".$i);
// 			}
// 		}
// 		//ON SUPPRIME TOUS LES MEDICAMENTS
// 		$medicaments->deleteOrdonConsom($idOrdonnance);
		 
// 		//ON AJOUTE LES NOUVEAUX MEDICAMENTS
// 		$tab[0] = $idOrdonnance; //r�cup�rer l'id de l'ordonnance et l'inserer dans le tableau
// 		$medicaments->addOrdonConsom($tab);// on ajoute les m�dicaments dans l'ordonnance
		 
// 		/********************Traitement (Ordonnance)***********************/
// 		/********************Traitement (Ordonnance)***********************/
		  
		    
// 		/**** TRAITEMENTS CHIRURGICAUX ****/
// 		/**** TRAITEMENTS CHIRURGICAUX ****/
// 		$diagnostic_traitement_chirurgical = $this->getParam("diagnostic_traitement_chirurgical");
// 		$intervention_prevue = $this->getParam("intervention_prevue");
// 		$type_anesthesie_demande = $this->getParam("type_anesthesie_demande");
// 		$numero_vpa = $this->getParam("numero_vpa");
// 		$observation = $this->getParam("observation");
	
// 		//Cr�er le traitement chirurgical
// 		$info_traitement = array('diagnostic'=>$diagnostic_traitement_chirurgical,
// 				'intervention_prevue'=>$intervention_prevue,
// 				'type_anesthesie'=>$type_anesthesie_demande,
// 				'numero_vpa'=>$numero_vpa,
// 				'observation'=>$observation,
// 				'idcons'=>$id_cons);
	
// 		$ordonnance->updateTraitementsChirurgicaux($info_traitement);
	
		 
// 		/******************** Demande examens (Biologique et morphologiqe) *******************/
// 		/******************** Demande examens (Biologique et morphologiqe) *******************/
// 		/******************** Demande examens (Biologique et morphologiqe) *******************/
// 		$groupe = $this->getParam('groupe');
// 		$hemmogrammes = $this->getParam('hemmogramme');
// 		$hepatiques = $this->getParam('hepatique');
// 		$renals = $this->getParam('renal');
// 		$hemostase = $this->getParam('hemostase');
// 		$inflammatoires = $this->getParam('inflammatoire');
// 		$radios = $this->getParam('radio');
// 		$ecographies = $this->getParam('ecographie');
// 		$fibroscopies = $this->getParam('fibroscopie');
// 		$scanners = $this->getParam('scanner');
// 		$irms = $this->getParam('irm');
// 		$autreb = $this->getParam('autreb');
// 		$autrem = $this->getParam('autrem');
		 
// 		$examenDemande = array('idcons' => $id_cons);
// 		$examenDemande[1] = $groupe;
// 		$examenDemande[2] = $hemmogrammes;
// 		$examenDemande[3] = $hepatiques;
// 		$examenDemande[4] = $renals;
// 		$examenDemande[5] = $hemostase;
// 		$examenDemande[6] = $inflammatoires;
// 		$examenDemande[7] = $autreb;
// 		$examenDemande[8] = $radios;
// 		$examenDemande[9] = $ecographies;
// 		$examenDemande[10] = $irms;
// 		$examenDemande[11] = $scanners;
// 		$examenDemande[12] = $fibroscopies;
// 		$examenDemande[13] = $autrem;
		 
		 
// 		//--- NOTE SUR LES EXAMENS
// 		$ngroupe = $this->getParam('ngroupe');
// 		$nhemmogramme = $this->getParam('nhemmogramme');
// 		$nhepatique = $this->getParam('nhepatique');
// 		$nrenal = $this->getParam('nrenal');
// 		$nhemostase= $this->getParam('nhemostase');
// 		$ninflammatoire = $this->getParam('ninflammatoire');
// 		$nradio = $this->getParam('nradio');
// 		$necographie = $this->getParam('necographie');
// 		$nfibroscopie = $this->getParam('nfibroscopie');
// 		$nscanner = $this->getParam('nscanner');
// 		$nirm = $this->getParam('nirm');
// 		$nautreb = $this->getParam('nautreb');
// 		$nautrem = $this->getParam('nautrem');
	
// 		$noteExamen = array();
// 		$noteExamen[1] = $ngroupe;
// 		$noteExamen[2] = $nhemmogramme;
// 		$noteExamen[3] = $nhepatique;
// 		$noteExamen[4] = $nrenal;
// 		$noteExamen[5] = $nhemostase;
// 		$noteExamen[6] = $ninflammatoire;
// 		$noteExamen[7] = $nautreb;
// 		$noteExamen[8] = $nradio;
// 		$noteExamen[9] = $necographie;
// 		$noteExamen[10] = $nirm;
// 		$noteExamen[11] = $nscanner;
// 		$noteExamen[12] = $nfibroscopie;
// 		$noteExamen[13] = $nautrem;
		 
		 
// 		//instancier la consultation et r�cup�rer l'enregistrement pour avoir la date
// 		$cons = new Consultation_Model_Managers_Consultation ();
// 		$consult = $cons->getConsult($id_cons);
		 
// 		//On ajoute la demande dans la table Demande_Examen si �a n'existe pas
// 		$dateonly = Zend_Date::now ()->toString ('yyyy-MM-dd');
// 		$values = array('idcons' =>$id_cons, 'date'=>$dateonly);
// 		$demandeExamen = new Consultation_Model_Managers_DemandeExamen();
// 		$demandeExamen->updateDemande($values, $consult['DATEONLY']);
		 
// 		//Mis � jour des examens
// 		$demande = new Consultation_Model_Managers_DemandeListeExamen();
// 		$demande->updateDemandeListeExamen($examenDemande,$noteExamen);
		 
// 		$this->redirect("consultation/Consultation/consultationmedecin");
	
	}
	//******* R�cup�rer les services correspondants en cliquant sur un hopital
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
			//Information sur le m�decin
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
			//r�cup�ration de la liste des m�dicaments
			$medicaments = $consommable->fetchConsommable();
			
			$tab = array();
			$j = 1;
			
			for($i = 1 ; $i < 10 ; $i++ ){
				$codeMedicament = $this->params()->fromPost("medicament_0".$i);
				if($codeMedicament == true){
					$tab[$j++] = $medicaments[$codeMedicament]; //on r�cup�re le m�dicament par son nom
					$tab[$j++] = $this->params()->fromPost("medicament_1".$i);
					$tab[$j++] = $this->params()->fromPost("medicament_2".$i);
					$tab[$j++] = $this->params()->fromPost("medicament_3".$i);
				}
			}
			
			$patient = $this->getPatientTable();
			$donneesPatientOR = $patient->getPatient($id_patient);
			//\Zend\Debug\Debug::dump($donneesPatient); exit();
			//-***************************************************************
			//Cr�ation du fichier pdf
			//*************************
			//Cr�er le document
			$DocPdf = new DocumentPdf();
			//Cr�er la page
			$page = new OrdonnancePdf();

			//Envoyer l'id_cons
			$page->setIdCons($id_cons);
			//Envoyer les donn�es sur le partient
			$page->setDonneesPatient($donneesPatientOR);
			//Envoyer les m�dicaments
			$page->setMedicaments($tab);
			
			//Ajouter une note � la page
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
			//R�cup�ration des donn�es
			$donneesDemande['diagnostic'] = $this->params ()->fromPost ( 'diagnostic_traitement_chirurgical' );
			$donneesDemande['intervention_prevue'] = $this->params ()->fromPost (  'intervention_prevue' );
			$donneesDemande['type_anesthesie_demande'] = $this->params()->fromPost('type_anesthesie_demande');
			$donneesDemande['numero_vpa'] = $this->params()->fromPost('numero_vpa');
			$donneesDemande['observation'] = $this->params()->fromPost('observation');
			
			//CREATION DU DOCUMENT PDF
			//Cr�er le document
			$DocPdf = new DocumentPdf();
			//Cr�er la page
			$page = new TraitementChirurgicalPdf();
			
			//Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			//Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatient);
			//Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			//Envoi les donn�es de la demande
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
		
				//R�cup�rer le nom du service d'accueil
 				$service = $this->getServiceTable();
 				$infoService = $service->getServiceparId($id_service);
 				//R�cup�rer le nom de l'hopital d'accueil
 				$hopital = $this->getHopitalTable();
 				$infoHopital = $hopital->getHopitalParId($id_hopital);
 				
 				$donneesDemandeT['NomService'] = $infoService['NOM'];
 				$donneesDemandeT['NomHopital'] = $infoHopital['NOM_HOPITAL'];
 				$donneesDemandeT['MotifTransfert'] = $motif_transfert;

				//-***************************************************************
				//Cr�ation du fichier pdf
			
				//-***************************************************************
 				//Cr�er le document
 				$DocPdf = new DocumentPdf();
 				//Cr�er la page
 				$page = new TransfertPdf();
 					
 				//Envoi Id de la consultation
 				$page->setIdConsT($id_cons);
 				//Envoi des donn�es du patient
 				$page->setDonneesPatientT($donneesPatient);
 				//Envoi des donn�es du medecin
 				$page->setDonneesMedecinT($donneesMedecin);
 				//Envoi les donn�es de la demande
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
				//Cr�ation du fichier pdf
				//Cr�er le document
				$DocPdf = new DocumentPdf();
				//Cr�er la page
				$page = new RendezVousPdf();
				
				//Envoi Id de la consultation
				$page->setIdConsR($id_cons);
				//Envoi des donn�es du patient
				$page->setDonneesPatientR($donneesPatient);
				//Envoi des donn�es du medecin
				$page->setDonneesMedecinR($donneesMedecin);
				//Envoi les donn�es du redez vous
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
