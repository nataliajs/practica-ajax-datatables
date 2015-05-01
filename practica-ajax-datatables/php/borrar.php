<?php
header('Access-Control-Allow-Origin: *');
//informaci´on de la conexion
$host="localhost";
$usuario="nataliajimenez_d";
$pass="abc123";
$db="nataliajimenez_d";

if(isset($_REQUEST['iddoctor'])){
	if(empty($_REQUEST['iddoctor'])){
		echo "Parametro iddoctor vacio";
	}else{
		$id_doctor=$_REQUEST['iddoctor'];
	}
}else{
	echo "No se ha enviado id_clinica";
}

$consulta1='DELETE FROM clinica_doctor WHERE id_doctor='.$id_doctor;

$consulta='DELETE FROM doctores WHERE id_doctor='.$id_doctor;

$mysql= new mysqli($host,$usuario,$pass,$db);

if($mysql->connect_error){
	die('Error de conexión: ' . $mysqli->connect_error);
}else{
	$query_res1=$mysql->query($consulta1);
	$query_res=$mysql->query($consulta);
}

if(!$query_res1){
	if ($mysql->errno == 1451) {
        $mensaje = "Imposible borrar las clinicas del doctor";
        $estado = $mysql->errno;
    } else {
        $mensaje = 'Error en la consulta: ' . $mysql->error . "\n";
        $estado = $mysql->errno;
    }
}elseif(!$query_res){
	if ($mysql->errno == 1451) {
        $mensaje = "Imposible borrar el doctor. Debera borrar antes los datos asociados a este doctor";
        $estado = $mysql->errno;
        //echo "<script type='text/javascript'>alert('".$mensaje."');</script>";
    } else {
        $mensaje = 'Error en la consulta: ' . $mysql->error . "\n";
        $estado = $mysql->errno;
    }
} else {
    $mensaje = "Doctor borrado";
    $estado = 0;
}
$resultado=array();
$resultado[]=array(
		'mensaje'=>$mensaje,
		'estado'=>$estado
	);
echo json_encode($resultado);