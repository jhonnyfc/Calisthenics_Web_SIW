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
	Envia
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function mdatosPublicaciones(){
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
	Envia
		 1 --> Si se ha mandado el correo correctamente
		-1 --> Si existe algun problema 
		-2 --> El nombre no cumple con las especificaciones
		-3 --> El email no cumple con las especificaciones
		-4 --> El telefono no cumple con las especificaciones
		-5 --> El mensaje no cumple con las especificaciones
	**/
	function mdatosCorreo(){

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
	Envia
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function mdatosEjercicios(){
		$conexion = conexionbasedatos();

		$consulta = "select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, FE.DESCRIPCION, FE.IDFOTO
					from final_ejercicio FE, final_grupo FG
					where FE.MUSCULO = FG.IDGRUPO;";

		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}

	}

	/**
	Funcion encargada de recoger la informacion de un ejercicio
	Envia
		resultado --> Si se ha realizado la consulta correctamente
		-1 --> Si existe algun problema con la base de datos
	**/
	function mdatosEjercicioInformacion() {
		$conexion = conexionbasedatos();
		
		$idejercicio = $_GET["idejercicio"];

		$consulta = "select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, FE.DESCRIPCION, FE.IDFOTO
					from final_ejercicio FE, final_grupo FG
					where FE.MUSCULO = FG.IDGRUPO AND FE.IDEJERCICIO = '$idejercicio';";

		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}

	/**
	Funcion encargada de validar y guardar datos del registro del usuario
	Envia
		 1 --> No hay problemas y se ha guardado el usuario
		-1 --> Si existe algun problema con la base de datos
		-2 --> Si ya existe el nickname elegido por el usuario
	**/
	function mvalidarRegistro() {
		$conexion = conexionbasedatos();

		$nombre = $_POST["nombre"];
		$email = $_POST["email"];
		$contraseña = $_POST["password"];
		$nickname = $_POST["nickname"];
		$apellido1 = $_POST["apellido1"];
		$contraseña = md5($contraseña);

		$consulta = "select * 
					from final_usuario 
					where nickname = '$nickname'; ";

		if ($resultado = $conexion->query($consulta)) {
			if ($datos = $resultado->fetch_assoc()) {
				return -2;
			}
			else {
				$consulta = "insert into final_USUARIO values ('$nickname', '$nombre', '$apellido1', '$email', '$contraseña');";
				if ($resultado = $conexion->query($consulta)) {
					$_SESSION["nickname"] = $nickname;
					$_SESSION["contraseña"] = $contraseña;
					return 1;
				} else {
					return -1;
				}
			}
		} else {
			return -1;
		}
	}

	/**
	Funcion encargada de validar usuario
	Envia
		 1 --> Login correcto
		-1 --> Si existe algun problema con la base de datos
		-2 --> No existe el usuario
		-3 --> No coincide la contraseña
	**/
	function mvalidarLogin() {
		$conexion = conexionbasedatos();

		$nickname = $_POST["nickname"];
		$contraseña = $_POST["password"];
		$contraseña = md5($contraseña);

		$consulta = "select * 
					 from final_USUARIO
					 where nickname = '$nickname';";

		if ($resultado = $conexion->query($consulta)) {
			if ($datos = $resultado->fetch_assoc()) {
				if ($contraseña == $datos["CONTRASEÑA"]) {
					$_SESSION["nickname"] = $nickname;
					$_SESSION["contraseña"] = $contraseña;
					return 1;
				} else {
					return -3;
				}
			} else {
				return -2;
			}
		}else {
			return -1;
		}
	}

	/**
	Funcion encargada de comprobar si el usuario esta logueado
	Envia
		 1 --> Si
		-1 --> Si existe algun problema con la base de datos
		-2 --> No existe el usuario
		-3 --> No coincide la contraseña
	**/
	function mcomprobarUsuarioSesion() {
		$conexion = conexionbasedatos();

		$nickname = $_SESSION["nickname"];
		$contraseña = $_SESSION["contraseña"];

		$consulta = "select * 
					 from final_USUARIO
					 where nickname = '$nickname';";

		if ($resultado = $conexion->query($consulta)) {
			if ($datos = $resultado->fetch_assoc()) {
				if ($contraseña == $datos["CONTRASEÑA"]) {
					return 1;
				} else {
					return -3;
				}
			} else {
				return -2;
			}
		}else {
			return -1;
		}
	}

	/**
	Funcion encargada enviar correo al usuario y poder recuperar la constraseña
	Envia
		 1 --> Si
		-1 --> Si existe algun problema con la base de datos
		-2 --> El nickname no cumple con las especificaciones 
		-3 --> El email no cumple con las especificacines
		-4 --> El nickname y/o el email no coinciden con la cuenta
	**/
	function menviarContraseña() {
		
		$nickname = $_POST["nickname"];
		$email = $_POST["email"];
		
		if (!preg_match("/^[a-zA-Z0-9]*$/",$nickname)) {
			return -2;
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return -3;
		}

		$conexion = conexionbasedatos();
		$consulta = "select *
					 from final_USUARIO
					 where NICKNAME = '$nickname' and CORREO = '$email';";
		if ($resultado = $conexion->query($consulta)) {
			if ($datos = $resultado->fetch_assoc()) {
				$nueva_contraseña = "";
				$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
				for($i=0;$i<8;$i++) {
					$nueva_contraseña .= substr($str,rand(0,62),1);
				}
				$nueva_contraseña_usuario = $nueva_contraseña;
				$nueva_contraseña = md5($nueva_contraseña);
				$consulta = "update final_USUARIO SET CONTRASEÑA = '$nueva_contraseña' where nickname = '$nickname';";
				if ($resultado = $conexion->query($consulta)) {
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
				    $mail->addAddress("$email");

				    $mail->isHTML(true);
				    $mail->Subject = 'CalisteniaWeb';
				    $mail->Body = "Buenos dias, <br>
				    			   somos de CalisteniaWeb y le enviamos su nueva contraseña: <br>
				    			   Contraseña nueva: '$nueva_contraseña_usuario'.";

				    $mail->send();

					//} catch (Exception $exception) {
					  // return -1;
					   // echo 'Algo salio mal', $exception->getMessage();
					//}
					return 1;
				} else {
					return -1;
				}
			} else {
				return -4;
			}
		}else {
			return -1;
		}

		
	}
	

?>
