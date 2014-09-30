<?php

namespace Consultation;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
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

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {
	public function onBootstrap(MvcEvent $e) {
		// $eventManager = $e->getApplication()->getEventManager();
		// $moduleRouteListener = new ModuleRouteListener();
		// $moduleRouteListener->attach($eventManager);
		$serviceManager = $e->getApplication ()->getServiceManager ();
		$viewModel = $e->getApplication ()->getMvcEvent ()->getViewModel ();

		$myServiceUser = $serviceManager->get ( 'Admin\Model\UtilisateurTable' );
		$myServiceAuth = $serviceManager->get ( 'AuthService' );
		$login = $myServiceAuth->getIdentity ();
		$viewModel->user = $myServiceUser->fetchUtilisateur ( $login );
	}
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
						}
				)
		);
	}
}