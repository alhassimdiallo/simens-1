<?php
namespace Admin\Model;

class Utilisateur{
	public $id;
	public $login;
	public $password;
	public $name;
	public $prenom;
	public $service;
	public $type;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->login = (!empty($data['login'])) ? $data['login'] : null;
		$this->password  = (!empty($data['password'])) ? $data['password'] : null;
		$this->name  = (!empty($data['name'])) ? $data['name'] : null;
		$this->prenom  = (!empty($data['prenom'])) ? $data['prenom'] : null;
		$this->service  = (!empty($data['service'])) ? $data['service'] : null;
		$this->type  = (!empty($data['TYPE'])) ? $data['TYPE'] : null;
	}
}