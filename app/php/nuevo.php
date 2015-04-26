<?php
//informaci´on de la conexion
$host="localhost";
$usuario="dwec";
$pass="abc123";
$db="doctores";


$mysql= new mysqli($host,$usuario,$pass,$db);

$nombredoctor = $_REQUEST['nombre'];
$numcolegiado = $_REQUEST['colegiado'];
$clinicas = $_REQUEST['clinicas'];

if($mysql->connect_error){
	die('Error de conexión: ' . $mysqli->connect_error);
}else{
	//para tener un id_doctor(es PK) sumo 1 al valor m´aximo que hay en la DB
	$consultaClinicas = 'SELECT max(id_doctor) as maximo FROM doctores';
	$max = $mysql->query($consultaClinicas);
	$row = $max->fetch_array();
	$id_doctor = $row['maximo'] + 1;
	//creo el doctor
	$consulta = 'INSERT INTO doctores (id_doctor , nombre , numcolegiado) VALUES ("'.$id_doctor.'" , "'.$nombredoctor.'" , "'.$numcolegiado.'")';
	$query_res=$mysql->query($consulta);
	//añado a clinicas_doctores las clinicas
	for($i=0 ; $i<count($clinicas) ; $i++){
		$consulta1 = 'INSERT INTO clinica_doctor (id_doctor , id_clinica) VALUES ('.$id_doctor.','.$clinicas[$i].')';
		$query_res1=$mysql->query($consulta1);
	}	

}

if(!$query_res){
        $mensaje = 'Error en la consulta0: ' . $mysql->error . "\n";
        $estado = $mysql->errno;    
}elseif (!$query_res1) {
        $mensaje = 'Error en la consulta1: ' . $mysql->error . "\n";
        $estado = $mysql->errno; 
}else {
    $mensaje = "Se ha añadido el doctor";
    $estado = 0;
}
$resultado=array();
$resultado[]=array(
		'mensaje'=>$mensaje,
		'estado'=>$estado
	);
echo json_encode($resultado);