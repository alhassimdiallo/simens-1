<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'EspacePatient\Controller\EspacePatient' => 'EspacePatient\Controller\EspacePatientController',
				),
		),
		'router' => array(
				'routes' => array(
						'espace-patient' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/espacepatient[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'EspacePatient\Controller\EspacePatient',
												'action'     => 'recherche',
										),
								),
						),
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'espace-patient' => __DIR__ . '/../view',
				),
		),
);