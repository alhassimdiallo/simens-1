<?php
namespace Personnel\Model;

class Service {
	public  $id_personne;
	Public  $nom;
	public  $domaine;

	public function exchangeArray($data) {
		$this->id_personne = (! empty ( $data ['id_personne'] )) ? $data ['id_personne'] : null;
		$this->nom = (! empty ( $data ['nom'] )) ? $data ['nom'] : null;
		$this->domaine = (! empty ( $data ['nom'] )) ? $data ['domaine'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}