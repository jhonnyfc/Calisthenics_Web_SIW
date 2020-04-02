<?php 

	function conexionbasedatos() {
		$conexion = mysqli_connect("localhost", "root", "", "grupo33");

		return $conexion;
	}

	/**
	Funcion encargada de recoger la informacion de la tabla final_publicacion
	Manda
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function mdatospublicaciones(){
		$conexion = conexionbasedatos();

		$consulta = "select * from final_publicacion";
		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}

	/**
	Funcion encargada de recoger la informacion del formulario de contacto
	Manda
		 1--> Si se ha mandado el correo correctamente
		-1 --> Si existe algun problema 
	**/
	function mdatoscorreo(){

		$destino = "danieldbg1calisteniaweb@gmail.com";
		$nombre = $_POST["nombre"];
		$email = $_POST["email"];
		$telefono = $_POST["telefono"];
		$mensaje = $_POST["mensaje"];
		//direcciones que recibirán copia oculta (administrador)
		//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n";

		//Validar informacion del formulario (mejor con javascript)
		
		if (!preg_match("/^[a-zA-Z]*$/",$nombre)) {
			return -2;
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return -3;
		}
		if (!filter_var($telefono, FILTER_VALIDATE_INT)) {
			return -4;
		}
		if (!preg_match("/^[a-zA-Z]*$/",$mensaje)) {
			return -5;
		}
		

		$contenido = "Nombre: ".$nombre."\nCorreo: ".$email."\nTelefono: ".$telefono."\nMensaje: ".$mensaje;

		if (mail($destino, "CalisteniaWeb", $contenido/*$headers*/)){
			return 1;
		}
		else{
			return -1;
		}
	}

	/**
	Funcion encargada de recoger la informacion de la tabla final_ejercicio
	Manda
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function mdatosejercicios(){
		$conexion = conexionbasedatos();

		$consulta = "select * from final_ejercicios";

		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}

	}



?>