<?php
$host="localhost";
$usuario="dwec";
$pass="abc123";
$db="doctores";

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