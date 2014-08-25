<?php
return array(
		'controllers' => array(
				'invokables' => array(
						//'Admin\Controller\Login' => 'Admin\Controller\LoginController',
						'Admin\Controller\Auth' => 'Admin\Controller\AuthController',
						'Admin\Controller\Success' => 'Admin\Controller\SuccessController'
				),
		),
// 		'router' => array(
// 				'routes' => array(
// 						'admin' => array(
// 								'type'    => 'segment',
// 								'options' => array(
// 										'route'    => '/admin[/][:action][/:id]',
// 										'constraints' => array(
// 												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
// 												'id'     => '[0-9]+',
// 										),
// 										'defaults' => array(
// 												'controller' => 'Admin\Controller\Login',
// 												'action'     => 'login',
// 										),
// 								),
// 						),
// 				),
// 		),
		'router' => array(
				'routes' => array(
						'home' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
										'route'    => '/',
										'defaults' => array(
												'controller' => 'Admin\Controller\Auth',
												'action'     => 'login',
										),
								),
						),
						'login' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/auth',
										'defaults' => array(
												'__NAMESPACE__' => 'Admin\Controller',
												'controller'    => 'Auth',
												'action'        => 'login',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'process' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:action]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														),
												),
										),
								),
						),

						'success' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/success',
										'defaults' => array(
												'__NAMESPACE__' => 'Admin\Controller',
												'controller'    => 'Success',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:action]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														),
												),
										),
								),
						),

				),
		),
		'service_manager' => array(
				'abstract_factories' => array(
						'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
						'Zend\Log\LoggerAbstractServiceFactory',
				),
				'aliases' => array(
						'translator' => 'MvcTranslator',
				),
		),
		'translator' => array(
				'locale' => 'en_US',
				'translation_file_patterns' => array(
						array(
								'type'     => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern'  => '%s.mo',
						),
				),
		),
		'view_manager' => array(
				'display_not_found_reason' => true,
				'display_exceptions'       => true,
				'doctype'                  => 'HTML5',
				'not_found_template'       => 'error/404',
				'exception_template'       => 'error/index',
				'template_map' => array(
						'admin/layout'           => __DIR__ . '/../view/admin/layout.phtml',
						'admin/auth/login' => __DIR__ . '/../view/admin/auth/login.phtml',
						'error/404'               => __DIR__ . '/../view/error/404.phtml',
						'error/index'             => __DIR__ . '/../view/error/index.phtml',
				),
				'template_path_stack' => array(
					'admin' => __DIR__ . '/../view',
				),
				'layout' => 'admin/layout',
		),
		// Placeholder for console routes
		'console' => array(
				'router' => array(
						'routes' => array(
						),
				),
		),
);