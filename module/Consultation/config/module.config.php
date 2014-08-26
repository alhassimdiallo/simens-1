<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Consultation\Controller\Consultation' => 'Consultation\Controller\ConsultationController',
				),
		),
		'router' => array(
				'routes' => array(
						'consultation' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/consultation[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Consultation\Controller\Consultation',
												'action'     => 'recherche',
										),
								),
						),
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'consultation' => __DIR__ . '/../view',
				),
		),
);