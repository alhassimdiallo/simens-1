<?php

namespace Personnel\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;

class PersonnelTable {
	protected $tableGateway;
	protected $conversionDate;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getConversionDate(){
		$this->conversionDate = new DateHelper();
	
		return $this->conversionDate;
	}
	
	public function getPersonne($id_personne)
	{
		$id_personne  = (int) $id_personne;
		$rowset = $this->tableGateway->select(array('ID_PERSONNE' => $id_personne));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id_personne");
		}
		return $row;
	}
	
	public function savePersonnel(Personnel $personnel, $nomphoto = null)
	{
		$this->getConversionDate();
		
		$data = array(
				'civilite' => $personnel->civilite,
				'nom'  => $personnel->nom,
				'prenom'  => $personnel->prenom,
				'date_naissance'  => $this->conversionDate->convertDateInAnglais($personnel->date_naissance),
				'lieu_naissance'  => $personnel->lieu_naissance,
				'nationalite'  => $personnel->nationalite_actuelle,
				'adresse'  => $personnel->adresse,
				'telephone'  => $personnel->telephone,
				'email'  => $personnel->email,
				'type_personnel'  => $personnel->type_personnel,
				'sexe'  => $personnel->sexe,
				'profession'  => $personnel->profession,
				'date_enregistrement'  => $personnel->date_enregistrement,
				'photo'  => $nomphoto,
		);

		$id_personne = (int)$personnel->id_personne;
		if($id_personne == 0) {
			return($this->tableGateway->getLastInsertValue($this->tableGateway->insert($data)));
 		} else {
			if ($this->getPersonne($id_personne)) {
				$this->tableGateway->update($data, array('ID_PERSONNE' => $id_personne));
			} else {
				throw new \Exception('Cette personne n existe pas');
 			}
		}
	
	}
	
	//Réduire la chaine addresse
	function adresseText($Text){
		$chaine = $Text;
		if(strlen($Text)>36){
			$chaine = substr($Text, 0, 36);
			$nb = strrpos($chaine, ' ');
			$chaine = substr($chaine, 0, $nb);
			$chaine .=' ...';
		}
		return $chaine;
	}
	
	public function getListePersonnel() 
	{


		$db = $this->tableGateway->getAdapter();
		
		$aColumns = array('Nom','Prenom','Datenaissance','Sexe', 'Adresse', 'Nationalite', 'id');
		
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
		->from(array('pers' => 'personnel'))->columns(array('Nom'=>'NOM','Prenom'=>'PRENOM','Datenaissance'=>'DATE_NAISSANCE','Sexe'=>'SEXE','Adresse'=>'ADRESSE','Nationalite'=>'NATIONALITE','Typepersonnel'=>'TYPE_PERSONNEL','id'=>'ID_PERSONNE'));
		
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
		 * Pr�parer la liste
		*/
		foreach ( $rResult as $aRow )
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
						$html  ="<a href='".$tabURI[0]."public/personnel/info-personnel/id_personne/".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline; margin-right: 15%;' src='".$tabURI[0]."public/images_icons/vue.PNG' title='details'></a>";
		
						$html .="<a href='".$tabURI[0]."public/facturation/modifier/id_patient/".$aRow[ $aColumns[$i] ]."'>";
						$html .="<img style='display: inline; margin-right: 15%;' src='".$tabURI[0]."public/images_icons/modifier.PNG' title='Modifier'></a>";
		
						$html .="<a id='".$aRow[ $aColumns[$i] ]."' href='javascript:envoyer(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline;' src='".$tabURI[0]."public/images_icons/trash_16.PNG' title='Supprimer'></a>";
						
						$html .="<input type='hidden' value='".$aRow[ 'Typepersonnel' ]."'>";
						
						$row[] = $html;
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