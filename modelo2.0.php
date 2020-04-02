<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/vendor/autoload.php';
	//require 'Constantes.php';

	
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
		
		/*
		$destino = "danieldbg1calisteniaweb@gmail.com";
		$nombre = $_POST["nombre"];
		$email = $_POST["email"];
		$telefono = $_POST["telefono"];
		$mensaje = $_POST["mensaje"];


		$contenido = "Nombre: ".$nombre."\nCorreo: ".$email."\nTelefono: ".$telefono."\nMensaje: ".$mensaje;
		
		if (mail($destino, "CalisteniaWeb", $contenido)) {
			//return 1;
			echo 1;
		}
		else{
			//return -1;
			echo -1;
		}
	*/

		//Create a new PHPMailer instance
		/*
		$mail = new PHPMailer();
		$mail->IsSMTP();
		 
		//Configuracion servidor mail
		$mail->From = "danieldbg1Calisteniaweb@gmail.com"; //remitente
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls'; //seguridad
		$mail->Host = "smtp.gmail.com"; // servidor smtp
		$mail->Port = 587; //puerto
		$mail->Username ='danieldbg1Calisteniaweb@gmail.com'; //nombre usuario
		$mail->Password = 'danidbg1CalisteniaWeb'; //contraseña

		$email = $_POST["email"];
		$telefono = $_POST["telefono"];
		$mensaje = $_POST["mensaje"];

		//Agregar destinatario
		$mail->AddAddress($email);
		$mail->Subject = $telefono;
		$mail->Body = $mensaje;

		//Avisar si fue enviado o no y dirigir al index
		if ($mail->Send()) {
		    echo'<script type="text/javascript">
		           alert("Enviado Correctamente");
		        </script>';
		} else {
		    echo'<script type="text/javascript">
		           alert("NO ENVIADO, intentar de nuevo");
		        </script>';
		}
		*/

		$destino = "danieldbg1calisteniaweb@gmail.com";
		$nombre = $_POST["nombre"];
		$email = $_POST["email"];
		$telefono = $_POST["telefono"];
		$mensaje = $_POST["mensaje"];

		$mail = new PHPMailer(true);

		try {
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

		} catch (Exception $exception) {
		    echo 'Algo salio mal', $exception->getMessage();
		}
	}
		



?>