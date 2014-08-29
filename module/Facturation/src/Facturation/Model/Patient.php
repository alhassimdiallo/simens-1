<?php

namespace Facturation\Model;

class Patient {
	public $id_personne;
	public $nom;
	public $prenom;
	public $date_naissance;
	public $adresse;
	public $sexe;
	public $nationalite_actuelle;

	public function exchangeArray($data) {
		$this->id_personne = (! empty ( $data ['id_personne'] )) ? $data ['id_personne'] : null;
		$this->nom = (! empty ( $data ['nom'] )) ? $data ['nom'] : null;
		$this->prenom = (! empty ( $data ['prenom'] )) ? $data ['prenom'] : null;
		$this->date_naissance = (! empty ( $data ['date_naissance'] )) ? $data ['date_naissance'] : null;
		$this->adresse = (! empty ( $data ['adresse'] )) ? $data ['adresse'] : null;
		$this->sexe = (! empty ( $data ['sexe'] )) ? $data ['sexe'] : null;

		$this->nationalite_actuelle = (! empty ( $data ['nationalite_actuelle'] )) ? $data ['nationalite_actuelle'] : null;
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}