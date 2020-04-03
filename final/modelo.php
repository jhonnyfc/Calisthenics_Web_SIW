<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'phpmailer/vendor/autoload.php';

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

		$mail = new PHPMailer(true);

		//try {
		    $mail->SMTPDebug = 2;
		    $mail->isSMTP();

		    $mail->Host = 'smtp.gmail.com';
		    $mail->SMTPAuth = true;

		    $mail->Username = 'danieldbg1Calisteniaweb@gmail.com';
		    $mail->Password = 'danidbg1CalisteniaWeb';

		    $mail->SMTPSecure = 'tls';
		    $mail->Port = 587;

		    ## MENSAJE A ENVIAR

		    $mail->setFrom('danieldbg1Calisteniaweb@gmail.com');
		    $mail->addAddress('danieldbg1Calisteniaweb@gmail.com');

		    $mail->isHTML(true);
		    $mail->Subject = 'CalisteniaWeb';
		    $mail->Body = "Buenos dias, <br>
		    				soy '$nombre' y este es mi problema:<br>
		    				'$mensaje'<br><br>
		    				Informacion de contacto:<br>
		    				Telefono:'$telefono'<br>
		    				Correo: '$email'";

		    $mail->send();

		//} catch (Exception $exception) {
		  // return -1;
		   // echo 'Algo salio mal', $exception->getMessage();
		//}
		return 1;
	}

	/**
	Funcion encargada de recoger la informacion de la tabla final_ejercicio
	Manda
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function mdatosejercicios(){
		$conexion = conexionbasedatos();

		$consulta = "select FE.IDEJERCICIO, FE.NOMBRE, FG.NOMBRE_MUSCULO , FE.NIVEL, FE.DESCRIPCION, FE.IDFOTO
					from final_ejercicio FE, final_grupo FG
					where FE.MUSCULO = FG.IDGRUPO;";

		$resultado = $conexion->query($consulta);

		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}

	}

	/**
	Funcion encargada de recoger la informacion de un ejercicio
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function mdatosejercicioinformacion() {
		$conexion = conexionbasedatos();
		
		$idejercicio = $_GET["idejercicio"];

		$consulta = "select FE.IDEJERCICIO, FE.NOMBRE, FG.NOMBRE_MUSCULO , FE.NIVEL, FE.DESCRIPCION, FE.IDFOTO
					from final_ejercicio FE, final_grupo FG
					where FE.MUSCULO = FG.IDGRUPO AND FE.IDEJERCICIO = '$idejercicio';";

		$resultado = $conexion->query($consulta);

		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}

	}

	



?>
