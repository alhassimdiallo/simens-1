<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Facturation\Controller\Facturation' => 'Facturation\Controller\FacturationController',
				),
		),
		'router' => array(
				'routes' => array(
						'facturation' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/facturation[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Facturation\Controller\Facturation',
												'action'     => 'listepatient',
										),
								),
						),
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'facturation' => __DIR__ . '/../view',
				),
		),
);