<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Facturation\View\Helper\DateHelper;
use Zend\Db\Sql\Sql;

class UtilisateursTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function getUtilisateurs($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function getUtilisateursWithUsername($username)
	{
		$rowset = $this->tableGateway->select(array('username' => "$username"));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	/**
	 * A utiliser et a modifier pour la gestion du cas 'un utilisateur plusieur role'
	 */
// 	public function getRole($idUtilisateur)
// 	{
// 		$db = $this->tableGateway->getAdapter();
		
// 		$sql = new Sql($db);
// 		$sQuery = $sql->select()
// 		->from(array('user' => 'utilisateurs'))->columns(array('*'))
// 		->join(array('r' => 'role'), 'user.id = r.', array('Datedemande'=>'date', 'Idcons'=>'id_cons'))
// 		->join(array('d' => 'demande'), 'd.idCons = cons.id_cons' , array('*'))
// 		->join(array('med' => 'medecin') , 'med.id_personne = cons.id_personne' , array('NomMedecin' =>'nom', 'PrenomMedecin' => 'prenom'))
// 		->where(array('user.id' => $idUtilisateur))
// 		->group('d.idCons');
		
// 		$stat = $sql->prepareStatementForSqlObject($sQuery);
// 		$Result = $stat->execute()->current();
		
// 		return $Result;
// 	}

	/**
	 * Recuperer la liste des utilisateurs
	 */
	public function getListeUtilisateurs()
	{




		$db = $this->tableGateway->getAdapter();
		
		$aColumns = array('Username','Nom','Prenom','NomService','Fonction','Role', 'Id');
		
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
		->from(array('u' => 'utilisateurs'))->columns(array('Nom'=>'nom','Prenom'=>'prenom','Username'=>'username','Role'=>'role','Fonction'=>'fonction','Id'=>'id'))
		->join(array('s' => 'service'), 's.ID_SERVICE = u.id_service', array('NomService'=>'NOM'));
		
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
		
		$rResult = $rResultFt;
		
		$output = array(
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
			if($aRow['Id'] != 1) { //SI C'EST LE superAdmin on ne l'affiche pas
			  for ( $i=0 ; $i<count($aColumns) ; $i++ )
			  {
				if ( $aColumns[$i] != ' ')
				{ 
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
		
					else if ($aColumns[$i] == 'Id') {
						$html  ="<a href='javascript:modifier(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 30%;' src='".$tabURI[0]."public/images_icons/pencil_16.png' title='détails'></a>";
		
						$html  .="<a href='javascript:supprimer(".$aRow[ $aColumns[$i] ].")'>";
						$html .="<img style='display: inline; margin-right: 5%;' src='".$tabURI[0]."public/images_icons/delete_16.png' title='Hospitaliser'></a>";
		
						$html .="<input id='".$aRow[ $aColumns[$i] ]."'   type='hidden' value='".$aRow[ 'Id' ]."'>";
		
						$row[] = $html;
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
	 * Crypter le mot de passe
	 * @param unknown $donnees
	 */
	const PASSWORD_HASH = 'MY_PASSWORD_HASH_WHICH_SHOULD_BE_SOMETHING_SECURE';
	protected function _encryptPassword($value) {
		for($i = 0; $i < 10; $i ++) {
			$value = md5 ( $value . self::PASSWORD_HASH );
		}
		return $value;
	}
	
	
	public function saveDonnees($donnees)
	{
		$date = new \DateTime ("now");
		$formatDate = $date->format ( 'Y-m-d H:i:s' );
		$data = array(
				'username' => $donnees->username,
				'password' => $this->_encryptPassword($donnees->password),
				'role' => $donnees->role,
				'nom' => $donnees->nomUtilisateur,
				'prenom' => $donnees->prenomUtilisateur,
				'id_service' => $donnees->service,
				'fonction' => $donnees->fonction,
		);
		
		$id = (int)$donnees->id;
		
		if($id == 0) {
			$data['date_enregistrement'] = $formatDate;
			$this->tableGateway->insert($data);
		}
		else {
			$data['date_de_modification'] = $formatDate;
			$this->tableGateway->update($data, array('id' => $id));
		}
	}
	
	public function modifierPassword($donnees)
	{
		$date = new \DateTime ("now");
		$formatDate = $date->format ( 'Y-m-d H:i:s' );
		$data = array(
				'username' => $donnees->username,
				'password' => $this->_encryptPassword($donnees->nouveaupassword),
				'nom' => $donnees->nomUtilisateur,
				'prenom' => $donnees->prenomUtilisateur,
				'date_de_modification' => $formatDate,
		);
	
		$this->tableGateway->update($data, array('id' => $donnees->id));
	}
	
	/**
	 * Encrypts a value by md5 + static token
	 * 10 times
	 */
	public function encryptPassword($value) {
		for($i = 0; $i < 10; $i ++) {
			$value = md5 ( $value . self::PASSWORD_HASH );
		}
	
		return $value;
	}
}