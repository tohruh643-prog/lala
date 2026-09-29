<?php 

//EJB SOLUTIONS - BATUTO 2025

require_once("../../include/initialize.php");
global $mydb;

header('Content-Type: application/json');

if (isset($_POST['TYPEID'])) {
	$output = array();
	$query =	"SELECT * FROM tblusertype 
		WHERE TYPEID = '".$_POST["TYPEID"]."' 
		LIMIT 1";
	$mydb->setQuery($query);
	$result = $mydb->loadResultList();

	foreach($result as $row)
	{ 
		$output["TYPEID"]   = $row->TYPEID;
		$output["USERTYPE"] = $row->USERTYPE;
		$output["STATUS"]   = isset($row->STATUS) ? $row->STATUS : 'Active';
	}
	echo json_encode($output);
}elseif (isset($_POST['id'])) {
	$Permission = new Permission();
	$Permission->AllowOpen = $_POST['ischeck'];
	$Permission->updatePermission($_POST['id']);
}else{
	$output = array();
	$query = "SELECT * FROM `tblusertype` ";

	$search_value = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : '';
	if($search_value != '')
	{
		$query .= " where `USERTYPE` LIKE '%".$search_value."%' ";
	}

	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY `USERTYPE` DESC ';
	}

	$length = isset($_POST["length"]) ? $_POST["length"] : -1;
	$start  = isset($_POST["start"])  ? $_POST["start"]  : 0;
	if($length != -1)
	{
		$query .= " LIMIT " . $start . ", " . $length . "";
	}

	$mydb->setQuery($query);
	$cur = $mydb->loadResultList();
	$data = array();
	$filtered_rows = $mydb->num_rows();
	$i = 1;	
	foreach ($cur as $result) {

		// Status badge
		$status = isset($result->STATUS) ? $result->STATUS : 'Active';
		if ($status == 'Active') {
			$statusbadge = '<span class="badge badge-success">Active</span>';
		} else {
			$statusbadge = '<span class="badge badge-danger">In-Active</span>';
		}

		// Action buttons: Edit (yellow) + Delete (red)
		$actions  = '<button type="button" name="update" TYPEID="'.$result->TYPEID.'" class="btn btn-warning btn-xs editEntry"><span class="fa fa-edit fw-fa"></span></button> ';
		$actions .= '<button type="button" name="delete" TYPEID="'.$result->TYPEID.'" USERTYPE="'.htmlspecialchars($result->USERTYPE, ENT_QUOTES).'" class="btn btn-danger btn-xs deleteEntry"><span class="fa fa-trash fw-fa"></span></button>';

		$sub_array = array();

		$sub_array[] = $i;
		$sub_array[] = $result->USERTYPE;
		$sub_array[] = $statusbadge;
		$sub_array[] = $actions;
		$data[] = $sub_array;
		$i = $i + 1;		
	}
	function get_total_all_records()
	{
		global $mydb;
		$statement = "SELECT * FROM `tblusertype`";
		$mydb->setQuery($statement);
		return $mydb->num_rows();
	}

	$output = array('data' 			   => $data, 
					"recordsTotal"	   => $filtered_rows,
					"recordsFiltered"	=>	get_total_all_records() );
	echo json_encode($output);
}
?>