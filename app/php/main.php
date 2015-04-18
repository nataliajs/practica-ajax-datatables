<?php
$table='vdoctoresclinicas';
$primaryKey='id_doctor';

$columns = array(
		array('db'	=>	'id_doctor' , 'dt'	=>	'idDoctor'),
		array('db'	=>	'nombre_doctor' , 'dt'	=>	'nombreDoctor'),
		array('db'	=>	'numcolegiado' , 'dt'	=>	'numColegiado'),
		array('db'	=>	'clinicas' , 'dt'	=>	'clinicas')
	);

$sql_details = array(
		'user'=>'dwec',
		'pass'=>'abc123',
		'db'=>'doctores',
		'host'=>'localhost'
	);

require('ssp.class.php');

echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	);
