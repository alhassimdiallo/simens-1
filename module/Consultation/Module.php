<?php

namespace Consultation;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Consultation\Model\Consultation;
use Consultation\Model\ConsultationTable;
use Zend\Db\TableGateway\TableGateway;
use Consultation\Model\MotifAdmission;
use Consultation\Model\RvPatientConsTable;
use Consultation\Model\RvPatientCons;
use Consultation\Model\MotifAdmissionTable;
use Consultation\Model\TransfererPatientServiceTable;
use Consultation\Model\TransfererPatientService;
use Consultation\Model\DonneesExamensPhysiquesTable;
use Consultation\Model\DonneesExamensPhysiques;
use Consultation\Model\DiagnosticsTable;
use Consultation\Model\Diagnostics;
use Consultation\Model\Ordonnance;
use Consultation\Model\OrdonnanceTable;
use Consultation\Model\DemandeVisitePreanesthesiqueTable;
use Consultation\Model\DemandeVisitePreanesthesique;
use Consultation\Model\NotesExamensMorphologiquesTable;
use Consultation\Model\NotesExamensMorphologiques;
use Consultation\Model\DemandeTable;
use Consultation\Model\Demande;
use Consultation\Model\OrdonConsommable;
use Consultation\Model\OrdonConsommableTable;
use Zend\Mvc\MvcEvent;
use Consultation\Model\AntecedentPersonnelTable;
use Consultation\Model\AntecedentPersonnel;
use Consultation\Model\AntecedentsFamiliauxTable;
use Consultation\Model\AntecedentsFamiliaux;
use Consultation\Model\DemandehospitalisationTable;
use Consultation\Model\Demandehospitalisation;
use Consultation\Model\Soinhospitalisation;
use Consultation\Model\SoinhospitalisationTable;
use Consultation\Model\SoinsTable;
use Consultation\Model\Soins;
use Consultation\Model\HospitalisationTable;
use Consultation\Model\Hospitalisation;
use Consultation\Model\HospitalisationlitTable;
use Consultation\Model\Hospitalisationlit;
use Consultation\Model\LitTable;
use Consultation\Model\Lit;
use Consultation\Model\SalleTable;
use Consultation\Model\Salle;
use Consultation\Model\BatimentTable;
use Consultation\Model\Batiment;
use Consultation\Model\ResultatVisitePreanesthesiqueTable;
use Consultation\Model\ResultatVisitePreanesthesique;
use Consultation\Model\Soinhospitalisation4;
use Consultation\Model\Soinhospitalisation4Table;

class Module implements AutoloaderProviderInterface {
	
// 	public function onBootstrap(MvcEvent $e) {
// 		$serviceManager = $e->getApplication ()->getServiceManager ();
// 		$viewModel = $e->getApplication ()->getMvcEvent ()->getViewModel ();

// 		$uAuth = $serviceManager->get( 'Admin\Controller\Plugin\UserAuthentication' ); //@todo - We must use PluginLoader $this->userAuthentication()!!
// 		$username = $uAuth->getAuthService()->getIdentity();
		
// 		$uTable = $serviceManager->get( 'Admin\Model\UtilisateursTable' );
// 		$user = $uTable->getUtilisateursWithUsername($username);
		
// 		if($user) {
// 			$uService = $serviceManager->get( 'Personnel\Model\ServiceTable');
// 			$service = $uService->getServiceparId($user->id_service);
			
// 			$viewModel->user = $user;
// 			$viewModel->service = $service['NOM'];
// 		}
// 	}
	
