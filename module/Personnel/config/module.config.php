<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Personnel\Controller\Personnel' => 'Personnel\Controller\PersonnelController',
				),
		),
		'router' => array(
				'routes' => array(
						'personnel' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/personnel[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Personnel\Controller\Personnel',
												'action'     => 'index',
										),
								),
						),
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'personnel' => __DIR__ . '/../view',
				),
		),
);