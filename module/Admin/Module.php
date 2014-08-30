<?php

namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Admin\Model\AuthentificationService;
use Admin\Model\AuthentificationServiceTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {
	public function onBootstrap(MvcEvent $e) {
		$eventManager = $e->getApplication ()->getEventManager ();
		$moduleRouteListener = new ModuleRouteListener ();
		$moduleRouteListener->attach ( $eventManager );
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
						'Admin\Model\AuthentificationStorage' => function ($sm) {
							return new \Admin\Model\AuthentificationStorage ( 'zf_tutorial' );
						},

						'AuthService' => function ($sm) {
							// My assumption, you've alredy set dbAdapter
							// and has users table with columns : user_name and pass_word
							// that password hashed with md5
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$dbTableAuthAdapter = new DbTableAuthAdapter ( $dbAdapter, 'authentification', 'login', 'password' );

							$authService = new AuthenticationService ();
							$authService->setAdapter ( $dbTableAuthAdapter );
							$authService->setStorage ( $sm->get ( 'Admin\Model\AuthentificationStorage' ) );
							return $authService;
						},
						'Admin\Model\AuthentificationServiceTable' => function ($sm) {
							$tableGateway = $sm->get ( 'AuthentificationServiceTableGateway' );
							$table = new AuthentificationServiceTable ( $tableGateway );
							return $table;
						},
						'AuthentificationServiceTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new AuthentificationService () );
							return new TableGateway ( 'authentification_service', $dbAdapter, null, $resultSetPrototype );
						}
				)
		);
	}
}