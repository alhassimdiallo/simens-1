<?php
namespace Consultation\Model;

class DemandeVisitePreanesthesique{
	public $id_cons;
	public $diagnostic;
	public $observation;
	public $intervention_prevue;
	public $numero_vpa;
	public $type_anesthesie;

	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
		$this->diagnostic = (! empty ( $data ['DIAGNOSTIC'] )) ? $data ['DIAGNOSTIC'] : null;
		$this->observation = (! empty ( $data ['OBSERVATION'] )) ? $data ['OBSERVATION'] : null;
		$this->intervention_prevue = (! empty ( $data ['INTERVENTION_PREVUE'] )) ? $data ['INTERVENTION_PREVUE'] : null;
		$this->numero_vpa = (! empty ( $data ['NUMERO_VPA'] )) ? $data ['NUMERO_VPA'] : null;
		$this->type_anesthesie = (! empty ( $data ['TYPE_ANESTHESIE'] )) ? $data ['TYPE_ANESTHESIE'] : null;
	}
}