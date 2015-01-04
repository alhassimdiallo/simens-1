<?php

namespace Hospitalisation\Model;

/**
 * POUR LA RECUPERATION DES DONNEES DE LA BASE
 * @author hassim
 *
 */
class ResultatExamen {
	
	public $idResultat;
	public $idDemande;
	public $techniqueUtiliser;
	public $noteResultat;
	public $conclusion;
	public $image;
	public $envoyer;
	
	public function exchangeArray($data) {
 			$this->idResultat = (! empty ( $data ['idResultat'] )) ? $data ['idResultat'] : null;
 			$this->idDemande = (! empty ( $data ['idDemande'] )) ? $data ['idDemande'] : null;
 			$this->techniqueUtiliser = (! empty ( $data ['techniqueUtiliser'] )) ? $data ['techniqueUtiliser'] : null;
 			$this->noteResultat = (! empty ( $data ['noteResultat'] )) ? $data ['noteResultat'] : null;
 			$this->conclusion = (! empty ( $data ['conclusion'] )) ? $data ['conclusion'] : null;
 			$this->image = (! empty ( $data ['image'] )) ? $data ['image'] : null;
 			$this->envoyer = (! empty ( $data ['envoyer'] )) ? $data ['envoyer'] : null;
	}
	
}