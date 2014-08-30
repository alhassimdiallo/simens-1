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

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface {
	// public function onBootstrap(MvcEvent $e)
	// {
	// $eventManager = $e->getApplication()->getEventManager();
	// $moduleRouteListener = new ModuleRouteListener();
	// $moduleRouteListener->attach($eventManager);
	// }
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
							$tableGateway = $sm->get('PatientTableGateway');
							$table = new PatientTable($tableGateway);
							return $table;
						},
						'PatientTableGateway' => function($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Patient());
							return new TableGateway('patient', $dbAdapter, null, $resultSetPrototype);
						}
				)
		);
	}
	public function getViewHelperConfig()
	{
		return array();
	}
}