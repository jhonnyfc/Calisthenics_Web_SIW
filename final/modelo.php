<?php 
	
	function conexionbasedatos() {
		$conexion = mysqli_connect("localhost", "root", "", "grupo33");

		return $conexion;
	}

	function mdatospublicaciones(){
		$conexion = conexionbasedatos();

		$consulta = "select * from final_publicacion";
		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}



?>