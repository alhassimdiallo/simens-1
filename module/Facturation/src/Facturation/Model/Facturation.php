<?php
namespace Facturation\Model;

class Facturation {
	public $id_facturation;
	public $id_patient;
	public $id_service;
	public $date_cons;
	public $numero;
	public $montant;
	public $note;

	public function exchangeArray($data) {
		$this->id_facturation = (! empty ( $data ['id_facturation'] )) ? $data ['id_facturation'] : null;
		$this->id_patient = (! empty ( $data ['id_patient'] )) ? $data ['id_patient'] : null;
		$this->id_service = (! empty ( $data ['id_service'] )) ? $data ['id_service'] : null;
		$this->date_cons = (! empty ( $data ['date_cons'] )) ? $data ['date_cons'] : null;
		$this->numero = (! empty ( $data ['numero'] )) ? $data ['numero'] : null;
		$this->montant = (! empty ( $data ['montant'] )) ? $data ['montant'] : null;
		$this->note = (! empty ( $data ['note'] )) ? $data ['note'] : null;
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
}