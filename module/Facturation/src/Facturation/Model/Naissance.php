<?php
namespace Facturation\Model;

class Naissance {
	public $id_bebe;
	public $id_maman;
	public $heure_naissance;
	public $poids;
	public $taille;
	public $groupe_sanguin;
	public $date_enregistrement;
	public $date_naissance;
	public $note;

	public function exchangeArray($data) {
		$this->id_bebe = (! empty ( $data ['id_bebe'] )) ? $data ['id_bebe'] : null;
		$this->id_maman = (! empty ( $data ['id_maman'] )) ? $data ['id_maman'] : null;
		$this->heure_naissance = (! empty ( $data ['heure_naissance'] )) ? $data ['heure_naissance'] : null;
		$this->poids = (! empty ( $data ['poids'] )) ? $data ['poids'] : null;
		$this->taille = (! empty ( $data ['taille'] )) ? $data ['taille'] : null;
		$this->groupe_sanguin = (! empty ( $data ['groupe_sanguin'] )) ? $data ['groupe_sanguin'] : null;
		$this->date_enregistrement = (! empty ( $data ['date_enregistrement'] )) ? $data ['date_enregistrement'] : null;
		$this->date_naissance = (! empty ( $data ['date_naissance'] )) ? $data ['date_naissance'] : null;
		$this->note = (! empty ( $data ['note'] )) ? $data ['note'] : null;
	}
}
