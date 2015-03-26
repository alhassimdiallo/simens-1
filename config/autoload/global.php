<?php
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array (
		'db' => array (
				'driver' => 'Pdo',
				'dsn' => 'mysql:dbname=simens;host=localhost',
				'driver_options' => array (
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
				)
		),
		'service_manager' => array (
				'factories' => array (
						'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
// 						'Admin\Model\AuthentificationStorage' => function ($sm) {
// 							return new \Admin\Model\AuthentificationStorage ( 'zf_tutorial' );
// 						},

// 						'AuthService' => function ($sm) {
// 							// My assumption, you've alredy set dbAdapter
// 							// and has users table with columns : user_name and pass_word
// 							// that password hashed with md5
// 							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
// 							$dbTableAuthAdapter = new DbTableAuthAdapter ( $dbAdapter, 'authentification', 'login', 'password' );

// 							$authService = new AuthenticationService ();
// 							$authService->setAdapter ( $dbTableAuthAdapter );
// 							$authService->setStorage ( $sm->get ('Admin\Model\AuthentificationStorage' ) );
// 							return $authService;
// 						}
				)
		)
);
