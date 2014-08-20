<?php
namespace Admin\Model;

class AuthentificationService{
	public $id;
	public $username;
	public $password;
	public $id_service;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->username = (!empty($data['username'])) ? $data['username'] : null;
		$this->password  = (!empty($data['password'])) ? $data['password'] : null;
		$this->id_service  = (!empty($data['id_service'])) ? $data['id_service'] : null;
	}
}
