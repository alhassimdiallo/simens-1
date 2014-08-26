<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Hospitalisation\Controller\Hospitalisation' => 'Hospitalisation\Controller\HospitalisationController',
				),
		),
		'router' => array(
				'routes' => array(
						'hospitalisation' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/hospitalisation[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Hospitalisation\Controller\Hospitalisation',
												'action'     => 'hospi',
										),
								),
						),
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'hospitalisation' => __DIR__ . '/../view',
				),
		),
);