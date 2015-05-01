<?php
header('Access-Control-Allow-Origin: *');
//informaci´on de la conexion
$host="localhost";
$usuario="nataliajimenez_d";
$pass="abc123";
$db="nataliajimenez_d";


$mysql= new mysqli($host,$usuario,$pass,$db);
$mysql->set_charset('utf8');

$id_doctor = $_REQUEST['id_doctor'];
$nombredoctor = $_REQUEST['nombre'];
$numcolegiado = $_REQUEST['colegiado'];
$clinicas = $_REQUEST['clinicas'];
if($mysql->connect_error){
	die('Error de conexión: ' . $mysqli->connect_error);
}else{

	$consulta = 'UPDATE doctores SET nombre="'.$nombredoctor.'" , numcolegiado = "'.$numcolegiado.'" WHERE id_doctor ="'.$id_doctor.'"';
	$query_res=$mysql->query($consulta);
	$consulta1 = 'DELETE FROM clinica_doctor WHERE id_doctor='.$id_doctor;
	$query_res1=$mysql->query($consulta1);
	for($i=0 ; $i<count($clinicas) ; $i++){
		$consulta2 = 'INSERT INTO clinica_doctor (id_doctor , id_clinica) VALUES ('.$id_doctor.','.$clinicas[$i].')';
		$query_res2=$mysql->query($consulta2);
	}	

}

if(!$query_res){
        $mensaje = 'Error en la consulta0: ' . $mysql->error . "\n";
        $estado = $mysql->errno;    
}elseif (!$query_res1) {
        $mensaje = 'Error en la consulta1: ' . $mysql->error . "\n";
        $estado = $mysql->errno; 
}elseif(!$query_res2){
        $mensaje = 'Error en la consulta2: ' . $mysql->error . "\n";
        $estado = $mysql->errno; 
}else {
    $mensaje = "Se han actualizado los datos del doctor";
    $estado = 0;
}
$resultado=array();
$resultado[]=array(
		'mensaje'=>$mensaje,
		'estado'=>$estado
	);

require('ssp.class.php');
echo json_encode($resultado);