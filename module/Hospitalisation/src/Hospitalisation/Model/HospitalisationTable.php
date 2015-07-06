<?php

namespace Hospitalisation\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;
use Zend\XmlRpc\Value\String;
use Zend\Db\Sql\Predicate\In;

class HospitalisationTable {
	protected $tableGateway;
	protected $conversionDate;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function getHospitalisation($id_hosp)
	{
		$rowset = $this->tableGateway->select(array(
				'id_hosp' => (int) $id_hosp,
		));
		$row = $rowset->current();
		if (!$row) {
			$row = null;
		}
		return $row;
	}
	
	/**
	 * Recuperer l'hospitalisation connaissant le code de la demande d'hospitalisation
	 */
	public function getHospitalisationWithCodedh($id_demande_hospi)
	{
		$rowset = $this->tableGateway->select(array(
				'code_demande_hospitalisation' => (int) $id_demande_hospi,
		));
		$row = $rowset->current();
		if (!$row) {
			$row = null;
		}
		return $row;
	}
	
	public function saveHospitalisation($code_demande)
	{
		$today = new \DateTime ();
		$date = $today->format ( 'Y-m-d H:i:s' );
		
		$data = array(
				'date_debut' => $date,
				'code_demande_hospitalisation' => $code_demande
		);
		return($this->tableGateway->getLastInsertValue($this->tableGateway->insert($data)));
	}
	
	/**
	 * Liberation du patient
	 */
	public function libererPatient($id_demande_hospi, $resumer_medical, $motif_sorti) 
	{
		$today = new \DateTime ();
		$date = $today->format ( 'Y-m-d H:i:s' );
		
		$data = array(
				'date_fin' => $date,
				'resumer_medical' => $resumer_medical,
				'motif_sorti' => $motif_sorti,
				'terminer' => 1
		);
		return $this->tableGateway->update($data, array('code_demande_hospitalisation' => $id_demande_hospi));
	}
	
	/**
	 * MAJOR ,  MAJOR , MAJOR , MAJOR , MAJOR
	 * Recuperation de la liste des patients liberés par le médecin et a libérer par le major 
	 */
	public function getListePatientALiberer()
	{
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'Datedebut', 'Datefin' , 'id');
	
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
		->from(array('pat' => 'patient'))->columns(array('*'))
		->join(array('pers' => 'personne'), 'pat.ID_PERSONNE = pers.ID_PERSONNE', array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','id'=>'ID_PERSONNE'))
		->join(array('cons' => 'consultation'), 'cons.ID_PATIENT = pat.ID_PERSONNE', array('Datedemandehospi'=>'DATE', 'Idcons'=>'ID_CONS'))
		->join(array('dh' => 'demande_hospitalisation'), 'dh.id_cons = cons.ID_CONS' , array('*'))
		->join(array('h' => 'hospitalisation'), 'h.code_demande_hospitalisation = dh.id_demande_hospi' , array('Datedebut'=>'date_debut', 'Datefin'=>'date_fin'))
		->join(array('hl' => 'hospitalisation_lit'), 'hl.id_hosp = h.id_hosp' , array('*'))
		->where(array('h.terminer' => 1, 'hl.liberation_lit' => 0))
		->order('h.date_fin asc');
	
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
		 * $Control pour convertir la date en franï¿½ais
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
	
		$rResult2 = $stat->execute();
		foreach ( $rResult2 as $aRow )
		{
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
	
						$html  ="<infoBulleVue><a style='padding-right: 15px;' href='javascript:vuedetails(". $aRow[ $aColumns[$i] ] .")'>";
						$html .="<img src='".$tabURI[0]."public/images_icons/voir2.png' title='dÃ©tails'></a>";
						//$html .="<a><img src='".$tabURI[0]."public/images_icons/tick_16.png' title='EnvoyÃ©'></a><infoBulleVue>";
	
						$row[] = $html;
					}
	
					
					else if ($aColumns[$i] == 'Datedebut') {
						$row[] = $Control->convertDateTime($aRow[ 'Datedebut' ]);
					}
	
					else if ($aColumns[$i] == 'Datefin') {
						$row[] = $Control->convertDateTime($aRow[ 'Datefin' ]);
					}
					
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
	
				}
			}
	
			$output['aaData'][] = $row;
		}
		return $output;
	}
}