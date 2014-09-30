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

class ConsultationController extends AbstractActionController {
	protected $patientTable;
	protected $consultationTable;
	protected $motifAdmissionTable;
	protected $rvPatientConsTable;
	protected $serviceTable;
	protected $transfererPatientServiceTable;
	protected $consommableTable;
	// protected $_service;
	// protected $_nom;
	// protected $_prenom;
	// public function __construct(){
	// $user = $this->layout()->user;
	// $this->_service = $user['service'];
	// $this->_nom = $user['name'];
	// $this->_prenom = $user['prenom'];
	// }
	// public function testAction(){
	// $sl = $this->layout()->user;
	// return new ViewModel(array('test' => $sl));
	// }
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Facturation\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getConsultationTable() {
		if (! $this->consultationTable) {
			// var_dump('test'); exit();
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
		// Recherher l'id du service
		$service = $this->getServiceTable ();
		$LigneDuService = $service->getServiceParNom ( $LeService );
		$IdDuService = $LigneDuService ['ID_SERVICE'];

		$consModel = new Consultation ();

		if (isset ( $_POST ['terminer'] )) {
			$form = new ConsultationForm ();
			$formData = $this->getRequest ()->getPost ();
			$form->setInputFilter ( $consModel->getInputFilter () );
			$form->setData ( $formData );
			if ($form->isValid ()) {
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
				) );
			}
		}
		$this->redirect ()->toRoute ( 'consultation', array (
				'action' => 'recherche'
		) );
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
	public function majComplementConsultation() {

		// $Control = new Facturation_Model_Helpers_Aides();

		// $id_pat = $this->getParam ( 'id_patient', 0 );
		// $id = $this->getParam ( 'id_cons' );
		// $list = new Admin_Model_Managers_Patient() ;
		// $liste = $list->getPatient( $id_pat );
		// $this->view->lesdetails = $liste;
		// $this->view->id_cons = $id;

		// //Recuperer la photo du patient
		// $this->view->image = $list->getPhoto($id_pat);

		// $form = new Consultation_Form_FormConsultation ();

		// //instancier le motif d'admission et recup�rer l'enregistrement
		// $motif = new Consultation_Model_Managers_MotifAdmissionn();
		// $motif_admission = $motif->getMotifAdmissionn($id);
		// $nbMotif = $motif->nbMotifs($id);
		// $this->view->nbMotifs = $nbMotif;

		// //instancier la consultation et r�cup�rer l'enregistrement
		// $cons = new Consultation_Model_Managers_Consultation ();
		// $consult = $cons->getConsult($id);

		// //instancier les donn�es de l'examen physique
		// $examen = new Consultation_Model_Managers_ExamenPhysiquee();
		// $examen_physique = $examen->getExamenPhysique($id);

		// //instancier les donn�es des r�sultats des examens compl�mentaires
		// $examens_bio = new Consultation_Model_Managers_Resultats();
		// $examens_biologiques = $examens_bio->getResultatsExamensBiologiques($id);

		// //instancier les donn�es de l'examen morphologique
		// $examen_morph = new Consultation_Model_Managers_NoteExamensMorphologiques();
		// $examen_morphologique = $examen_morph->getNotesExamensMorphologiques($id);

		// //instancier les donn�es des diagnostics
		// $diagn = new Consultation_Model_Managers_Diagnostics();
		// $diagnostics = $diagn->getDiagnostics($id);
		// //$nbDiagnostics = $diagn->nbDiagnostics($id);

		// //instancier les donn�es du rendez-vous m�dical
		// $rv = new Consultation_Model_Managers_RvPatientCons();
		// $rendez_vous = $rv->getRendezVous($id);
		// $this->view->verifieRV = $rendez_vous;

		// //instancier les donn�es du transfert vers un autre service
		// $transfert = new Consultation_Model_Managers_TransfererPatientService();
		// $transfert_patient_serv = $transfert->donneesPatientMedecin($id);
		// $transfert_patient_hop = $transfert->hopitalDuService($transfert_patient_serv['ID_SERVICE']);
		// $this->view->verifieService = $transfert_patient_serv;

		// //Instanciation de l'ordonnance
		// $ordonnance = new Consultation_Model_Managers_Ordonnance ();
		// $idOrdonnance = $ordonnance->getIdOrdonnance($id); //on r�cup�re l'$id de l'ordonnance
		// $this->view->idOrdon = $idOrdonnance;

		// //Instancier la liste des demandes d'examens effectu�es
		// $demandes = new Consultation_Model_Managers_DemandeListeExamen();
		// $listeDemandeExamen = $demandes->getListeDemandeExamen($id);
		// $this->view->listeDemande = $listeDemandeExamen;

		// //INSTANCIATION DES MEDICAMENTS de l'ordonnance
		// $medicaments = new Consultation_Model_Managers_OrdonConsommable();
		// $nbMedicaments = $medicaments->nbmedicaments($idOrdonnance);
		// $this->view->nbMed = $nbMedicaments;

		// $listeMedicaments = $medicaments->getMedicaments($idOrdonnance);
		// $this->view->listeMed = $listeMedicaments;

		// //INSTANCIATION DU TRAITEMENT CHIRURGICAL
		// $leTraitementChirurgical = $ordonnance->getTraitementChirurgical($id);

		// //Duree traitement
		// $this->view->duree_traitement = $ordonnance->getDureeTraitement($id);

		// //instanciation du model transfert
		// $transferer = new Consultation_Model_Managers_TransfererPatientService();
		// //r�cup�ration de la liste des hopitaux
		// $hopital = $transferer->fetchHopital();
		// $form->hopital_accueil->addMultiOptions($hopital);

		// //r�cup�ration de la liste des services de l'hopital concern�
		// $service = $transferer->serviceDeHopital($transfert_patient_hop['ID_HOPITAL']);
		// $form->service_accueil->addMultiOptions($service);

		// //liste des groupes sanguin
		// //$groupe = array('A'=>'A', 'B'=>'B', 'AB'=>'AB', 'O'=>'O');
		// //$form->groupe_sanguin->addMultiOptions($groupe);

		// //liste des heures rv
		// $heure_rv = array('08:00'=>'08:00', '09:00'=>'09:00', '10:00'=>'10:00', '15:00'=>'15:00', '16:00'=>'16:00');
		// $form->heure_rv->addMultiOptions($heure_rv);

		// //On teste d'abord si le rendez-vous existe
		// $date_RV_Recu = $rendez_vous['date'];
		// if($date_RV_Recu){ $date_RV = $Control->convertDate($date_RV_Recu); }
		// else{ $date_RV = $date_RV_Recu;}

		// $data = array (

		// //Les donn�es des constantes prises
		// 'id_cons' => $consult ['ID_CONS'],
		// 'id_medecin' => $consult ['ID_PERSONNE'],
		// 'id_patient' => $consult ['PAT_ID_PERSONNE'],
		// 'motif_admission' => $consult ['MOTIF_ADMISSION'],
		// 'date_cons' => $consult ['DATE'],
		// 'poids' => $consult ['POIDS'],
		// 'taille' => $consult ['TAILLE'],
		// 'temperature' => $consult ['TEMPERATURE'],
		// 'tension' => $consult ['TENSION'],
		// 'pouls' => $consult ['POULS'],
		// 'frequence_respiratoire' => $consult ['FREQUENCE_RESPIRATOIRE'],
		// 'glycemie_capillaire' => $consult ['GLYCEMIE_CAPILLAIRE'],
		// 'bu' => $consult ['BU'],
		// //'observation' => $consult ['OBSERVATION']

		// //Les donn�es de l'analyse biologique
		// 'groupe_sanguin' => $examens_biologiques[1][2],
		// 'hemogramme_sanguin' => $examens_biologiques[2][2],
		// 'bilan_hepatique' => $examens_biologiques[3][2],
		// 'bilan_renal' => $examens_biologiques[4][2],
		// 'bilan_hemolyse' => $examens_biologiques[5][2],
		// 'bilan_inflammatoire' => $examens_biologiques[6][2],

		// //Les donn�es de l'examen morphologique
		// 'radio' => $examen_morphologique['radio'],
		// 'ecographie' => $examen_morphologique['ecographie'],
		// 'fibrocospie' => $examen_morphologique['fibroscopie'],
		// 'scanner' => $examen_morphologique['scanner'],
		// 'irm' => $examen_morphologique['irm'],

		// //Les donn�es du rendez vous m�dical
		// 'motif_rv' => $rendez_vous['NOTE'],
		// 'date_rv' => $date_RV,
		// 'heure_rv' => $rendez_vous['heure'],

		// //Les donn�es du transfert du patient
		// 'motif_transfert' => $transfert_patient_serv['motif_transfert'],
		// 'hopital_accueil' => $transfert_patient_hop['ID_HOPITAL'],
		// 'service_accueil' => $transfert_patient_serv['ID_SERVICE'],

		// //Traitement chirurgical
		// 'diagnostic_traitement_chirurgical' => $leTraitementChirurgical['diagnostic'],
		// 'intervention_prevue' => $leTraitementChirurgical['intervention_prevue'],
		// 'type_anesthesie_demande' => $leTraitementChirurgical['type_anesthesie'],
		// 'numero_vpa' => $leTraitementChirurgical['numero_vpa'],
		// 'observation'=> $leTraitementChirurgical['observation']

		// );
		// //POUR LES MOTIFS D ADMISSION
		// $k = 1;
		// foreach($motif_admission as $Motifs){
		// $data['motif_admission'.$k] = $Motifs->Libelle_motif;
		// $k++;
		// }

		// //POUR LES EXAMEN PHYSIQUES
		// $k = 1;
		// foreach ($examen_physique as $Examen) {
		// $data['examen_donnee'.$k] = $Examen->Libelle_examen;
		// $k++;
		// }
		// //POUR LES DIAGNOSTICS
		// $k = 1;
		// foreach ($diagnostics as $diagnos){
		// $data['diagnostic'.$k] = $diagnos->Libelle_diagnostics;
		// $k++;
		// }

		// $form->populate ( $data );
		// $this->view->form = $form;
		// $this->view->heure_cons = $consult['HEURECONS'];

		// //POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// //POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// //POUR LES ANTECEDENTS OU TERRAIN PARTICULIER
		// $listeConsultation = $cons->listeConsultationsPatient($id_pat);
		// $this->view->liste = $listeConsultation;
	}
	//******* R�cup�rer les services correspondants en cliquant sur un hopital
	public function servicesAction()
	{
		$id=(int)$this->params()->fromPost ('id');
		switch ($id){
			case 1 :{
				$services= $this->getServiceTable();
				foreach($services->getServiceHopital(1) as $listeServices){
					$liste_select.= "<option value=".$listeServices['Id_service'].">".$listeServices['Nom_service']."</option>";
				}
				break;
			}
			case 2 :{
				$services= $this->getServiceTable();
				foreach($services->getServiceHopital(2) as $listeServices){
					$liste_select.= "<option value=".$listeServices['Id_service'].">".$listeServices['Nom_service']."</option>";
				}
				break;
			}
			default : break;
		}

		if ($this->getRequest()->isPost()){
			$this->getResponse()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html' );
			return $this->getResponse ()->setContent(Json::encode ( $liste_select));
		}
	}
}
