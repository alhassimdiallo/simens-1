<?php

namespace Archivage;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Archivage\Model\PatientTable;
use Archivage\Model\Patient;
use Archivage\Model\TarifConsultationTable;
use Archivage\Model\TarifConsultation;
use Archivage\Model\FacturationTable;
use Archivage\Model\Facturation;
use Archivage\Model\ConsultationTable;
use Archivage\Model\Consultation;
use Archivage\Model\ServiceTable;
use Archivage\Model\Service;
use Archivage\Model\DemandehospitalisationTable;
use Archivage\Model\Demandehospitalisation;
use Archivage\Model\BatimentTable;
use Archivage\Model\Batiment;
use Archivage\Model\HospitalisationTable;
use Archivage\Model\Hospitalisation;
use Archivage\Model\HospitalisationlitTable;
use Archivage\Model\Hospitalisationlit;
use Archivage\Model\LitTable;
use Archivage\Model\Lit;
use Archivage\Model\TransfererPatientServiceTable;
use Archivage\Model\TransfererPatientService;
use Archivage\Model\SalleTable;
use Archivage\Model\Salle;
use Archivage\Model\Soinhospitalisation3Table;
use Archivage\Model\Soinhospitalisation3;
use Archivage\Model\DemandeTable;
use Archivage\Model\Demande;
use Archivage\Model\ExamenTable;
use Archivage\Model\Examen;
use Archivage\Model\ResultatExamenTable;
use Archivage\Model\ResultatExamen;
use Archivage\Model\ResultatVisitePreanesthesiqueTable;
use Archivage\Model\ResultatVisitePreanesthesique;

class Module implements AutoloaderProviderInterface {
	
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
						)
				)
		);
	}
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig() {
		return array (
				'factories' => array (
						'Archivage\Model\PatientTable' => function ($sm) {
							$tableGateway = $sm->get ( 'PatientTableGateway' );
							$table = new PatientTable ( $tableGateway );
							return $table;
						},
						'PatientTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Patient () );
							return new TableGateway ( 'patient', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\TarifConsultationTable' => function ($sm) {
							$tableGateway = $sm->get( 'TarifConsultationTableGateway' );
							$table = new TarifConsultationTable( $tableGateway );
							return $table;
						},
						'TarifConsultationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype (new TarifConsultation());
							return new TableGateway ( 'tarif_consultation', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\FacturationTable' => function ($sm) {
							$tableGateway = $sm->get( 'FacturationTableGateway' );
							$table = new FacturationTable( $tableGateway );
							return $table;
						},
						'FacturationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Facturation() );
							return new TableGateway ( 'facturation', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\ConsultationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ConsultationTableGateway' );
							$table = new ConsultationTable ( $tableGateway );
							return $table;
						},
						'ConsultationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Consultation());
							return new TableGateway ( 'consultation', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\ServiceTable' => function ($sm) {
							$tableGateway = $sm->get('ServiceTableGateway');
							$table = new ServiceTable($tableGateway);
							return $table;
						},
						'ServiceTableGateway' => function($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Service());
							return new TableGateway('service', $dbAdapter, null, $resultSetPrototype);
						},
						'Archivage\Model\DemandehospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandehospitalisationTableGateway' );
							$table = new DemandehospitalisationTable ( $tableGateway );
							return $table;
						},
						'DemandehospitalisationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Demandehospitalisation () );
							return new TableGateway ( 'demande_hospitalisation2', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\BatimentTable' => function ($sm) {
							$tableGateway = $sm->get ( 'BatimentTableGateway' );
							$table = new BatimentTable ( $tableGateway );
							return $table;
						},
						'BatimentTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Batiment () );
							return new TableGateway ( 'batiment', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\HospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'HospitalisationTableGateway' );
							$table = new HospitalisationTable ( $tableGateway );
							return $table;
						},
						'HospitalisationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Hospitalisation() );
							return new TableGateway ( 'hospitalisation', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\HospitalisationlitTable' => function ($sm) {
							$tableGateway = $sm->get ( 'HospitalisationlitTableGateway' );
							$table = new HospitalisationlitTable ( $tableGateway );
							return $table;
						},
						'HospitalisationlitTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Hospitalisationlit() );
							return new TableGateway ( 'hospitalisation_lit', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\LitTable' => function ($sm) {
							$tableGateway = $sm->get ( 'LitTableGateway' );
							$table = new LitTable ( $tableGateway );
							return $table;
						},
						'LitTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Lit() );
							return new TableGateway ( 'lit', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\TransfererPatientServiceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'TransfererPatientServiceTableGateway' );
							$table = new TransfererPatientServiceTable($tableGateway);
							return $table;
						},
						'TransfererPatientServiceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new TransfererPatientService());
							return new TableGateway ( 'transferer_patient_service', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\SalleTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SalleTableGateway' );
							$table = new SalleTable( $tableGateway );
							return $table;
						},
						'SalleTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Salle() );
							return new TableGateway ( 'salle', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\Soinhospitalisation3Table' => function ($sm) {
							$tableGateway = $sm->get ( 'Soinhospitalisation3TableGateway' );
							$table = new Soinhospitalisation3Table( $tableGateway );
							return $table;
						},
						'Soinhospitalisation3TableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soinhospitalisation3() );
							return new TableGateway ( 'soins_hospitalisation_3', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\DemandeTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeTableGateway' );
							$table = new DemandeTable( $tableGateway );
							return $table;
						},
						'DemandeTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Demande() );
							return new TableGateway ( 'demande', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\ExamenTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ExamenTableGateway' );
							$table = new ExamenTable( $tableGateway );
							return $table;
						},
						'ExamenTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Examen() );
							return new TableGateway ( 'examens', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\ResultatExamenTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ResultatExamenTableGateway' );
							$table = new ResultatExamenTable( $tableGateway );
							return $table;
						},
						'ResultatExamenTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new ResultatExamen() );
							return new TableGateway ( 'resultats_examens2', $dbAdapter, null, $resultSetPrototype );
						},
						'Archivage\Model\ResultatVisitePreanesthesiqueTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ResultatVisitePreanesthesiqueTableGateway' );
							$table = new ResultatVisitePreanesthesiqueTable( $tableGateway );
							return $table;
						},
						'ResultatVisitePreanesthesiqueTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new ResultatVisitePreanesthesique() );
							return new TableGateway ( 'resultat_vpa', $dbAdapter, null, $resultSetPrototype );
						},
