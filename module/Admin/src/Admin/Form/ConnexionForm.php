<?php
namespace Admin\Form;

use Zend\Form\Form;

class ConnexionForm extends Form{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct();

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'username',
				'type' => 'Text',
				'options' => array(
						'label' => 'Login',
				),
		));
		$this->add(array(
				'name' => 'password',
				'type' => 'Password',
				'options' => array(
						'label' => 'Mot de passe',
				),
		));
		$this->add(array(
				'name' => 'rememberme',
				'type' => 'Checkbox',
				'options' => array(
						'label' => 'Remember Me ?:',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Submit',
						'id' => 'submitbutton',
				),
		));
	}
}
