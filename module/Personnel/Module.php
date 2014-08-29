<?php
namespace Personnel;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Personnel\Model\Service;
use Personnel\Model\ServiceTable;

class Module
{
// 	public function onBootstrap(MvcEvent $e)
// 	{
// 		$eventManager        = $e->getApplication()->getEventManager();
// 		$moduleRouteListener = new ModuleRouteListener();
// 		$moduleRouteListener->attach($eventManager);
// 	}

	public function getAutoloaderConfig()
	{
		return array(
// 				'Zend\Loader\ClassMapAutoloader' => array(
// 						__DIR__ . '/autoload_classmap.php',
// 				),
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
						'Personnel\Model\ServiceTable' => function ($sm) {
							$tableGateway = $sm->get('ServiceTableGateway');
							$table = new ServiceTable($tableGateway);
							return $table;
						},
						'ServiceTableGateway' => function($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Service());
							return new TableGateway('service', $dbAdapter, null, $resultSetPrototype);
						}
				)
		);
	}

}