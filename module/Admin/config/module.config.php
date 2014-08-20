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

		'view_manager' => array(
				'template_path_stack' => array(
						'admin' => __DIR__ . '/../view',
				),
		),
);