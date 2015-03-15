<?php
namespace Hospitalisation;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Hospitalisation\Model\DemandehospitalisationTable;
use Hospitalisation\Model\Demandehospitalisation;
use Zend\Db\TableGateway\TableGateway;
use Hospitalisation\Model\PatientTable;
use Hospitalisation\Model\Patient;
use Hospitalisation\Model\BatimentTable;
use Hospitalisation\Model\Batiment;
use Hospitalisation\Model\HospitalisationTable;
use Hospitalisation\Model\Hospitalisation;
use Hospitalisation\Model\HospitalisationlitTable;
use Hospitalisation\Model\Hospitalisationlit;
use Hospitalisation\Model\LitTable;
use Hospitalisation\Model\Lit;
use Hospitalisation\Model\SalleTable;
use Hospitalisation\Model\Salle;
use Hospitalisation\Model\SoinhospitalisationTable;
use Hospitalisation\Model\Soinhospitalisation;
use Hospitalisation\Model\SoinsTable;
use Hospitalisation\Model\Soins;
use Hospitalisation\Model\DemandeTable;
use Hospitalisation\Model\Demande;
use Hospitalisation\Model\ExamenTable;
use Hospitalisation\Model\Examen;
use Hospitalisation\Model\ResultatExamenTable;
use Hospitalisation\Model\ResultatExamen;
use Hospitalisation\Model\Soinhospitalisation3Table;
use Hospitalisation\Model\Soinhospitalisation3;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
	public function registerJsonStrategy(MvcEvent $e)
	{
		$app          = $e->getTarget();
		$locator      = $app->getServiceManager();
		$view         = $locator->get('Zend\View\View');
		$jsonStrategy = $locator->get('ViewJsonStrategy');
	
		// Attach strategy, which is a listener aggregate, at high priority
		$view->getEventManager()->attach($jsonStrategy, 100);
	}
	
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig()
	{
		return array (
				'factories' => array (
						'Hospitalisation\Model\DemandehospitalisationTable' => function ($sm) {
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
						'Hospitalisation\Model\PatientTable' => function ($sm) {
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
						'Hospitalisation\Model\BatimentTable' => function ($sm) {
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
						'Hospitalisation\Model\HospitalisationTable' => function ($sm) {
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
						'Hospitalisation\Model\HospitalisationlitTable' => function ($sm) {
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
						'Hospitalisation\Model\LitTable' => function ($sm) {
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
						'Hospitalisation\Model\SalleTable' => function ($sm) {
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
						'Hospitalisation\Model\SoinhospitalisationTable' => function ($sm) {
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
						'Hospitalisation\Model\SoinsTable' => function ($sm) {
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
						'Hospitalisation\Model\DemandeTable' => function ($sm) {
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
						'Hospitalisation\Model\ExamenTable' => function ($sm) {
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
						'Hospitalisation\Model\ResultatExamenTable' => function ($sm) {
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
						'Hospitalisation\Model\Soinhospitalisation3Table' => function ($sm) {
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
						
						)
				);
	}

}