// 						'Consultation\Model\MotifAdmissionTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'MotifAdmissionTableGateway' );
// 							$table = new MotifAdmissionTable($tableGateway);
// 							return $table;
// 						},
// 						'MotifAdmissionTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new MotifAdmission());
// 							return new TableGateway ( 'motif_admissionn', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\RvPatientConsTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'RvPatientConsTableGateway' );
// 							$table = new RvPatientConsTable ( $tableGateway );
// 							return $table;
// 						},
// 						'RvPatientConsTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new RvPatientCons());
// 							return new TableGateway ( 'rv_patient_cons', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\DonneesExamensPhysiquesTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'DonneesExamensPhysiquesTableGateway' );
// 							$table = new DonneesExamensPhysiquesTable($tableGateway);
// 							return $table;
// 						},
// 						'DonneesExamensPhysiquesTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new DonneesExamensPhysiques());
// 							return new TableGateway ( 'Donnees_examen_physiquee', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\DiagnosticsTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'DiagnosticsTableGateway' );
// 							$table = new DiagnosticsTable($tableGateway);
// 							return $table;
// 						},
// 						'DiagnosticsTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Diagnostics());
// 							return new TableGateway ( 'diagnostics', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\OrdonnanceTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'OrdonnanceTableGateway' );
// 							$table = new OrdonnanceTable($tableGateway);
// 							return $table;
// 						},
// 						'OrdonnanceTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Ordonnance());
// 							return new TableGateway ( 'ordonnance', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\DemandeVisitePreanesthesiqueTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'DemandeVisitePreanesthesiqueTableGateway' );
// 							$table = new DemandeVisitePreanesthesiqueTable($tableGateway);
// 							return $table;
// 						},
// 						'DemandeVisitePreanesthesiqueTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new DemandeVisitePreanesthesique());
// 							return new TableGateway ( 'demande_visite_preanesthesique', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\NotesExamensMorphologiquesTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'NotesExamensMorphologiquesTableGateway' );
// 							$table = new NotesExamensMorphologiquesTable($tableGateway);
// 							return $table;
// 						},
// 						'NotesExamensMorphologiquesTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new NotesExamensMorphologiques());
// 							return new TableGateway ( 'note_examen_morphologique', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\DemandeTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'DemandeTableGateway' );
// 							$table = new DemandeTable($tableGateway);
// 							return $table;
// 						},
// 						'DemandeTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Demande());
// 							return new TableGateway ( 'demande', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\OrdonConsommableTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'OrdonConsommableTableGateway' );
// 							$table = new OrdonConsommableTable($tableGateway);
// 							return $table;
// 						},
// 						'OrdonConsommableTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new OrdonConsommable());
// 							return new TableGateway ( 'ordon_consommable', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\AntecedentPersonnelTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'AntecedentPersonnelTableGateway' );
// 							$table = new AntecedentPersonnelTable($tableGateway);
// 							return $table;
// 						},
// 						'AntecedentPersonnelTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentPersonnel());
// 							return new TableGateway ( 'ant_personnels_personne', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\AntecedentsFamiliauxTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'AntecedentsFamiliauxTableGateway' );
// 							$table = new AntecedentsFamiliauxTable($tableGateway);
// 							return $table;
// 						},
// 						'AntecedentsFamiliauxTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet();
// 							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentsFamiliaux());
// 							return new TableGateway ( 'ant_familiaux_personne', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\DemandehospitalisationTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'DemandehospitalisationTableGateway' );
// 							$table = new DemandehospitalisationTable ( $tableGateway );
// 							return $table;
// 						},
// 						'DemandehospitalisationTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Demandehospitalisation () );
// 							return new TableGateway ( 'demande_hospitalisation2', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\SoinhospitalisationTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'SoinhospitalisationTableGateway' );
// 							$table = new SoinhospitalisationTable( $tableGateway );
// 							return $table;
// 						},
// 						'SoinhospitalisationTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Soinhospitalisation() );
// 							return new TableGateway ( 'soins_hospitalisation_2', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\Soinhospitalisation4Table' => function ($sm) {
// 							$tableGateway = $sm->get ( 'Soinhospitalisation4TableGateway' );
// 							$table = new Soinhospitalisation4Table( $tableGateway );
// 							return $table;
// 						},
// 						'Soinhospitalisation4TableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Soinhospitalisation4() );
// 							return new TableGateway ( 'soins_hospitalisation_3', $dbAdapter, null, $resultSetPrototype );
// 						},
// 						'Consultation\Model\SoinsTable' => function ($sm) {
// 							$tableGateway = $sm->get ( 'SoinsTableGateway' );
// 							$table = new SoinsTable( $tableGateway );
// 							return $table;
// 						},
// 						'SoinsTableGateway' => function ($sm) {
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$resultSetPrototype = new ResultSet ();
// 							$resultSetPrototype->setArrayObjectPrototype ( new Soins() );
// 							return new TableGateway ( 'soins', $dbAdapter, null, $resultSetPrototype );
// 						},
 				)
		);
	}
}