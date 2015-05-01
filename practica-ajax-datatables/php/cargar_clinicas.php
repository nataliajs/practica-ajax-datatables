<?php
header('Access-Control-Allow-Origin: *');
$host="localhost";
$usuario="nataliajimenez_d";
$pass="abc123";
$db="nataliajimenez_d";

$consulta='SELECT nombre, id_clinica FROM clinicas';
$mysql= new mysqli($host,$usuario,$pass,$db);
$mysql->set_charset("utf8");
$resultado=$mysql->query($consulta);
$clinicas='';
$c=$resultado->fetch_array();
while($c){
	$clinicas.='<option value ='.$c['id_clinica'].'>'.$c['nombre'].'</option>';
	$c=$resultado->fetch_array();
}
echo $clinicas;