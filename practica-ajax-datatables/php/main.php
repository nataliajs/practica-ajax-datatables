<?php
header('Access-Control-Allow-Origin: *');

$table='vdoctoresclinicas';
$primaryKey='id_doctor';

$columns = array(
		array('db'	=>	'id_doctor' , 'dt'	=>	'idDoctor'),
		array('db'	=>	'nombre_doctor' , 'dt'	=>	'nombreDoctor'),
		array('db'	=>	'numcolegiado' , 'dt'	=>	'numColegiado'),
		array('db'	=>	'clinicas' , 'dt'	=>	'clinicas')
	);

$sql_details = array(
		'user'=>'nataliajimenez_d',
		'pass'=>'abc123',
		'db'=>'nataliajimenez_d',
		'host'=>'localhost'
	);

require('ssp.class.php');

echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	);
