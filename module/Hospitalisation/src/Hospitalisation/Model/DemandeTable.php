<?php

namespace Hospitalisation\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;

class DemandeTable {
	protected $tableGateway;
	protected $conversionDate;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getDemande($idDemande)
	{
		$rowset = $this->tableGateway->select(array(
				'idDemande' => (int) $idDemande,
		));
		
		$row = $rowset->current();
		if (!$row) {
			$row = null;
		}
		return $row;
	}
	
	/**
	 * LISTE DE TOUS LES EXAMENS DEMANDES (BIOLOGIQUES ET MORPHOLOGIQUES)
	 * @param unknown $id_cons
	 * @return \Zend\Db\Adapter\Driver\ResultInterface
	 */
	public function getDemandesExamens($id_cons) 
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select();
		$sQuery->from(array('d' => 'demande'))->columns(array('*'))
		->where(array('d.idCons' => $id_cons))
		->order('d.idDemande ASC');

		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute();
		
		return $Result;
	}
	
	
	/**
	 * LISTE DES EXAMENS MORPHOLOGIQUES DEMANDES
	 * @param $id_cons
	 */
	
	public function getDemandesExamensMorphologiques($id_cons)
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select();
		$sQuery->from(array('d' => 'demande'))->columns(array('*'))
		->join(array('e' => 'examens'), 'e.idExamen = d.idExamen', array('*'))
		->where(array('d.idCons' => $id_cons, 'e.idType' => 2))
		->order('d.idDemande ASC');
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute();
	
		return $Result;
	}
	
	/**
	 * LISTE DES EXAMENS BIOLOGIQUES DEMANDES
	 * @param $id_cons
	 */
	
	public function getDemandesExamensBiologiques($id_cons)
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select();
		$sQuery->from(array('d' => 'demande'))->columns(array('*'))
		->join(array('e' => 'examens'), 'e.idExamen = d.idExamen', array('*'))
		->where(array('d.idCons' => $id_cons, 'e.idType' => 1))
		->order('d.idDemande ASC');
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute();
	
		return $Result;
	}
	
	
	/**
	 * Recuperer un enregistrement
	 * @param l'id de la consultation : $id_cons
	 */
	public function getDemandeWithIdcons($id_cons) 
	{
		$db = $this->tableGateway->getAdapter();
		
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pat' => 'patient'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','id'=>'id_personne'))
		->join(array('cons' => 'consultation'), 'cons.pat_id_personne = pat.id_personne', array('Datedemande'=>'date', 'Idcons'=>'id_cons'))
		->join(array('d' => 'demande'), 'd.idCons = cons.id_cons' , array('*'))
		->join(array('med' => 'medecin') , 'med.id_personne = cons.id_personne' , array('NomMedecin' =>'nom', 'PrenomMedecin' => 'prenom'))
		->where(array('d.idCons' => $id_cons))
		->group('d.idCons');
		
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute();
		
		return $Result;
	}
	
	public function VerifierDemandeExamenSatisfaite($id_cons)
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select();
		$sQuery->from(array('d' => 'demande'))->columns(array('*'))
		->where(array('d.idCons' => $id_cons));
			
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute();
		
		foreach ($Result as $ligne) {
			
			/*
			 *On cherche dans la table resultat si toutes les demandes sont satisfaites  
			 */
			$sql2 = new Sql($db);
			$sQuery2 = $sql2->select();
			$sQuery2->from(array('re' => 'resultats_examens2'))->columns(array('*'))
			->where(array('re.idDemande' => $ligne['idDemande']));
			$stat2 = $sql2->prepareStatementForSqlObject($sQuery2);
			$Result2 = $stat2->execute()->current();
			if($Result2['envoyer'] == 0) {
				return false;
			}
			
		}
	
		return true;
	}
	
	
	/**
	 * V�rifier si toutes les demandes d'examens morphologiques sont satifaites
	 */
	public function VerifierDemandeExamenMorphoSatisfaite($id_cons)
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select();
		$sQuery->from(array('d' => 'demande'))->columns(array('*'))
		->join(array('e' => 'examens'), 'e.idExamen = d.idExamen', array('*'))
		->where(array('d.idCons' => $id_cons, 'e.idType' => 2));
			
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute();
	
		foreach ($Result as $ligne) {
				
			/*
			 * On cherche dans la table resultat si toutes les demandes sont satisfaites
			 */
			$sql2 = new Sql($db);
			$sQuery2 = $sql2->select();
			$sQuery2->from(array('re' => 'resultats_examens2'))->columns(array('*'))
			->where(array('re.idDemande' => $ligne['idDemande']));
			$stat2 = $sql2->prepareStatementForSqlObject($sQuery2);
			$Result2 = $stat2->execute()->current();
			if($Result2['envoyer'] == 0) {
				return false;
			}
				
		}
	
		return true;
	}
	
	
	/**
	 * V�rifier si toutes les demandes d'examens biologiques sont satifaites
	 */
	public function VerifierDemandeExamenBioSatisfaite($id_cons)
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select();
		$sQuery->from(array('d' => 'demande'))->columns(array('*'))
		->join(array('e' => 'examens'), 'e.idExamen = d.idExamen', array('*'))
		->where(array('d.idCons' => $id_cons, 'e.idType' => 1));
			
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute();
	
		foreach ($Result as $ligne) {
	
			/*
			 * On cherche dans la table resultat si toutes les demandes sont satisfaites
			*/
			$sql2 = new Sql($db);
			$sQuery2 = $sql2->select();
			$sQuery2->from(array('re' => 'resultats_examens2'))->columns(array('*'))
			->where(array('re.idDemande' => $ligne['idDemande']));
			$stat2 = $sql2->prepareStatementForSqlObject($sQuery2);
			$Result2 = $stat2->execute()->current();
			if($Result2['envoyer'] == 0) {
				return false;
			}
	
		}
	
		return true;
	}
	
	
	/**
	 * EXAMENS BIOLOGIQUES ,  EXAMENS BIOLOGIQUES , EXAMENS BIOLOGIQUES
	 * Recuperation de la liste des patients pour lesquels tous les examens sont deja effectues
	 */
	public function getListeExamensEffectues()
	{
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'dateDemande', 'medecinDemandeur' , 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pat' => 'patient'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','id'=>'id_personne'))
		->join(array('cons' => 'consultation'), 'cons.pat_id_personne = pat.id_personne', array('Datedemande'=>'date', 'Idcons'=>'id_cons'))
		->join(array('d' => 'demande'), 'd.idCons = cons.id_cons' , array('*'))
		->join(array('med' => 'medecin') , 'med.id_personne = cons.id_personne' , array('NomMedecin' =>'nom', 'PrenomMedecin' => 'prenom'))
		->order('d.idDemande DESC')
		->group('d.idCons');
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Preparer la liste
		*/
		
		/* EXAMENS BIOLOGIQUES
		 * EXAMENS BIOLOGIQUES
		 * EXAMENS BIOLOGIQUES
		 * 
		 * Liste examens satisfaits
		 */

		/*
		 * Liste satisfaite
		 */
		$rResult2 = $stat->execute();
		foreach ( $rResult2 as $aRow )
		{
		  if($this->VerifierDemandeExamenBioSatisfaite($aRow[ 'Idcons' ]) == true ) {
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
	
					else if ($aColumns[$i] == 'Datenaissance') {
						$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'Adresse') {
						$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
					}
	
					else if ($aColumns[$i] == 'id') {
	
						$html  ="<infoBulleVue><a href='javascript:listeExamensBio(". $aRow[ $aColumns[$i] ] .",". $aRow[ 'idDemande' ] .")'>";
						$html .="<img src='".$tabURI[0]."public/images_icons/voir.png' title='détails'></a><infoBulleVue>";
	
						if($this->VerifierDemandeExamenBioSatisfaite($aRow[ 'Idcons' ]) == true ) {
							$html .="<infoBulleVue><a>";
							$html .="<img style='margin-left: 20%;' src='".$tabURI[0]."public/images_icons/tick_16.png' title='Terminer'></a><infoBulleVue>";
						}else {
							$html .="<a>";
							$html .="<img style='margin-left: 20%; color: white; opacity: 0.09;' src='".$tabURI[0]."public/images_icons/tick_16.png' title='Terminer'></a>";
						}
						
						
						$html .="<input id='".$aRow[ 'idDemande' ]."'  type='hidden' value='".$aRow[ 'Idcons' ]."'>";
	
						$row[] = $html;
					}
	
					else if ($aColumns[$i] == 'medecinDemandeur') {
						$row[] = $aRow[ 'PrenomMedecin' ]." ".$aRow[ 'NomMedecin' ];
					}
						
					else if ($aColumns[$i] == 'dateDemande') {
						$row[] = $Control->convertDateTime($aRow[ 'dateDemande' ]);
					}
	
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
	
				}
			}
	
			$output['aaData'][] = $row;
		  }
		}
		return $output;
	}
	
	/**
	 * EXAMENS BIOLOGIQUES ,  EXAMENS BIOLOGIQUES , EXAMENS BIOLOGIQUES
	 * Recuperation de la liste des patients pour les demandes d'examens
	 */
	public function getListeDemandesExamens()
	{
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'dateDemande', 'medecinDemandeur' , 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pat' => 'patient'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','id'=>'id_personne'))
		->join(array('cons' => 'consultation'), 'cons.pat_id_personne = pat.id_personne', array('Datedemande'=>'date', 'Idcons'=>'id_cons'))
		->join(array('d' => 'demande'), 'd.idCons = cons.id_cons' , array('*'))
		->join(array('med' => 'medecin') , 'med.id_personne = cons.id_personne' , array('NomMedecin' =>'nom', 'PrenomMedecin' => 'prenom'))
		
		->join(array('e' => 'examens'), 'e.idExamen = d.idExamen', array('*'))
		->where(array('e.idType' => 2))
		->order('d.idDemande ASC')
		->group('d.idCons');
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Preparer la liste
		*/
	
		/* EXAMENS BIOLOGIQUES
		 * EXAMENS BIOLOGIQUES
		* EXAMENS BIOLOGIQUES
		*
		* Liste non encore satisfaite
		*/
		foreach ( $rResult as $aRow )
		{
			if($this->VerifierDemandeExamenBioSatisfaite($aRow[ 'Idcons' ]) == false ) {
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if ( $aColumns[$i] != ' ' )
					{
						/* General output */
						if ($aColumns[$i] == 'Nom'){
							$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
						}
	
						else if ($aColumns[$i] == 'Datenaissance') {
							$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
						}
	
						else if ($aColumns[$i] == 'Adresse') {
							$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
						}
	
						else if ($aColumns[$i] == 'id') {
	
							$html  ="<infoBulleVue><a href='javascript:listeExamensBio(". $aRow[ $aColumns[$i] ] .",". $aRow[ 'idDemande' ] .")'>";
							$html .="<img src='".$tabURI[0]."public/images_icons/voir.png' title='détails'></a><infoBulleVue>";
	
							if($this->VerifierDemandeExamenBioSatisfaite($aRow[ 'Idcons' ]) == true ) {
								$html .="<infoBulleVue><a>";
								$html .="<img style='margin-left: 20%;' src='".$tabURI[0]."public/images_icons/tick_16.png' title='Terminer'></a><infoBulleVue>";
							}else {
								$html .="<a>";
								$html .="<img style='margin-left: 20%; color: white; opacity: 0.09;' src='".$tabURI[0]."public/images_icons/tick_16.png' ></a>";
							}
	
	
							$html .="<input id='".$aRow[ 'idDemande' ]."'  type='hidden' value='".$aRow[ 'Idcons' ]."'>";
	
							$row[] = $html;
						}
	
						else if ($aColumns[$i] == 'medecinDemandeur') {
							$row[] = $aRow[ 'PrenomMedecin' ]." ".$aRow[ 'NomMedecin' ];
						}
	
						else if ($aColumns[$i] == 'dateDemande') {
							$row[] = $Control->convertDateTime($aRow[ 'dateDemande' ]);
						}
	
						else {
							$row[] = $aRow[ $aColumns[$i] ];
						}
	
					}
				}
	
				$output['aaData'][] = $row;
			}
		}
	
		return $output;
	}
	
	
	/**
	 * EXAMENS MORPHOLOGIQUES ,  EXAMENS MORPHOLOGIQUES , EXAMENS MORPHOLOGIQUES
	 * Recuperation de la liste des patients pour les demandes d'examens
	 */
	public function getListeDemandesExamensMorpho()
	{
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'dateDemande', 'medecinDemandeur' , 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pat' => 'patient'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','id'=>'id_personne'))
		->join(array('cons' => 'consultation'), 'cons.pat_id_personne = pat.id_personne', array('Datedemande'=>'date', 'Idcons'=>'id_cons'))
		->join(array('d' => 'demande'), 'd.idCons = cons.id_cons' , array('*'))
		->join(array('med' => 'medecin') , 'med.id_personne = cons.id_personne' , array('NomMedecin' =>'nom', 'PrenomMedecin' => 'prenom'))
		
		->join(array('e' => 'examens'), 'e.idExamen = d.idExamen', array('*'))
		->where(array('e.idType' => 2))
		->order('d.idDemande ASC')
		->group('d.idCons');
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Preparer la liste
		*/
	
		foreach ( $rResult as $aRow )
		{
			if($this->VerifierDemandeExamenMorphoSatisfaite($aRow[ 'Idcons' ]) == false ) {
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if ( $aColumns[$i] != ' ' )
					{
						/* General output */
						if ($aColumns[$i] == 'Nom'){
							$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
						}
	
						else if ($aColumns[$i] == 'Datenaissance') {
							$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
						}
	
						else if ($aColumns[$i] == 'Adresse') {
							$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
						}
	
						else if ($aColumns[$i] == 'id') {
	
							$html  ="<infoBulleVue><a href='javascript:listeExamensMorpho(". $aRow[ $aColumns[$i] ] .",". $aRow[ 'idDemande' ] .")'>";
							$html .="<img src='".$tabURI[0]."public/images_icons/voir.png' title='détails'></a><infoBulleVue>";
	
							if($this->VerifierDemandeExamenMorphoSatisfaite($aRow[ 'Idcons' ]) == true ) {
								$html .="<infoBulleVue><a>";
								$html .="<img style='margin-left: 20%;' src='".$tabURI[0]."public/images_icons/tick_16.png' title='Terminer'></a><infoBulleVue>";
							}else {
								$html .="<a>";
								$html .="<img style='margin-left: 20%; color: white; opacity: 0.09;' src='".$tabURI[0]."public/images_icons/tick_16.png' ></a>";
							}
	
	
							$html .="<input id='".$aRow[ 'idDemande' ]."'  type='hidden' value='".$aRow[ 'Idcons' ]."'>";
	
							$row[] = $html;
						}
	
						else if ($aColumns[$i] == 'medecinDemandeur') {
							$row[] = $aRow[ 'PrenomMedecin' ]." ".$aRow[ 'NomMedecin' ];
						}
	
						else if ($aColumns[$i] == 'dateDemande') {
							$row[] = $Control->convertDateTime($aRow[ 'dateDemande' ]);
						}
	
						else {
							$row[] = $aRow[ $aColumns[$i] ];
						}
	
					}
				}
	
				$output['aaData'][] = $row;
			}
		}
	
		return $output;
	}
	
	/**
	 * EXAMENS MORPHOLOGIQUES ,  EXAMENS MORPHOLOGIQUES , EXAMENS MORPHOLOGIQUES
	 * Recuperation de la liste des patients pour lesquels tous les examens sont deja effectues
	 */
	public function getListeExamensMorphoEffectues()
	{
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'dateDemande', 'medecinDemandeur' , 'id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pat' => 'patient'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Datenaissance'=>'date_naissance','Sexe'=>'sexe','Adresse'=>'adresse','id'=>'id_personne'))
		->join(array('cons' => 'consultation'), 'cons.pat_id_personne = pat.id_personne', array('Datedemande'=>'date', 'Idcons'=>'id_cons'))
		->join(array('d' => 'demande'), 'd.idCons = cons.id_cons' , array('*'))
		->join(array('med' => 'medecin') , 'med.id_personne = cons.id_personne' , array('NomMedecin' =>'nom', 'PrenomMedecin' => 'prenom'))
		->order('d.idDemande DESC')
		->group('d.idCons');
	
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en fran�ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Preparer la liste
		*/
	
		/* EXAMENS BIOLOGIQUES
		 * EXAMENS BIOLOGIQUES
		* EXAMENS BIOLOGIQUES
		*
		* Liste examens satisfaits
		*/
	
		/*
		 * Liste satisfaite
		*/
		$rResult2 = $stat->execute();
		foreach ( $rResult2 as $aRow )
		{
			if($this->VerifierDemandeExamenMorphoSatisfaite($aRow[ 'Idcons' ]) == true ) {
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if ( $aColumns[$i] != ' ' )
					{
						/* General output */
						if ($aColumns[$i] == 'Nom'){
							$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
						}
	
						else if ($aColumns[$i] == 'Datenaissance') {
							$row[] = $Control->convertDate($aRow[ $aColumns[$i] ]);
						}
	
						else if ($aColumns[$i] == 'Adresse') {
							$row[] = $this->adresseText($aRow[ $aColumns[$i] ]);
						}
	
						else if ($aColumns[$i] == 'id') {
	
							$html  ="<infoBulleVue><a href='javascript:listeExamensMorpho(". $aRow[ $aColumns[$i] ] .",". $aRow[ 'idDemande' ] .")'>";
							$html .="<img src='".$tabURI[0]."public/images_icons/voir.png' title='détails'></a><infoBulleVue>";
	
							if($this->VerifierDemandeExamenMorphoSatisfaite($aRow[ 'Idcons' ]) == true ) {
								$html .="<infoBulleVue><a>";
								$html .="<img style='margin-left: 20%;' src='".$tabURI[0]."public/images_icons/tick_16.png' title='Terminer'></a><infoBulleVue>";
							}else {
								$html .="<a>";
								$html .="<img style='margin-left: 20%; color: white; opacity: 0.09;' src='".$tabURI[0]."public/images_icons/tick_16.png' title='Terminer'></a>";
							}
	
	
							$html .="<input id='".$aRow[ 'idDemande' ]."'  type='hidden' value='".$aRow[ 'Idcons' ]."'>";
	
							$row[] = $html;
						}
	
						else if ($aColumns[$i] == 'medecinDemandeur') {
							$row[] = $aRow[ 'PrenomMedecin' ]." ".$aRow[ 'NomMedecin' ];
						}
	
						else if ($aColumns[$i] == 'dateDemande') {
							$row[] = $Control->convertDateTime($aRow[ 'dateDemande' ]);
						}
	
						else {
							$row[] = $aRow[ $aColumns[$i] ];
						}
	
					}
				}
	
				$output['aaData'][] = $row;
			}
		}
		return $output;
	}
	
	/**
	 * Demande effectuee
	 */
	public function demandeEffectuee($idDemande)
	{
		$this->tableGateway->update(array('appliquer' => 1), array('idDemande' => $idDemande));
	}
	
}