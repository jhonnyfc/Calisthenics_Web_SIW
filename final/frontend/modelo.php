<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'phpmailer/vendor/autoload.php';
	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;

	function conexionbasedatos() {
		$conexion = mysqli_connect("dbserver", "grupo33","KaNgiga9to","db_grupo33");
		//$conexion = mysqli_connect("localhost", "root", "", "grupo33");

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

		$consulta = "select * from final_publicacion order by FECHA_PUBLICACION desc; ";
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

		    header('Location: index.php?accion=contacto&id=1');
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
					where FE.MUSCULO = FG.IDGRUPO AND FE.IDEJERCICIO = $idejercicio;";

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
		$sexo = $_POST["sexo"];

		//echo "SEXO: ".$sexo;
		
		$contraseña = md5($contraseña);

		$consulta = "select * 
					from final_usuario 
					where nickname = '$nickname'; ";

		if ($resultado = $conexion->query($consulta)) {
			if ($datos = $resultado->fetch_assoc()) {
				return -2;
			}
			else {
				$consulta = "insert into final_USUARIO (nickname, nombre, apellido, correo, contraseña, sexo) values ('$nickname', '$nombre', '$apellido1', '$email', '$contraseña', '$sexo');";

				if ($resultado = $conexion->query($consulta)) {
					$_SESSION["nickname"] = $nickname;
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
	**/
	function mcomprobarUsuarioSesion() {
		$conexion = conexionbasedatos();
		if (isset($_SESSION["nickname"]) ) {
			$nickname = $_SESSION["nickname"];

			$consulta = "select * 
						 from final_USUARIO
						 where nickname = '$nickname';";

			if ($resultado = $conexion->query($consulta)) {
				if ($datos = $resultado->fetch_assoc()) {
					return 1;
				} else {
					return -2;
				}
			}else {
				return -1;
			}
		} else {
			return -2;
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
				    header('Location: index.php?accion=login&id=3');
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

	function menviarContraseñaNueva() {

		$nickname = $_POST["nickname"];
		$nueva_contraseña = $_POST["contraseña"];
		$nueva_contraseña = md5($nueva_contraseña);
		$email = $_POST["email"];
		
		if (!preg_match("/^[a-zA-Z0-9]*$/",$nickname)) {
			return -2;
		}

		$conexion = conexionbasedatos();
		
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
		    $mail->Body = "Buenos días, <br>
		    			   somos de CalisteniaWeb y le enviamos informamos que su contraseña ha sido modificada con exito.<br> Ya puede entrar y disfrutar de todas las ventajas que ofrece CalisteniaWeb.<br><br>";

		    $mail->send();
		    header('Location: index.php?accion=login&id=3');
			return 1;
		} else {
			return -1;
		}
			


	}
	function mdatosEjercicioActualizar() {
		$conexion = conexionbasedatos();
		
		$musculos = "";
		$nivel = "";
		$valores = $_POST["valores"];

		$valores = explode(',', $valores);

		for ($i=0; $i < count($valores); $i++) { 
			if ($valores[$i] == "Principiante" OR $valores[$i] == "Intermedio" OR $valores[$i] == "Avanzado") {
				if ($nivel=="") {
					$nivel.='"'.$valores[$i].'"';
				} else {
					$nivel.=','.'"'.$valores[$i].'"';
				}
			} else {
				if ($musculos=="") {
					$musculos.= '"'.$valores[$i].'"';
				} else {
					$musculos.=','.'"'.$valores[$i].'"';
				}
				
			}

		}

		if ($nivel!="" and $musculos!="") {
			$consulta= "select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, 					FE.DESCRIPCION, FE.IDFOTO
						from final_ejercicio fe, final_grupo fg
						where fe.musculo = fg.IDGRUPO and fe.NIVEL_EJERCICIO IN ($nivel) and fg.NOMBRE_MUSCULO IN ($musculos);";
		} else if ($nivel=="" and $musculos!="") {
			$consulta= "select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, 					FE.DESCRIPCION, FE.IDFOTO
						from final_ejercicio fe, final_grupo fg
						where fe.musculo = fg.IDGRUPO and fg.NOMBRE_MUSCULO IN ($musculos);";
		} else {
			$consulta= "select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, 					FE.DESCRIPCION, FE.IDFOTO
						from final_ejercicio fe, final_grupo fg
						where fe.musculo = fg.IDGRUPO and fe.NIVEL_EJERCICIO IN ($nivel);";
		}
		
		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}

	function mDatosUsuario() {
		$conexion = conexionbasedatos();

		$consulta = "select *
					from final_USUARIO;";

		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}
	function mDatosUsuarioPerfil(){
		$conexion = conexionbasedatos();
		$nickname = $_SESSION["nickname"];
		$consulta = "select *
					from final_USUARIO
					where nickname = '$nickname';";

		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}


	function mCerrarSesion(){
		@session_start();
		unset($_SESSION["nickname"]); 
		unset($_SESSION["contraseña"]);
		session_destroy();
		$conexion = conexionbasedatos();


		$consulta1 ="select * from final_publicacion limit 3";

		$consulta2 ="select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, FE.DESCRIPCION, FE.IDFOTO
					 from final_ejercicio FE, final_grupo FG
					 where FE.MUSCULO = FG.IDGRUPO;";

		$consulta3 ="select t.IDTEMA, t.NICKNAME, t.FECHA_PUBLICACION, t.NOMBRE, t.CONTENIDO, count(lt.IDTEMA) as likes
					 from final_tema t, final_likes_tema lt
					 where t.IDTEMA = lt.IDTEMA
					 group by t.IDTEMA, t.NICKNAME, t.FECHA_PUBLICACION, t.NOMBRE, t.CONTENIDO
					 order by likes desc
					 limit 2;";
		$res = array();
		if ( ($resultado1 = $conexion->query($consulta1)) and ($resultado2 = $conexion->query($consulta2)) and ($resultado3 = $conexion->query($consulta3)) ){
			
			$res[0] = $resultado1;
			$res[1] = $resultado2;
			$res[2] = $resultado3;
			return $res;
		} else {
			$res[0] = -1;
			return $res;
		}
	}
	
	function mDatosRutinas() {
		$conexion = conexionbasedatos();

		$consulta = "select FR.NOMBRE_RUTINA, FR.INTERVALO_TIEMPO, FR.NIVEL_RUTINA, FG.NOMBRE_MUSCULO, FR.IDRUTINA 
					from final_rutina Fr, final_grupo FG
					where FG.IDGRUPO =FR.IDGRUPO;";

		if ($resultado = $conexion->query($consulta)) {

			return $resultado;
		} else {
			return -1;
		}

	}	

	function mdatosRutinaActualizar() {
		$conexion = conexionbasedatos();
		
		$musculos = "";
		$nivel = "";
		$valores = $_POST["valores"];

		$valores = explode(',', $valores);

		for ($i=0; $i < count($valores); $i++) { 
			if ($valores[$i] == "Principiante" OR $valores[$i] == "Intermedio" OR $valores[$i] == "Avanzado") {
				if ($nivel=="") {
					$nivel.='"'.$valores[$i].'"';
				} else {
					$nivel.=','.'"'.$valores[$i].'"';
				}
			} else {
				if ($musculos=="") {
					$musculos.= '"'.$valores[$i].'"';
				} else {
					$musculos.=','.'"'.$valores[$i].'"';
				}
				
			}

		}

		if ($nivel!="" and $musculos!="") {
			$consulta ="select FR.NOMBRE_RUTINA, FR.INTERVALO_TIEMPO, FR.NIVEL_RUTINA, FG.NOMBRE_MUSCULO, FR.IDRUTINA 
						from final_rutina Fr, final_grupo FG
						where FG.IDGRUPO =FR.IDGRUPO and FR.NIVEL_RUTINA IN ($nivel) AND FG.NOMBRE_MUSCULO IN ($musculos) ;";
		} else if ($nivel=="" and $musculos!="") {
			$consulta ="select FR.NOMBRE_RUTINA, FR.INTERVALO_TIEMPO, FR.NIVEL_RUTINA, FG.NOMBRE_MUSCULO, FR.IDRUTINA 
						from final_rutina Fr, final_grupo FG
						where FG.IDGRUPO =FR.IDGRUPO and FG.NOMBRE_MUSCULO IN ($musculos) ;";
		} else {
			$consulta ="select FR.NOMBRE_RUTINA, FR.INTERVALO_TIEMPO, FR.NIVEL_RUTINA, FG.NOMBRE_MUSCULO, FR.IDRUTINA 
						from final_rutina Fr, final_grupo FG
						where FG.IDGRUPO =FR.IDGRUPO and FR.NIVEL_RUTINA IN ($nivel);";
		}
		
		if ($resultado = $conexion->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}
	function mdatosRutinaInfo() {
		$conexion = conexionbasedatos();
		
		$res = array();
		$idrutina = $_GET["idrutina"];
		$consulta ="select FR.NOMBRE_RUTINA, FR.INTERVALO_TIEMPO, FR.NIVEL_RUTINA, FG.NOMBRE_MUSCULO, FR.IDRUTINA 
					from final_rutina Fr, final_grupo FG
					where FG.IDGRUPO =FR.IDGRUPO and FR.IDRUTINA = '$idrutina';";

	
		
		if ($resultado = $conexion->query($consulta)) {
			$res[0] = $resultado;
			$consulta = "select fe.NOMBRE_EJERCICIO, fe.DESCRIPCION, fg.NOMBRE_MUSCULO, fe.NIVEL_EJERCICIO, fe.IDFOTO, fe.IDEJERCICIO
						from final_ejercicio_rutina fer, final_ejercicio fe, final_grupo fg
						where fer.IDRUTINA = $idrutina and fer.IDEJERCICIO =  fe.IDEJERCICIO and fg.IDGRUPO = fe.MUSCULO ;";

			if ($resultado = $conexion->query($consulta)) {
				$res[1] = $resultado;
				return $res;
			} else {
				$res[0] = -1;
				return $res;
			}
		} else {
			$res[0] = -1;
			return $res;
		}
	}
	function mdatosForo(){
		$conexion = conexionbasedatos();
		$res = array();

		$consulta ="select *
					from final_tema
					order by FECHA_PUBLICACION asc;";
		$consulta2 = "select t.IDTEMA, COUNT(lt.IDTEMA) as LIKES
					  from final_tema t, final_likes_tema lt
					  where t.IDTEMA=lt.IDTEMA 
					  group by t.IDTEMA
					  order by LIKES desc";

		if ( $resultado = $conexion->query($consulta) ) {
			$res[0] = $resultado;
			if ( $resultado = $conexion->query($consulta2) ) {
				$res[1] = $resultado;
				return $res;
			} else {
				return $res[0] = -1;
			}
		} else {
			return $res[0] = -1;
		}
	
	}



	function mdatosTema(){
		$conexion = conexionbasedatos();
		$idtema = $_GET["idtema"];
		$consulta ="select m.IDMENSAJE, m.NICKNAME, m.IDTEMA, m.CONTENIDO, t.FECHA_PUBLICACION, t.NOMBRE, m.FECHA_PUBLICACION_MENSAJE, t.CONTENIDO as contenidoTema
					from final_tema t, final_mensaje m 
					where t.idtema=m.idtema and t.idtema=$idtema
					order by t.FECHA_PUBLICACION asc";

		if ( $resultado = $conexion->query($consulta) ) {
			if ($resultado->num_rows > 0) {
				return $resultado;
			} else {
				$consulta ="select t.IDTEMA, t.FECHA_PUBLICACION, t.NOMBRE, t.contenido as contenidoTema, t.NICKNAME
							from final_tema t
							where t.idtema=$idtema
							order by t.FECHA_PUBLICACION asc";
				if ( $resultado = $conexion->query($consulta) ) {
					return $resultado;
				} else {
					return -1;	
				}
			}
		} else {
			return -1;
		}
	}

	function mdatosLikes(){
		$conexion = conexionbasedatos();

		$consulta ="select NICKNAME, IDTEMA
					from final_likes_tema;";
		$resultado = $conexion->query($consulta);
			
		if ( $resultado = $conexion->query($consulta) ) {
			return $resultado;
		} else {
			return -1;
		}
	}

	function mBorrarLike(){
		$conexion = conexionbasedatos();

		$resultado1 = array();
		$nickname_usuario = $_SESSION["nickname"];
		$idtema = $_GET["idtema"];
		$consulta ="delete from final_likes_tema where nickname = '$nickname_usuario' and idtema = $idtema;";
		if ( $resultado = $conexion->query($consulta) ) {
			$resultado1[0] = 1;
			echo json_encode($resultado1);
		} else {
			$resultado1[0] = -1;
			echo json_encode($resultado1);
		}
		
	}

	function mInsertarLike(){
		$conexion = conexionbasedatos();

		$resultado1 = array();
		$nickname_usuario = $_SESSION["nickname"];
		$idtema = $_GET["idtema"];
		$consulta ="insert into final_likes_tema values ($idtema, '$nickname_usuario');";

		if ( $resultado = $conexion->query($consulta) ) {
			$resultado1[0] = 1;
			echo json_encode($resultado1);
		} else {
			$resultado1[0] = -1;
			echo json_encode($resultado1);
		}
	}

	function mInsertarMensajePrincipal(){
		$conexion = conexionbasedatos();

		$nickname_usuario = $_SESSION["nickname"];
		$idtema = $_POST["idtema"];
		$contenido = $_POST["message-text"];
		$consulta ="insert into final_mensaje (nickname, idtema, contenido) values ('$nickname_usuario', $idtema,' $contenido');";
		
		if ( $resultado = $conexion->query($consulta) ) {
			return 1;
		} else {
			return -1;
		}
	}
	function mInsertarMensajeSecundario(){
		$conexion = conexionbasedatos();

		$nickname_usuario = $_SESSION["nickname"];
		$idmensaje = $_POST["idmensaje"];
		$idtema = $_POST["idtema"];
		$contenido = $_POST["message-text"];
		$consulta ="insert into final_MENSAJES_SECUNDARIOS (idmensaje, idtema, contenido, nickname) values ( $idmensaje, $idtema, '$contenido','$nickname_usuario');";
		if ( $resultado = $conexion->query($consulta) ) {
			return 1;
		} else {
			return -1;
		}
	}

	function mdatosMensajeSecundarios(){
		$conexion = conexionbasedatos();

		$idtema = $_GET["idtema"];

		$consulta ="select *
					from final_mensajes_secundarios ms
					where ms.IDTEMA=$idtema";

		if ( $resultado = $conexion->query($consulta) ) {
			return $resultado;
		} else {
			return -1;
		}
	}

	function mdatosInicio(){
		$conexion = conexionbasedatos();


		$consulta1 ="select * from final_publicacion order by FECHA_PUBLICACION desc";

		$consulta2 ="select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, FE.DESCRIPCION, FE.IDFOTO
					 from final_ejercicio FE, final_grupo FG
					 where FE.MUSCULO = FG.IDGRUPO;";

		$consulta3 ="select t.IDTEMA, t.NICKNAME, t.FECHA_PUBLICACION, t.NOMBRE, t.CONTENIDO, count(lt.IDTEMA) as likes
					 from final_tema t, final_likes_tema lt
					 where t.IDTEMA = lt.IDTEMA
					 group by t.IDTEMA, t.NICKNAME, t.FECHA_PUBLICACION, t.NOMBRE, t.CONTENIDO
					 order by likes desc
					 limit 2;";
		$res = array();
		if ( ($resultado1 = $conexion->query($consulta1)) and ($resultado2 = $conexion->query($consulta2)) and ($resultado3 = $conexion->query($consulta3)) ){
			
			$res[0] = $resultado1;
			$res[1] = $resultado2;
			$res[2] = $resultado3;
			return $res;
		} else {
			$res[0] = -1;
			return $res;
		}

	}
	function mdatosPDF(){
		$conexion = conexionbasedatos();
		
		$consulta = "select FE.IDEJERCICIO, FE.NOMBRE_EJERCICIO, FG.NOMBRE_MUSCULO , FE.NIVEL_EJERCICIO, FE.DESCRIPCION, FE.IDFOTO
					from final_ejercicio FE, final_grupo FG
					where FE.MUSCULO = FG.IDGRUPO
                    order by fg.NOMBRE_MUSCULO;";

		if ($resultado = $conexion->query($consulta)) {
			$content = "";
			$content = '<html>';
			$content .= '<head>';
			$content .= '<style>';
			$content .= '</style>';
			$content .= '</head><body>';
			$content .= '<h1>Lista de ejercicios</h1>';
			$musculo = "";
			$cont = 1;
			$fila = $resultado->fetch_assoc();
			while($fila = $resultado->fetch_assoc()) {
				/*
				$ejercicios[$cont] = array("IDEJERCICIO"=>$fila["IDEJERCICIO"],
										   "NOMBRE_EJERCICIO"=>$fila["NOMBRE_EJERCICIO"], 
										   "NOMBRE_MUSCULO"=>$fila["NOMBRE_MUSCULO"], 
										   "NIVEL_EJERCICIO"=>$fila["NIVEL_EJERCICIO"], 
										   "DESCRIPCION"=>$fila["DESCRIPCION"],
										   "IDFOTO"=>$fila["IDFOTO"]);
				$cont++;
				*/
				if ($fila["NOMBRE_MUSCULO"] != $musculo and $cont==0) {
					$content .= "</ol>";
				}
				if ($fila["NOMBRE_MUSCULO"] != $musculo) {
					
					//$content .= "<ol>";
					$content .= "<h3>Músculos implicados: ".$fila['NOMBRE_MUSCULO']. "</h3>";
					$musculo = $fila["NOMBRE_MUSCULO"];
					$content .= "<ol>";
					$cont = 0;
				}
				$content .= "<li><h4>Nombre del ejercicio: ".$fila['NOMBRE_EJERCICIO']."<br>Nivel de dificultad: ".$fila['NIVEL_EJERCICIO']."</h4>";
				$content .= $fila['DESCRIPCION']."<br></li><br>";
				
			}
			
			
			$content .= '</body></html>';
			//echo $content;die();
			
			$dompdf = new Dompdf();
			$dompdf -> loadHtml($content);
			$dompdf -> setPaper('A4', 'landscape');
			$dompdf -> render();//Genera el PDF desde contenido HTML
			$pdf = $dompdf->output();//Obtener el PDF generado
			$dompdf -> stream();//Enviar el PDF generado

			return 1;
		} else {
			return -1;
		}
	}


	function mactualizarFotoPerfil() {
		$conexion = conexionbasedatos();

		$nickname = $_POST["nickname"];

		$consulta ="update final_usuario
					set foto = '$nickname.jpg'
					where nickname = '$nickname'";

		$resultado = $conexion->query($consulta);
		
		$dir = dirname(__FILE__);
	    $dir .= '\\final_fotos_perfil\\';

	    if(!empty($_FILES)){
	        $temp_file = $_FILES['file']['tmp_name'];
	        //$location = $dir . $_FILES['file']['name'];
	        $location = $dir . $nickname.".jpg";

	        list($ancho, $alto) = getimagesize($temp_file);
	        $nuevo_ancho = 200;
	        $nuevo_alto = 200;

	        // Cargar
	        $thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
	        header('Content-type: image/jpg');
	        	$origen = imagecreatefromjpeg($temp_file);
	        
	        // Cambiar el tamaño
	        imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

	        // move_uploaded_file($thumb , $location);
	        if (imagepng($thumb , $location)){

	        } else {
	        	header("HTTP/1.0 400 Bad Request");
	        	echo 'error1';
	        } 
	    } else {
	    	header("HTTP/1.0 400 Bad Request");
	    	echo 'error2';
	    }
	    
	}

	function manadirTema(){
		$conexion = conexionbasedatos();

		$nombre = $_SESSION["nickname"];
		$titulo = $_POST["titulo"];
		$contenido = $_POST["contenido"];

		$consulta = "insert into final_tema (nickname, nombre, contenido) values ('$nombre', '$titulo', '$contenido');";

		if ($resultado = $conexion->query($consulta)) {
			return 1;
		} else {
			return -1;
		}

	}


?>
