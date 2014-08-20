<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Admin\Controller\Login' => 'Admin\Controller\LoginController',
				),
		),
		'router' => array(
				'routes' => array(
						'admin' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/admin[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Admin\Controller\Login',
												'action'     => 'login',
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