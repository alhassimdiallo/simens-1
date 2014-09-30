<?php
namespace Consultation\Model;

class RvPatientCons {
	public $id_personne;
	public $id_service;
	public $id_cons;
	public $note;
	public $heure;
	public $date;

	public function exchangeArray($data) {
		$this->id_personne = (! empty ( $data ['ID_PERSONNE'] )) ? $data ['ID_PERSONNE'] : null;
		$this->id_service = (! empty ( $data ['ID_SERVICE'] )) ? $data ['ID_SERVICE'] : null;
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
		$this->note = (! empty ( $data ['NOTE'] )) ? $data ['NOTE'] : null;
		$this->heure = (! empty ( $data ['heure'] )) ? $data ['heure'] : null;
		$this->date = (! empty ( $data ['date'] )) ? $data ['date'] : null;
	}
}