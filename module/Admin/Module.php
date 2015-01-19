<?php

namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Admin\Model\UtilisateursTable;
use Zend\Db\ResultSet\ResultSet;
use Admin\Model\Utilisateurs;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\StaticEventManager;

class Module implements AutoloaderProviderInterface
{
	/**
	 * Init function
	 *
	 * @return void
	 */
	public function init()
	{
		// Attach Event to EventManager
		$events = StaticEventManager::getInstance();
		$events->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this, 'mvcPreDispatch'), 100); //@todo - Go directly to User\Event\Authentication
	    
	}
	
	
	
    /**
     * Get Autoloader Configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
    
    
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	
	/**
	 * MVC preDispatch Event
	 *
	 * @param $event
	 * @return mixed
	 */
	public function mvcPreDispatch($event) {
		$di = $event->getTarget()->getServiceLocator();
		$auth = $di->get('Admin\Event\Authentication');
	
		return  $auth->preDispatch($event);
	}
	
	public function getServiceConfig()
	{
		return array(
				'factories' => array(
						'Admin\Model\UtilisateursTable' =>  function($sm) {
							$tableGateway = $sm->get('UtilisateursTableGateway');
							$table = new UtilisateursTable($tableGateway);
							return $table;
						},
						'UtilisateursTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Utilisateurs());
							return new TableGateway('utilisateurs', $dbAdapter, null, $resultSetPrototype);
						},
				),
		);
	}
}