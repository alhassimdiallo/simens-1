<?php

namespace Facturation;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Facturation\Model\Patient;
use Facturation\Model\PatientTable;
use Facturation\Model\Deces;
use Facturation\Model\DecesTable;
use Facturation\Form\AdmissionForm;
use Facturation\Model\FacturationTable;
use Facturation\Model\Facturation;
use Facturation\Model\Naissance;
use Facturation\Model\NaissanceTable;
use Facturation\Model\TarifConsultation;
use Facturation\Model\TarifConsultationTable;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface {
	public function onBootstrap(MvcEvent $e) {
		// Register a "render" event, at high priority (so it executes prior
		// to the view attempting to render)
		$app = $e->getApplication();
		$app->getEventManager()->attach('render', array($this, 'registerJsonStrategy'), 100);
	}

	public function registerJsonStrategy(MvcEvent $e)
	{
		$app          = $e->getTarget();
		$locator      = $app->getServiceManager();
		$view         = $locator->get('Zend\View\View');
		$jsonStrategy = $locator->get('ViewJsonStrategy');

		// Attach strategy, which is a listener aggregate, at high priority
		$view->getEventManager()->attach($jsonStrategy, 100);
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
						'Facturation\Model\PatientTable' => function ($sm) {
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
						'Facturation\Model\DecesTable' => function ($sm) {
							$tableGateway = $sm->get ( 'DecesTableGateway' );
							$table = new DecesTable ( $tableGateway );
							return $table;
						},
						'DecesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Deces () );
							return new TableGateway ( 'deces', $dbAdapter, null, $resultSetPrototype );
						},
						'Facturation\Model\FacturationTable' => function ($sm) {
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
						'Facturation\Model\NaissanceTable' => function ($sm) {
							$tableGateway = $sm->get( 'NaissanceTableGateway' );
							$table = new NaissanceTable( $tableGateway );
							return $table;
						},
						'NaissanceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Naissance() );
							return new TableGateway ( 'naissances', $dbAdapter, null, $resultSetPrototype );
						},
						'Facturation\Model\TarifConsultationTable' => function ($sm) {
							$tableGateway = $sm->get( 'TarifConsultationTableGateway' );
							$table = new TarifConsultationTable( $tableGateway );
							return $table;
						},
						'TarifConsultationTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new TarifConsultation() );
							return new TableGateway ( 'tarif_consultation', $dbAdapter, null, $resultSetPrototype );
						}

				)
		);
	}
	public function getViewHelperConfig() {
		return array ();
	}
}