	public function getAutoloaderConfig() {
		return array (
				// 'Zend\Loader\ClassMapAutoloader' => array(
				// __DIR__ . '/autoload_classmap.php',
				// ),
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
						'Consultation\Model\ConsultationTable' => function ($sm) {
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
						'Consultation\Model\MotifAdmissionTable' => function ($sm) {
							$tableGateway = $sm->get ( 'MotifAdmissionTableGateway' );
							$table = new MotifAdmissionTable($tableGateway);
							return $table;
						},
						'MotifAdmissionTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new MotifAdmission());
							return new TableGateway ( 'motif_admissionn', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\RvPatientConsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'RvPatientConsTableGateway' );
							$table = new RvPatientConsTable ( $tableGateway );
							return $table;
						},
						'RvPatientConsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new RvPatientCons());
							return new TableGateway ( 'rv_patient_cons', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\TransfererPatientServiceTable' => function ($sm) {
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
						'Consultation\Model\DonneesExamensPhysiquesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DonneesExamensPhysiquesTableGateway' );
							$table = new DonneesExamensPhysiquesTable($tableGateway);
							return $table;
						},
						'DonneesExamensPhysiquesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new DonneesExamensPhysiques());
							return new TableGateway ( 'Donnees_examen_physiquee', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\DiagnosticsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DiagnosticsTableGateway' );
							$table = new DiagnosticsTable($tableGateway);
							return $table;
						},
						'DiagnosticsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Diagnostics());
							return new TableGateway ( 'diagnostics', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\OrdonnanceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'OrdonnanceTableGateway' );
							$table = new OrdonnanceTable($tableGateway);
							return $table;
						},
						'OrdonnanceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Ordonnance());
							return new TableGateway ( 'ordonnance', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\DemandeVisitePreanesthesiqueTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeVisitePreanesthesiqueTableGateway' );
							$table = new DemandeVisitePreanesthesiqueTable($tableGateway);
							return $table;
						},
						'DemandeVisitePreanesthesiqueTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new DemandeVisitePreanesthesique());
							return new TableGateway ( 'demande_visite_preanesthesique', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\NotesExamensMorphologiquesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'NotesExamensMorphologiquesTableGateway' );
							$table = new NotesExamensMorphologiquesTable($tableGateway);
							return $table;
						},
						'NotesExamensMorphologiquesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new NotesExamensMorphologiques());
							return new TableGateway ( 'note_examen_morphologique', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\DemandeTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DemandeTableGateway' );
							$table = new DemandeTable($tableGateway);
							return $table;
						},
						'DemandeTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new Demande());
							return new TableGateway ( 'demande', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\OrdonConsommableTable' => function ($sm) {
							$tableGateway = $sm->get ( 'OrdonConsommableTableGateway' );
							$table = new OrdonConsommableTable($tableGateway);
							return $table;
						},
						'OrdonConsommableTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new OrdonConsommable());
							return new TableGateway ( 'ordon_consommable', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\AntecedentPersonnelTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AntecedentPersonnelTableGateway' );
							$table = new AntecedentPersonnelTable($tableGateway);
							return $table;
						},
						'AntecedentPersonnelTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentPersonnel());
							return new TableGateway ( 'ant_personnels_personne', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\AntecedentsFamiliauxTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AntecedentsFamiliauxTableGateway' );
							$table = new AntecedentsFamiliauxTable($tableGateway);
							return $table;
						},
						'AntecedentsFamiliauxTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype ( new AntecedentsFamiliaux());
							return new TableGateway ( 'ant_familiaux_personne', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\DemandehospitalisationTable' => function ($sm) {
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
						'Consultation\Model\SoinhospitalisationTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SoinhospitalisationTableGateway' );
							$table = new SoinhospitalisationTable( $tableGateway );
							return $table;
						},
						'SoinhospitalisationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soinhospitalisation() );
							return new TableGateway ( 'soins_hospitalisation_2', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\Soinhospitalisation4Table' => function ($sm) {
							$tableGateway = $sm->get ( 'Soinhospitalisation4TableGateway' );
							$table = new Soinhospitalisation4Table( $tableGateway );
							return $table;
						},
						'Soinhospitalisation4TableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soinhospitalisation4() );
							return new TableGateway ( 'soins_hospitalisation_3', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\SoinsTable' => function ($sm) {
							$tableGateway = $sm->get ( 'SoinsTableGateway' );
							$table = new SoinsTable( $tableGateway );
							return $table;
						},
						'SoinsTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Soins() );
							return new TableGateway ( 'soins', $dbAdapter, null, $resultSetPrototype );
						},
						'Consultation\Model\HospitalisationTable' => function ($sm) {
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
						'Consultation\Model\HospitalisationlitTable' => function ($sm) {
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
						'Consultation\Model\LitTable' => function ($sm) {
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
						'Consultation\Model\SalleTable' => function ($sm) {
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
						'Consultation\Model\BatimentTable' => function ($sm) {
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
						'Consultation\Model\ResultatVisitePreanesthesiqueTable' => function ($sm) {
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
				)
		);
	}
}