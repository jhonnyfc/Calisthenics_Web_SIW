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

	function mdatoscorreo(){

		$destino = "danieldbg1calisteniaweb@gmail.com";
		$nombre = $_POST["nombre"];
		$email = $_POST["email"];
		$telefono = $_POST["telefono"];
		$mensaje = $_POST["mensaje"];
		//direcciones que recibirán copia oculta (administrador)
		//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n";

		//Validar informacion del formulario (mejor con javascript)
		/*
		if (!preg_match("/^[a-zA-Z]*$/",$nombre)) {
			return -1;
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return -2;
		}
		if (!filter_var($telefono, FILTER_VALIDATE_INT)) {
			return -3;
		}
		if (!preg_match("/^[a-zA-Z]*$/",$mensaje)) {
			return -4;
		}
		*/

		$contenido = "Nombre: ".$nombre."\nCorreo: ".$email."\nTelefono: ".$telefono."\nMensaje: ".$mensaje;

		if (mail($destino, "CalisteniaWeb", $contenido,/*$headers*/)){
			return 1;
		}
		else{
			return -1;
		}


		
	}



?>